<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
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
    <title>Abonos</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php include("Navbar.php") ?>

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
                            <th onclick="sortTable(0)">Edit estado</th>
                            <th onclick="sortTable(1)">Estado</th>
                            <th onclick="sortTable(2)">Cantidad</th>
                            <th onclick="sortTable(3)">Pago</th>
                            <th onclick="sortTable(4)">Cambio</th>
                            <th onclick="sortTable(5)">Fecha</th>
                            <th onclick="sortTable(6)">Hora</th>
                            <th onclick="sortTable(7)">Cliente</th>
                            <th onclick="sortTable(8)">Registró</th>
                            <th onclick="sortTable(9)">Adeudo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = new Models\Conexion();
                        $negocios = $_SESSION['idnegocio'];
                        $query = "SELECT idabono,abono.estado AS a_estado,cantidad,pago,cambio,fecha,hora,cliente.nombre AS nombre_cliente,
                                            cliente.apaterno AS ap_cliente, cliente.amaterno AS am_cliente,trabajador.nombre,
                                            trabajador.apaterno, adeudos_id FROM abono
                                            INNER JOIN adeudos ON abono.adeudos_id=adeudos.idadeudos
                                            INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente
                                            INNER JOIN trabajador ON trabajador.idtrabajador=abono.trabajador_idtrabajador
                                            WHERE adeudos.negocios_idnegocios = '$negocios'
                                            ORDER BY adeudos_id DESC";
                        $row = $con->consultaListar($query);
                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td style="width:100px;">
                                <div class="row" style="margin: 0 auto;">
                                    <?php if ($_SESSION['acceso'] == "Employes") {
                                            ?>
                                    <button style="margin: 0 auto;" class="btn btn-secondary" disabled><img src="img/edit.png"></button>
                                    <?php } else {
                                            ?>
                                    <a style="margin-left:2px;" class="btn btn-secondary" href="EditAbonos.php?id=<?php echo $renglon['idabono']; ?>&estado=<?php echo $renglon['a_estado']; ?>">
                                        <img src="img/edit.png">
                                    </a>
                                    <?php   } ?>

                                </div>
                            </td>
                            <td><?php echo $renglon['a_estado']; ?></td>
                            <td>$ <?php echo $renglon['cantidad']; ?></td>
                            <td>$ <?php echo $renglon['pago']; ?></td>
                            <td>$ <?php echo $renglon['cambio']; ?></td>
                            <td><?php echo $renglon['fecha']; ?></td>
                            <td><?php echo $renglon['hora']; ?></td>
                            <td><?php echo $renglon['nombre_cliente'] . " " . $renglon['ap_cliente'] . " " . $renglon['am_cliente']; ?></td>
                            <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                            <td><a href="VConsultasAdeudos.php?ad= <?php echo $renglon['adeudos_id']; ?>"># <?php echo $renglon['adeudos_id']; ?></a></td>
                        </tr>
                        <?php
                        } ?>
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
</body>

</html>
