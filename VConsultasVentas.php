<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
//header('Cache-Control: no cache');
//session_cache_limiter('private_no_expire');
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEO" || $_SESSION['acceso'] == "ManagerAB"
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
    <link rel="stylesheet" href="css/style.css">
    
    <title>Ventas</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php include("Navbar.php") ?>
    
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto; margin-top:10px;">
            <nav class="navbar navbar-dark bg-dark">
                <div class="container">
                    <a style="margin: 0 auto;" href="#" class="navbar-brand">Buscar ventas por :</a>
                </div>
            </nav>
            <div class="card card-body">
                <button onclick="activarListaE();" class="btn btn-lg btn-block btn-info">Estado</button>
                <button onclick="activarListaF();" class="btn btn-lg btn-block btn-info">Fecha</button>
                <button onclick="activarListaM();" class="btn btn-lg btn-block btn-info">Mes</button>
            </div>
        </div>
    </div>
    <div class="row" style=" margin-top: 15px;">
        <div id="busqueda" class="col-xs-4" style="margin: 0 auto;">
            <script>
                document.getElementById('busqueda').style.display = 'none';
            </script>
            <div class=" card card-body">
                <div><button onclick="activarM();" class="btn btn-danger">x</button></div><br>
                <form class="form-group" action="VConsultasVentas.php" method="post">
                    <div id="estado">
                        <input id="inestado" class="form form-control" list="estadov" name="DlEstado" autocomplete="off">
                        <datalist id="estadov">
                            <option value="R">
                            <option value="C">
                        </datalist>
                    </div>
                    <div id="fechas">
                        <input class="form-control" type="date" name="DFecha">
                    </div>
                    <div id="mes">
                        <input id="inmes" class="form-control" type="month" name="DMes">
                    </div><br>

                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

        <div class="col-xl-12" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered table-responsive-xl">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th>Pagó</th>
                        <th>Forma</th>
                        <th>Cambio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Es</th>
                        <th>Trabajador</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['DlEstado']) || isset($_POST['DFecha']) || isset($_GET['venta']) || isset($_POST['DMes'])
                    ) {
                        if (isset($_POST['DlEstado']) || isset($_POST['DFecha'])) {
                            $estado = $_POST['DlEstado'];
                            $fecha = $_POST['DFecha'];
                            $venta = "";
                        } else if (isset($_GET['venta'])) {
                            $venta = $_GET['venta'];
                            $estado = "";
                            $fecha = "";
                        }
                        if (isset($_POST['DMes']) && strlen($_POST['DMes']) != 0) {
                            $mesdelaño = explode("-", $_POST['DMes']);
                            $año = $mesdelaño[0];
                            $mes = $mesdelaño[1];
                        } else {
                            $mes = "";
                            $año = "";
                        }
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        $query = "SELECT idventas, descuento ,total , pago, forma_pago, 
                        cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta 
                        INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                        WHERE venta.fecha = '$fecha' AND venta.idnegocios='$negocio' 
                        OR venta.estado_venta= '$estado' AND venta.idnegocios='$negocio' 
                        OR venta.idventas= '$venta' AND venta.idnegocios='$negocio'
                        OR MONTH(venta.fecha) = '$mes' AND YEAR(venta.fecha)='$año' 
                        AND venta.idnegocios='$negocio' ORDER BY idventas DESC";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td><a href="VConceptoVenta.php?idv3n7a=<?php echo $renglon['idventas'];  ?>">Mostrar</a></td>
                                <td>$ <?php echo $renglon['descuento']; ?></td>
                                <td>$ <?php echo $renglon['total']; ?></td>
                                <td>$ <?php echo $renglon['pago']; ?></td>
                                <td><?php echo $renglon['forma_pago']; ?></td>
                                <td>$ <?php echo $renglon['cambio']; ?></td>
                                <td><?php echo $renglon['fecha']; ?></td>
                                <td><?php echo $renglon['hora']; ?></td>
                                <td><?php echo $renglon['estado_venta']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>

                                <td style="width:100px;">
                                    <div class="row">
                                        <?php if ($_SESSION['acceso'] == "Employes") {
                                            ?>
                                            <button style="margin: 0 auto;" class="btn btn-secondary" disabled><img src="img/edit.png"></button>
                                        <?php  } else {
                                            ?>
                                            <a style="margin: 0 auto;" class="btn btn-secondary" href="EditEventas.php?id=<?php echo $renglon['idventas']; ?>&estado=<?php echo $renglon['estado_venta']; ?>">
                                                <img src="img/edit.png">
                                            </a>
                                        <?php } ?>

                                    </div>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            <?php
            } ?>
        </div>
        <script src="js/user_jquery.js"></script>
</body>

</html>