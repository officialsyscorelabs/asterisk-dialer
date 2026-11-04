#!/bin/sh
# assign a value:
# now print the content of "a":
cd /var/run/asterisk
chmod 777 asterisk.ctl
#asterisk -rx "agent show" | grep -v -e'not logged'
#asterisk -rx "agent show" | grep -v -e'logged in on'
asterisk -rx "core show channels"

