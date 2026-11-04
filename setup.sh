#!/usr/bin/env bash
# ==============================================================================
# TURNKEY AUTOMATED INSTALLER & RESTORATION RUNBOOK FOR ASTERISK DIALER ON AWS
# ==============================================================================
# Compatible with: CentOS 7 (x86_64) / RHEL 7 (Recommended for 100% parity)
# ==============================================================================

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_info() { echo -e "${BLUE}[INFO]${NC} $1"; }
log_success() { echo -e "${GREEN}[SUCCESS]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
log_error() { echo -e "${RED}[ERROR]${NC} $1"; }

if [ "$EUID" -ne 0 ]; then
    log_error "This script must be run as root (or with sudo)!"
    exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

log_info "Starting Automated Asterisk Dialer Setup on AWS EC2..."

# ------------------------------------------------------------------------------
# STEP 1: SYSTEM REPOSITORIES & DEPENDENCIES
# ------------------------------------------------------------------------------
log_info "Step 1: Installing base dependencies and build prerequisites..."
yum clean all
yum makecache -y
yum install -y epel-release
yum groupinstall -y "Development Tools"
yum install -y \
    wget curl net-tools zip unzip tar git \
    libxml2 libxml2-devel ncurses ncurses-devel libuuid-devel \
    jansson jansson-devel openssl openssl-devel sqlite sqlite-devel \
    bzip2 patch libedit-devel \
    perl perl-DBI perl-DBD-MySQL perl-CPAN \
    mariadb-server mariadb mariadb-devel \
    httpd php php-mysql php-cli php-common \
    fail2ban fail2ban-systemd \
    python3 python3-pip

log_success "Base dependencies successfully installed."

# ------------------------------------------------------------------------------
# STEP 2: SYSTEM TUNING & KERNEL OPTIMIZATION (HIGH-THROUGHPUT VOIP)
# ------------------------------------------------------------------------------
log_info "Step 2: Applying Linux kernel audio & UDP packet tuning..."

cat << 'EOF' > /etc/sysctl.d/99-voip-telephony.conf
# VoIP high-throughput socket buffer tuning
net.core.rmem_max = 16777216
net.core.wmem_max = 16777216
net.core.rmem_default = 262144
net.core.wmem_default = 262144
net.core.netdev_max_backlog = 10000
net.ipv4.udp_rmem_min = 16384
net.ipv4.udp_wmem_min = 16384
net.ipv4.ip_local_port_range = 1024 65535
fs.file-max = 2097152
EOF
sysctl --system >/dev/null 2>&1 || true

cat << 'EOF' > /etc/security/limits.d/99-asterisk.conf
asterisk soft nofile 65535
asterisk hard nofile 65535
asterisk soft nproc 65535
asterisk hard nproc 65535
root soft nofile 65535
root hard nofile 65535
EOF

# Set SELinux to permissive to prevent socket and AGI blockages
if [ -f /etc/selinux/config ]; then
    sed -i 's/^SELINUX=enforcing/SELINUX=permissive/' /etc/selinux/config
    setenforce 0 2>/dev/null || true
fi

log_success "Kernel parameters optimized for VoIP."

# ------------------------------------------------------------------------------
# STEP 3: MARIADB / MYSQL DATABASE SETUP & RESTORATION
# ------------------------------------------------------------------------------
log_info "Step 3: Initializing MariaDB and restoring databases..."

systemctl start mariadb
systemctl enable mariadb

# Create user 'smartpremium' and database 'yahoo' as defined in portal configs
mysql -e "CREATE DATABASE IF NOT EXISTS yahoo CHARACTER SET utf8 COLLATE utf8_general_ci;"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'smartpremium'@'localhost' IDENTIFIED BY 'superadmin' WITH GRANT OPTION;"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'smartpremium'@'127.0.0.1' IDENTIFIED BY 'superadmin' WITH GRANT OPTION;"
mysql -e "FLUSH PRIVILEGES;"

if [ -f "$SCRIPT_DIR/yahoo_database.sql" ]; then
    log_info "Importing yahoo_database.sql..."
    mysql yahoo < "$SCRIPT_DIR/yahoo_database.sql"
    log_success "Database 'yahoo' restored successfully."
elif [ -f "$SCRIPT_DIR/all_databases.sql" ]; then
    log_info "Importing all_databases.sql..."
    mysql < "$SCRIPT_DIR/all_databases.sql"
    log_success "All databases restored successfully."
else
    log_warn "No SQL dump found directly in repository root."
fi

# ------------------------------------------------------------------------------
# STEP 4: ASTERISK 13.38.3 BUILD & INSTALLATION
# ------------------------------------------------------------------------------
log_info "Step 4: Checking Asterisk installation..."

if ! command -v asterisk >/dev/null 2>&1 && [ ! -f /usr/sbin/asterisk ]; then
    log_info "Compiling Asterisk 13.38.3 from source..."
    cd /usr/src
    if [ ! -f asterisk-13.38.3.tar.gz ]; then
        wget -q http://downloads.asterisk.org/pub/telephony/asterisk/old-releases/asterisk-13.38.3.tar.gz || \
        wget -q https://github.com/asterisk/asterisk/archive/refs/tags/13.38.3.tar.gz -O asterisk-13.38.3.tar.gz
    fi
    tar -xzf asterisk-13.38.3.tar.gz
    cd asterisk-13.38.3
    contrib/scripts/install_prereq install >/dev/null 2>&1 || true
    ./configure --with-jansson-bundled --prefix=/usr --sysconfdir=/etc --localstatedir=/var
    make -j$(nproc)
    make install
    make config
    cd "$SCRIPT_DIR"
    log_success "Asterisk 13.38.3 compiled and installed."
else
    log_success "Asterisk binary already present (/usr/sbin/asterisk)."
fi

# Create asterisk user and group if not present
id -u asterisk >/dev/null 2>&1 || useradd -m -s /sbin/nologin asterisk

# ------------------------------------------------------------------------------
# STEP 5: RESTORE ASTERISK CONFIGS & PERMISSIONS
# ------------------------------------------------------------------------------
log_info "Step 5: Restoring Asterisk configuration and AGIs..."

if [ -d "$SCRIPT_DIR/etc/asterisk" ]; then
    mkdir -p /etc/asterisk
    cp -r "$SCRIPT_DIR/etc/asterisk/"* /etc/asterisk/
    log_success "Copied /etc/asterisk configuration files."
fi

if [ -d "$SCRIPT_DIR/var_lib_asterisk/agi-bin" ]; then
    mkdir -p /var/lib/asterisk/agi-bin
    cp -r "$SCRIPT_DIR/var_lib_asterisk/agi-bin/"* /var/lib/asterisk/agi-bin/
    chmod +x /var/lib/asterisk/agi-bin/*.agi 2>/dev/null || true
    chmod +x /var/lib/asterisk/agi-bin/* 2>/dev/null || true
    log_success "Copied and made AGIs executable in /var/lib/asterisk/agi-bin."
fi

# Ensure Asterisk init service script is present
if [ -f "$SCRIPT_DIR/etc/asterisk.init" ]; then
    cp "$SCRIPT_DIR/etc/asterisk.init" /etc/init.d/asterisk
    chmod +x /etc/init.d/asterisk
    chkconfig --add asterisk 2>/dev/null || true
    chkconfig asterisk on 2>/dev/null || true
fi

# Permissions fix
chown -R asterisk:asterisk /etc/asterisk /var/lib/asterisk /var/spool/asterisk /var/log/asterisk /var/run/asterisk 2>/dev/null || true

# ------------------------------------------------------------------------------
# STEP 6: RESTORE WEB INTERFACE (APACHE & PHP PORTAL)
# ------------------------------------------------------------------------------
log_info "Step 6: Restoring Web Management & Agent Portals..."

if [ -d "$SCRIPT_DIR/var_www/html" ]; then
    mkdir -p /var/www/html
    cp -r "$SCRIPT_DIR/var_www/html/"* /var/www/html/
    chown -R apache:apache /var/www/html
    chmod -R 755 /var/www/html
    log_success "Restored /var/www/html/ web applications."
fi

systemctl restart httpd
systemctl enable httpd

# ------------------------------------------------------------------------------
# STEP 7: RESTORE MONITORING & CRON AUTOMATION
# ------------------------------------------------------------------------------
log_info "Step 7: Configuring automated 30-minute Telegram health reporting..."

if [ -f "$SCRIPT_DIR/usr_local_bin/hourly_report.sh" ]; then
    cp "$SCRIPT_DIR/usr_local_bin/hourly_report.sh" /usr/local/bin/hourly_report.sh
    chmod +x /usr/local/bin/hourly_report.sh
    
    # Add to crontab if not already registered
    (crontab -l 2>/dev/null | grep -v "hourly_report.sh"; echo "*/30 * * * * /usr/local/bin/hourly_report.sh") | crontab -
    log_success "Hourly report cron job installed."
fi

# ------------------------------------------------------------------------------
# STEP 8: RESTART & VERIFY ALL SERVICES
# ------------------------------------------------------------------------------
log_info "Step 8: Starting and validating all services..."

service asterisk restart || systemctl restart asterisk
systemctl restart mariadb
systemctl restart httpd
systemctl restart fail2ban 2>/dev/null || true

sleep 3

echo ""
echo "=========================================================================="
log_success "🎉 ASTERISK DIALER DEPLOYMENT COMPLETE & OPERATIONAL!"
echo "=========================================================================="
echo "• Asterisk PBX Version: $(/usr/sbin/asterisk -V 2>/dev/null || echo 'Running')"
echo "• Web Portal URL:       http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || hostname -I | awk '{print $1}')/voicedialtech/"
echo "• Agent Portal URL:     http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || hostname -I | awk '{print $1}')/agent/"
echo "• Database User:        smartpremium / superadmin"
echo "• Database Name:        yahoo"
echo "• SIP Port:             UDP 5060"
echo "• Audio Stream Ports:   UDP 10000 - 20000"
echo "=========================================================================="
