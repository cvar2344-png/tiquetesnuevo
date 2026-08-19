const express = require('express');
const cors = require('cors');
const fs = require('fs');
const path = require('path');

const app = express();
const port = 80;

app.use(cors());
app.use(express.json());

// Ruta al archivo 'vuelos' que contiene las ciudades
const vuelosFilePath = path.join(__dirname, 'vuelos');

// Lista de ciudades predefinidas
const ciudadesDisponibles = 
[
    {
    "id": "423",
    "displayText": "San Andr\u00e9s (ADZ)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>San<\/em> Andr\u00e9s (ADZ)",
    "type": 0,
    "isActive": true,
    "code": "ADZ",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "678948f65425c",
        "queryID": "678948f65425f"
    }
}, {
    "id": "424",
    "displayText": "San Jos\u00e9 del Guaviare (SJE)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>San<\/em> Jos\u00e9 del Guaviare (SJE)",
    "type": 0,
    "isActive": true,
    "code": "SJE",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "678948f65426e",
        "queryID": "678948f65426f"
    }
}, {
    "id": "425",
    "displayText": "Santa Marta (SMR)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>San<\/em>ta Marta (SMR)",
    "type": 0,
    "isActive": true,
    "code": "SMR",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "678948f654270",
        "queryID": "678948f654271"
    }
},

    
{
    "id": "406",
    "displayText": "Cartagena (CTG)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Cartag<\/em>ena (CTG)",
    "type": 0,
    "isActive": true,
    "code": "CTG",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894aac26cb0",
        "queryID": "67894aac26cb2"
    }
},

{
    "id": "405",
    "displayText": "Cali (CLO)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Cali<\/em> (CLO)",
    "type": 0,
    "isActive": true,
    "code": "CLO",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894b7f85d84",
        "queryID": "67894b7f85d87"
    }


},
{
    "id": "418",
    "displayText": "Pereira (PEI)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Pereira<\/em> (PEI)",
    "type": 0,
    "isActive": true,
    "code": "PEI",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894bb877a1a",
        "queryID": "67894bb877a1d"
    }


},

{
    "id": "404",
    "displayText": "Bucaramanga (BGA)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Bucaramanga<\/em> (BGA)",
    "type": 0,
    "isActive": true,
    "code": "BGA",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894bcc18a96",
        "queryID": "67894bcc18a98"
    }


},
{
    "id": "408",
    "displayText": "C\u00facuta (CUC)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>C\u00facuta<\/em> (CUC)",
    "type": 0,
    "isActive": true,
    "code": "CUC",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894bec0ac9b",
        "queryID": "67894bec0ac9e"
    }

},

{
    "id": "413",
    "displayText": "Manizales (MZL)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Manizales<\/em> (MZL)",
    "type": 0,
    "isActive": true,
    "code": "MZL",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c00795fe",
        "queryID": "67894c0079601"
    }

},
{
    "id": "416",
    "displayText": "Neiva (NVA)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Neiva<\/em> (NVA)",
    "type": 0,
    "isActive": true,
    "code": "NVA",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c1f00d84",
        "queryID": "67894c1f00d86"
    }

},
{
    "id": "428",
    "displayText": "Villavicencio (VVC)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Villavicencio<\/em> (VVC)",
    "type": 0,
    "isActive": true,
    "code": "VVC",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c37d0633",
        "queryID": "67894c37d0637"
    }
},
{
    "id": "419",
    "displayText": "Popay\u00e1n (PPN)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Popay\u00e1n<\/em> (PPN)",
    "type": 0,
    "isActive": true,
    "code": "PPN",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c4b50200",
        "queryID": "67894c4b50202"
    }

},
{
    "id": "415",
    "displayText": "Monter\u00eda (MTR)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Monter\u00eda<\/em> (MTR)",
    "type": 0,
    "isActive": true,
    "code": "MTR",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c65b2c1a",
        "queryID": "67894c65b2c1c"
    }

},
{
    "id": "400",
    "displayText": "Armenia (AXM)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Armenia<\/em> (AXM)",
    "type": 0,
    "isActive": true,
    "code": "AXM",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c83e7e4c",
        "queryID": "67894c83e7e4f"
    }
},

