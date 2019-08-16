<?php
session_start();

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

require_once "Config/Autoload.php";
Config\Autoload::run();
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
    swal({title:'Exito',text:'Se han registrado los datos exitosamente!',type:'success'});
</script>

<?php } else {
        ?>
<script>
    swal({title:'Error',text:'No registrado compruebe los campos unicos!',type:'error'});
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
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Administracion Clientes AB</title>
    <script>
        function agregar() {
            document.getElementById("formulario").style.display = "block";
            document.getElementById("tabla").style.display = "none";
            document.getElementById("bagregar").style.display = "none";
            document.getElementById("bmostrar").style.display = "block";
        }

        function mostrar() {
            document.getElementById("bagregar").style.display = "block";
            document.getElementById("bmostrar").style.display = "none";
            document.getElementById("formulario").style.display = "none";
            document.getElementById("tabla").style.display = "block";

        }
    </script>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Clientes</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <button id="bagregar" onclick="agregar();" class="btn btn-lg btn-block btn-primary">Agregar</button>
                <button id="bmostrar" onclick="mostrar();" class="btn btn-lg btn-block btn-info">Mostrar</button>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 5px;">
        <div id="formulario" class="col-md-3" style="margin:0 auto; display: none;">
            <div class=" card card-body">
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
                    <input onclick="location.reload()" type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                </form>

            </div>

        </div>
        <div id="tabla" class="col-lg-12" style="margin-left: 10px; margin-top: 10px;">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasC.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ap-P</th>
                        <th>Ap-M</th>
                        <th>Doc</th>
                        <th>#Doc</th>
                        <th>Direcci&oacute;n</th>
                        <th>Tel&eacute;fono</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Estado</th>
                        <th>Tarea</th>
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
</body>

</html>
