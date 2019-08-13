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
} else if (is_null($_SESSION['idven'])) {
    header('location: VVender.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] == "Employes"

) {
    header('location: OPCAFI.php');
}
if (
    isset($_POST['DlProductos']) || isset($_POST['DlCodigosP'])
    || isset($_POST['DlDescripciones']) && isset($_POST['SCantidad'])
) {

    /*se hace el registro del producto en el concepto de la venta, en la funcion setIdP
 se optiene el id del producto para poderlo registrar en el concepto de la venta */
    $producto = $_POST['DlProductos'];
    $codigo = $_POST['DlCodigosP'];
    $descripcion = $_POST['DlDescripciones'];
    $cantidad = $_POST['SCantidad'];
    $negocio = $_SESSION['idnegocio'];
    $dv = new Models\DetalleVenta();
    $idventa = (int) $_SESSION['idven'];
    if (strlen($descripcion) === 0) {
        $descripcion = null;
    }
    $dv->setIdVenta($idventa);
    $dv->setIdP($producto, $codigo, $descripcion, $negocio);
    $dv->setCantidad($cantidad);
    $dv->setSuptotal($cantidad);
    $dv->guardar();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Ventas</title>
    <script type="text/javascript">
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }
    </script>

</head>


<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Ventas</a>
        </div>
    </nav>
    <div class="row" style=" margin-top: 15px;">
        <div id="busqueda" class="col-xs-4" style="margin: 0 auto;">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <div id="codigos">
                    <h4><label class="badge badge-pill badge-primary">Agregar producto a la lista:</label></h4>
                        <h5><label class="badge badge-danger">Código:</label></h5>
                        <input id="incodigo" class="form form-control" list="codigosp" name="DlCodigosP" autocomplete="off">
                        <datalist id="codigosp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $query = "SELECT codigo_barras FROM producto 
                            INNER JOIN inventario ON producto.codigo_barras = inventario.producto_codigo_barras 
                            WHERE negocios_idnegocios ='$negocios' AND pestado = 'A' ORDER BY codigo_barras ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['codigo_barras'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('incodigo').disabled = true;</script>";
                            } ?>
                        </datalist><br>

                    </div>
                    <div id="productos">
                        <h5><label class="badge badge-danger">Producto:</label></h5>
                        <input id="inproducto" class="form form-control" list="lproductos" name="DlProductos" autocomplete="off">
                        <datalist id="lproductos">

                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $query = "SELECT nombre,color,marca,talla_numero FROM producto INNER JOIN 
                            inventario ON producto.codigo_barras = inventario.producto_codigo_barras
                            WHERE negocios_idnegocios = '$negocios' AND pestado = 'A'";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre'] . " " . $result['marca'] . " color " . $result['color'] . " talla " . $result['talla_numero'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('inproducto').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                    </div>
                    <div id="desc">
                        <h5><label class="badge badge-danger">Descripción:</label></h5>
                        <input id="indescripcion" class="form form-control" list="descripcionp" name="DlDescripciones" autocomplete="off">
                        <datalist id="descripcionp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $query = "SELECT descripcion FROM producto 
                            INNER JOIN inventario ON producto.codigo_barras = inventario.producto_codigo_barras 
                            WHERE negocios_idnegocios ='$negocios' AND pestado = 'A' ORDER BY descripcion ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['descripcion'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('indescripcion').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                    </div>
                    <h4><label for="cant" class="badge badge-pill badge-success">Cantidad:</label></h4>
                    <input id="cant" class="form form-control" type="number" name="SCantidad" min="0" max="" value="1"><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Agregar">
                </form>

            </div>
        </div>

        <div class="col-md-8" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered table-responsive-md">
                <form action="#" method="post">
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="tv" name="RTv" value="Efectivo" checked autofocus>Contado
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="tv" name="RTv" value="Credito">Crédito
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="tv" name="RTv" value="Tarjeta">Tarjeta
                            </label>
                        </div>
                    </div> <br>
                    <thead>
                        <tr>
                            <th>Tareas</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Existencia</th>
                            <th>Costo</th>
                            <th>Cant</th>
                            <th>Subtotal</th>

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
                        $datos = false;
                        while ($renglon = mysqli_fetch_array($row)) {
                            $datos = true;
                            $imprimir_existencia = false;
                            $existencia = $renglon['cantidad'] - $renglon['cantidad_producto'];
                            if ($existencia < 0) {
                                //se comprueba el stock si no hay suficiente producto se elimina de la lista
                                echo "<script>alert('No es posible agregar $renglon[cantidad_producto] $renglon[nombre] $renglon[marca] color $renglon[color] talla $renglon[talla_numero] solo hay $renglon[cantidad] en existencia');
                                window.location.href='deleteVVentas.php?id=$renglon[iddetalle_venta]';</script>";
                            } else {
                                $imprimir_existencia = true;
                            }
                            ?>
                            <tr>
                                <td style="width: 30px;">
                                    <div class="row" style="margin: 0 auto;">
                                        <a onclick="if(confirm('SE ELIMINARÁ DE LA LISTA! :<?php echo ' ' . $renglon['cantidad_producto'] . ' ' . $renglon['nombre'] . '(s) ' . $renglon['descripcion'] ?>'))
                                        {href= 'deleteVVentas.php?id=<?php echo $renglon['iddetalle_venta']; ?>'} " class="btn btn-warning"><img src="img/eliminarf.png">
                                        </a>
                                        <a style="margin-top: 5px;" class="btn btn-secondary" href="EditVVentas.php?id=<?php echo $renglon['iddetalle_venta'] . "&can=" . $renglon['cantidad_producto'] . "&precio=" . $renglon['precio_venta'] . "&stock=" . $renglon['cantidad'] ?>">
                                            <img src="img/edit.png">
                                        </a>
                                    </div>
                                </td>
                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($renglon['imagen']) ?>" height="90" width="90"></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['marca'] . " color " . $renglon['color'] . " talla " . $renglon['talla_numero']; ?></td>
                                <td><?php echo $renglon['descripcion']; ?></td>
                                <td><?php if ($imprimir_existencia === true) {
                                        echo $existencia;
                                    } ?></td>
                                <td>$<?php echo $renglon['precio_venta']; ?></td>
                                <td><?php echo $renglon['cantidad_producto']; ?></td>
                                <td>$<?php echo $renglon['subtotal']; ?></td>

                            </tr>
                        <?php
                        }  ?>
                        <tr style="background:  #3366ff;">
                            <?php
                            //se muestra el total de la venta en la tabla
                            $idventa = (int) $_SESSION['idven'];
                            $query_total = "SELECT SUM(subtotal) AS total FROM detalle_venta WHERE idventa = '$idventa'";
                            $result = $con->consultaRetorno($query_total);
                            if (!is_null($result['total'])) {
                                ?>
                                <td colspan="8">
                                    <h5 style="color: white; text-align: right;">Total = $ <?php echo $result['total']; ?></h5>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
            </table>
            <input id="bvender" class="btn btn-dark btn-lg btn-block" style="margin-top:-10px;" type="submit" value="Realizar Venta">
            <?php if ($datos == false) {
                echo "<script> document.getElementById('bvender').style.display = 'none';</script> ";
            }
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
</body>

</html>