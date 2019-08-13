<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    || $_SESSION['acceso'] == "CEO"
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
    <title>Busquedas Usuarios AB</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busquedas Suscripciones</a>
        </div>
    </nav>
    <div class="row" style="margin-left: -6px; margin-top: 5px;">
        <div class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <div>
                        <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
                        <datalist id="negocios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio FROM negocios ORDER BY nombre_negocio ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre_negocio'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                            } ?>

                        </datalist>
                    </div><br>

                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>


            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Activacion</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th>Negocio</th>
                        <th>Monto</th>
                        <th>Registró</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (
                        isset($_POST['DlNegocios'])
                    ) {
                        $con = new Models\Conexion();
                        $negocios = $_POST['DlNegocios'];

                        $query = "SELECT idsuscripcion,fecha_activacion,fecha_vencimiento,suscripcion.estado,
                        monto,negocio_id,nombre,apaterno FROM suscripcion
                        INNER JOIN negocios ON suscripcion.negocio_id = negocios.idnegocios
                        INNER JOIN usuariosab ON suscripcion.usuariosab_idusuariosab = usuariosab.idusuariosab
                        WHERE nombre_negocio = '$negocios'";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                            <tr>
                                <td><?php echo $renglon['idsuscripcion']; ?></td>
                                <td><?php echo $renglon['fecha_activacion']; ?></td>
                                <td><?php echo $renglon['fecha_vencimiento']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td><a href="VConsultasN.php?id=<?php echo $renglon['negocio_id']; ?>"># <?php echo $renglon['negocio_id']; ?></a></td>
                                <td>$ <?php echo $renglon['monto']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                                <td style="width:100px;">
                                    <div class="row">
                                        <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVSuscripcion.php?id=<?php echo $renglon['idsuscripcion'] ?>">
                                            <img src="img/edit.png">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            <?php
            } ?>

        </div>
    </div>
</body>

</html>