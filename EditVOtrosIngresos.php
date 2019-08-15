<?php
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
require_once "Config/Autoload.php";
Config\Autoload::run();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (
        isset($_POST['TCantidad']) && isset($_POST['STipo'])
        && isset($_POST['SFIngreso']) && isset($_POST['DFecha'])
        && isset($_POST['REstado'])
    ) {
        $otro_ingreso = new Models\OtrosIngresos();
        $otro_ingreso->setIdOtrosIngresos($id);
        $otro_ingreso->setCantidad($_POST['TCantidad']);
        $otro_ingreso->setTipo($_POST['STipo']);
        $otro_ingreso->setFormaIngreso($_POST['SFIngreso']);
        $otro_ingreso->setFecha($_POST['DFecha']);
        $otro_ingreso->setEstado($_POST['REstado']);
        $trabajador = $_SESSION['id'];
        $result = $otro_ingreso->editar($trabajador);
        if ($result === 1) {
            ?>
<script>
    alert('editado Exitosamente');
</script>
<?php } else if ($result === 0) {
            ?>
<script>
    alert('No se a realizado ningún cambio');
</script>
<?php } else if ($result === -1) {
            ?>
<script>
    alert('no editado compruebe los campos unicos');
</script>
<?php }
    }
    $query = "SELECT * FROM otros_ingresos WHERE id_otros_ingresos='$id'";
    $con = new Models\Conexion();
    $result = $con->consultaRetorno($query);
    $con->cerrarConexion();
    ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Administracion Gastos</title>
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Edicion Otros Ingresos</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px; margin-left:5px;">
        <div style="margin: 0 auto;" class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="can" class="badge badge-primary">Cantidad $ :</label></h5>
                    <input value="<?php echo $result['cantidad']; ?>" id="can" name="TCantidad" class="form form-control" type="text" placeholder="Ingrese la cantidad $" autocomplete="off" required><br>

                    <h5><label for="tipo" class="badge badge-primary">Tipo :</label></h5>
                    <select id="tipo" name="STipo" class="form form-control" required>
                        <option></option>
                        <option>Capital Externo</option>
                        <option>Prestamo</option>
                    </select> <br>

                    <h5><label for="fingreso" class="badge badge-primary">Forma de Ingreso :</label></h5>
                    <select name="SFIngreso" id="fingreso" class="form form-control" required>
                        <option></option>
                        <option>Efectivo</option>
                        <option>Banco</option>
                    </select> <br>
                    <script>
                        document.getElementById('tipo').value = "<?php echo $result['tipo']; ?>";
                        document.getElementById('fingreso').value = "<?php echo $result['forma_ingreso'];  ?>";
                    </script>
                    <div>
                        <h5><label for="fecha" class="badge badge-primary">Fecha :</label></h5>
                        <input value="<?php echo $result['fecha']; ?>" class="form-control" id="fecha" type="date" name="DFecha" required>
                    </div><br>
                    <h5><label for="acceso" class="badge badge-primary">Estado:</label></h5>

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
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Editar">

                </form>
            </div>
        </div>
    </div>

    </div>
</body>

</html>
<?php }
?>