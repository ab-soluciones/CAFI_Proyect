<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (isset($_POST['search'])) {
    $busqueda = $_POST['search'];
    $con = new Models\Conexion();
    $negocio =  $_SESSION['idnegocio'];
    $query = "SELECT producto_codigo_barras,imagen,nombre,marca,color,talla_numero,unidad_medida,descripcion,precio_venta,
cantidad FROM producto INNER JOIN inventario ON producto.codigo_barras = inventario.producto_codigo_barras
WHERE CONCAT(nombre,' ' ,marca,' ',color,' ',talla_numero,' ', producto_codigo_barras) LIKE '%$busqueda%' AND inventario.negocios_idnegocios = '$negocio'";
    $row = $con->consultaListar($query);
    $con->cerrarConexion();
    $json = array();
    while ($renglon = mysqli_fetch_array($row)) {
        $json[] = array(
            'codigo_barras' =>  $renglon['producto_codigo_barras'],
            'imagen' => $renglon['imagen'],
            'nombre' => $renglon['nombre'],
            'marca' =>  $renglon['marca'],
            'color' => $renglon['color'],
            'talla_numero' =>  $renglon['talla_numero'],
            'unidad_medida' =>  $renglon['unidad_medida'],
            'precio' =>  $renglon['precio_venta'],
            'existencia' =>  $renglon['cantidad']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
