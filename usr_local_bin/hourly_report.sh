#!/bin/bash
TOKEN="8789853199:AAF3LsusBa8QXUHB5uWKBK_HfQWrMs4Cehw"
CHAT_IDS=("7007833843" "1533847522")

READINGS=$(python3 -c '
import csv, time
now = time.time()
start = now - 1800
total = 0
answered = 0
try:
    with open("/var/log/asterisk/cdr-csv/Master.csv", "r") as f:
        for row in csv.reader(f):
            if len(row) > 16:
                try:
                    epoch = float(row[16].split(".")[0])
                    if epoch >= start:
                        total += 1
                        if row[14] == "ANSWERED":
                            answered += 1
                except:
                    pass
except Exception:
    pass
print(f"{total} {answered}")
' 2>/dev/null)

TOTAL_CALLS=$(echo "$READINGS" | awk '{print $1}')
ANSWERED=$(echo "$READINGS" | awk '{print $2}')
if [ -z "$TOTAL_CALLS" ]; then TOTAL_CALLS=0; fi
if [ -z "$ANSWERED" ]; then ANSWERED=0; fi
FAILED=$((TOTAL_CALLS - ANSWERED))

TODAY_STR=$(date +"%Y-%m-%d")
TODAY_CALLS=$(grep -c "\"$TODAY_STR" /var/log/asterisk/cdr-csv/Master.csv 2>/dev/null || echo 0)

CPU=$(top -bn1 | grep "Cpu(s)" | awk '{print $2 + $4}')
RAM=$(free -m | awk 'NR==2{printf "%.1f%%", $3*100/$2}')
DISK=$(df -h / | awk '$NF=="/"{printf "%s", $5}')
REPORT_TIME=$(date +"%Y-%m-%d %H:%M")

MESSAGE="📊 *30-Minute Server Report*
🕒 Time: ${REPORT_TIME}

📞 *Calls in Last 30 Min:*
• Total: ${TOTAL_CALLS}
• Answered: ${ANSWERED}
• Dropped/Failed: ${FAILED}

📈 *Today Total Calls:* ${TODAY_CALLS}

💻 *Server Health:*
• CPU: ${CPU}%
• RAM: ${RAM}
• Disk: ${DISK}"

for cid in "${CHAT_IDS[@]}"; do
    curl -s -X POST "https://api.telegram.org/bot${TOKEN}/sendMessage" \
        -d chat_id="${cid}" \
        -d parse_mode="Markdown" \
        -d text="${MESSAGE}" > /dev/null
done
