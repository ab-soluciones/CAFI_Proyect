<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
session_start();
//se inicializan la variables globales
$_SESSION['descuento'] = null;
$_SESSION['clienteid'] = null;
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] == "Employes"

) {
    header('location: OPCAFI.php');
}

if (isset($_POST['nuevaventa']) && is_null($_SESSION['idven'])) {
    /*se crea una nueva venta para poder hacer uso de la tabla detalle venta(describe el concepto de la venta)
     ya que tiene relacion de muchos a muchos con la tabla productos y la tabla venta */
    $venta = new Models\Venta();
    $id = $venta->guardar();
    $_SESSION['idven'] = $id['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Ventas</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php
    $sel = "venta";
    include("Navbar.php")
    ?>

    <div class="contenedor container-fluid">

        <div class="row">
            <div class="col-5 p-3">
                <h3 class="text-center bg-dark text-white mb-3">Venta</h3>
                
                <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="scroll table table-hover table-bordered">
                        <form action="#" method="post">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center">Producto</th>
                                    <th class="text-nowrap text-center">Costo</th>
                                    <th class="text-nowrap text-center">Cant</th>
                                    <th class="text-nowrap text-center">Subtotal</th>

                                </tr>
                            </thead>
                            <tbody id="renglones">
                                <?php
                                //se muestran en la tabla los productos agregados al concepto de la venta
                                $idventa = (int) $_SESSION['idven'];
                                $query = "SELECT nombre,imagen,color,marca,unidad_medida,talla_numero,descripcion,precio_venta,cantidad,
                                cantidad_producto,iddetalle_venta,subtotal FROM producto
                                INNER JOIN detalle_venta ON producto.codigo_barras = detalle_venta.producto_codigo_barras
                                INNER JOIN inventario ON producto.codigo_barras = inventario.producto_codigo_barras
                                WHERE detalle_venta.idventa='$idventa'";
                                $row = $con->consultaListar($query);
                                $datos = "none";
                                while ($renglon = mysqli_fetch_array($row)) {
                                    $datos = "display";
                                    $imprimir_existencia = false;
                                    $existencia = $renglon['cantidad'] - $renglon['cantidad_producto'];
                                    if ($existencia < 0) {
                                        //se comprueba el stock si no hay suficiente producto se elimina de la lista
                                        echo "<script>swal({
                                            title: 'Atención',
                                            text: 'No es posible agregar $renglon[cantidad_producto] productos solo existen $renglon[cantidad] en inventario',
                                            type: 'warning'
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = 'deleteVVentas.php?id=$renglon[iddetalle_venta]';
                                            }
                                        });</script>";
                                    } else {
                                        $imprimir_existencia = true;
                                    }
                                    ?>
                                <tr>
                                    <td class="text-center">
                                        <a onclick="if(confirm('SE ELIMINARÁ DE LA LISTA! :<?php echo ' ' . $renglon['cantidad_producto'] . ' ' . $renglon['nombre'] . '(s) ' . $renglon['descripcion'] ?>'))
                                            {href= 'deleteVVentas.php?id=<?php echo $renglon['iddetalle_venta']; ?>'} " class="btn btn-warning"><img src="img/eliminarf.png">
                                        </a>
                                    </td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['nombre'] . " " . $renglon['marca'] . " color " . $renglon['color'] . " talla " . $renglon['talla_numero']; ?></td>
                                    <td class="text-nowrap text-center">$<?php echo $renglon['precio_venta']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['cantidad_producto']; ?> <a href="#" class="text-weight-bold">Cambiar</a></td>
                                    <td class="text-nowrap text-center">$<?php echo $renglon['subtotal']; ?></td>

                                </tr>
                                <?php
                                }  ?>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                                <tr>
                                    <td><a href="#">X</a></td>
                                    <td>Barra de Chocolate</td>
                                    <td>$14</td>
                                    <td>2</td>
                                    <td>$28</td>
                                </tr>
                            </tbody>
                    </table>
                    <?php
                    if (isset($_POST['RTv'])) {
                        //se envia al usuario a la pagina correspondiente dependiendo el tipo de venta
                        if ($_POST['RTv'] == "Efectivo") {
                            $_SESSION['forma_pago'] = "Efectivo";
                            echo "<script> window.location.href='VPago.php?v3nd3rpr0=v3nd3r&total=$result[total]'</script>";
                        } else if ($_POST['RTv'] == "Credito") {
                            $_SESSION['forma_pago'] = "Crédito";
                            echo "<script> window.location.href='VAdeudo.php?t0t41v34=$result[total]'</script>";
                        } else if ($_POST['RTv'] == "Tarjeta") {
                            $_SESSION['forma_pago'] = "Tarjeta";
                            echo "<script> window.location.href='VPago.php?v3nd3rpr0=v3nd3r&total=$result[total]'</script>";
                        }
                    } ?>
                    </form>
                </div>
                </div>


                <div style="background:  #3366ff;">
                    <td class="text-nowrap text-center" colspan="8">
                        <h5 style="color: white; text-align: right;" class="p-2 font-weight-bold">Total = $300</h5>
                    </td>
                </div>
                <input id="bvender" class="btn btn-block mt-2 p-3 font-weight-bold text-white" style="background-color: orangered; color" type="submit" value="Realizar Venta">
            </div>

            <div class="col-7 p-3">
                <h3 class="text-center bg-dark text-white mb-3">Busqueda de Producto</h3>
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar Producto..." title="Type in a name" value="">
                    
                    <div class="input-group-prepend ml-3">
                        <div class="input-group-text font-weight-bold">Cantidad:</div>
                    </div>
                    <div>
                        <input type="number" value="1" name="quantity" min="1" max="" style="width: 60px; height: 38px;">
                    </div> 

                    <button id="bclose" class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar a lista</button>
                </div>
                <div class="contenedorTabla table-responsive" style="display: table; height: 200px;">    
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center">Imagen</th>
                                <th class="text-nowrap text-center">Producto</th>
                                <th class="text-nowrap text-center">Descripción</th>
                                <th class="text-nowrap text-center">Existencia</th>
                                <th class="text-nowrap text-center">Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap text-center"><img src="img/cambio.png" alt=""></td>
                                <td class="text-nowrap text-center">Tennis Adidas</td>
                                <td class="text-nowrap text-center">Descripción</td>
                                <td class="text-nowrap text-center">70</td>
                                <td class="text-nowrap text-center">$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Contenedor -->
    
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
