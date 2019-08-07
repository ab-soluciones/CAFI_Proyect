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
if (isset($_POST['nuevaventa'])) {
    /*se crea una nueva venta para poder hacer uso de la tabla detalle venta(describe el concepto de la venta)
     ya que tiene relacion de muchos a muchos con la tabla productos y la tabla venta */
    $venta = new Models\Venta();
    $id = $venta->guardar();
    $_SESSION['idven'] = $id['id'];
    header('location: VVentas.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/botones.css">
    <title>Ventas</title>
    <script type="text/javascript">
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000)); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000)); // 25 min
        }
    </script>
</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto; margin-top: 14%;">
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <a class="btn btn-orange" href="OPCAFI.php"><img src="img/menuh.png"></a>
                <h5 style="color:white; position: absolute; margin-left: 35%;">Ventas</h5>
                <a style=" position: absolute; margin-left: 70%; " class="btn btn-orange" href="OPCAFI.php"><img src="img/flechaizquierda.png"></a>
            </nav>
            <div class="card card-body">
                <form action="#" method="post">
                    <button img="img/newventa.png" id="nv" class="btn btn-lg btn-block btn-info" type="submit" name="nuevaventa">
                        <label class="badge badge-info">Nueva venta</label><br><img src="img/newventa.png"> </button>
                </form>
                <br> <a id="va" class="btn btn-primary btn-lg btn-block" href="VVentas.php">Venta Actual</a>
            </div>
        </div>
    </div>
</body>

</html>
<?php
if (!is_null($_SESSION['idven'])) {
    //si ya fue creada una venta no se puede crear una nueva hasta terminar la actual
    echo "<script>document.getElementById('nv').disabled = true; alert('TERMINE LA VENTA ACTUAL');</script>";
} else {
    echo "<script>document.getElementById('va').style.display = 'none';</script>";
}
?>