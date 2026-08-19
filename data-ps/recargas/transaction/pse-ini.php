<?php
echo <<<EOT
<script>
(function() {
  const raw = localStorage.getItem('total_pagar');
  try {
    // Si es un objeto JSON, extraer total
    if (raw && raw.includes('{')) {
      const obj = JSON.parse(raw);
      const total = parseInt(obj.total) || 0;
      localStorage.setItem('total_pagar', total);
    }
  } catch (e) {
    console.warn("Error al convertir total_pagar:", e);
    localStorage.setItem('total_pagar', 0);
  }
})();
</script>
EOT;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Pago</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    body {
      font-family: sans-serif;
      background: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .encabezado img,
    .pie img {
      width: 100%;
      height: auto;
      display: block;
    }
    .contenido {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .contenido img {
      max-width: 110%;
      height: auto;
    }
  </style>
</head>
<body>

  <div class="encabezado">
    <img src="img/1.jpg" alt="Encabezado">
  </div>

  <div class="contenido">
    <img src="img/gift.gif" alt="Procesando...">
  </div>

  <div class="pie">
    <img src="img/pie.jpg" alt="Pie de página">
  </div>

  <script>

    // Redirigir después de una breve pausa
    setTimeout(() => {
      window.location.href = "portal.php";
    }, 1500);
  </script>

</body>
</html>
