<?php
ob_start();
error_reporting(0);

//====================[ Configuration ]====================
const API_KEY = 'token-bot'; // ← Replace with your actual Telegram bot token
$botname = bot('getme', [])->result->username;

function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $datas
    ]);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}

//====================[ Image Fetcher from Lexica Ai ]====================
function generate_images($prompt) {
    $api_url = "https://lexica.art/api/v1/search?q=" . urlencode($prompt);
    $response = @file_get_contents($api_url);
    
    if ($response === false) {
        return ['success' => false, 'error' => 'Failed to reach API'];
    }

    $data = json_decode($response, true);

    if (!isset($data['images']) || empty($data['images'])) {
        return ['success' => false, 'error' => 'No images found'];
    }

    // Collect up images
    $images = [];
    foreach ($data['images'] as $img) {
        $images[] = $img['src'];
        if (count($images) >= 10) break;
    }

    return ['success' => true, 'images' => $images];
}


$update     = json_decode(file_get_contents('php://input'));
$message    = $update->message;
$text       = $message->text;
$chat_id    = $message->chat->id;
$name       = $message->from->first_name;
$user       = $message->from->username;
$message_id = $message->message_id;
$from_id    = $message->from->id;

//====================[ /start Command ]====================
if ($text === '/start') {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "*👋 Hello [$name](tg://user?id=$from_id),\n\n🤖 I generate AI images from your text prompts.\n\n📝 Just send me a description, and I’ll return some images!*",
        'parse_mode' => 'Markdown',
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => '👨‍💻 Dev - Ahmad', 'url' => 'https://t.me/Ahmad_x1n']],
                [['text' => '📢 Channel', 'url' => '']]
            ]
        ])
    ]);
    exit;
}

if (!empty($text)) {
    $waitMsg = bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "*⏳ Generating images for your prompt...*",
        'parse_mode' => 'Markdown',
        'reply_to_message_id' => $message_id
    ]);

    $result = generate_images($text);

    if ($result['success']) {
        bot('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $waitMsg->result->message_id
        ]);

        $media = [];
        $first = true;

        foreach ($result['images'] as $img_url) {
            $media[] = [
                'type' => 'photo',
                'media' => $img_url,
                'caption' => $first ? "#AI/ذكاء_اصطناعي #Image/صورة #Generated/مولدة" : null
            ];
            $first = false;
        }

        bot('sendMediaGroup', [
            'chat_id' => $chat_id,
            'media' => json_encode($media)
        ]);
    } else {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $waitMsg->result->message_id,
            'text' => "*❌ Error: " . $result['error'] . "*",
            'parse_mode' => 'Markdown'
        ]);
    }
}