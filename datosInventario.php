<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
$con = new Models\Conexion();
$negocios = $_SESSION['idnegocio'];
$datos = false;
$query = "SELECT clientesab_idclienteab FROM negocios WHERE idnegocios = '$negocios'";
$result = $con->consultaRetorno($query);
$query = "SELECT nombre,color,marca,talla_numero FROM producto t1
WHERE t1.clientesab_id_clienteab = '$result[clientesab_idclienteab]' AND T1.pestado = 'A'
AND NOT EXISTS (SELECT NULL FROM inventario t2 WHERE t2.producto_codigo_barras = t1.codigo_barras AND t2.negocios_idnegocios = '$negocios')";
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