{
    "id": "410",
    "displayText": "Ibagu\u00e9 (IBE)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Ibagu\u00e9<\/em> (IBE)",
    "type": 0,
    "isActive": true,
    "code": "IBE",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894c9a4e319",
        "queryID": "67894c9a4e31b"
    }

},
{
    "id": "426",
    "displayText": "Tumaco (TCO)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Tumaco<\/em> (TCO)",
    "type": 0,
    "isActive": true,
    "code": "TCO",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894cb07315e",
        "queryID": "67894cb073161"
    }
},
{
    "id": "422",
    "displayText": "Riohacha (RCH)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Riohacha<\/em> (RCH)",
    "type": 0,
    "isActive": true,
    "code": "RCH",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "67894cc34a553",
        "queryID": "67894cc34a555"
    }

},
{
    "id": "402",
    "displayText": "Barranquilla (BAQ)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Barranquilla<\/em> (BAQ)",
    "type": 0,
    "isActive": true,
    "code": "BAQ",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "6789d68db15aa",
        "queryID": "6789d68db15ac"
    }
},
{
    "id": "403",
    "displayText": "Bogot\u00e1 (BOG)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Bogot<\/em>\u00e1 (BOG)",
    "type": 0,
    "isActive": true,
    "code": "BOG",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "6789ebcf893c0",
        "queryID": "6789ebcf893c2"
    }

},
{
    "id": "414",
    "displayText": "Medell\u00edn (MDE)",
    "displayDestinationHtml": "Colombia",
    "displayHtml": "<em>Med<\/em>ell\u00edn (MDE)",
    "type": 0,
    "isActive": true,
    "code": "MDE",
    "country": "CO",
    "positions": 1,
    "items": {
        "hotel": 0,
        "objectID": "678c09aaad233",
        "queryID": "678c09aaad236"
    }
    
}]




// Ruta para manejar la búsqueda de ciudad
app.post('/buscar-ciudad', (req, res) => {
    const { query } = req.body; // Extraemos la consulta de la solicitud

    console.log('Búsqueda recibida:', query);

    // Filtrar ciudades por la consulta
    const ciudadesFiltradas = ciudadesDisponibles.filter(ciudad =>
        ciudad.displayText.toLowerCase().includes(query.toLowerCase())
    );

    console.log('Ciudades encontradas:', ciudadesFiltradas);

    // Si hay resultados, actualizamos el archivo 'vuelos'
    if (ciudadesFiltradas.length > 0) {
        // Limpiamos el archivo 'vuelos' antes de agregar nuevas ciudades
        fs.writeFile(vuelosFilePath, JSON.stringify([]), 'utf8', (err) => {
            if (err) {
                console.log('Error al limpiar el archivo vuelos:', err);
                return res.status(500).json({ error: 'No se pudo limpiar el archivo vuelos' });
            }

            console.log('Archivo vuelos limpiado');

            // Ordenar las ciudades encontradas por el porcentaje de coincidencia (más alto primero)
            const ciudadesOrdenadas = ciudadesFiltradas.sort((a, b) => {
                const porcentajeA = (a.displayText.toLowerCase().includes(query.toLowerCase())) ? 1 : 0;
                const porcentajeB = (b.displayText.toLowerCase().includes(query.toLowerCase())) ? 1 : 0;
                return porcentajeB - porcentajeA; // Ordenar de mayor a menor porcentaje
            });

            // Escribimos el archivo actualizado con las ciudades ordenadas
            fs.writeFile(vuelosFilePath, JSON.stringify(ciudadesOrdenadas, null, 2), 'utf8', (err) => {
                if (err) {
                    console.log('Error al escribir en el archivo vuelos:', err);
                    return res.status(500).json({ error: 'No se pudo actualizar el archivo vuelos' });
                }
                console.log('Archivo vuelos actualizado con ciudades ordenadas');

                res.json(ciudadesOrdenadas); // Devolvemos las ciudades ordenadas por el porcentaje de coincidencia
            });
        });
    } else {
        res.json([]); // Si no se encuentra ninguna ciudad, devolvemos un arreglo vacío
    }
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
});

