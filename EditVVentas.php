<?php
require_once "Config/Autoload.php";
session_start();
Config\Autoload::run();
$con = new Models\Conexion();
if (isset($_GET['id']) && isset($_GET['can']) && isset($_GET['precio']) && isset($_GET['stock'])) {
    $id = $_GET['id'];
    $cantidad = $_GET['can'];
    $precio = $_GET['precio'];
    $stock = $_GET['stock'];

    if (isset($_POST['SCantidad'])) {
        $dv = new Models\DetalleVenta();
        $dv->setCantidad($_POST['SCantidad']);
        $dv->setPrecio($precio);
        $dv->setSuptotal($_POST['SCantidad']);
        $dv->editar($id);

        header('location: VVentas.php');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Edicion de cantidad</title>
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
                        <h5><label for="cant" class="badge badge-warning">Cantidad:</label></h5>
                        <input id="cant" class="form form-control" type="number" name="SCantidad" min="1" max="<?php echo $stock; ?>" value="<?php echo $cantidad; ?>"><br>
                        <input type="submit" class="btn  btn-block btn-dark" value="Editar">
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} ?>