<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
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

    <title>Busquedas Adeudos</title>
    <script>
        var datos = false;
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function comprobarRows() {
            if (datos == true) {
                var rengolnes;
                renglones = document.getElementById("renglones");
                renglones.innerHTML = "";
            }

        }

        function activarListaC() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("clientes").style.display = "block";
            document.getElementById("fechas").style.display = "none";
            document.getElementById("botones").style.display = "none";

        }

        function activarListaF() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("clientes").style.display = "none";
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

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busquedas Adeudos</a>
        </div>
    </nav>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <h5 style="margin: 0 auto;"><label class="badge badge-warning">BUSQUEDA POR:</label></h5><br>
                <button onclick="activarListaC();" class="btn btn-lg btn-block btn-info">Cliente</button>
                <button onclick="activarListaF();" class="btn btn-lg btn-block btn-info">Fecha</button>
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

                <div id="clientes">
                    <form class="form-group" action="VConsultasAdeudos.php" method="post">
                        <input id="inclientes" class="form form-control" list="clientesv" name="DlClientes" required autocomplete="off">
                        <datalist id="clientesv">
                            <?php
                            $con = new Models\Conexion();
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $query = "SELECT nombre,apaterno,amaterno FROM cliente WHERE negocios_idnegocios ='$negocios' ORDER BY apaterno ASC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('inclientes').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                        <input class="btn btn-block btn-dark" type="submit" value="Buscar">
                    </form>
                </div>

                <div id="fechas">
                    <form class="form-group" action="#" method="post">
                        <input class="form-control" type="date" name="DFecha" required><br>
                        <input class="btn btn-block btn-dark" type="submit" value="Buscar">
                    </form>
                </div><br>
            </div>
        </div>

        <div class="col-md-8" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th>Deuda</th>
                        <th>Pago minimo</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        <th>Venta</th>
                        <th>Abonar</th>
                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['DlClientes'])
                    ) {
                        $con = new Models\Conexion();
                        $nombre = $_POST['DlClientes'];
                        $negocios = $_SESSION['idnegocio'];
                        $query = "SELECT idadeudos , total_deuda ,pago_minimo,estado_deuda, ventas_idventas FROM adeudos 
                        INNER JOIN cliente ON cliente.idcliente=adeudos.cliente_idcliente
                        WHERE  (SELECT CONCAT(cliente.nombre,' ', cliente.apaterno,' ' ,cliente.amaterno))='$nombre'
                        AND adeudos.negocios_idnegocios='$negocios' ORDER BY ventas_idventas DESC";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td>$ <?php echo $renglon['total_deuda']; ?></td>
                                <td>$ <?php echo $renglon['pago_minimo']; ?></td>
                                <td><?php echo $renglon['estado_deuda']; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td><a href="VConsultasVentas.php?venta= <?php echo $renglon['ventas_idventas']; ?>"># <?php echo $renglon['ventas_idventas']; ?></a></td>
                                <td>
                                    <?php if ($renglon['estado_deuda'] == "L") {
                                        ?>
                                        <button class="btn btn-success" disabled><img src="img/abonos.png"></a></button>
                                        <button class="btn btn-success" disabled><img src="img/tarjeta.png"></a></button>
                                    <?php  } else {
                                        ?>
                                        <div class="container">
                                            <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Efectivo">
                                                <img src="img/abonos.png"></a>
                                            <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Tarjeta">
                                                <img src="img/tarjeta.png"></a>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                        } ?>

                    </tbody>
                </table>

            <?php
            } ?>
            <?php
            $con = new Models\Conexion();
            if (isset($_POST['DFecha'])) {
                $fecha = $_POST['DFecha'];
                $query = "SELECT idadeudos ,total_deuda , pago_minimo, estado_deuda , ventas_idventas,nombre,apaterno,amaterno FROM adeudos 
                      INNER JOIN venta ON adeudos.ventas_idventas = venta.idventas 
                      INNER JOIN cliente ON adeudos.cliente_idcliente = cliente.idcliente WHERE venta.fecha='$fecha'";
                $row = $con->consultaListar($query);
                $con->cerrarConexion();
                while ($renglon = mysqli_fetch_array($row)) {
                    echo "<script>datos = true;</script>";
                    ?>
                    <tr>
                        <td>$ <?php echo $renglon['total_deuda']; ?></td>
                        <td>$ <?php echo $renglon['pago_minimo']; ?></td>
                        <td><?php echo $renglon['estado_deuda']; ?></td>
                        <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno'] . " " . $renglon['amaterno']; ?></td>
                        <td><a href="VConsultasVentas.php?venta= <?php echo $renglon['ventas_idventas']; ?>"># <?php echo $renglon['ventas_idventas']; ?></a></td>
                        <td>
                            <?php if ($renglon['estado_deuda'] == "L") {
                                ?>
                                <button class="btn btn-success" disabled><img src="img/abonos.png"></a></button>
                                <button class="btn btn-success" disabled><img src="img/tarjeta.png"></a></button>
                            <?php  } else {
                                ?>
                                <div class="container">
                                    <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Efectivo">
                                        <img src="img/abonos.png"></a>
                                    <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Tarjeta">
                                        <img src="img/tarjeta.png"></a>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                } ?>
                </tbody>
                </table>
            <?php } ?>
            <?php if (isset($_GET['ad'])) {
                $con = new Models\Conexion();
                $adeudo = $_GET['ad'];
                $negocios = $_SESSION['idnegocio'];
                $query = "SELECT idadeudos , total_deuda ,pago_minimo,
                estado_deuda, ventas_idventas,nombre,apaterno,amaterno FROM adeudos 
                        INNER JOIN cliente ON cliente.idcliente=adeudos.cliente_idcliente
                        WHERE idadeudos='$adeudo' AND adeudos.negocios_idnegocios='$negocios'";
                $row = $con->consultaListar($query);
                $con->cerrarConexion();

                while ($renglon = mysqli_fetch_array($row)) {
                    echo "<script>datos = true;</script>";
                    ?>
                    <tr>
                        <td>$ <?php echo $renglon['total_deuda']; ?></td>
                        <td>$ <?php echo $renglon['pago_minimo']; ?></td>
                        <td><?php echo $renglon['estado_deuda']; ?></td>
                        <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno'] . " " . $renglon['amaterno']; ?></td>
                        <td><a href="VConsultasVentas.php?venta= <?php echo $renglon['ventas_idventas']; ?>"># <?php echo $renglon['ventas_idventas']; ?></a></td>
                        <td>
                            <?php if ($renglon['estado_deuda'] == "L") {
                                ?>
                                <button class="btn btn-success" disabled><img src="img/abonos.png"></a></button>
                                <button class="btn btn-success" disabled><img src="img/tarjeta.png"></a></button>
                            <?php  } else {
                                ?>
                                <div class="container">
                                    <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Efectivo">
                                        <img src="img/abonos.png"></a>
                                    <a class="btn btn-success" href="NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Tarjeta">
                                        <img src="img/tarjeta.png"></a>
                                </div>
                            <?php } ?>
                        </td>

                    </tr>
                <?php
                } ?> </tbody>
                </table>

            <?php } ?>
        </div>
    </div>
</body>

</html>