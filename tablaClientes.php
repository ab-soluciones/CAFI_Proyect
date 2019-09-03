<?php 
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

$negocio = $_SESSION['idnegocio'];
$con = new Models\Conexion();
$query = "SELECT * FROM cliente WHERE negocios_idnegocios ='$negocio' ORDER BY idcliente DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) { 
    $json[] = array(
        'id' =>  $renglon['idcliente'],
        'nombre' => $renglon['nombre'],
        'apt' => $renglon['apaterno'],
        'apm' => $renglon['amaterno'],
        'tipodoc' =>  $renglon['tipo_documento'],
        'numdoc' =>  $renglon['numero_documento'],
        'direccion' =>  $renglon['direccion'],
        'telefono' =>  $renglon['telefono'],
        'correo' =>  $renglon['correo'],
        'estado' =>  $renglon['estado'],
        'negocios_idnegocios' =>  $renglon['negocios_idnegocios'],
        'trabajador_idtrabajador' =>  $renglon['trabajador_idtrabajador']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
?>