#!/usr/bin/env python3
import sys
import re
import os
import urllib.request
import urllib.parse
from datetime import datetime

COUNTRY_CODES_1 = {"1", "7"}
COUNTRY_CODES_2 = {
    "20", "27", "30", "31", "32", "33", "34", "36", "39",
    "40", "41", "43", "44", "45", "46", "47", "48", "49",
    "51", "52", "53", "54", "55", "56", "57", "58",
    "60", "61", "62", "63", "64", "65", "66",
    "81", "82", "84", "86",
    "90", "91", "92", "93", "94", "95", "98"
}

KNOWN_PREFIXES = [
    "8080#", "8081#", "8082#", "8181#", "8282#", "8383#", "9999#",
    "5031#", "5050#", "5051#", "5052#", "5053#", "6060#", "7070#",
    "11#", "22#", "33#", "44#", "55#", "66#", "77#", "88#",
    "749477", "2727271", "808080", "66666",
    "7171#", "7171", "7899", "8888", "9898", "7777", "8383",
    "5049", "5050", "5051", "5052", "5053", "6060", "7070", "5055", "5151", "5252", "5353", "5454", "5555", "5656", "5757",
    "11", "22", "33", "44", "55", "66", "77", "88", "099"
]

def log_agi(msg):
    sys.stderr.write(f"fraud_guard: {msg}\n")
    sys.stderr.flush()

def read_agi_headers():
    headers = {}
    while True:
        line = sys.stdin.readline()
        if not line or line.strip() == "":
            break
        parts = line.strip().split(":", 1)
        if len(parts) == 2:
            headers[parts[0].strip()] = parts[1].strip()
    return headers

def send_agi_cmd(cmd):
    sys.stdout.write(f"{cmd}\n")
    sys.stdout.flush()
    return sys.stdin.readline()

def send_telegram_alert(exten, pfx, cc, pat, cid):
    try:
        TOKEN = "8789853199:AAF3LsusBa8QXUHB5uWKBK_HfQWrMs4Cehw"
        CHAT_IDS = ["7007833843", "1533847522"]
        msg = (
            "🛡️ *FRAUD CALL BLOCKED*\n"
            f"📞 *Dialed:* `{exten}`\n"
            f"🏷️ *Prefix:* `{pfx or 'None'}` | *CC:* `+{cc}`\n"
            f"⚠️ *Pattern Detected:* `{pat}` (3+ same digits)\n"
            f"👤 *Caller ID:* `{cid}`\n"
            "🚫 *Action:* Immediate Hangup (Cause 21 / SIP 603)"
        )
        for cid_num in CHAT_IDS:
            data = urllib.parse.urlencode({"chat_id": cid_num, "text": msg, "parse_mode": "Markdown"}).encode()
            req = urllib.request.Request(f"https://api.telegram.org/bot{TOKEN}/sendMessage", data=data)
            urllib.request.urlopen(req, timeout=1.2)
    except Exception as e:
        log_agi(f"Telegram alert error: {e}")

def parse_number(raw):
    prefix = ""
    rest = raw
    if "#" in raw:
        idx = raw.index("#")
        prefix = raw[:idx+1]
        rest = raw[idx+1:]
    else:
        # Check against known prefixes first
        for p in KNOWN_PREFIXES:
            if not p.endswith("#") and raw.startswith(p):
                prefix = p
                rest = raw[len(p):]
                break
        # Dynamic check if raw is long (e.g. 14+ digits) and starts with a 4-digit routing prefix
        if not prefix and len(raw) >= 14:
            cand_rest = raw[4:]
            if (len(cand_rest) >= 2 and cand_rest[:2] in COUNTRY_CODES_2) or (len(cand_rest) >= 1 and cand_rest[:1] in COUNTRY_CODES_1):
                prefix = raw[:4]
                rest = cand_rest

    # Extract Country Code (1 to 3 digits)
    cc = ""
    sub = rest
    if len(rest) >= 2 and rest[:2] in COUNTRY_CODES_2:
        cc = rest[:2]
        sub = rest[2:]
    elif len(rest) >= 1 and rest[:1] in COUNTRY_CODES_1:
        cc = rest[:1]
        sub = rest[1:]
    elif len(rest) >= 3:
        cc = rest[:3]
        sub = rest[3:]

    return prefix, cc, sub

def main():
    headers = read_agi_headers()
    exten = headers.get("agi_extension", "")
    cid = headers.get("agi_callerid", "")

    if not exten:
        res = send_agi_cmd("GET VARIABLE EXTEN")
        # Extract from response
        m = re.search(r"\((.*?)\)", res)
        if m:
            exten = m.group(1)

    raw = exten.strip()
    prefix, cc, sub = parse_number(raw)

    # Inspect first 6 digits after Country Code for 4 consecutive identical digits
    lead_sub = sub[:6]
    match = re.search(r"(\d)\1{2}", lead_sub)

    if match:
        fraud_pattern = match.group(0)
        log_agi(f"FRAUD DETECTED: exten={exten} pfx={prefix} cc={cc} sub={sub} match={fraud_pattern}")

        try:
            with open("/var/log/asterisk/fraud_blocked.log", "a") as f:
                now_str = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
                f.write(f"[{now_str}] BLOCKED exten={exten} pfx={prefix} cc={cc} pattern={fraud_pattern} cid={cid}\n")
        except Exception:
            pass

        send_agi_cmd("SET VARIABLE FRAUD_STATUS BLOCKED")
        send_agi_cmd(f"SET VARIABLE FRAUD_PATTERN {fraud_pattern}")
        send_telegram_alert(exten, prefix, cc, fraud_pattern, cid)
    else:
        send_agi_cmd("SET VARIABLE FRAUD_STATUS CLEAN")

if __name__ == "__main__":
    main()
