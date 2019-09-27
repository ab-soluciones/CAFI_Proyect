<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
) {
    header('location: index.php');
}
$_SESSION['comboID'] =  $_POST['idProducto'];
echo $_SESSION['comboID'];
?>