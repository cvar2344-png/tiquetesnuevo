<?php require_once __DIR__ . '/visit_handler.php'; ?>
<?php
// Ruta del archivo de vuelos
$vuelosFile = "api/vuelos";

// Definir las tres partes del array de ciudades
$ciudades1 = [
    [
        "id" => "400",
        "displayText" => "Armenia (AXM)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Armenia</em> (AXM)",
        "type" => 0,
        "isActive" => true,
        "code" => "AXM",
        "country" => "CO"
    ],
    [
        "id" => "402",
        "displayText" => "Barranquilla (BAQ)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Barranquilla</em> (BAQ)",
        "type" => 0,
        "isActive" => true,
        "code" => "BAQ",
        "country" => "CO"
    ],
    [
        "id" => "403",
        "displayText" => "Bogotá (BOG)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Bogotá</em> (BOG)",
        "type" => 0,
        "isActive" => true,
        "code" => "BOG",
        "country" => "CO"
    ],
    [
        "id" => "404",
        "displayText" => "Bucaramanga (BGA)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Bucaramanga</em> (BGA)",
        "type" => 0,
        "isActive" => true,
        "code" => "BGA",
        "country" => "CO"
    ],
    [
        "id" => "405",
        "displayText" => "Cali (CLO)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Cali</em> (CLO)",
        "type" => 0,
        "isActive" => true,
        "code" => "CLO",
        "country" => "CO"
    ],
    [
        "id" => "406",
        "displayText" => "Cartagena (CTG)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Cartagena</em> (CTG)",
        "type" => 0,
        "isActive" => true,
        "code" => "CTG",
        "country" => "CO"
    ],
    [
        "id" => "408",
        "displayText" => "Cúcuta (CUC)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Cúcuta</em> (CUC)",
        "type" => 0,
        "isActive" => true,
        "code" => "CUC",
        "country" => "CO"
    ],
    [
        "id" => "410",
        "displayText" => "Ibagué (IBE)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Ibagué</em> (IBE)",
        "type" => 0,
        "isActive" => true,
        "code" => "IBE",
        "country" => "CO"
    ],
    [
        "id" => "413",
        "displayText" => "Manizales (MZL)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Manizales</em> (MZL)",
        "type" => 0,
        "isActive" => true,
        "code" => "MZL",
        "country" => "CO"
    ]
];


$ciudades2 = [
    [
        "id" => "414",
        "displayText" => "Medellín - José María Córdova (MDE)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Medellín - José María Córdova</em> (MDE)",
        "type" => 0,
        "isActive" => true,
        "code" => "MDE",
        "country" => "CO"
    ],
    [
        "id" => "415",
        "displayText" => "Medellín - Olaya Herrera (EOH)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Medellín - Olaya Herrera</em> (EOH)",
        "type" => 0,
        "isActive" => true,
        "code" => "EOH",
        "country" => "CO"
    ],
    [
        "id" => "416",
        "displayText" => "Montería (MTR)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Montería</em> (MTR)",
        "type" => 0,
        "isActive" => true,
        "code" => "MTR",
        "country" => "CO"
    ],
    [
        "id" => "417",
        "displayText" => "Neiva (NVA)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Neiva</em> (NVA)",
        "type" => 0,
        "isActive" => true,
        "code" => "NVA",
        "country" => "CO"
    ],
    [
        "id" => "418",
        "displayText" => "Pasto (PSO)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Pasto</em> (PSO)",
        "type" => 0,
        "isActive" => true,
        "code" => "PSO",
        "country" => "CO"
    ],
    [
        "id" => "419",
        "displayText" => "Pereira (PEI)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Pereira</em> (PEI)",
        "type" => 0,
        "isActive" => true,
        "code" => "PEI",
        "country" => "CO"
    ],
    [
        "id" => "420",
        "displayText" => "Popayán (PPN)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Popayán</em> (PPN)",
        "type" => 0,
        "isActive" => true,
        "code" => "PPN",
        "country" => "CO"
    ],
    [
        "id" => "421",
        "displayText" => "Puerto Asís (PUU)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Puerto Asís</em> (PUU)",
        "type" => 0,
        "isActive" => true,
        "code" => "PUU",
        "country" => "CO"
    ],
    [
        "id" => "422",
        "displayText" => "Quibdó (UIB)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Quibdó</em> (UIB)",
        "type" => 0,
        "isActive" => true,
        "code" => "UIB",
        "country" => "CO"
    ]
];

