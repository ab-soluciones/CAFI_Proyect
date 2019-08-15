<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] != "CEOAB") {
    header('location: VABOptions.php');
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
    $result = $usab->guardar();
    if ($result === 1) {
        ?>
<script>
  swal({title:'Exito',text:'Se han registrado los datos exitosamente!',type:'success'});
</script>

<?php } else {
        ?>
<script>
    swal({title:'Error',text:'No se han realizado los cambios compruebe los campos unicos',type:'error'});
</script>
<?php }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Administraci&oacute;n Usuarios AB</title>
    <script>
        function cerrar() {
            window.close();
        }
    </script>
</head>

<body style="background: #f2f2f2;">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="row">
                <button onclick="cerrar();" style="width: 100px;" class="btn btn-danger"><img src="img/salir2.png"></button>
            </div>

            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Administraci&oacute;n de Usuarios</a>

        </div>

    </nav>
    <div class="row" style="margin-left: -6px; margin-top: 5px;">
        <div class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="on" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="on" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="on" required><br>
                    <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>

                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="CEOAB">CEOAB
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="ManagerAB" checked autofocus>Manager
                            </label>
                        </div>
                    </div><br>


                    <h5><label for="login" class="badge badge-primary">Usuario:</label></h5>
                    <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="on" required><br>
                    <h5><label for="pass" class="badge badge-primary">Contrase&ntilde;a:</label></h5>
                    <input id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contrase&ntilde;a" required><br>
                    <h5><label for="acceso" class="badge badge-primary">Estado:</label></h5>

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

                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Guardar">
                </form>

            </div>

        </div>

        <div class="col-md-8">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasU.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered table-responsive-md">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido-P</th>
                        <th>Apellido-M</th>
                        <th>Acceso</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM usuariosab ORDER BY idusuariosab DESC";
                    $row = $con->consultaListar($query);

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                        <tr>
                            <td><?php echo $renglon['idusuariosab']; ?></td>
                            <td><?php echo $renglon['nombre']; ?></td>
                            <td><?php echo $renglon['apaterno']; ?></td>
                            <td><?php echo $renglon['amaterno']; ?></td>
                            <td><?php echo $renglon['acceso']; ?></td>
                            <td><?php echo $renglon['login']; ?></td>
                            <td><?php echo $renglon['password']; ?></td>
                            <td><?php echo $renglon['estado']; ?></td>
                            <td style="width:100px;">
                                <div class="row">
                                    <a onclick="if(confirm('SE ELIMINARÁ EL REGISTRO #<?php echo $renglon['idusuariosab']; ?>!'))
                                                                                                                                                                                                                                                                                                                                                                {href= 'deleteVUAB.php?id=<?php echo $renglon['idusuariosab']; ?>'} " class="btn btn-warning"><img src="img/eliminarf.png">
                                    </a>
                                    <a style="margin-left:2px;" class="btn btn-secondary" href="EditVUAB.php?id=<?php echo $renglon['idusuariosab'] ?>">
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
