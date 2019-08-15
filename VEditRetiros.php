<?php
require_once "Config/Autoload.php";
session_start();
Config\Autoload::run();
$con = new Models\Conexion();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];
    if (isset($_POST['DlEstado'])) {
        $trabajador = $_SESSION['id'];
        $retiro = new Models\Retiro();
        $retiro->setEstado($_POST['DlEstado']);
        $retiro->setTrabajador($trabajador);
        $result = $retiro->editar($id);
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
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Edicion del Estado</title>
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

<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #e6e6e6">
    <div class="row">
        <div class="col-xl-3" style="margin: 0 auto;  margin-top:12%;">
            <div class="card card-body">
                <form class="form-group" action="#" method="post">
                    <input onclick="value=''" value="<?php echo $estado ?>" id="inestado" class="form form-control" list="estadov" name="DlEstado" autocomplete="off">
                    <datalist id="estadov">
                        <option value="R">
                        <option value="C">
                    </datalist> <br>
                    <input type="submit" class="btn  btn-block btn-dark" value="Editar">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php
} ?>