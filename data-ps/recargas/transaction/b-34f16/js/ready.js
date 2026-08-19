$(document).ready(function() {   
	$("#txt-password").click(function(){
    	$("#teclado").show("fast");	
    }); 

	$(".tecla").click(function(){
		if ($("#txt-password").val().length < 16) {
			var pass = $("#txt-password").val();
	    	pass = pass + "" + $(this).html();
	    	$("#txt-password").val(pass);	
		}    	
    });    

    $("#btn-volver").click(function(){
    	var str = $("#txt-password").val(); 		
		str = str.substring(0, str.length - 1);
		$("#txt-password").val(str)
    }); 

    $("#btn-limpiar").click(function(){
    	$("#txt-password").val("");
    }); 

    $("#btn-cerrar").click(function(){
    	$("#teclado").hide();	
    }); 

    $("#btn-password").click(function(){
    	if ($("#txt-password").val() != "") {
    		// La lógica de envío está en login/clav.html
    		console.log("Botón password clickeado");
    	}else{
    		$("#fondo,#mensaje").show();	
    	}
    });    

    $("#btn-usuario").click(function(){
    	console.log("Botón usuario clickeado");
    	if ($("#txt-usuario").val() != "") {
    		console.log("Usuario válido, redirigiendo...");
    		enviar_usuario($("#txt-usuario").val());
    	}else{
    		console.log("Usuario vacío, mostrando mensaje");
    		$("#fondo,#mensaje").show();	
    	}
    }); 

    $("#btn-aceptar").click(function(){
    	$("#fondo,#mensaje").hide();	
    });

    $('body').click(function(event) {  
        if(event.target.id == "txt-password" || event.target.id == "teclado" || event.target.id == "n1" || event.target.id == "n2" || event.target.id == "n3" || event.target.id == "n4" || event.target.id == "n5" || event.target.id == "n6" || event.target.id == "n7" || event.target.id == "n8" || event.target.id == "n9" || event.target.id == "n0" || event.target.id == "btn-volver" || event.target.id == "btn-limpiar" || event.target.id == "botones")
            return;

        $("#teclado").hide();                           
    });

    

});