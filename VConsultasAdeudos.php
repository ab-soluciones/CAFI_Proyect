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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Adeudos</title>
</head>

<body>
    <?php
    $sel = "adeudos";
    include("Navbar.php")
    ?>

    <div class="contenedor container-fluid">
        <div id="tableContainer" class="d-block col-lg-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
            </div>
            <div class="contenedorTabla table-responsive">
                <table class="table table-hover table-striped table-dark">
                    <thead class="thead-dark">
                        <tr class="encabezados">

                            <th class="text-nowrap text-center" onclick="sortTable(0)">Deuda</th>
                            <th class="text-nowrap text-center" onclick="sortTable(1)">Pago minimo</th>
                            <th class="text-nowrap text-center" onclick="sortTable(2)">Estado</th>
                            <th class="text-nowrap text-center" onclick="sortTable(3)">Cliente</th>
                            <th class="text-nowrap text-center" onclick="sortTable(4)">Venta</th>
                            <th class="text-nowrap text-center" onclick="sortTable(5)">Abonar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = new Models\Conexion();
                        $negocios = $_SESSION['idnegocio'];
                        if (isset($_GET['ad'])) {
                            $adeudo = $_GET['ad'];
                            $query = "SELECT idadeudos , total_deuda ,pago_minimo,estado_deuda, ventas_idventas,nombre,apaterno,amaterno
                            FROM adeudos INNER JOIN cliente ON cliente.idcliente=adeudos.cliente_idcliente
                            WHERE adeudos.negocios_idnegocios='$negocios' AND idadeudos='$adeudo' ORDER BY ventas_idventas DESC";
                            $row = $con->consultaListar($query);
                        } else {
                            $query = "SELECT idadeudos , total_deuda ,pago_minimo,estado_deuda, ventas_idventas,nombre,apaterno,amaterno
                            FROM adeudos INNER JOIN cliente ON cliente.idcliente=adeudos.cliente_idcliente
                            WHERE adeudos.negocios_idnegocios='$negocios' ORDER BY ventas_idventas DESC";
                            $row = $con->consultaListar($query);
                        }

                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td class="text-nowrap text-center">$<?php echo $renglon['total_deuda']; ?></td>
                            <td class="text-nowrap text-center">$<?php echo $renglon['pago_minimo']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['estado_deuda']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['nombre'] . " " . $renglon['apaterno'] . " " . $renglon['amaterno']; ?></td>
                            <td class="text-nowrap text-center"><a href="VConsultasVentas.php?venta= <?php echo $renglon['ventas_idventas']; ?>">?></a></td>
                            <td class="text-nowrap text-center">
                                <?php if ($renglon['estado_deuda'] == "L") {
                                        ?>
                                <button class="btn btn-success" disabled><img src="img/abonos.png"></a></button>
                                <button class="btn btn-success" disabled><img src="img/tarjeta.png"></a></button>
                                <?php  } else {
                                        ?>
                                <div class="container">
                                    <button onclick="window.location.href='NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Efectivo'" class="btn btn-success" <?php if ($renglon['estado_deuda'] == "L") echo "disabled"; ?>><img src="img/abonos.png"></button>
                                    <button onclick="window.location.href='NAbono.php?tt=<?php echo $renglon['total_deuda']; ?>&ad=<?php echo $renglon['idadeudos']; ?>&edoda=<?php echo $renglon['estado_deuda']; ?>&frm_pg=Tarjeta'" class="btn btn-success" <?php if ($renglon['estado_deuda'] == "L") echo "disabled"; ?>><img src="img/tarjeta.png"></button>
                                </div>
                            </td>
                        </tr>
                        <?php
                            } 
                         }
                        ?>

                    </tbody>
                </table>
            </div>
            <!--Tabla contenedor-->
        </div>
        <!--col-7-->
    </div>
    <!--row-->
    </div>
    <!--container-->
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
