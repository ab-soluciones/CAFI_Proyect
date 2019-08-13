<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    ||  $_SESSION['acceso'] == "CEO"
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
    <title>Busquedas Ventas</title>
    <script>
        var datos = false;

        function comprobarRows() {
            if (datos == true) {
                var rengolnes;
                renglones = document.getElementById("renglones");
                renglones.innerHTML = "";
            }
        }

        function activarListaN() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("negocios").style.display = "block";
            document.getElementById("fechas").style.display = "none";
            document.getElementById("botones").style.display = "none";

        }

        function activarListaF() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("negocios").style.display = "none";
            document.getElementById("fechas").style.display = "block";
            document.getElementById("botones").style.display = "none";


        }

        function activarM() {
            comprobarRows();
            document.getElementById("busqueda").style.display = "none";
            document.getElementById("botones").style.display = "block";

        }
    </script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busquedas Ventas</a>
        </div>
    </nav>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <h5 style="margin: 0 auto;"><label class="badge badge-warning">BUSQUEDA POR:</label></h5><br>
                <button onclick="activarListaN();" class="btn btn-lg btn-block btn-info">Negocio</button>
                <button onclick="activarListaF();" class="btn btn-lg btn-block btn-info">Negocio y fecha</button>
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
                <form class="form-group" action="#" method="post">
                    <div id="negocios">
                        <input id="innegocio" class="form form-control" list="lnegocios" name="DlNegocios" autocomplete="off">
                        <datalist id="lnegocios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio FROM negocios ORDER BY nombre_negocio ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre_negocio'] . "'> "; ?>
                            <?php
                        }
                        if ($datos == false) {
                            echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                        } ?>

                        </datalist>
                    </div>
                    <div id="fechas">
                        <input id="innegociof" class="form form-control" list="lnegocios" name="DlNegocios2" autocomplete="off">
                        <datalist id="lnegocios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio FROM negocios ORDER BY nombre_negocio ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre_negocio'] . "'> "; ?>
                            <?php
                        }
                        if ($datos == false) {
                            echo "<script>document.getElementById('innegociof').disabled = true;</script>";
                        } ?>

                        </datalist><br>
                        <input class="form-control" type="date" name="DFecha">
                    </div><br>

                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

        <div class="col-xl-12" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered">
                <div id="lmv">
                    <h5 style="margin: 0 auto;"><label class="badge badge-info">
                            <a style="color: white;" href="VMasVendidos.php">Lo más vendido--></a>
                        </label></h5>
                </div>

                <thead>
                    <tr>
                        <th>Descripcion</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th>Pagó</th>
                        <th>Cambio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Trabajador</th>
                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['DlNegocios']) && isset($_POST['DFecha']) || isset($_POST['DlNegocios'])
                    ) {
                        if ($_POST['DlNegocios'] == "") {
                            $negocio2 = $_POST['DlNegocios2'];
                            $fecha = $_POST['DFecha'];
                            $negocio = "";
                        } else if ($_POST['DlNegocios2'] == "") {
                            $negocio = $_POST['DlNegocios'];
                            $fecha = "";
                            $negocio2 = "";
                        }
                        $con = new Models\Conexion();
                        $query = "SELECT idventas, descuento ,total , pago, cambio , fecha, hora, estado_venta, nombre,apaterno FROM venta 
                        INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                        INNER JOIN negocios ON negocios.idnegocios=venta.idnegocios
                        WHERE negocios.nombre_negocio = '$negocio2' AND venta.fecha = '$fecha' OR negocios.nombre_negocio='$negocio'
                        ORDER BY idventas DESC";
                        $row = $con->consultaListar($query);

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td><?php $query = "SELECT nombre,precio_venta, unidad_medida, cantidad_producto,subtotal FROM
                                producto INNER JOIN detalle_venta ON producto.idproducto = detalle_venta.producto WHERE
                                detalle_venta.idventa='$renglon[idventas]'";
                                    $row2 = $con->consultaListar($query);
                                    $cont = 1;
                                    while ($renglon2 = mysqli_fetch_array($row2)) {

                                        if ($cont > 1) {
                                            echo "<br>";
                                        }
                                        echo "$renglon2[cantidad_producto]" . "  " . $renglon2['nombre'] . "  PU:  $  " . $renglon2['precio_venta'] . "  " .
                                            "  UM:  " . $renglon2['unidad_medida'] . "  SbT:  $  " . $renglon2['subtotal'];
                                        $cont++;
                                    }

                                    ?></td>
                                <td><?php echo $renglon['descuento']; ?></td>
                                <td>$ <?php echo $renglon['total']; ?></td>
                                <td>$ <?php echo $renglon['pago']; ?></td>
                                <td>$ <?php echo $renglon['cambio']; ?></td>
                                <td><?php echo $renglon['fecha']; ?></td>
                                <td><?php echo $renglon['hora']; ?></td>
                                <td><?php echo $renglon['estado_venta']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                            </tr>
                        <?php
                    } ?>
                    </tbody>
                </table>
            <?php
        } ?>
        </div>
    </div>
</body>

</html>