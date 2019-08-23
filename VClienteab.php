<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    ||  $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <title>Administracion Clientes AB</title>

</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Clientes</a>
        </div>
    </nav>
    </div>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">
                <form class="form-group" action="#" method="post">
                    <h5 class="etiquetas"><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5 class="etiquetas"><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required><br>
                    <h5 class="etiquetas"><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required><br>
                    <h5 class="etiquetas"><label for="doc" class="badge badge-primary">Documento:</label></h5>

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

                    <h5 class="etiquetas"><label for="numdoc" class="badge badge-primary">#Documento:</label></h5>
                    <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required><br>
                    <h5 class="etiquetas"><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                    <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required><br>
                    <h5 class="etiquetas"><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                    <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required><br>
                    <h5 class="etiquetas"><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                    <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com"><br>
                    <h5 class="etiquetas"><label for="login" class="badge badge-primary">Usuario:</label></h5>
                    <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required><br>
                    <h5 class="etiquetas"><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                    <input id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña" required><br>
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                </form>

            </div>
            <div id="tableContainer" class="d-block col-lg-8">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                <table class="table table-bordered table-hover fixed_headers table-responsive">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th onclick="sortTable(0)">Nombre</th>
                            <th onclick="sortTable(1)">Ap-P</th>
                            <th onclick="sortTable(2)">Ap-M</th>
                            <th onclick="sortTable(3)">Doc</th>
                            <th onclick="sortTable(4)">#Doc</th>
                            <th onclick="sortTable(5)">Direcci&oacute;n</th>
                            <th onclick="sortTable(6)">Tel&eacute;fono</th>
                            <th onclick="sortTable(7)">Email</th>
                            <th onclick="sortTable(8)">Usuario</th>
                            <th onclick="sortTable(9)">Contraseña</th>
                            <th onclick="sortTable(10)">Estado</th>
                            <th onclick="sortTable(11)">Tarea</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = new Models\Conexion();
                        $query = "SELECT * FROM clientesab ORDER BY id_clienteab DESC";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td><?php echo $renglon['nombre']; ?></td>
                            <td><?php echo $renglon['apaterno']; ?></td>
                            <td><?php echo $renglon['amaterno']; ?></td>
                            <td><?php echo $renglon['tipo_documento']; ?></td>
                            <td><?php echo $renglon['numero_documento']; ?></td>
                            <td><?php echo $renglon['direccion']; ?></td>
                            <td><?php echo $renglon['telefono']; ?></td>
                            <td><?php echo $renglon['correo']; ?></td>
                            <td><?php echo $renglon['login']; ?></td>
                            <td><?php echo $renglon['password']; ?></td>
                            <td><?php echo $renglon['estado']; ?></td>
                            <td style="width:100px;">
                                <div class="row">
                                    <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVClienteAB.php?id=<?php echo $renglon['id_clienteab'] ?>">
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
    <?php
    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
        && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
        && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
        && isset($_POST['TLogin']) && isset($_POST['TPContraseña'])
    ) {
        $cliente = new Models\Clienteab();
        $cliente->setNombre($_POST['TNombre']);
        $cliente->setApaterno($_POST['TApellidoP']);
        $cliente->setAmaterno($_POST['TApellidoM']);
        $cliente->setDocumento($_POST['RDoc']);
        $cliente->setNumDoc($_POST['TNumDoc']);
        $cliente->setDireccion($_POST['TDireccion']);
        $cliente->setTelefono($_POST['TTelefono']);
        $cliente->setCorreo($_POST['TCorreo']);
        $cliente->setAcceso("CEO");
        $cliente->setLogin($_POST['TLogin']);
        $cliente->setPassword($_POST['TPContraseña']);
        $cliente->setEstado("A");
        $result = $cliente->guardar($_SESSION['id']);
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
            text: 'No registrado compruebe los campos unicos!',
            type: 'error'
        });
    </script>
    <?php }
    }
    ?>
    <script src="js/user_jquery.js"></script>
</body>
</html>