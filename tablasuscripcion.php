<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    || $_SESSION['acceso'] == "CEO"
) {
    header('location: index.php');
}
$con = new Models\Conexion();
$query = "SELECT idsuscripcion , fecha_activacion,fecha_vencimiento ,suscripcion.estado, monto, nombre_negocio,ciudad,domicilio,nombre,apaterno FROM suscripcion 
INNER JOIN negocios ON negocio_id = idnegocios INNER JOIN usuariosab ON suscripcion.usuariosab_idusuariosab = idusuariosab
ORDER BY idsuscripcion DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'id' =>  $renglon['idsuscripcion'],
        'fecha_activacion' => $renglon['fecha_activacion'],
        'fecha_vencimiento' =>  $renglon['fecha_vencimiento'],
        'estado' =>  $renglon['estado'],
        'negocio' =>  $renglon['nombre_negocio'] . " " . $renglon['ciudad'] . " " . $renglon['domicilio'],
        'monto' =>  $renglon['monto'],
        'registro' =>  $renglon['nombre'] . " " . $renglon['apaterno']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
