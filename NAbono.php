<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEO" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}
if (
    isset($_GET['cant']) && isset($_GET['pg']) && isset($_GET['ad'])
    && isset($_GET['cam'])  && isset($_GET['tt'])
    && isset($_GET['frm_pg'])
) {
    $negocio = $_SESSION['idnegocio'];
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$negocio'";
    $resultado = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $cantidad = $_GET['cant'];
    $pago = $_GET['pg'];
    $adeudo = (int) $_GET['ad'];
    $cambio = $_GET['cam'];
    $total = $_GET['tt'];
    $forma_pago = $_GET['frm_pg'];
    $total = $total - $cantidad;
    $abono = new Models\Abono();
    $abono->setCantidad($cantidad);
    $abono->setPago($pago);
    $abono->setFormaPago($forma_pago);
    $abono->setCambio($cambio);
    $abono->setFecha();
    $abono->setHora();
    $abono->setNegocio($_SESSION['idnegocio']);
    $abono->setTrabajador($_SESSION['id']);
    $result = $abono->guardar($adeudo, $total);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>


</html>
<?php
    if ($result === 1) {
        ?>
<script>
    swal({
        title: 'Exito',
        text: 'Se han guardado los datos exitosamente',
        type: 'success'
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = "<?php if ($resultado['impresora'] === "A") {
                                                echo "ticketabono.php?ad=$adeudo";
                                            } else if ($resultado['impresora'] === "I") {
                                                echo "VConsultasAdeudos.php";
                                            } ?>";
        }
    });
</script>

<?php } else {
        ?>
<script>
    swal({
        title: 'Error',
        text: 'No se han guardado los datos',
        type: 'error'
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = "<?php if ($resultado['impresora'] === "A") {
                                                echo "ticketabono.php?ad=$adeudo";
                                            } else if ($resultado['impresora'] === "I") {
                                                echo "VConsultasAdeudos.php";
                                            } ?>";
        }
    });
</script>
</body>
<?php }
}
?>
<?php
if (isset($_GET['tt']) && isset($_GET['ad']) && isset($_GET['edoda']) && isset($_GET['frm_pg'])) {
    $total = $_GET['tt'];
    $adeudo = $_GET['ad'];
    $estado = $_GET['edoda'];
    $forma_pago = $_GET['frm_pg'];
    if ($estado == "L") {
        echo "<script>alert('Imposible abonar la deuda esta liquidada'); window.location.href= 'VConsultasAdeudos.php'; </script>";
    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Abono</title>
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

<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #e6e6e6">
    <div class="row">
        <div class="col-xl-3" style="margin: 0 auto;  margin-top:12%;">
            <div class="card card-body">
                <form class="form-group" action="#" method="post">
                    <?php
                        if ($forma_pago === "Tarjeta") {
                            ?>
                    <h5><label for="cant" class="badge badge-success">Abono:</label></h5>
                    <input id="cant" class="form form-control" type="text" name="TCantidad" placeholder="Ingrese la cantidad cargada a la tarjeta"><br>
                    <?php } else if ($forma_pago === "Efectivo") {
                            ?>
                    <h5><label for="cant" class="badge badge-success">Abono:</label></h5>
                    <input id="cant" class="form form-control" type="text" name="TCantidad" placeholder="Ingrese la cantidad $"><br>
                    <h5><label for="pago" class="badge badge-success">Pago:</label></h5>
                    <input id="pago" class="form form-control" type="text" name="TPago" placeholder="Ingrese la cantidad $"><br>

                    <?php }
                        ?>
                    <input type="submit" class="btn  btn-block btn-dark" value="Agregar">
                </form>
            </div>
        </div>
    </div>

</body>

</html>
<?php
    if (isset($_POST['TCantidad']) && isset($_POST['TPago'])) {
        $cantidad = $_POST['TCantidad'];
        $pago = $_POST['TPago'];
        if ($cantidad > $total) {
            echo "<script>alert('No puede ingresar una cantidad mas grande que el total de la deuda');</script>";
            echo "<script>window.location.href='NAbono.php?tt=$total&ad=$adeudo&edoda=$estado&frm_pg=$forma_pago'</script>";
        } else {
            $cambio = $pago - $cantidad;
            echo "<script>if(confirm('SU CAMBIO ES DE $ $cambio CONFIRME LA VENTA:')){window.location.href='NAbono.php?cant=$cantidad&pg=$pago&ad=$adeudo&cam=$cambio&tt=$total&frm_pg=$forma_pago'}else{window.location.href='NAbono.php?tt=$total&ad=$adeudo&edoda=$estado'}</script>";
        }
    }
    if (isset($_POST['TCantidad'])) {
        $cantidad = $_POST['TCantidad'];
        if ($cantidad > $total) {
            echo "<script>alert('No puede ingresar una cantidad mas grande que el total de la deuda');</script>";
            echo "<script>window.location.href='NAbono.php?tt=$total&ad=$adeudo&edoda=$estado&frm_pg=$forma_pago'</script>";
        } else {
            echo "<script>window.location.href='NAbono.php?cant=$cantidad&pg=0&ad=$adeudo&cam=0&tt=$total&frm_pg=$forma_pago'</script>";
        }
    }
}

?>