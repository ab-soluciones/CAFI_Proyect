<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if(isset($_POST['codigo'])){
$dv= new Models\DetalleVenta();
$dv->setCodigodeBarras($_POST['codigo']);
$dv->setUsuario($_SESSION['login']);
$result = $dv->eliminar();
echo $result;
}
