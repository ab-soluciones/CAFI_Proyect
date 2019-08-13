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
    <title>Concepto Venta</title>
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Concepto Venta</a>
        </div>
    </nav>
    <?php
    if (isset($_GET['idv3n7a'])) {
        $negocio = $_SESSION['idnegocio'];
        $con = new Models\Conexion();
        $venta = $_GET['idv3n7a'];
        $query = "SELECT nombre,imagen,color,marca,precio_venta, unidad_medida, talla_numero, cantidad_producto,subtotal FROM
        producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
        detalle_venta.idventa='$venta'";
        $row = $con->consultaListar($query);
        $con->cerrarConexion();
        ?>
        <div class="col-md-8" style=" margin: 0 auto; margin-top:25px;">
            <table class="table table-bordered table-responsive-md">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>UM</th>
                        <th>Talla</th>
                        <th>PU</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <?php while ($renglon = mysqli_fetch_array($row)) {
                    ?>
                    <tbody>
                        <td><?php echo $renglon['cantidad_producto']; ?></td>
                        <td><?php echo $renglon['nombre']; ?></td>
                        <td><img src="data:image/jpg;base64,<?php echo base64_encode($renglon['imagen']) ?>" height="100" width="100" /></td>
                        <td><?php echo $renglon['marca']; ?></td>
                        <td><?php echo $renglon['color']; ?></td>
                        <td><?php echo $renglon['unidad_medida']; ?></td>
                        <td><?php echo $renglon['talla_numero']; ?></td>
                        <td><?php echo $renglon['precio_venta']; ?></td>
                        <td><?php echo $renglon['subtotal']; ?></td>
                    </tbody>

                <?php } ?>
            </table>
            <a href="VConsultasVentas.php?venta=<?php echo $venta; ?>" class="btn btn-success btn-lg btn-block">Aceptar</a>
        </div>
    <?php } ?>
</body>

</html>