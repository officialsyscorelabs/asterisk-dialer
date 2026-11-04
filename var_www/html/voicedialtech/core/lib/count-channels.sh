#!/bin/sh
# assign a value:
# now print the content of "a":
cd /var/run/asterisk
chmod 777 asterisk.ctl
echo "---------------------Total Calls Provider IP 64.237.56.26---------------------------";
asterisk -rx "sip show channels" | grep -c 'provider64'
echo "---------------------Details Provider IP 64.237.56.26---------------------------";
asterisk -rx "sip show channels" | grep -i 'provider64'
echo "---------------------Total Calls Provider IP 5.9.95.14   ---------------------------";
asterisk -rx "sip show channels" | grep -c 's97'
echo "---------------------Details Provider IP 5.9.95.14   ---------------------------";
asterisk -rx "sip show channels" | grep -i 's97'


