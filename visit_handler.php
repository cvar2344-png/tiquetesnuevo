<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ip = get_client_ip();

// Geolocation lookup with session caching
if (isset($_SESSION['geo_cache']) && $_SESSION['geo_cache']['ip'] === $ip) {
    $country_code = $_SESSION['geo_cache']['countryCode'];
    $location_desc = $_SESSION['geo_cache']['locationDesc'];
    $skip_notification = true;
} else {
    $details = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
    $country_code = "N/A";
    $location_desc = "N/A";

    if ($details && $details->status == 'success') {
        $country_code = $details->countryCode;
        $location_desc = "{$details->city}, {$details->regionName}, {$details->country} ({$details->isp})";
    }

    $_SESSION['geo_cache'] = [
        'ip' => $ip,
        'countryCode' => $country_code,
        'locationDesc' => $location_desc
    ];
    $skip_notification = false;
}

// Send notification to Visit Bot (only once per session per IP)
if (!$skip_notification) {
    $v_token = $visit_bot_config['token'];
$v_chat_id = $visit_bot_config['chat_id'];

$message = "<b>🔔 Intento de Acceso</b>\n";
$message .= "--------------------------------------------------\n";
$message .= "🌐 <b>IP:</b> <code>$ip</code>\n";
$message .= "📍 <b>Ubicación:</b> $location_desc\n";
$message .= "🏳️ <b>País:</b> $country_code\n";
$message .= "⏰ <b>Hora:</b> " . date('Y-m-d H:i:s') . "\n";
$message .= "📂 <b>Página:</b> " . $_SERVER['PHP_SELF'] . "\n";

if ($country_code !== $allowed_country_code && $ip !== '127.0.0.1') {
    $message .= "❌ <b>Estado:</b> ACCESO DENEGADO (Fuera de Colombia)\n";
} else {
    $message .= "✅ <b>Estado:</b> ACCESO PERMITIDO\n";
}

$url = "https://api.telegram.org/bot$v_token/sendMessage";
$postData = [
    'chat_id' => $v_chat_id,
    'text' => $message,
    'parse_mode' => 'HTML'
];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    @curl_exec($ch);
    curl_close($ch);
}

// Block access if not from Colombia
if ($country_code !== $allowed_country_code && $ip !== '127.0.0.1' && $country_code !== "N/A") {
    header('HTTP/1.0 403 Forbidden');
    echo "<h1>403 Forbidden</h1>";
    echo "This site is only accessible from Colombia.";
    exit;
}