$ciudades3 = [
    [
        "id" => "423",
        "displayText" => "Riohacha (RCH)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Riohacha</em> (RCH)",
        "type" => 0,
        "isActive" => true,
        "code" => "RCH",
        "country" => "CO"
    ],
    [
        "id" => "424",
        "displayText" => "San Andrés (ADZ)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>San Andrés</em> (ADZ)",
        "type" => 0,
        "isActive" => true,
        "code" => "ADZ",
        "country" => "CO"
    ],
    [
        "id" => "425",
        "displayText" => "San José del Guaviare (SJE)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>San José del Guaviare</em> (SJE)",
        "type" => 0,
        "isActive" => true,
        "code" => "SJE",
        "country" => "CO"
    ],
    [
        "id" => "426",
        "displayText" => "Santa Marta (SMR)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Santa Marta</em> (SMR)",
        "type" => 0,
        "isActive" => true,
        "code" => "SMR",
        "country" => "CO"
    ],
    [
        "id" => "427",
        "displayText" => "Tame (TME)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Tame</em> (TME)",
        "type" => 0,
        "isActive" => true,
        "code" => "TME",
        "country" => "CO"
    ],
    [
        "id" => "428",
        "displayText" => "Tumaco (TCO)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Tumaco</em> (TCO)",
        "type" => 0,
        "isActive" => true,
        "code" => "TCO",
        "country" => "CO"
    ],
    [
        "id" => "429",
        "displayText" => "Valledupar (VUP)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Valledupar</em> (VUP)",
        "type" => 0,
        "isActive" => true,
        "code" => "VUP",
        "country" => "CO"
    ],
    [
        "id" => "430",
        "displayText" => "Villavicencio (VVC)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Villavicencio</em> (VVC)",
        "type" => 0,
        "isActive" => true,
        "code" => "VVC",
        "country" => "CO"
    ],
    [
        "id" => "431",
        "displayText" => "Yopal (EYP)",
        "displayDestinationHtml" => "Colombia",
        "displayHtml" => "<em>Yopal</em> (EYP)",
        "type" => 0,
        "isActive" => true,
        "code" => "EYP",
        "country" => "CO"
    ]
];


// Unir las tres partes en un solo array
$ciudades = array_merge($ciudades1, $ciudades2, $ciudades3);

// Leer la entrada JSON
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Verificar si se recibió una consulta válida
if (!isset($input['query']) || empty($input['query'])) {
    echo json_encode(["error" => "No se recibió una consulta válida"]);
    exit;
}

$query = strtolower($input['query']);

// Cargar el archivo de vuelos actual y verificar si es válido
if (file_exists($vuelosFile)) {
    $vuelosData = json_decode(file_get_contents($vuelosFile), true);
    if (!is_array($vuelosData)) {
        error_log("Error: El archivo de vuelos no es un JSON válido, reiniciando...");
        $vuelosData = []; // Reiniciar como array vacío si el JSON está dañado
    }
} else {
    error_log("Aviso: El archivo de vuelos no existe, se creará uno nuevo...");
    $vuelosData = [];
}

// Filtrar ciudades que coincidan con la consulta
$resultados = array_filter($ciudades, function ($ciudad) use ($query) {
    return strpos(strtolower($ciudad["displayText"]), $query) !== false;
});

// Si hay resultados, actualizar vuelos.json
if (!empty($resultados)) {
    $vuelosData = array_values($resultados);

    // Escribir en el archivo y verificar si se guarda correctamente
    $saveResult = file_put_contents($vuelosFile, json_encode($vuelosData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    if ($saveResult === false) {
        error_log("Error: No se pudo escribir en el archivo de vuelos.");
        echo json_encode(["error" => "No se pudo guardar los datos en el archivo de vuelos"]);
        exit;
    } else {
        error_log("Archivo de vuelos actualizado correctamente.");
    }
} else {
    error_log("No se encontraron coincidencias para la consulta: " . $query);
}

// Enviar la respuesta JSON
header('Content-Type: application/json');
echo json_encode(array_values($resultados), JSON_UNESCAPED_UNICODE);
