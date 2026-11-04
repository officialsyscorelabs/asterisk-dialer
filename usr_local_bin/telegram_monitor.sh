#!/bin/bash
TOKEN="8789853199:AAF3LsusBa8QXUHB5uWKBK_HfQWrMs4Cehw"
CHAT_IDS=("7007833843" "1533847522")

send_telegram() {
    local message="$1"
    for cid in "${CHAT_IDS[@]}"; do
        curl -s -X POST "https://api.telegram.org/bot${TOKEN}/sendMessage" \
            -d chat_id="${cid}" \
            -d text="${message}" > /dev/null
    done
}

send_telegram "✅ Dialer Security Engine Started. Monitoring for threats..."

# Ignore list for benign warnings and config reload syntax notices
IGNORE_PATTERN="non-critical invite transaction|Retransmission timeout|already banned|deprecated|Unknown insecure|already in use|Unable to register extension|No certificate file|sent to invalid extension"

tail -n 0 -F /var/log/asterisk/messages /var/log/fail2ban.log 2>/dev/null | while read line; do
    if echo "$line" | grep -qE "(WARNING|ERROR|Ban )"; then
        if ! echo "$line" | grep -qE "$IGNORE_PATTERN"; then
            send_telegram "🚨 ALERT: $line"
        fi
    fi
done
