<?php

// Your Telegram Bot Token
define('BOT_TOKEN', 'YOUR_BOT_TOKEN');

// Short.io API credentials
define('SHORT_IO_API_KEY', 'sk_wbYbmArZdbN3q1LB'); //Or update with your API_TOKEN
define('SHORT_IO_ENDPOINT', 'https://api.short.io/links');
define('SHORT_IO_DOMAIN', 'h04d.short.gy'); // Replace with your Short.io domain

// State tracking for users
$user_states = [];

// Handle Telegram updates
function handleTelegramUpdate($update) {
    if (!isset($update['message'])) {
        return;
    }

    $chat_id = $update['message']['chat']['id'];
    $text = trim($update['message']['text'] ?? '');

    if ($text === '/start') {
        sendTelegramRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Hello! Send me a link, and I'll shorten it for you."
        ]);
        return;
    }

    // Check if the input is a valid URL
    if (filter_var($text, FILTER_VALIDATE_URL)) {
        $shortResponse = createShortURL($text);
        $shortURL = $shortResponse['shortURL'] ?? 'Error: Unable to create short URL.';

        sendTelegramRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Short URL: $shortURL"
        ]);
    } else {
        sendTelegramRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Please send a valid URL."
        ]);
    }
}

// Create a short URL using Short.io API
function createShortURL($originalURL) {
    $headers = [
        'accept: application/json',
        'authorization: ' . SHORT_IO_API_KEY,
        'content-type: application/json',
    ];

    $data = [
        'originalURL' => $originalURL,
        'domain' => SHORT_IO_DOMAIN,
        'allowDuplicates' => true,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SHORT_IO_ENDPOINT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Send a request to the Telegram API
function sendTelegramRequest($method, $parameters) {
    $url = 'https://api.telegram.org/bot' . BOT_TOKEN . '/' . $method;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Main logic to handle incoming updates
$update = json_decode(file_get_contents('php://input'), true);
handleTelegramUpdate($update);

?>
