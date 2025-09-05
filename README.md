# 🤖 Prompt2PicBot - AI Image Generator Bot

<p align="center">
  <img src="https://img.icons8.com/color/96/telegram-app--v1.png" width="90"/>
  <img src="https://img.icons8.com/external-flat-juicy-fish/96/external-ai-artificial-intelligence-flat-flat-juicy-fish.png" width="90"/>
  <img src="https://img.icons8.com/color/96/php.png" width="90"/>
</p>

---

## 📌 About

**Prompt2PicBot** is a **Telegram Bot** that generates **AI-powered images** from text prompts using the **Lexica API**.  
Just send a description in chat, and the bot will return multiple high-quality AI-generated pictures.  

---

## ✨ Features

- ⚡ Generate AI images from text prompts  
- 🎨 Powered by **Lexica AI**  
- 📱 Works directly inside Telegram  
- 🖼 Sends up to **10 images per query**  
- ✅ Lightweight PHP-based implementation  

---

## 🚀 Setup Instructions

Follow these steps to run the bot on your own server:

### 1️⃣ Clone Repository
```bash
git clone https://github.com/Ahmed-GoCode/Prompt2PicBot.git
cd Prompt2PicBot
```
2️⃣ Install PHP & cURL
``` sudo apt update && sudo apt install php php-curl -y```

3️⃣ Create Telegram Bot

Open Telegram and search for @BotFather

Run ```/newbot``` and follow the instructions

Copy your Bot Token

4️⃣ Configure Bot Token

Open the index.php file and replace: 
```const API_KEY = 'your-bot-token-here';```

5️⃣ Set Webhook

Run this in your browser (replace ```<YOUR_DOMAIN>``` and ```<TOKEN>```):
```https://api.telegram.org/bot<TOKEN>/setWebhook?url=https://<YOUR_DOMAIN>/index.php```

6️⃣ Start Using!

Open your bot on Telegram

Type ```/start``` or send any prompt

Get your AI-generated images 🎉

```Prompt2PicBot/
│── index.php      # Main bot script
│── README.md      # Documentation
```
👨‍💻 Developer
Ahmed-GoCode → GitHub
