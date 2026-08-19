<?php 
require('../panel/include/setings.php');
$ip = $_SERVER['REMOTE_ADDR'];
$registro = get_id($ip);
$sts = status($registro);
echo $sts;
?>