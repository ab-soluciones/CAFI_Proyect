<?php
session_start();

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
) {
    header('location: OPCAFI.php');
}

require_once "Config/Autoload.php";
Config\Autoload::run();

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

    <title>Administracion Clientes</title>
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


<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Clientes</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px; margin-left:5px;">
        <div class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="on" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="on" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="on" required><br>
                    <h5><label for="doc" class="badge badge-primary">Documento:</label></h5>

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

                    <h5><label for="numdoc" class="badge badge-primary">#Documento:</label></h5>
                    <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="on" required><br>
                    <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                    <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required><br>
                    <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                    <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required><br>
                    <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                    <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com"><br>
                    <h5><label for="acceso" class="badge badge-primary">Estado:</label></h5>

                    <div class="row" style="margin-left: 5px;">
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
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                </form>
            </div>

        </div>
        <div class="" style="margin-top: 10px; margin-left: 10px;">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasCli.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ap-P</th>
                        <th>Ap-M</th>
                        <th>Doc</th>
                        <th>#Doc</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Est</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $negocio = $_SESSION['idnegocio'];
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM cliente WHERE negocios_idnegocios ='$negocio' ORDER BY idcliente DESC";
                    $row = $con->consultaListar($query);

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
                        <td><?php echo $renglon['estado']; ?></td>
                        <td style="width:100px;">
                            <div class="row">
                                <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVCliente.php?id=<?php echo $renglon['idcliente'] ?>">
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
    <?php
    if (
    isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
    && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
    && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
    && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
    && isset($_POST['REstado'])
) {
    $cliente = new Models\Cliente();
    $cliente->setNombre($_POST['TNombre']);
    $cliente->setApaterno($_POST['TApellidoP']);
    $cliente->setAmaterno($_POST['TApellidoM']);
    $cliente->setDocumento($_POST['RDoc']);
    $cliente->setNumDoc($_POST['TNumDoc']);
    $cliente->setDireccion($_POST['TDireccion']);
    $cliente->setTelefono($_POST['TTelefono']);
    $cliente->setCorreo($_POST['TCorreo']);
    $cliente->setEstado($_POST['REstado']);
    $result = $cliente->guardar($_SESSION['idnegocio'], $_SESSION['id']);
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
</body>

</html>
