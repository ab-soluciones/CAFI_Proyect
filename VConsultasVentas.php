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
    <?php
    $sel = "ventas";
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
            <div class="contenedorTabla">
                <table class="scroll table width="100%" table-bordered table-hover fixed_headers table-responsive">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th class="text-nowrap text-center" onclick="soExplore rtTable(0)">Concepto</th>
                            <th class="text-nowrap text-center" onclick="sortTable(1)">Descuento</th>
                            <th class="text-nowrap text-center" onclick="sortTable(2)">Total</th>
                            <th class="text-nowrap text-center" onclick="sortTable(3)">Pago</th>
                            <th class="text-nowrap text-center" onclick="sortTable(4)">Forma</th>
                            <th class="text-nowrap text-center" onclick="sortTable(5)">Cambio</th>
                            <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha</th>
                            <th class="text-nowrap text-center" onclick="sortTable(7)">Hora</th>
                            <th class="text-nowrap text-center" onclick="sortTable(8)">Es</th>
                            <th class="text-nowrap text-center" onclick="sortTable(9)">Trabajador</th>
                            <th class="text-nowrap text-center" onclick="sortTable(10)">Editar</th>
                        </tr>
                    </thead>
                    <tbody id="renglones">
                        <?php
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        if(isset($_GET['venta'])){
                            $venta = $_GET['venta'];
                            $query = "SELECT idventas, descuento ,total , pago, forma_pago,
                            cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta
                            INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                            WHERE venta.idnegocios='$negocio' AND idventas = '$venta' ORDER BY idventas DESC";
                            $row = $con->consultaListar($query);
                        }else{
                            $query = "SELECT idventas, descuento ,total , pago, forma_pago,
                            cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta
                            INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                            WHERE venta.idnegocios='$negocio' ORDER BY idventas DESC";
                            $row = $con->consultaListar($query);
                        }

                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td class="text-nowrap text-center"><a href="VConceptoVenta.php?idv3n7a=<?php echo $renglon['idventas'];  ?>">Mostrar</a></td>
                            <td class="text-nowrap text-center">$ <?php echo $renglon['descuento']; ?></td>
                            <td class="text-nowrap text-center">$ <?php echo $renglon['total']; ?></td>
                            <td class="text-nowrap text-center">$ <?php echo $renglon['pago']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['forma_pago']; ?></td>
                            <td class="text-nowrap text-center">$ <?php echo $renglon['cambio']; ?></td>
                            <td class="text-nowrap text-center">$ <?php echo $renglon['cambio']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['fecha']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['hora']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['estado_venta']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>

                            <td class="text-nowrap text-center" style="width:100px;">
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
