<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEO"
) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "CEO") {
    if (isset($_GET['id'])) {
        ?>
<?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT * FROM trabajador WHERE idtrabajador = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        //se optienen todos los datos del trabajador para colocarse en su elemento correspondiente del formulario
        if (isset($result)) {

            ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title> Edicion de Trabajador</title>
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

<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion de Trabajador</a>
            <h5></h5>
        </div>
    </nav>
    <div class="row" style="">
        <div class="col-md-3" style="margin: 0 auto;" id="formulario">
            <div class="card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input value="<?php echo $result['nombre'] ?>" id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input value="<?php echo $result['apaterno'] ?>" id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input value="<?php echo $result['amaterno'] ?>" id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required><br>
                    <h5><label for="doc" class="badge badge-primary">Documento:</label></h5>

                    <?php if ($result['tipo_documento'] == "INE") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="INE" checked autofocus>INE
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="CURP">CURP
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="Otro">Otro
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else if ($result['tipo_documento'] == "CURP") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="INE">INE
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="CURP" checked autofocus>CURP
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="Otro">Otro
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else if ($result['tipo_documento'] == "Otro") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="INE">INE
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="CURP">CURP
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="doc" name="RDoc" value="Otro" checked autofocus>Otro
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } ?>

                    <h5><label for="numdoc" class="badge badge-primary">#Documento:</label></h5>
                    <input value="<?php echo $result['numero_documento'] ?>" id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required><br>
                    <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                    <input value="<?php echo $result['direccion'] ?>" id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required><br>
                    <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                    <input value="<?php echo $result['telefono'] ?>" id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required><br>
                    <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                    <input value="<?php echo $result['correo'] ?>" id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com"><br>

                    <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>

                    <?php if ($result['acceso'] == "Manager") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="Employes">Employes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="Manager" checked>Manager
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="Manager">Manager
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="Employes" checked>Employes
                            </label>
                        </div>
                    </div> <br>
                    <?php

                                } ?>

                    <h5><label for="login" class="badge badge-primary">Nombre de Usuario:</label></h5>
                    <input value="<?php echo $result['login'] ?>" id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required><br>
                    <h5><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                    <input value="<?php echo $result['password'] ?>" id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña" required><br>
                    <h5><label for="sueldo" class="badge badge-primary">Sueldo:</label></h5>
                    <input value="<?php echo $result['sueldo'] ?>" id="sueldo" class="form form-control" type="text" name="TSueldo" placeholder="$" autocomplete="off"><br>
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
                    <input type="submit" class="btn btn-lg btn-block btn-dark" name="" value="Editar">
                </form>
            </div>
        </div>


</body>

</html>
<?php

        } ?>
<?php

    }
    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
        && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
        && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
        && isset($_POST['RAcceso'])  && isset($_POST['TLogin'])
        && isset($_POST['TPContraseña']) && isset($_POST['TSueldo'])
        && isset($_POST['REstado'])
    ) {
        $trabajador = new Models\Trabajador();
        $trabajador->setNombre($_POST['TNombre']);
        $trabajador->setApaterno($_POST['TApellidoP']);
        $trabajador->setAmaterno($_POST['TApellidoM']);
        $trabajador->setDocumento($_POST['RDoc']);
        $trabajador->setNumDoc($_POST['TNumDoc']);
        $trabajador->setDireccion($_POST['TDireccion']);
        $trabajador->setTelefono($_POST['TTelefono']);
        $trabajador->setCorreo($_POST['TCorreo']);
        $trabajador->setAcceso($_POST['RAcceso']);
        $trabajador->setLogin($_POST['TLogin']);
        $trabajador->setPassword($_POST['TPContraseña']);
        $sueldo = $_POST['TSueldo'];
        $sueldo = floatval($sueldo);
        $trabajador->setSueldo($sueldo);
        $trabajador->setEstado($_POST['REstado']);
        $result = $trabajador->editar($_POST['agregarloa']);
        if ($result === 1) {
            ?>
<script>
    swal({title:'Exito',text:'Editado exitosamente!',type:'success'});
</script>
<?php } else if ($result === 0) {
            ?>
<script>
    swal({title:'Error',text:'No se ha realizado ningun cambio!',type:'error'});
</script>
<?php } else if ($result === -1) {
            ?>
<script>
    swal({title:'Error',text:'No editado compruebe los campos unicos',type:'error'});
</script>
<?php }

        //se edita la informacion del trabajador
    }
}
?>
