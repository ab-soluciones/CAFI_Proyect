<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager") {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB") {
    if (isset($_GET['id'])) {
        ?>
<?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT fecha_activacion,fecha_vencimiento,suscripcion.estado,
        monto,nombre_negocio FROM suscripcion
        INNER JOIN negocios ON suscripcion.negocio_id = negocios.idnegocios          
        WHERE suscripcion.idsuscripcion = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        $con->cerrarConexion();
        if (isset($result)) {
            ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> Edicion Suscripcion</title>
    <script>
        function alertaA() {
            alert('ALERTA ! ESTÁ SEGURO DE CAMBIAR EL ESTADO A ACTIVO ? ! RECUERDE QUE TAMBIEN ACTIVARÁ A TODOS LOS USUARIOS DEL SISTEMA PERTENECIENTES AL NEGOCIO DE ESTA SUSCRIPCION !');
        }

        function alertaI() {
            alert('ALERTA ! ESTÁ SEGURO DE CAMBIAR EL ESTADO A INACTIVO ? ! RECUERDE QUE TAMBIEN INACTIVARÁ A TODOS LOS USUARIOS DEL SISTEMA PERTENECIENTES AL NEGOCIO DE ESTA SUSCRIPCION !');
        }
    </script>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion de Suscripción</a>
            <h5></h5>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-3" style="  margin: 0 auto; margin-top:5px;">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <div>
                        <h5><label for="fecha1" class="badge badge-primary">Fecha Activacion:</label></h5>
                        <input value="<?php echo $result['fecha_activacion'] ?>" class="form-control" id="fecha1" type="date" name="DFecha" required>
                    </div><br>

                    <div>
                        <h5><label for="fecha2" class="badge badge-primary">Fecha Vencimiento:</label></h5>
                        <input value="<?php echo $result['fecha_vencimiento'] ?>" class="form-control" id="fecha2" type="date" name="DFecha2" required>
                    </div><br>


                    <h5><label for="fecha2" class="badge badge-primary">Estado:</label></h5>


                    <?php if ($result['estado'] == "A") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaA();" class="form-check-input" type="radio" id="estado" name="REstado" value="A" checked>Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaI();" class="form-check-input" type="radio" id="estado" name="REstado" value="I">Inactiva
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaA();" class="form-check-input" type="radio" id="estado" name="REstado" value="A">Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaI();" class="form-check-input" type="radio" id="estado" name="REstado" value="I" checked>Inactiva
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } ?>

                    <h5><label for="monto" class="badge badge-primary">Monto:</label></h5>
                    <input id="monto" type="text" class="form form-control" name="TMonto" value="<?php echo $result['monto']; ?>" required placeholder="Monto $" autocomplete="off"><br>
                    <input style="margin-top:15px;" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Editar">
                </form>
            </div>
</body>

</html>
<?php

        } ?>
<?php

    }
    if (
        isset($_POST['DFecha']) && isset($_POST['DFecha2'])
        && isset($_POST['REstado']) && isset($_POST['TMonto'])
    ) {
        $sus = new Models\Suscripcion();
        $idusuario = $_SESSION['id'];
        $sus->setActivacion($_POST['DFecha']);
        $sus->setVencimiento($_POST['DFecha2']);
        $sus->setEstado($_POST['REstado']);
        $sus->setMonto($_POST['TMonto']);
        $result = $sus->editar($id, $idusuario);
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
}
?>