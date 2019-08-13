<?php
require_once "Config/Autoload.php";
session_start();
Config\Autoload::run();
$con = new Models\Conexion();
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
//se optiene el valor de las variables haciendolas raras para el usuario
if (isset($_GET['v3nd3rpr0']) && $_GET['v3nd3rpr0'] == "v3nd3r" && isset($_GET['total'])) {
    $total = $_GET['total'];
    if (isset($_POST['TDescuento']) && isset($_POST['BPorcentaje'])) {
        //se aplica el descuento por porcentaje y se guarda en la sesion
        $descuento = $_POST['TDescuento'];
        $descuento = $total * $descuento;
        $descuento = $descuento / 100;
        $_SESSION['descuento'] = $descuento;
        $total -= $descuento;
        header("location: VPago.php?v3nd3rpr0=v3nd3r&total=$total");
    } else if (isset($_POST['TDescuento']) && isset($_POST['BPesos'])) {
        //se aplica el descuento por pesos y se guarda en la sesion
        $descuento = $_POST['TDescuento'];
        $_SESSION['descuento'] = $descuento;
        $total -= $descuento;
        header("location: VPago.php?v3nd3rpr0=v3nd3r&total=$total");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Pago de venta</title>
        <script type="text/javascript">
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


    <body style="background: #f2f2f2;" onload="ini(); " onkeypress="parar();" onclick="parar();">

        <div class="jumbotron" style="background: #3366ff; color:white; text-align: center;">
            <h1>Monto total de la venta $ <?php echo $total; ?></h1>
            <p>
                <h5><?php if ($_SESSION['forma_pago'] === "Tarjeta") {
                        //se muestra un mensaje diferente si la venta será pagada por tarjeta o con efectivo 
                        echo "Ingrese la tarjeta en la terminál y cobre el total";
                    } else echo " Ingrese a continuacion la cantidad de dinero recibida:" ?> </h5>
            </p>
        </div>

        <div class="card bg-light" style=" width: 220px; margin: 0 auto; margin-top:2%;">
            <div class="card-body text-center">
                <div class="col-xs-4">
                    <!--Con el boton cancelar se puede cancelar el pago redirigiendo al usuario a la pagina de ventas-->
                    <div><button onclick="window.location.href='VVentas.php';" class="btn btn-danger">Cancelar x</button></div><br>
                    <form class="form-group" action="#" method="post">
                        <?php if ($_SESSION['forma_pago'] != "Tarjeta") {
                            ?>
                            <!-- si el pago es en efectivo o a credito se mandan los datos del formulario por el metodo post para calcular el cambio  -->
                            <button type="submit" class="btn btn-dark btn-lg btn-block">
                                <label class="badge badge-dark">Vender</label><br><img src="img/cash_register.png"> </button><br>
                        <?php } else {
                            ?>
                            <a href='finalizarPago.php?total=<?php echo $total; ?>' class="btn btn-dark btn-lg btn-block">
                                <label class="badge badge-dark">Vender</label><br><img src="img/cash_register.png">
                            </a>
                        <?php } ?>

                        <?php if (isset($_SESSION['clienteid'])) {
                            ?>
                            <h5><label for=" abono" class="badge badge-primary">Abono :</label></h5>
                            <input id="abono" class="form form-control" type="text" name="TAbono" placeholder="$" autocomplete="off">
                            <br>
                        <?php } ?>

                        <?php if ($_SESSION['forma_pago'] != "Tarjeta") {
                            ?>
                            <h5><label for="monto" class="badge badge-primary">Pago $ :</label></h5>
                            <input id="monto" class="form form-control" type="text" name="TPago" placeholder="$" autocomplete="off">
                        <?php } ?>

                    </form>
                    <?php if (!isset($_SESSION['descuento'])) {
                        ?>
                        <form id="desc" class="form-group" action="#" method="post">
                            <h5><label for="monto" class="badge badge-success">Descuento :</label></h5>
                            <input id="monto" class="form form-control" type="text" name="TDescuento" placeholder="Ingrese el descuento" autocomplete="off"><br>
                            <button name="BPorcentaje" type="submit" class="btn btn-success btn-lg">%</button>
                            <button name="BPesos" type="submit" class="btn btn-success btn-lg">$</button>
                        </form>

                    <?php } ?>

                </div>
            </div>
        </div>
        </div>
    </body>

    </html>
<?php }

if (isset($_POST['TPago']) && !isset($_POST['TAbono'])) {
    $pago = $_POST['TPago'];
    if ($pago >= $total) {
        $cambio = $pago - $total;
        echo "<script>if(confirm('SU CAMBIO ES DE $ $cambio CONFIRME LA VENTA:')){window.location.href='finalizarPago.php?total=$total&pago=$pago&cambio=$cambio'}else{window.location.href='VVentas.php'}</script>";
    } else {
        echo "<script> alert('Ingrese una cantidad de $ valida');</script>";
    }
    //si la venta es al contado se comprueba que el pago sea mayor que el total de la venta, siendo asi se da un msj de alerta con el cambio , si no es asi se da un msj diciendo que la cantidad ingresada no es válida
}
if (isset($_POST['TAbono']) && isset($_POST['TPago'])) {
    $abono = $_POST['TAbono'];
    $pago = $_POST['TPago'];
    $cambio = $pago - $abono;
    $total_deuda = $total - $abono;
    echo "<script>if(confirm('SU CAMBIO ES DE $ $cambio CONFIRME LA VENTA:')){window.location.href='finalizarPago.php?total=$total&pago=$pago&cambio=$cambio&totald=$total_deuda&abono=$abono'}else{window.location.href='VVentas.php'}</script>";
    //si la venta es  credito se guarda el anticipo en la variable pago, se da la alerta con el cambio y se redirige al archivo de finalizar pago
}
?>