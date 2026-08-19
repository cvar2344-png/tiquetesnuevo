<?php
require_once __DIR__ . '/visit_handler.php';
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

$token = $telegram_config['token'];
$chat_id = $telegram_config['chat_id'];

$action = $_GET['action'] ?? 'sendMessage';

if ($action === 'sendMessage') {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!$input || !isset($input['message'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    $url = "https://api.telegram.org/bot$token/sendMessage";
    $postData = [
        'chat_id' => $chat_id,
        'text' => $input['message'],
        'parse_mode' => 'HTML'
    ];

    if (isset($input['reply_markup'])) {
        $postData['reply_markup'] = is_string($input['reply_markup']) ? $input['reply_markup'] : json_encode($input['reply_markup']);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
} elseif ($action === 'getUpdates') {
    $transactionId = $_GET['transactionId'] ?? null;

    if (!$transactionId) {
        echo json_encode(['status' => 'error', 'message' => 'transactionId required']);
        exit;
    }

    $url = "https://api.telegram.org/bot$token/getUpdates";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $apiResponse = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($apiResponse, true);
    $filteredUpdates = [];

    if (isset($data['result']) && is_array($data['result'])) {
        foreach ($data['result'] as $update) {
            // Check callback_query data
            if (isset($update['callback_query']['data'])) {
                if (strpos($update['callback_query']['data'], $transactionId) !== false) {
                    $filteredUpdates[] = $update;
                }
            }
            // Also check message text if needed, but primarily callback buttons
        }
    }
    // Reverse to get the latest action first
    $filteredUpdates = array_reverse($filteredUpdates);

    echo json_encode(['ok' => true, 'result' => $filteredUpdates]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unsupported action']);
}
