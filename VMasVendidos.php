<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager") {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Productos mas vendidos</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Productos mas vendidos</a>
        </div>
    </nav>
    <div class="row" style="margin-left: 5px; margin-top: 5px;">
        <div class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <div>
                        <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
                        <datalist id="negocios">
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
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['DlNegocios'])) {
                        $con = new Models\Conexion();
                        $negocio = $_POST['DlNegocios'];
                        $query = "SELECT producto.nombre,producto.descripcion , SUM(cantidad_producto) AS cantidadproducto FROM detalle_venta
                        INNER JOIN producto ON detalle_venta.producto= producto.idproducto
                        INNER JOIN negocios ON producto.negocios_idnegocios=negocios.idnegocios
                        WHERE negocios.nombre_negocio='$negocio'
                        GROUP BY idproducto
                        ORDER BY `cantidadproducto` DESC";
                        $row = $con->consultaListar($query);

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                            <tr>
                                <td><?php echo $renglon['nombre']; ?></td>
                                <td><?php echo $renglon['descripcion']; ?></td>
                                <td><?php echo $renglon['cantidadproducto']; ?></td>

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