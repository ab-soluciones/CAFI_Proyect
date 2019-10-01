<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEOAB"
) {
    header('location: index.php');
}
$con = new Models\Conexion();
$query = "SELECT * FROM usuariosab ORDER BY idusuariosab DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();

while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'id' =>  $renglon['idusuariosab'],
        'nombre' => $renglon['nombre'],
        'apaterno' => $renglon['apaterno'],
        'amaterno' => $renglon['amaterno'],
        'acceso' =>  $renglon['acceso'],
        'login' =>  $renglon['login'],
        'password' =>  $renglon['password'],
        'estado' =>  $renglon['estado'],
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
