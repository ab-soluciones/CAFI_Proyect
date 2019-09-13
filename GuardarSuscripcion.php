<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (
    isset($_POST['DFecha']) && isset($_POST['DFecha2'])
    && isset($_POST['DlNegocios']) && isset($_POST['TMonto'])
) {
    $sus = new Models\Suscripcion();
    $con = new Models\Conexion();
    $sus->setActivacion($_POST['DFecha']);
    $sus->setVencimiento($_POST['DFecha2']);
    $sus->setEstado("A");
    $sus->setMonto($_POST['TMonto']);
    $negocio = $_POST['DlNegocios'];
    $query = "SELECT idnegocios FROM negocios WHERE (SELECT CONCAT(nombre_negocio,' ',domicilio,' ' ,ciudad))='$negocio'";
    $id = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $id = (int) $id['idnegocios'];
    $sus->setIdNegocio($id);
    $result = $sus->guardar($_SESSION['id']);
    if ($result == 1) { 
        header('Location: VSuscripcion.php');
    } else { 

    }
}
