<?php 
     require_once "Config/Autoload.php";
     Config\Autoload::run();
     session_start();
     $con = new Models\Conexion();
     $negocio = $_SESSION['idnegocio'];
     $query = "SELECT codigo_barras,nombre,imagen,color,marca,descripcion,unidad_medida,talla_numero,tipo,precio_compra,precio_venta,pestado,cantidad
     FROM producto INNER JOIN inventario ON producto.codigo_barras=inventario.producto_codigo_barras
     WHERE inventario.negocios_idnegocios='$negocio' ORDER BY nombre ASC";
     $row = $con->consultaListar($query);
     $con->cerrarConexion();
     $json = array();
        while ($renglon = mysqli_fetch_array($row)) {
            $json[] = array(
                'codigo_barras' =>  $renglon['codigo_barras'],
                'nombre' => $renglon['nombre'],
                'imagen' =>  $renglon['imagen'],
                'color' =>  $renglon['color'],
                'marca' =>  $renglon['marca'],
                'descripcion' => $renglon['descripcion'],
                'unidad_medida' => $renglon['unidad_medida'],
                'talla_numero' =>  $renglon['talla_numero'],
                'tipo' =>  $renglon['tipo'],
                'precio_compra' => $renglon['precio_compra'],
                'precio_venta' => $renglon['precio_venta'],
                'pestado' => $renglon['pestado'],
                'cantidad' => $renglon['cantidad']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
?>