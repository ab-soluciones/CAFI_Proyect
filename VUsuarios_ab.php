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

    <div class="container-fluid">
        <div class="row align-items-start">
            <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">
              <div id="tableContainer" class="d-block col-lg-8">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                <div class="row" style="margin-left: -6px; margin-top: 5px;">
                <form class="form-group" action="#" method="post">

                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required><br>
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
                    <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required><br>
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
        </div>

        <div class="col-md-8">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasU.php">BUSCAR--></a>
                </label></h5>

                <div class="contenedorTabla">
              <table class="table table-bordered table-hover fixed_headers table-responsive">
                  <thead class="thead-dark">
                      <tr class="encabezados">
                          <th onclick="sortTable(0)">ID Usuarios AB</th>
                          <th onclick="sortTable(1)">Nombre</th>
                          <th onclick="sortTable(2)">Apellido Paterno</th>
                          <th onclick="sortTable(3)">Apellido Materno</th>
                          <th onclick="sortTable(4)">Acceso</th>
                          <th onclick="sortTable(5)">Usuario</th>
                          <th onclick="sortTable(6)">Contraseña</th>
                          <th onclick="sortTable(7)">Estado</th>
                          <th onclick="sortTable(8)">Acciones</th>
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
    </div>
  </div>
    <?php
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
        swal({
            title: 'Exito',
            text: 'Se han registrado los datos exitosamente!',
            type: 'success'
        });
    </script>

    <?php } else {
            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No se han guardado los datos compruebe los campos unicos',
            type: 'error'
        });
    </script>
    <?php }
    }
    ?>
    <script src="js/user_jquery.js"></script>
</body>

</html>
