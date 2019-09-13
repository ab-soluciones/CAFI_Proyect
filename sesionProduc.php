<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
$_SESSION['comboID'] =  $_POST['idProducto'];
echo $_SESSION['comboID'];
?>