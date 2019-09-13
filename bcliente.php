<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
if (isset($_POST['search'])) {
  $negocios = $_SESSION['idnegocio'];
  $busqueda =  $_POST['search'];
  //se optienen los datos del cliente para mostrarlos en la tabla para que el usuario compruebe si es el cliente
  $query = "SELECT idcliente,nombre,apaterno,amaterno,direccion,telefono, estado FROM cliente
  WHERE  CONCAT(nombre,' ',apaterno,' ' ,amaterno,' ',numero_documento,' ',telefono)  LIKE  '%$busqueda%'
  AND negocios_idnegocios= '$negocios'";
  $row = $con->consultaListar($query);
  $json = array();
  while ($renglon = mysqli_fetch_array($row)) {
      //se suman el total de adeudos sin liquidar para mostrarle al usuario cuantas cuentas sin pagar tiene antes de realizar la venta
      $query2 = "SELECT COUNT(idadeudos) AS total FROM adeudos
  WHERE cliente_idcliente='$renglon[idcliente]' AND estado_deuda='A'";

      $totaladeudos = $con->consultaRetorno($query2);
    
      $json[] = array(
        'idcliente' =>  $renglon['idcliente'],
        'nombre' =>  $renglon['nombre']." ". $renglon['apaterno']." ". $renglon['amaterno'],
        'direccion' =>  $renglon['direccion'],
        'telefono' => $renglon['telefono'],
        'estado' =>  $renglon['estado'],
        'adeudos' => $totaladeudos['total']
    );
}

    $jsonstring = json_encode($json);
    echo $jsonstring;
}
$con->cerrarConexion();