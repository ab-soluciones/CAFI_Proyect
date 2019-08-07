<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "CEO"
    || $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Manager"
) {
    if (isset($_GET['id'])) {
        ?>
        <?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT * FROM cliente where idcliente = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        if (
            isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
            && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
            && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
            && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
            && isset($_POST['REstado'])
        ) {
            $cliente = new Models\Cliente();
            $trabajador = $_SESSION['id'];
            $cliente->setNombre($_POST['TNombre']);
            $cliente->setApaterno($_POST['TApellidoP']);
            $cliente->setAmaterno($_POST['TApellidoM']);
            $cliente->setDocumento($_POST['RDoc']);
            $cliente->setNumDoc($_POST['TNumDoc']);
            $cliente->setDireccion($_POST['TDireccion']);
            $cliente->setTelefono($_POST['TTelefono']);
            $cliente->setCorreo($_POST['TCorreo']);
            $cliente->setEstado($_POST['REstado']);
            $cliente->editar($id, $trabajador);
            header('location: VClientes.php');
        }
        if (isset($result)) {

            ?>
            <!DOCTYPE html>
            <html lang="en" dir="ltr">

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link rel="stylesheet" href="css/bootstrap.css">
                <title> Edicion Cliente</title>
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
                        <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion de Cliente</a>
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
                                <input value="<?php echo $result['numero_documento'] ?>" id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="on" required><br>
                                <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                                <input value="<?php echo $result['direccion'] ?>" id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required><br>
                                <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                                <input value="<?php echo $result['telefono'] ?>" id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required><br>
                                <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                                <input value="<?php echo $result['correo'] ?>" id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com"><br>


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
            </body>

            </html>
        <?php

        } ?>
    <?php

    }
}
?>