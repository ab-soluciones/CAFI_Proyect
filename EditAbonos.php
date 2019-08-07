<?php
require_once "Config/Autoload.php";
session_start();
Config\Autoload::run();
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
    $idusuario = $_SESSION['id'];
    if (isset($_POST['DlEstado'])) {
        $adeudo = new Models\Adeudo();
        if ($estado == "R" && $_POST['DlEstado'] == "C") {
            $adeudo->editarTotalEstadoC($id, $idusuario);
        } else if ($estado == "C" && $_POST['DlEstado'] == "R") {
            $adeudo->editarTotalEstadoR($id, $idusuario);
        }

        header('location: VAbonos.php');
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