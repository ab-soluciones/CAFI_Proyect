<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
$query = "SELECT idnegocios,nombre_negocio,domicilio,ciudad,telefono_negocio,impresora,clientesab.nombre AS clientenombre,clientesab.apaterno AS clienteapaterno , clientesab.amaterno AS clienteamaterno , usuariosab.nombre,usuariosab.apaterno FROM negocios
INNER JOIN clientesab ON clientesab_idclienteab = id_clienteab
INNER JOIN usuariosab ON negocios.usuariosab_idusuariosab = usuariosab.idusuariosab
ORDER BY idnegocios DESC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'id' =>  $renglon['idnegocios'],
        'nombre' => $renglon['nombre_negocio'],
        'domicilio' =>  $renglon['domicilio'],
        'ciudad' =>  $renglon['ciudad'],
        'telefono' =>  $renglon['telefono_negocio'],
        'impresora' =>  $renglon['impresora'],
        'cliente' =>  $renglon['clientenombre'] . " " . $renglon['clienteapaterno'] . " " . $renglon['clienteamaterno'],
        'usuarioab' =>  $renglon['nombre'] . " " . $renglon['apaterno']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
