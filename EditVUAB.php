<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['acceso'] != "CEOAB") {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "CEOAB") {

    if (isset($_GET['id'])) {
        ?>
<?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT * FROM usuariosab where idusuariosab = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        if (isset($result)) {
            ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> Edicion Usuario AB</title>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Edicion de Usuario</a>
            <h5></h5>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-3" style="  margin: 0 auto; margin-top:5px;">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input value="<?php echo $result['nombre'] ?>" id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="on" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input value="<?php echo $result['apaterno'] ?>" id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="on" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input value="<?php echo $result['amaterno'] ?>" id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="on" required><br>

                    <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>


                    <?php if ($result['acceso'] == "CEOAB") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="CEOAB" checked>CEOAB
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="ManagerAB">Manager
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="CEOAB">CEOAB
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="ManagerAB" checked>Manager
                            </label>
                        </div>
                    </div> <br>
                    <?php

                                } ?>


                    <h5><label for="login" class="badge badge-primary">Nombre de usuario:</label></h5>
                    <input value="<?php echo $result['login'] ?>" id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="on" required><br>
                    <h5><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                    <input value="<?php echo $result['password'] ?>" id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña" autocomplete="on" required><br>
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
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RAcceso']) &&
        isset($_POST['TLogin']) && isset($_POST['TPContraseña']) && isset($_POST['REstado'])
    ) {
        $usab = new Models\Usuarioab();
        $usab->setNombre($_POST['TNombre']);
        $usab->setApaterno($_POST['TApellidoP']);
        $usab->setAmaterno($_POST['TApellidoM']);
        $usab->setAcceso($_POST['RAcceso']);
        $usab->setLogin($_POST['TLogin']);
        $usab->setPassword($_POST['TPContraseña']);
        $usab->setEstado($_POST['REstado']);
        $result = $usab->editar($id);
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