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
    <title>Ventas</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php include("Navbar.php") ?>
    <div class="container-fluid">
        <div id="tableContainer" class="d-block col-lg-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
            </div>
            <div class="contenedorTabla">
                <table class="table table-bordered table-hover fixed_headers table-responsive">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th onclick="sortTable(0)">Concepto</th>
                            <th onclick="sortTable(1)">Descuento</th>
                            <th onclick="sortTable(2)">Total</th>
                            <th onclick="sortTable(3)">Pagó</th>
                            <th onclick="sortTable(4)">Forma</th>
                            <th onclick="sortTable(5)">Cambio</th>
                            <th onclick="sortTable(6)">Fecha</th>
                            <th onclick="sortTable(7)">Hora</th>
                            <th onclick="sortTable(8)">Es</th>
                            <th onclick="sortTable(9)">Trabajador</th>
                            <th onclick="sortTable(10)">Editar</th>
                        </tr>
                    </thead>
                    <tbody id="renglones">
                        <?php
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        $query = "SELECT idventas, descuento ,total , pago, forma_pago, 
                        cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta 
                        INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                        WHERE venta.idnegocios='$negocio' ORDER BY idventas DESC";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
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
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
            <!--Tabla contenedor-->
        </div>
        <!--container-->
    <script src="js/user_jquery.js"></script>
</body>

</html>