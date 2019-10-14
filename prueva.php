<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();

$con = new Models\Conexion();
$datos= array();
$query='SELECT * FROM prueva';
$result = $con->obtenerDatosDeTabla($query);

$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_all($result)) {
    $json[] = array(
        '1' =>  $renglon[0],
        '2' =>  $renglon[1],
        '3' =>  $renglon[2]
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
;
?>