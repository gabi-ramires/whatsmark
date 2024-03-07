#!/bin/bash

chat_id=$1

curl 'http://127.0.0.1:8000/api/client/sendMessage/'"$chat_id" \
  -H 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7' \
  -H 'Connection: keep-alive' \
  -H 'Content-Type: application/json' \
  -H 'Cookie: usuarioLogado=true; XSRF-TOKEN=eyJpdiI6InBRdU41QXZvN0JFQkZudzgwQmJLaEE9PSIsInZhbHVlIjoiSFZLVkhSd1MwVkZKcCtXNUZud0ptMlZqRFVrTzZDSnN0ZllBRlFKM1hMVmIxVWZYWjFnc005UlBMZjhySzJXQU8xS2VoU1k1VWxVYTR5OVZWWHgzSFJ1NSswRm5aTkxZSERNbkFyM2tIdVlYM2NoL0NUaWJrblgxQnJzTDZlMjEiLCJtYWMiOiIyMjg1ZWFjOTQ5ZTFjMWJmMzZhMTU5ZGNlOWVmZWNhZGFjOTQ5ZDQ0OTExZWEyMzhmZTY2M2E0MTM5ODM2OTUzIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6ImI3Q3NpcklzbUtiVjZQK0Y0TVRUWEE9PSIsInZhbHVlIjoiM0VyUmxoVGVlMll5Z1c1bHloS2NhUUk1TGFzMVNSMjdWUmFzTmlZK3hHMWVpMkxBNmJZSXlSS2hBTU8zU256NlJHTG5mbTFtSmkrZWxBNG4wTGdWWXpJdkFJcGRyZzg0bk03Q1RzNE5BTXR3bXRXNklKSE1sTEVSdHZXR1QvK0oiLCJtYWMiOiJlODZmZDJlMDQ1ZWZiODlhNmIyZGQ1NmFkZGE2MjZmZTc0NjMzMGM1N2NjYzQ4Yjk2OWY1NmJmOTFiMzJiNjVkIiwidGFnIjoiIn0%3D' \
  -H 'Origin: http://127.0.0.1:8000' \
  -H 'Referer: http://127.0.0.1:8000/nova-campanha' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36' \
  -H 'accept: */*' \
  -H 'sec-ch-ua: "Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"' \
  -H 'sec-ch-ua-mobile: ?0' \
  -H 'sec-ch-ua-platform: "Linux"' \
  --data-raw $'{"chatId":"555180187026@c.us","contentType":"string","content":"Seja bem vindo ao *WhatsMark*\u0021 😎\\n\\nCrie suas campanhas com imagens, emojis, botões e muito mais\u0021 🤩🚀"}' \
  --compressed