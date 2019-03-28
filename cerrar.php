<?php 
session_start();

//procedo a destruir la sesion
session_destroy();
//limpio el array de SESSION
$_SESSION = array(); 
//redirecciono al login
header('Location: login.php');
exit;
?>