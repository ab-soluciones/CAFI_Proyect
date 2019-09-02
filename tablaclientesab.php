<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
$query = "SELECT id_clienteab,clientesab.nombre,clientesab.apaterno,clientesab.amaterno,tipo_documento,
numero_documento,direccion,telefono,correo,clientesab.acceso,clientesab.login,clientesab.password,
clientesab.estado,usuariosab.nombre AS usnombre, usuariosab.apaterno AS usapaterno FROM clientesab
INNER JOIN usuariosab ON usuariosab_idusuariosab=idusuariosab ORDER BY id_clienteab DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) { 
    $json[] = array(
        'id' =>  $renglon['id_clienteab'],
        'nombre' => $renglon['nombre'],
        'apt' => $renglon['apaterno'],
        'apm' => $renglon['amaterno'],
        'tipodoc' =>  $renglon['tipo_documento'],
        'numdoc' =>  $renglon['numero_documento'],
        'direccion' =>  $renglon['direccion'],
        'telefono' =>  $renglon['telefono'],
        'correo' =>  $renglon['correo'],
        'login' =>  $renglon['login'],
        'password' =>  $renglon['password'],
        'estado' =>  $renglon['estado'],
        'registro' =>  $renglon['usnombre']." ". $renglon['usapaterno']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;