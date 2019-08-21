<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
  header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
  header('location: index.php');
} else if ($_SESSION['acceso'] == "Manager" ||  $_SESSION['acceso'] == "Employes"
) {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dv = new Models\DetalleVenta();
    $dv->eliminar($id);
    header("Location: VVentas.php");
  }
} 
 ?>