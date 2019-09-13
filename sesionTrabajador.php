<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
$_SESSION['idnegocio'] =  $_POST['idSucursal'];
echo $_SESSION['idnegocio'];
?>