# AI Agent Runbook: Automated AWS EC2 Deployment

> **Role for the AI Agent:** You are the Senior DevOps & Telecommunications Deployment Engineer. Your mission is to take a fresh AWS EC2 instance (CentOS 7 x86_64) and bring this entire Asterisk Dialer PBX, AGI telephony stack, MariaDB database, and Web Portals into a fully operational and optimized state matching the production server.

---

## 1. Quick Start Execution (Single Command)

Once logged into the fresh AWS EC2 instance via SSH, clone this repository and run the setup script:

```bash
# 1. Switch to root
sudo su -

# 2. Clone the repository
git clone https://github.com/officialsyscorelabs/asterisk-dialer.git /opt/asterisk-dialer

# 3. Enter directory and run automated setup
cd /opt/asterisk-dialer
chmod +x setup.sh
./setup.sh
```

---

## 2. What `setup.sh` Automatically Handles

1. **System & Toolchain Dependencies:**
   - Installs EPEL, development tools (`gcc`, `make`, `patch`), XML/ncurses/OpenSSL/Jansson/SQLite headers.
   - Installs Perl and exact CPAN database drivers required for AGIs (`perl-DBI`, `perl-DBD-MySQL`).
   - Installs Apache (`httpd`), PHP, and `php-mysql`.
   - Installs `fail2ban` and `mariadb-server`.
2. **VoIP Kernel Optimization:**
   - Automatically increases UDP socket buffers (`net.core.rmem_max = 16777216`, `net.core.wmem_max = 16777216`).
   - Expands open file descriptors (`ulimit -n 65535`) for high concurrent call volume.
   - Sets SELinux to permissive mode to allow AGI pipe communication.
3. **Database Configuration:**
   - Starts MariaDB.
   - Creates the `yahoo` database and configures the `smartpremium` database user with password `superadmin`.
   - Restores the complete schema, agent data, and queues from `yahoo_database.sql`.
4. **Asterisk Build & Configuration:**
   - Compiles Asterisk 13.38.3 with Jansson support if not present.
   - Restores the entire `/etc/asterisk/` configuration (`sip.conf`, `pjsip.conf`, `extensions.conf`).
   - Copies all custom AGIs to `/var/lib/asterisk/agi-bin/` and sets execute permissions.
5. **Web Portals & Monitoring:**
   - Restores `/var/www/html/` (`voicedialtech/` and `agent/` portals) with proper Apache permissions.
   - Installs `/usr/local/bin/hourly_report.sh` into root crontab to send automated 30-minute Telegram call health updates.
   - Starts and enables all services (`asterisk`, `mariadb`, `httpd`, `fail2ban`).

---

## 3. Post-Deployment Verification Steps for the AI Agent

Run these commands to verify that every service is 100% active:

```bash
# 1. Check Asterisk status
asterisk -rx "core show version"
asterisk -rx "sip show peers"

# 2. Check Database connectivity
mysql -u smartpremium -psuperadmin -e "USE yahoo; SHOW TABLES;"

# 3. Check Web Portals
curl -I http://127.0.0.1/voicedialtech/
curl -I http://127.0.0.1/agent/

# 4. Check Cron
crontab -l | grep hourly_report.sh
```

---

## 4. AWS Security Group (Firewall) Checklist

Ensure the AWS Security Group attached to this EC2 instance allows:
* **UDP 5060:** SIP Trunk Signaling (Inbound from carrier and agent IPs).
* **UDP 10000 - 20000:** RTP Media Streams (Inbound `0.0.0.0/0`).
* **TCP 80 & 443:** Web Management & Agent Portals.
* **TCP 22:** Admin SSH.
