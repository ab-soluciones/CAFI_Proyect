<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
date_default_timezone_set("America/Mexico_City");
$año = date("Y");
$mes = date("m");
$dia = date("d");
$fecha = $año . "-" . $mes . "-" . $dia;
$negocio = $_SESSION['idnegocio'];
$con = new Models\Conexion();
$query = "SELECT idretiro,concepto,tipo,cantidad,descripcion,fecha,hora,retiros.estado,nombre,apaterno FROM retiros INNER JOIN trabajador ON retiros.trabajador_idtrabajador=trabajador.idtrabajador
WHERE retiros.negocios_idnegocios ='$negocio'ORDER BY idretiro DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();

while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'id' => $renglon['idretiro'],
        'concepto' => $renglon['concepto'],
        'tipo' => $renglon['tipo'],
        'cantidad' => $renglon['cantidad'],
        'descripcion' => $renglon['descripcion'],
        'fecha' => $renglon['fecha'],
        'hora' => $renglon['hora'],
        'estado' => $renglon['estado'],
        'nombre' => $renglon['nombre']. " " . $renglon['apaterno']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
?>