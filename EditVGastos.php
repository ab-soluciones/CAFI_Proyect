<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
if (isset($_GET['id'])) {
    ?>
    <?php
    $id = $_GET['id'];
    $con = new Models\Conexion();
    $query =  $sql = "SELECT * FROM gastos where idgastos = '$id'";
    $result = mysqli_fetch_assoc($con->consultaListar($query));
    $con->cerrarConexion();
    if (
        isset($_POST['SConcepto']) && isset($_POST['SPago'])
        && isset($_POST['TADescription']) && isset($_POST['TMonto'])
        && isset($_POST['REstado']) && isset($_POST['DFecha'])
    ) {
        $trabajador = $_SESSION['id'];
        $gasto = new Models\Gasto();
        $gasto->setConcepto($_POST['SConcepto']);
        $gasto->setPago($_POST['SPago']);
        $gasto->setDescripcion($_POST['TADescription']);
        $monto = $_POST['TMonto'];
        $monto = floatval($monto);
        $gasto->setMonto($monto);
        $gasto->setEstado($_POST['REstado']);
        $gasto->setFecha($_POST['DFecha']);
        $gasto->editar($id, $trabajador);
        header('location: VGastos.php');
    }
    if (isset($result)) {

        ?>
        <!DOCTYPE html>
        <html lang="en" dir="ltr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="css/bootstrap.css">
            <title> Edicion Gastos</title>
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

        <body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
            <nav class="navbar navbar-dark bg-dark">
                <div class="container">
                    <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion Gastos</a>
                    <h5></h5>
                </div>
            </nav>
            <div class="row">
                <div class="col-md-3" style="  margin: 0 auto; margin-top:5px;">
                    <div class=" card card-body">
                        <form class="form-group" action="#" method="post">
                            <select name="SConcepto" id="concepto" class="form form-control" required>
                                <option>Renta</option>
                                <option>Luz</option>
                                <option>Agua</option>
                                <option>Teléfono</option>
                                <option>Internet</option>
                                <option>Transporte</option>
                                <option>Sueldo</option>
                                <option>Articulos de Venta</option>
                                <option>Pago de Prestamo</option>
                                <option>Otro</option>
                            </select> <br>
                            <h5><label for="pago" class="badge badge-primary">Forma de pago:</label></h5>
                            <select name="SPago" id="pago" class="form form-control" required>
                                <option>Efectivo</option>
                                <option>Transferencia</option>
                                <option>Tarjeta</option>
                            </select> <br>
                            <script>
                                document.getElementById('concepto').value = "<?php echo $result['concepto']; ?>";
                                document.getElementById('pago').value = "<?php echo $result['pago']; ?>";
                            </script>
                            <h5><label for="desc" class="badge badge-primary">Descripcion:</label></h5>
                            <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion"><?php echo $result['descripcion'] ?></textarea><br>
                            <h5><label for="monto" class="badge badge-primary">Monto $:</label></h5>
                            <input value="<?php echo $result['monto'] ?>" id="monto" class="form form-control" type="text" name="TMonto" placeholder="$" autocomplete="off" required><br>
                            <?php if ($result['estado'] == "A") {
                                ?>
                                <div class="row" style="margin: 0 auto;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="A" checked autofocus>Activo
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="I">Inactivo
                                        </label>
                                    </div>
                                </div><br>
                            <?php

                            } else {
                                ?>
                                <div class="row" style="margin: 0 auto;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="A">Activo
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="I" checked autofocus>Inactivo
                                        </label>
                                    </div>
                                </div><br>
                            <?php

                            } ?>
                            <div>
                                <h5><label for="fecha" class="badge badge-primary">Fecha:</label></h5>
                                <input value="<?php echo $result['fecha'] ?>" class="form-control" id="fecha" type="date" name="DFecha" required>
                            </div><br>
                            <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Editar">
                        </form>
                    </div>
                </div>
            </div>
        </body>

        </html>
    <?php

    } ?>
<?php

}
?>