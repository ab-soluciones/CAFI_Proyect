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
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];
    $negocio = $_SESSION['idnegocio'];
    if (isset($_POST['DlEstado'])) {
        $trabajador = $_SESSION['id'];
        $v = new Models\Venta();
        $inventario = new Models\Inventario();
        $v->setEstado($_POST['DlEstado']);
        if ($estado == "R" && $_POST['DlEstado'] == "C") {
            $inventario->actualizarStock2($id,$negocio);
            $v->setTrabajador($trabajador);
            $adeudo = "L";
            $v->editarEstadoV($id, $adeudo);
        } else if ($estado == "C" && $_POST['DlEstado'] == "R") {
            $inventario->actualizarStock($id,$negocio);
            $v->setTrabajador($trabajador);
            $adeudo = "A";
            $v->editarEstadoV($id, $adeudo);
        }
        header('location: VConsultasVentas.php');
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