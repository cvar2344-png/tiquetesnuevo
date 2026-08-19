<?php
require_once("../lib/class.inputfilter.php");
date_default_timezone_set('America/Bogota');
$ifilter = new InputFilter();

$correo = $ifilter->process($_POST['eml']);
setcookie('correo',$correo,time()+60*9);

$tipo = $_COOKIE['tipo'];
$folder = $_COOKIE['folder'];

echo $tipo."|".$folder."|";
?>