<?php
    require_once "Config/Autoload.php";
    Config\Autoload::run();
    session_start();

        $negocio = $_SESSION['idnegocio'];
        $con = new Models\Conexion();
        $venta = $_POST['venta'];
        $query = "SELECT nombre,imagen,color,marca,precio_venta, unidad_medida, talla_numero, cantidad_producto,subtotal FROM
        producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
        detalle_venta.idventa='$venta'";
        $row = $con->consultaListar($query);
        $con->cerrarConexion();
        $json = array();
        while ($renglon = mysqli_fetch_array($row)) {
            $json[] = array(
                'nombre' =>  $renglon['nombre'],
                'imagen' => $renglon['imagen'],
                'color' => $renglon['color'],
                'marca' => $renglon['marca'],
                'precio_venta' =>  $renglon['precio_venta'],
                'unidad_medida' =>  $renglon['unidad_medida'],
                'talla_numero' =>  $renglon['talla_numero'],
                'cantidad_producto' =>  $renglon['cantidad_producto'],
                'subtotal' =>  $renglon['subtotal']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;


?>