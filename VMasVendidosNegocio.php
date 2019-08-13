<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
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
    <title>Productos mas vendidos</title>
    <script>
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
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Productos mas vendidos</a>
        </div>
    </nav>
    <div style="margin: 0 auto; margin-top:10px;" class="col-md-8">
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
                if (isset($_SESSION['idnegocio'])) {
                    $con = new Models\Conexion();
                    $negocio = $_SESSION['idnegocio'];
                    $query = "SELECT producto.nombre,producto.descripcion , SUM(cantidad_producto) AS cantidadproducto FROM detalle_venta
                        INNER JOIN producto ON detalle_venta.producto= producto.idproducto
                        WHERE producto.negocios_idnegocios='$negocio'
                        GROUP BY idproducto
                        ORDER BY `cantidadproducto` DESC";
                    $row = $con->consultaListar($query);
                    $con->cerrarConexion();

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