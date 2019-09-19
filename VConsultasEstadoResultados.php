<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Estado de Resultado</title>
    <script>
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function activarRango() {
            document.getElementById('busqueda').style.display = "block";
            document.getElementById('rango').style.display = "block";
            document.getElementById('botones').style.display = "none";
            document.getElementById('mes').style.display = "none";
        }

        function activarMes() {
            document.getElementById('busqueda').style.display = "block";
            document.getElementById('rango').style.display = "none";
            document.getElementById('botones').style.display = "none";
            document.getElementById('mes').style.display = "block";
        }

        function activarM() {
            document.getElementById("busqueda").style.display = "none";
            document.getElementById("botones").style.display = "block";

        }
    </script>
</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"><?php echo $_SESSION['nombrenegocio']; ?> estado de resultados</a>
        </div>
    </nav> <br>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <h5 style="margin: 0 auto;"><label class="badge badge-warning">Por :</label></h5><br>
                <button onclick="activarRango();" class="btn btn-lg btn-block btn-info">Rango de Fecha</button>
                <button onclick="activarMes();" class="btn btn-lg btn-block btn-info">Mes</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="busqueda" class="col-xs-4" style="margin: 0 auto; display:none;">
            <div class="card card-body">
                <div><button onclick="activarM();" class="btn btn-danger">x</button></div><br>
                <form action="#" method="post" class="form form-group">
                    <div id="rango">
                        <fieldset class="border p-2">
                            <legend class="w-auto">
                                <h6>FECHA 1 - FECHA 2</h6>
                            </legend>
                            <h5><label for="fecha1" style="margin: 0 auto;" class="badge badge-primary">De:</label></h5>
                            <input id="fecha1" class="form-control" type="date" name="DFecha1">
                            <br>
                            <h5><label for="fecha2" style="margin: 0 auto;" class="badge badge-success">A:</label></h5>
                            <input id="fecha2" class="form-control" type="date" name="DFecha2">
                        </fieldset>


                    </div>
                    <div id="mes">
                        <h5><label for="inmes" style="margin: 0 auto;" class="badge badge-primary">Mes:</label></h5>
                        <input id="inmes" class="form-control" type="month" name="DMes">
                    </div>
                    <br>
                    <h5><label for="negocio" style="margin: 0 auto;" class="badge badge-info">Negocio:</label></h5>
                    <select name="SNegocio" class="form-control" id="negocio">
                        <option><?php echo $_SESSION['nombrenegocio']; ?></option>
                        <option>Todos los negocios</option>
                    </select>
                    <br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>
        <br>

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
                    if (isset($_POST['DFecha1']) && isset($_POST['DFecha2']) && isset($_POST['DMes']) && isset($_POST['SNegocio'])) {
                        $con = new Models\Conexion();
                        $fecha1 = $_POST['DFecha1'];
                        $fecha2 = $_POST['DFecha2'];
                        if (isset($_POST['DMes']) && strlen($_POST['DMes']) != 0) {
                            $fecha = explode("-", $_POST['DMes']);
                            $año = $fecha[0];
                            $mes = $fecha[1];
                        } else {
                            $mes = "";
                            $año = "";
                        }
                        $negocio = $_SESSION['idnegocio'];

                        if ($_POST['SNegocio'] != "Todos los negocios") {

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
                        ?>

                        <?php if (isset($gastos) && isset($utilidad_neta)) {
                            ?>
                            <td>$ <?php echo $ventas; ?></td>
                            <td>$ <?php echo $costo_venta; ?></td>
                            <td>$ <?php echo $utilidad_bruta; ?></td>
                            <td>$ <?php echo $gastos; ?></td>
                            <td>$ <?php echo $utilidad_neta; ?></td>
                        <?php } else if (strlen($fecha1) != 0 && strlen($fecha2) != 0) {

                            if (strlen($ventas) != 0) {
                                ?>
                                <td><?php echo "$ " . $ventas; ?></td>
                            <?php }
                            if (strlen($costo_venta) != 0) {
                                ?>
                                <td><?php echo "$ " . $costo_venta; ?></td>

                            <?php  }
                            if (strlen($utilidad_bruta) != 0 && $utilidad_bruta != 0) {
                                ?>
                                <td><?php echo "$ " . $utilidad_bruta; ?></td>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>