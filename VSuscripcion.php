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

if (
    isset($_POST['DFecha']) && isset($_POST['DFecha2'])
    && isset($_POST['DlNegocios']) && isset($_POST['TMonto'])
) {
    $sus = new Models\Suscripcion();
    $con = new Models\Conexion();
    $sus->setActivacion($_POST['DFecha']);
    $sus->setVencimiento($_POST['DFecha2']);
    $sus->setEstado("A");
    $sus->setMonto($_POST['TMonto']);
    $negocio = $_POST['DlNegocios'];
    $query = "SELECT idnegocios FROM negocios WHERE (SELECT CONCAT(nombre_negocio,' ',domicilio,' ' ,ciudad))='$negocio'";
    $id = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $id = (int) $id['idnegocios'];
    $sus->setIdNegocio($id);
    $result = $sus->guardar($_SESSION['id']);
    if ($result === 1) {
        ?>
<script>
    alert('Producto Registrado Exitosamente');
</script>

<?php } else {
        ?>
<script>
    alert('Producto no registrado compruebe los campos unicos');
</script>
<?php }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>CRUD Suscripciones</title>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Administración de Suscripciones</a>
        </div>
    </nav>
    <div class="row" style="margin-left: -6px; margin-top: 5px;">
        <div class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <div>
                        <h5><label for="fecha1" class="badge badge-primary">Fecha Activacion:</label></h5>
                        <input class="form-control" id="fecha1" type="date" name="DFecha" required>
                    </div><br>

                    <div>
                        <h5><label for="fecha2" class="badge badge-primary">Fecha Vencimiento:</label></h5>
                        <input class="form-control" id="fecha2" type="date" name="DFecha2" required><br>
                    </div>
                    <h5><label for="monto" class="badge badge-primary">Monto:</label></h5>
                    <input id="monto" type="text" class="form form-control" name="TMonto" required placeholder="Monto $"><br>
                    <h5><label for="innegocio" class="badge badge-primary">Negocio:</label></h5>
                    <div>
                        <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
                        <datalist id="negocios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio,ciudad,domicilio FROM negocios ORDER BY nombre_negocio ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre_negocio'] . " " . $result['domicilio'] . " " . $result['ciudad'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                            } ?>

                        </datalist>
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Guardar">
                </form>

            </div>

        </div>
        <div class="col-md-8">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasSuscripcion.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Activacion</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th>Negocio</th>
                        <th>Monto</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM suscripcion ORDER BY idsuscripcion DESC";
                    $row = $con->consultaListar($query);

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                        <tr>
                            <td><?php echo $renglon['idsuscripcion']; ?></td>
                            <td><?php echo $renglon['fecha_activacion']; ?></td>
                            <td><?php echo $renglon['fecha_vencimiento']; ?></td>
                            <td><?php echo $renglon['estado']; ?></td>
                            <td><a href="VConsultasN.php?id=<?php echo $renglon['negocio_id']; ?>"># <?php echo $renglon['negocio_id']; ?></a></td>
                            <td>$ <?php echo $renglon['monto']; ?></td>
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
        </div>

    </div>
</body>

</html>