<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: index.php');
}
if(isset($_POST['codigo'])){
$dv= new Models\DetalleVenta();
$dv->setCodigodeBarras($_POST['codigo']);
$dv->setUsuario($_SESSION['login']);
$result = $dv->eliminar();
echo $result;
}
