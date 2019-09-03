<?php 
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();

$negocio = $_SESSION['idnegocio'];
$con = new Models\Conexion();
$query = "SELECT idgastos,concepto,pago,descripcion,monto,gastos.estado,fecha,nombre,apaterno FROM gastos
INNER JOIN trabajador ON trabajador_idtrabajador = idtrabajador
WHERE gastos.negocios_idnegocios ='$negocio' ORDER BY idgastos DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) { 
    $json[] = array(
        'id' =>  $renglon['idgastos'],
        'concepto' => $renglon['concepto'],
        'pago' => $renglon['pago'],
        'descripcion' => $renglon['descripcion'],
        'monto' =>  $renglon['monto'],
        'estado' =>  $renglon['estado'],
        'fecha' =>  $renglon['fecha'],
        'nombre' =>  $renglon['nombre']. " " . $renglon['apaterno']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
?>