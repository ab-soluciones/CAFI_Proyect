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
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    
    <title>Flujo de efectivo</title>
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand"><?php echo $_SESSION['nombrenegocio']; ?> flujo de efectivo cotidiano</a>
        </div>
    </nav>
    <p>Sucursal:</p>
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
        <h5 style="margin: 0 auto;"><label class="badge badge-info">
                <a style="color: white;" href="VConsultasFlujoEfectivo.php">Consultar otras fechas --></a>
            </label></h5>
        <table class="table table-bordered table-responsive-md">
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
                $negocio="";
                $ventas=null;
                $otros_ingresos=null;
                $gastos=null;
                $retiros=null;
                $efectivo=null;
                $ingresos_efectivo= null;
                $ingresos_banco=null;
                $ingresos_credito=null;
                $otros_ingresos_efectivo=null;
                $otros_ingresos_banco=null;
                if (isset($_POST['SNegocio'])) {
                    for ($i = 0; $i < sizeof($id); $i++) {
                        if (strcasecmp($_POST['SNegocio'], $nombre[$i]) == 0) {
                           $negocio = $id[$i];
                        }
                    }
                $con = new Models\Conexion();

                //consultas para optener el flujo de fectivo al dia

                $query = "SELECT SUM(total) AS totalventas FROM venta 
                WHERE NOT forma_pago='Crédito' AND estado_venta='R' AND idnegocios ='$negocio'";
                $result = $con->consultaRetorno($query);
                $ventastotal = $result['totalventas'];

                $query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos
                WHERE negocios_idnegocios ='$negocio' AND estado_deuda = 'A'";
                $result = $con->consultaRetorno($query);
                $anticipos = $result['anticipos'];

                $query = "SELECT SUM(cantidad) AS totalabonos FROM abono WHERE estado='R' AND negocios_idnegocios ='$negocio'";
                $result = $con->consultaRetorno($query);
                $total_abonos = $result['totalabonos'];

                $ventas = $ventastotal + $total_abonos + $anticipos;

                $query = "SELECT SUM(monto) AS totalgastos  FROM gastos WHERE estado='A' AND negocios_idnegocios ='$negocio'";
                $result = $con->consultaRetorno($query);
                $gastos = $result['totalgastos'];

                $query = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos WHERE estado='A' AND negocios_idnegocios ='$negocio'";
                $result = $con->consultaRetorno($query);
                $otros_ingresos = $result['oingresos'];

                $query = "SELECT SUM(cantidad) AS retiro FROM retiros WHERE 
                negocios_idnegocios ='$negocio' AND estado='R'";
                $result = $con->consultaRetorno($query);
                $retiros = $result['retiro'];

                $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

                $query = "SELECT forma_pago, SUM(total) AS totalventas FROM
                venta WHERE idnegocios='$negocio' AND estado_venta='R' GROUP BY forma_pago ORDER BY forma_pago ASC";
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
                negocios_idnegocios = '$negocio' AND estado='R' GROUP BY forma_pago ORDER BY forma_pago ASC";
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
                $query = "SELECT SUM(total_deuda) AS ingresos_credito FROM 
                adeudos WHERE negocios_idnegocios = '$negocio' AND estado_deuda='A'";
                $result = $con->consultaRetorno($query);

                $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo;
                $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;
                $ingresos_credito = $result['ingresos_credito'];

                $query = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos WHERE
                 negocios_idnegocios = '$negocio' AND estado='A' GROUP BY forma_ingreso ORDER BY  forma_ingreso ASC";
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
                if (isset($_POST['BSucursales'])) {
                    $dueño = $_SESSION['id'];
                    $con = new Models\Conexion();

                    //consultas para optener el flujo de efectivo al dia de todos los negocios pertenecientes a nuestro clienteab

                    $query = "SELECT SUM(total) AS totalventas FROM venta 
                    INNER JOIN negocios ON venta.idnegocios=negocios.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                    WHERE NOT venta.forma_pago='Crédito' AND venta.estado_venta='R' AND clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $ventastotal = $result['totalventas'];

                    $query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos 
                    INNER JOIN negocios ON negocios.idnegocios=adeudos.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                    WHERE clientesab.id_clienteab ='$dueño' AND estado_deuda = 'A'";
                    $result = $con->consultaRetorno($query);
                    $anticipos = $result['anticipos'];

                    $query = "SELECT SUM(cantidad) AS totalabonos FROM abono 
                    INNER JOIN negocios ON negocios.idnegocios=abono.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                    WHERE abono.estado='R' AND  clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $total_abonos = $result['totalabonos'];

                    $ventas = $ventastotal + $total_abonos + $anticipos;

                    $query = "SELECT SUM(monto) AS totalgastos FROM gastos
                    INNER JOIN negocios ON negocios.idnegocios=gastos.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab 
                    WHERE gastos.estado='A'  AND  clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $gastos = $result['totalgastos'];

                    $query = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos
                    INNER JOIN negocios ON negocios.idnegocios=otros_ingresos.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE otros_ingresos.estado='A' AND  clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $otros_ingresos = $result['oingresos'];

                    $query = "SELECT SUM(cantidad) AS retiro FROM retiros
                    INNER JOIN negocios ON negocios.idnegocios=retiros.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab  
                    WHERE retiros.estado='R' AND  clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $retiros = $result['retiro'];

                    $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

                    $query = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
                    INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE estado_venta='R' AND clientesab.id_clienteab ='$dueño'
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
                    WHERE abono.estado='R' AND clientesab.id_clienteab ='$dueño' GROUP BY forma_pago ORDER BY forma_pago ASC";
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
                    INNER JOIN negocios ON negocios.idnegocios=adeudos.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE adeudos.estado_deuda ='A' AND clientesab.id_clienteab ='$dueño'";
                    $result = $con->consultaRetorno($query);


                    $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo;
                    $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;
                    $ingresos_credito = $result['ingresos_credito'];

                    $query = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos 
                    INNER JOIN negocios ON negocios.idnegocios = otros_ingresos.negocios_idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE otros_ingresos.estado='A' AND clientesab.id_clienteab ='$dueño'
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
            </tbody>
        </table><br>
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
        </table>
        <form action="#" method="post">
            <button name="BSucursales" type="submit" class="btn btn-primary btn-lg btn-block">Flujo de todas las sucursales</button>
        </form>
    </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>