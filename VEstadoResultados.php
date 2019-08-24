<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
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
    <title>Estado de Resultado</title>
</head>

<body onload="inicio();">
<?php include("NavbarD.php") ?>
    <div style="margin: 0 auto; margin-top:10px;" class="col-md-8">
        <h5 style="margin: 0 auto;"><label class="badge badge-info">
                <a style="color: white;" href="VConsultasEstadoResultados.php">Consultar otras fechas --></a>
            </label></h5>
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Ventas</th>
                    <th>Costo de Venta</th>
                    <th>Utilidad Bruta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $negocio = $_SESSION['idnegocio'];
                $con = new Models\Conexion();

                //consultas para optener el estado de resultados al dia

                $query = "SELECT SUM(total) AS ventas FROM venta WHERE estado_venta = 'R' AND idnegocios='$negocio'";
                $result = $con->consultaRetorno($query);
                $ventas = $result['ventas'];

                $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta 
                FROM producto INNER JOIN detalle_venta ON producto.codigo_barras=detalle_venta.producto_codigo_barras
                INNER JOIN venta ON detalle_venta.idventa=venta.idventas
                WHERE venta.estado_venta='R' AND venta.idnegocios='$negocio'";
                $result = $con->consultaRetorno($query);
                $con->cerrarConexion();
                $costo_venta = $result['costo_venta'];
                $utilidad_bruta = $ventas - $costo_venta;

                if (isset($_POST['BSucursales'])) {
                    $dueño = $_SESSION['id'];
                    $con = new Models\Conexion();

                    //consultas para optener el estado de resultados de todos los negocios de nuestro clienteab

                    $query = "SELECT SUM(total) AS ventas FROM venta
                    INNER JOIN negocios ON negocios.idnegocios = venta.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                    WHERE estado_venta = 'R' AND clientesab.id_clienteab='$dueño'";
                    $result = $con->consultaRetorno($query);
                    $ventas = $result['ventas'];
                    $query = "SELECT SUM(producto.precio_compra * detalle_venta.cantidad_producto) AS costo_venta FROM producto 
                    INNER JOIN detalle_venta ON producto.codigo_barras = detalle_venta.producto_codigo_barras 
                    INNER JOIN venta ON detalle_venta.idventa = venta.idventas
                    INNER JOIN negocios ON negocios.idnegocios = venta.idnegocios
                    INNER JOIN clientesab ON negocios.clientesab_idclienteab = clientesab.id_clienteab
                    WHERE venta.estado_venta = 'R' AND clientesab.id_clienteab = '$dueño'";
                    $result = $con->consultaRetorno($query);
                    $con->cerrarConexion();
                    $costo_venta = $result['costo_venta'];
                    $utilidad_bruta = $ventas - $costo_venta;
                }
                ?>
                <td>$ <?php if (is_null($ventas)) {
                            echo "0";
                        } else {
                            echo $ventas;
                        } ?></td>
                <td>$ <?php if (is_null($costo_venta)) {
                            echo "0";
                        } else {
                            echo $costo_venta;
                        } ?></td>
                <td>$ <?php echo $utilidad_bruta; ?></td>
            </tbody>
        </table>
        <form action="#" method="post">
            <button name="BSucursales" type="submit" class="btn btn-primary btn-lg btn-block">Estado de todas las sucursales</button>
        </form>
    </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>