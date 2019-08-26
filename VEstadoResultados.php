<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

</head>

<body onload="inicio();">
    <?php include("NavbarD.php") ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-Producto-tab" data-toggle="tab" href="#Producto" role="tab" aria-controls="Producto" aria-selected="false">Producto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-Inventario-tab" data-toggle="tab" href="#Inventario" role="tab" aria-controls="Inventario" aria-selected="true">Inventario</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Producto" role="tabpanel" aria-labelledby="Producto-tab">
                                    <div class="col-12"><br>
                                        <form action="#" method="post">
                                            <h5><label for="negocio" style="margin: 0 auto;" class="badge badge-info">Negocio:</label></h5>
                                            <select class="form form-control" name="SSucursal">
                                                <option></option>
                                                <?php
                                                $con = new Models\Conexion();
                                                $dueño = $_SESSION['id'];
                                                $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                                WHERE clientesab_idclienteab = '$dueño'";
                                                $row = $con->consultaListar($query);
                                                $con->cerrarConexion();
                                                $cont = 0;
                                                while ($renglon = mysqli_fetch_array($row)) {
                                                    $nombre[$cont] = $renglon['nombre_negocio'];
                                                    $id[$cont] = $renglon['idnegocios'];
                                                    $cont++;
                                                    echo "<option>" . $renglon['nombre_negocio'] . "</option>";
                                                }
                                                ?>
                                                <option>Todos</option>
                                            </select> <br>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto">
                                                    <h6>FECHA 1 - FECHA 2</h6>
                                                </legend>
                                                <h5><label for="fecha1" style="margin: 0 auto;" class="badge badge-primary">De:</label></h5>
                                                <input id="fecha1" class="form-control" type="date" name="DFecha1">
                                                <br>
                                                <h5><label for="fecha2" style="margin: 0 auto;" class="badge badge-success">A:</label></h5>
                                                <input id="fecha2" class="form-control" type="date" name="DFecha2">
                                            </fieldset><br>
                                            <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Inventario" role="tabpanel" aria-labelledby="Inventario-tab">
                                    <div class="col-12">
                                        <br>
                                        <form action="#" method="post">
                                            <h5><label for="negocio" style="margin: 0 auto;" class="badge badge-info">Negocio:</label></h5>
                                            <select class="form form-control" name="SSucursal">
                                                <option></option>
                                                <?php
                                                $con = new Models\Conexion();
                                                $dueño = $_SESSION['id'];
                                                $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                                WHERE clientesab_idclienteab = '$dueño'";
                                                $row = $con->consultaListar($query);
                                                $con->cerrarConexion();
                                                $cont = 0;
                                                while ($renglon = mysqli_fetch_array($row)) {
                                                    $nombre[$cont] = $renglon['nombre_negocio'];
                                                    $id[$cont] = $renglon['idnegocios'];
                                                    $cont++;
                                                    echo "<option>" . $renglon['nombre_negocio'] . "</option>";
                                                }
                                                ?>
                                                <option>Todos</option>
                                            </select> <br>
                                            <h5><label for="inmes" style="margin: 0 auto;" class="badge badge-primary">Mes:</label></h5>
                                            <input id="inmes" class="form-control" type="month" name="DMes"><br>
                                            <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>

    <form action="#" method="POST">
        <select id="sucursal" class="form form-control" name="SNegocio">
            <option></option>
            <?php
            $con = new Models\Conexion();
            $dueño = $_SESSION['id'];
            $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                            WHERE clientesab_idclienteab = '$dueño'";
            $row = $con->consultaListar($query);
            $con->cerrarConexion();
            $cont = 0;
            while ($renglon = mysqli_fetch_array($row)) {
                $nombre[$cont] = $renglon['nombre_negocio'];
                $id[$cont] = $renglon['idnegocios'];
                $cont++;
                echo "<option>" . $renglon['nombre_negocio'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" style="display: none;">
    </form>
    <div style="margin: 0 auto; margin-top:10px;" class="col-md-8">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Ventas</th>
                    <th>Costo de Venta</th>
                    <th>Utilidad Bruta</th>
                    <?php if (isset($_POST['DMes']) && strlen($_POST['DMes']) != 0) {
                        ?>
                    <th>Gastos</th>
                    <th>Utilidad Neta</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $negocio = "";
                $ventas = null;
                $costo_venta = null;
                $utilidad_bruta = null;
                $con = new Models\Conexion();

                //consultas para optener el estado de resultados al dia

                if (isset($_POST['SNegocio'])) {
                    for ($i = 0; $i < sizeof($id); $i++) {
                        if (strcasecmp($_POST['SNegocio'], $nombre[$i]) == 0) {
                            $negocio = $id[$i];
                        }
                    }
                    $query = "SELECT SUM(total) AS ventas FROM venta WHERE estado_venta = 'R' AND idnegocios='$negocio'";
                    $result = $con->consultaRetorno($query);
                    $ventas = $result['ventas'];

                    $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta 
                FROM producto INNER JOIN detalle_venta ON producto.codigo_barras=detalle_venta.producto_codigo_barras
                INNER JOIN venta ON detalle_venta.idventa=venta.idventas
                WHERE venta.estado_venta='R' AND venta.idnegocios='$negocio'";
                    $result = $con->consultaRetorno($query);
                    $con->cerrarConexion();
                    $costo_venta = $result['costo_venta'];
                    $utilidad_bruta = $ventas - $costo_venta;
                }

                if (isset($_POST['BSucursales'])) {
                    $dueño = $_SESSION['id'];
                    $con = new Models\Conexion();

                    //consultas para optener el estado de resultados de todos los negocios de nuestro clienteab

                    $query = "SELECT SUM(total) AS ventas FROM venta
                    INNER JOIN negocios ON negocios.idnegocios = venta.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE estado_venta = 'R' AND clientesab.id_clienteab='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $ventas = $result['ventas'];
                    $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta FROM producto 
                    INNER JOIN detalle_venta ON producto.codigo_barras = detalle_venta.producto_codigo_barras 
                    INNER JOIN venta ON detalle_venta.idventa = venta.idventas
                    INNER JOIN negocios ON negocios.idnegocios = venta.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab = clientesab.id_clienteab
                    WHERE venta.estado_venta = 'R' AND clientesab.id_clienteab = '$dueño'";
                    $result = $con->consultaRetorno($query);
                    $con->cerrarConexion();
                    $costo_venta = $result['costo_venta'];
                    $utilidad_bruta = $ventas - $costo_venta;
                }
                if (isset($_POST['DFecha1']) && isset($_POST['DFecha2']) && isset($_POST['SSucursal']) || isset($_POST['DMes'])) {
                    $con = new Models\Conexion();
                    if (isset($_POST['DMes'])) {
                        $fecha = explode("-", $_POST['DMes']);
                        $año = $fecha[0];
                        $mes = $fecha[1];
                        $fecha1 = "";
                        $fecha2 = "";
                    } else {
                        $mes = "";
                        $año = "";
                        $fecha1 = $_POST['DFecha1'];
                        $fecha2 = $_POST['DFecha2'];
                    }
                    for ($i = 0; $i < sizeof($id); $i++) {
                        if (strcasecmp($_POST['SSucursal'], $nombre[$i]) == 0) {
                            $negocio = $id[$i];
                        }
                    }

                    if ($_POST['SSucursal'] != "Todos") {

                        $query = "SELECT SUM(total) AS ventas FROM venta WHERE fecha BETWEEN '$fecha1' 
                        AND '$fecha2' AND idnegocios='$negocio' AND estado_venta = 'R' 
                        OR MONTH(fecha) = '$mes' AND YEAR(fecha)='$año'  AND estado_venta = 'R' AND idnegocios='$negocio'";
                        $result = $con->consultaRetorno($query);
                        $ventas = $result['ventas'];

                        $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta FROM producto 
                        INNER JOIN detalle_venta ON producto.codigo_barras=detalle_venta.producto_codigo_barras
                        INNER JOIN venta ON detalle_venta.idventa=venta.idventas
                        WHERE venta.fecha BETWEEN '$fecha1' AND '$fecha2' AND venta.estado_venta ='R' AND venta.idnegocios='$negocio' 
                        OR MONTH(venta.fecha) = '$mes' AND YEAR(venta.fecha)='$año' AND venta.estado_venta ='R' AND venta.idnegocios='$negocio'";
                        $result = $con->consultaRetorno($query);
                        $costo_venta = $result['costo_venta'];

                        $utilidad_bruta = $ventas - $costo_venta;

                        if (isset($mes) && strlen($mes) != 0) {
                            $query = "SELECT SUM(monto) AS total  FROM gastos WHERE estado='A' AND MONTH(fecha)='$mes' 
                            AND YEAR(fecha)='$año' AND negocios_idnegocios='$negocio'  
                            GROUP BY concepto = 'Articulos de Venta'";
                            $result = $con->consultaRetorno($query);
                            $gastos = $result['total'];

                            $utilidad_neta = $utilidad_bruta - $gastos;
                        }
                        $con->cerrarConexion();
                    } else {
                        $dueño = $_SESSION['id'];
                        $con = new Models\Conexion();

                        $query = "SELECT SUM(total) AS ventas FROM venta
                        INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                        INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                        WHERE venta.fecha BETWEEN '$fecha1' AND '$fecha2' AND estado_venta = 'R' AND clientesab.id_clienteab ='$dueño'
                        OR MONTH(venta.fecha) = '$mes' AND YEAR(venta.fecha)='$año' AND estado_venta = 'R' AND clientesab.id_clienteab ='$dueño'";
                        $result = $con->consultaRetorno($query);
                        $ventas = $result['ventas'];

                        $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta FROM producto 
                        INNER JOIN detalle_venta ON producto.codigo_barras=detalle_venta.producto_codigo_barras
                        INNER JOIN venta ON detalle_venta.idventa=venta.idventas
                        INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                        INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                        WHERE venta.estado_venta ='R' AND clientesab.id_clienteab ='$dueño'";
                        $result = $con->consultaRetorno($query);
                        $costo_venta = $result['costo_venta'];

                        $utilidad_bruta = $ventas - $costo_venta;

                        if (isset($mes) && strlen($mes) != 0) {
                            $query = "SELECT SUM(monto) AS total  FROM gastos 
                            INNER JOIN negocios ON negocios.idnegocios=gastos.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE gastos.estado='A' AND MONTH(fecha)='$mes' 
                            AND YEAR(fecha)='$año'AND clientesab.id_clienteab ='$dueño'
                            GROUP BY concepto = 'Articulos de Venta'";
                            $result = $con->consultaRetorno($query);
                            $gastos = $result['total'];

                            $utilidad_neta = $utilidad_bruta - $gastos;
                        }
                        $con->cerrarConexion();
                    }
                }
                ?>
                <td>$ <?php if (is_null($ventas)) {
                            echo "0";
                        } else {
                            echo $ventas;
                        } ?></td>
                <td>$ <?php if (is_null($costo_venta)) {
                            echo "0";
                        } else {
                            echo $costo_venta;
                        } ?></td>
                <td>$ <?php if (is_null($utilidad_bruta)) {
                            echo "0";
                        } else {
                            echo $utilidad_bruta;
                        } ?></td>
                <?php if (isset($_POST['DMes']) && strlen($_POST['DMes']) != 0) {
                    ?>
                <td>$ <?php if (is_null($gastos)) {
                                echo "0";
                            } else {
                                echo $gastos;
                            } ?></td>
                  <td>$ <?php if (is_null($utilidad_neta)) {
                                echo "0";
                            } else {
                                echo $utilidad_neta;
                            } ?></td>
                <?php }
                ?>
            </tbody>
        </table>
        <form action="#" method="post">
            <button name="BSucursales" type="submit" class="btn btn-primary btn-lg btn-block">Estado de todas las sucursales</button>
        </form>
    </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>