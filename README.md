# Asterisk Dialer & Telephony Platform

Enterprise Asterisk PBX, Custom AGI Scripts, MariaDB Database, and Web Management Portals.

---

## Automated Deployment on AWS EC2

To deploy this entire stack onto a fresh AWS EC2 instance (CentOS 7 x86_64 / RHEL 7), run:

```bash
sudo su -
git clone https://github.com/officialsyscorelabs/asterisk-dialer.git /opt/asterisk-dialer
cd /opt/asterisk-dialer
chmod +x setup.sh
./setup.sh
```

For complete instructions tailored for AI agents and DevOps engineers, see:
👉 [**AI_AGENT_DEPLOYMENT_GUIDE.md**](./AI_AGENT_DEPLOYMENT_GUIDE.md)

---

## Included Components

* **Asterisk PBX Configuration:** `/etc/asterisk/` (`sip.conf`, `extensions.conf`, `pjsip.conf`)
* **AGI Telephony Scripts:** `/var/lib/asterisk/agi-bin/`
* **Web Portals:** `/var/www/html/` (`voicedialtech/` and `agent/`)
* **Database Dump:** `yahoo_database.sql` and `all_databases.sql`
* **Automations & Monitoring:** `/usr/local/bin/hourly_report.sh` (Telegram alerts)
* **Kernel & VoIP Tuning:** High-throughput UDP buffer profiles
