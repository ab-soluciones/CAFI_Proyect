<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
$con = new Models\Conexion();
$negocios = $_SESSION['idnegocio'];
$datos = false;
$query = "SELECT clientesab_idclienteab FROM negocios WHERE idnegocios = '$negocios'";
$result = $con->consultaRetorno($query);
$query = "SELECT nombre,color,marca,talla_numero FROM producto
        WHERE clientesab_id_clienteab = '$result[clientesab_idclienteab]' AND pestado = 'A'";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'nombre' =>  $renglon['nombre'],
        'color' =>  $renglon['color'],
        'marca' =>  $renglon['marca'],
        'talla_numero' =>  $renglon['talla_numero']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
?>