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
    $_SESSION['acceso'] != "CEO"
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
    <title>Flujo de efectivo</title>
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand"><?php echo $_SESSION['nombrenegocio']; ?> flujo de efectivo por:</a>
        </div>
    </nav> <br>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
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

        <div style="margin: 0 auto; margin-top:20px;" class="col-md-8">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Ventas</th>
                        <th>Otros Ingresos</th>
                        <th>Egresos</th>
                        <th>Retiros</th>
                        <th>Efectivo</th>
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

                            $query = "SELECT SUM(total) AS totalventas FROM venta WHERE NOT forma_pago='Crédito' 
                            AND estado_venta='R' AND fecha BETWEEN '$fecha1' AND '$fecha2' AND idnegocios ='$negocio' 
                            OR MONTH(fecha) = '$mes' AND YEAR(fecha)='$año'  AND estado_venta = 'R' AND idnegocios='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $ventastotal = $result['totalventas'];

                            $query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos INNER JOIN venta 
                            ON adeudos.ventas_idventas = venta.idventas WHERE venta.fecha BETWEEN '$fecha1' AND '$fecha2'
                            AND estado_deuda = 'A' AND negocios_idnegocios ='$negocio' OR MONTH(venta.fecha) = '$mes' AND 
                            YEAR(venta.fecha)='$año' AND estado_deuda = 'A' AND negocios_idnegocios ='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $anticipos = $result['anticipos'];

                            $query = "SELECT SUM(cantidad) AS totalabonos FROM abono 
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND estado='R' AND negocios_idnegocios ='$negocio'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND  estado='R' AND negocios_idnegocios ='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $total_abonos = $result['totalabonos'];

                            $ventas = $ventastotal + $total_abonos + $anticipos;

                            $query = "SELECT SUM(monto) AS totalgastos  FROM gastos 
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND estado='A' AND negocios_idnegocios ='$negocio' 
                            OR  MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND estado='A' AND negocios_idnegocios ='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $gastos = $result['totalgastos'];

                            $query = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos WHERE 
                            fecha BETWEEN '$fecha1' AND '$fecha2' AND estado='A' AND negocios_idnegocios ='$negocio' 
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND estado='A' AND negocios_idnegocios ='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $otros_ingresos = $result['oingresos'];

                            $query = "SELECT SUM(cantidad) AS retiro FROM retiros WHERE 
                            fecha BETWEEN '$fecha1' AND '$fecha2' AND estado='R' AND negocios_idnegocios ='$negocio' 
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND estado='R' AND negocios_idnegocios ='$negocio'";
                            $result = $con->consultaRetorno($query);
                            $retiros = $result['retiro'];

                            $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

                            $query = "SELECT forma_pago, SUM(total) AS totalventas FROM
                            venta WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND idnegocios='$negocio' AND estado_venta='R'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND idnegocios='$negocio' AND estado_venta='R'  
                            GROUP BY forma_pago ORDER BY forma_pago ASC";
                            $result = $con->consultaListar($query);

                            $ventas_efectivo = 0;
                            $ventas_tarjeta = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_pago'] === "Efectivo") {
                                    $ventas_efectivo = $renglon['totalventas'];
                                } else if ($renglon['forma_pago'] === "Tarjeta") {
                                    $ventas_tarjeta = $renglon['totalventas'];
                                }
                            }
                            $query = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono WHERE
                            fecha BETWEEN '$fecha1' AND '$fecha2' AND negocios_idnegocios = '$negocio' AND estado='R' 
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND negocios_idnegocios = '$negocio' AND estado='R' 
                            GROUP BY forma_pago ORDER BY forma_pago ASC";
                            $result = $con->consultaListar($query);

                            $abonos_efectivo = 0;
                            $abonos_tarjeta = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_pago'] === "Efectivo") {
                                    $abonos_efectivo = $renglon['totalabonos'];
                                } else if ($renglon['forma_pago'] === "Tarjeta") {
                                    $abonos_tarjeta = $renglon['totalabonos'];
                                }
                            }
                            $query = "SELECT SUM(total_deuda) AS ingresos_credito FROM adeudos
                            INNER JOIN venta ON adeudos.ventas_idventas=venta.idventas
                            WHERE venta.fecha BETWEEN '$fecha1' AND '$fecha2' AND negocios_idnegocios = '$negocio' AND estado_deuda='A'
                            OR MONTH(venta.fecha)='$mes' AND YEAR(venta.fecha)='$año' AND negocios_idnegocios = '$negocio' AND estado_deuda='A'";
                            $result = $con->consultaRetorno($query);

                            $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo;
                            $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;
                            $ingresos_credito = $result['ingresos_credito'];

                            $query = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos WHERE fecha 
                            BETWEEN '$fecha1' AND '$fecha2' AND negocios_idnegocios = '$negocio' AND estado='A'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND negocios_idnegocios = '$negocio' AND estado='A'
                            GROUP BY forma_ingreso ORDER BY  forma_ingreso ASC";
                            $result = $con->consultaListar($query);

                            $otros_ingresos_banco = 0;
                            $otros_ingresos_efectivo = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_ingreso'] === "Banco") {
                                    $otros_ingresos_banco = $renglon['total'];
                                } else if ($renglon['forma_ingreso'] === "Efectivo") {
                                    $otros_ingresos_efectivo = $renglon['total'];
                                }
                            }
                            $con->cerrarConexion();
                        } else {
                            $dueño = $_SESSION['id'];
                            $query = "SELECT SUM(total) AS totalventas FROM venta
                            INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE NOT forma_pago='Crédito' AND estado_venta='R' AND fecha BETWEEN '$fecha1' AND '$fecha2' AND clientesab.id_clienteab ='$dueño' OR MONTH(fecha) = '$mes' AND YEAR(fecha)='$año'  
                            AND estado_venta = 'R' AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $ventastotal = $result['totalventas'];

                            $query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos 
                            INNER JOIN venta ON adeudos.ventas_idventas = venta.idventas 
                            INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab WHERE venta.fecha BETWEEN 
                            '$fecha1' AND '$fecha2' AND estado_deuda = 'A' AND clientesab.id_clienteab ='$dueño' 
                            OR MONTH(venta.fecha) = '$mes' AND YEAR(venta.fecha)='$año' AND estado_deuda = 'A' AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $anticipos = $result['anticipos'];

                            $query = "SELECT SUM(cantidad) AS totalabonos FROM abono 
                            INNER JOIN negocios ON negocios.idnegocios=abono.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND abono.estado='R'  AND clientesab.id_clienteab ='$dueño'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND  abono.estado='R'  AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $total_abonos = $result['totalabonos'];

                            $ventas = $ventastotal + $total_abonos + $anticipos;

                            $query = "SELECT SUM(monto) AS totalgastos  FROM gastos 
                            INNER JOIN negocios ON negocios.idnegocios=gastos.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND gastos.estado='A'  AND clientesab.id_clienteab ='$dueño' 
                            OR  MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND gastos.estado='A'  AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $gastos = $result['totalgastos'];

                            $query = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos 
                            INNER JOIN negocios ON negocios.idnegocios=otros_ingresos.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND otros_ingresos.estado='A' AND clientesab.id_clienteab ='$dueño'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND otros_ingresos.estado='A' AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $otros_ingresos = $result['oingresos'];


                            $query = "SELECT SUM(cantidad) AS retiro FROM retiros 
                            INNER JOIN negocios ON negocios.idnegocios=retiros.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND retiros.estado='R' AND clientesab.id_clienteab ='$dueño'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND retiros.estado='R' AND clientesab.id_clienteab ='$dueño'";
                            $result = $con->consultaRetorno($query);
                            $retiros = $result['retiro'];

                            $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

                            $query = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
                            INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND clientesab.id_clienteab ='$dueño' AND estado_venta='R'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año'AND clientesab.id_clienteab ='$dueño' AND estado_venta='R'  
                            GROUP BY forma_pago ORDER BY forma_pago ASC";
                            $result = $con->consultaListar($query);

                            $ventas_efectivo = 0;
                            $ventas_tarjeta = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_pago'] === "Efectivo") {
                                    $ventas_efectivo = $renglon['totalventas'];
                                } else if ($renglon['forma_pago'] === "Tarjeta") {
                                    $ventas_tarjeta = $renglon['totalventas'];
                                }
                            }
                            $query = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono 
                            INNER JOIN negocios ON negocios.idnegocios=abono.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND clientesab.id_clienteab ='$dueño' AND abono.estado='R' 
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año'AND clientesab.id_clienteab ='$dueño' AND abono.estado='R' 
                            GROUP BY forma_pago ORDER BY forma_pago ASC";
                            $result = $con->consultaListar($query);

                            $abonos_efectivo = 0;
                            $abonos_tarjeta = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_pago'] === "Efectivo") {
                                    $abonos_efectivo = $renglon['totalabonos'];
                                } else if ($renglon['forma_pago'] === "Tarjeta") {
                                    $abonos_tarjeta = $renglon['totalabonos'];
                                }
                            }
                            $query = "SELECT SUM(total_deuda) AS ingresos_credito FROM adeudos
                            INNER JOIN venta ON adeudos.ventas_idventas=venta.idventas
                            INNER JOIN negocios ON negocios.idnegocios=adeudos.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                            WHERE venta.fecha BETWEEN '$fecha1' AND '$fecha2' AND clientesab.id_clienteab ='$dueño' AND estado_deuda='A'
                            OR MONTH(venta.fecha)='$mes' AND YEAR(venta.fecha)='$año' AND clientesab.id_clienteab ='$dueño' AND estado_deuda='A'";
                            $result = $con->consultaRetorno($query);

                            $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo;
                            $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;
                            $ingresos_credito = $result['ingresos_credito'];

                            $query = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos
                            INNER JOIN negocios ON negocios.idnegocios=otros_ingresos.negocios_idnegocios
                            INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                            WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND clientesab.id_clienteab ='$dueño' AND otros_ingresos.estado='A'
                            OR MONTH(fecha)='$mes' AND YEAR(fecha)='$año' AND clientesab.id_clienteab ='$dueño' AND otros_ingresos.estado='A'
                            GROUP BY forma_ingreso ORDER BY  forma_ingreso ASC";
                            $result = $con->consultaListar($query);

                            $otros_ingresos_banco = 0;
                            $otros_ingresos_efectivo = 0;

                            while ($renglon = mysqli_fetch_array($result)) {
                                if ($renglon['forma_ingreso'] === "Banco") {
                                    $otros_ingresos_banco = $renglon['total'];
                                } else if ($renglon['forma_ingreso'] === "Efectivo") {
                                    $otros_ingresos_efectivo = $renglon['total'];
                                }
                            }
                            $con->cerrarConexion();
                        }
                        ?>
                        <td>$ <?php if (is_null($ventas)) {
                                    echo "0";
                                } else {
                                    echo $ventas;
                                } ?></td>
                        <td>$ <?php if (is_null($otros_ingresos)) {
                                    echo "0";
                                } else {
                                    echo $otros_ingresos;
                                } ?></td>
                        <td>$ <?php if (is_null($gastos)) {
                                    echo "0";
                                } else {
                                    echo $gastos;
                                } ?></td>
                        <td>$ <?php if (is_null($retiros)) {
                                    echo "0";
                                } else {
                                    echo $retiros;
                                } ?></td>
                        <td>$ <?php if (is_null($efectivo)) {
                                    echo "0";
                                } else {
                                    echo $efectivo;
                                } ?></td>

                    <?php } ?>
                </tbody>
            </table> <br>
            <table class="table table-bordered table-responsive-md">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">INGRESOS DETALLADOS</th>
                    </tr>
                    <tr>
                        <th>Ingresos en Efectivo</th>
                        <th>Ingresos en Banco</th>
                        <th>Cuentas por Cobrar</th>
                        <th>Otros Ingresos en Efectivo</th>
                        <th>Otros Ingresos en Banco</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['DFecha1']) && isset($_POST['DFecha2']) && isset($_POST['DMes']) && isset($_POST['SNegocio'])) {
                        ?>
                        <td>$ <?php if (is_null($ingresos_efectivo)) {
                                    echo "0";
                                } else {
                                    echo $ingresos_efectivo;
                                } ?></td>
                        <td>$ <?php if (is_null($ingresos_banco)) {
                                    echo "0";
                                } else {
                                    echo $ingresos_banco;
                                } ?></td>
                        <td>$ <?php if (is_null($ingresos_credito)) {
                                    echo "0";
                                } else {
                                    echo $ingresos_credito;
                                } ?></td>
                        <td>$ <?php if (is_null($otros_ingresos_efectivo)) {
                                    echo "0";
                                } else {
                                    echo $otros_ingresos_efectivo;
                                } ?></td>
                        <td>$ <?php if (is_null($otros_ingresos_banco)) {
                                    echo "0";
                                } else {
                                    echo $otros_ingresos_banco;
                                } ?></td>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>