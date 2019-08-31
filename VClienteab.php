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
    <title>Clientes AB</title>

</head>

<body onload="inicio();">
<?php
$sel = "clientes"; 
include("NavbarAB.php") 
?>
<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                    <form class="form-group" id="formclienteab">
                        <div class="row">
                            <div class="col-lg-4">
                                <h5 class="etiquetas"><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <h5 class="etiquetas"><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <h5 class="etiquetas"><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                            <h5><label for="documento" class="badge badge-primary">Documento</label></h5>
                                <select class="form form-control" id="documento">
                                    <option value="INE">INE</option>
                                    <option value="I">CURP</option>
                                    <option value="I">Otro</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="etiquetas"><label for="numdoc" class="badge badge-primary">#Documento:</label></h5>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <h5 class="etiquetas"><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="etiquetas"><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono">
                            </div>
                            <div class="col-lg-6">
                                <h5 class="etiquetas"><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="etiquetas"><label for="login" class="badge badge-primary">Usuario:</label></h5>
                                <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off">
                            </div>
                            <div class="col-lg-6">
                                <h5 class="etiquetas"><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                                <input id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                            <h5><label for="estado" class="badge badge-primary">Estado</label></h5>
                                <select class="form form-control" id="estado">
                                    <option value="A">A</option>
                                    <option value="I">I</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit"  id="bclose" type="submit" class="mt-3 btn btn-secondary btn-lg btn-block btn-dark">Guardar</button>
                    </form>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <table class="table width="100%" display:block; table-bordered table-hover fixed_headers table-responsive">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th onclick="sortTable(0)">Id Cliente</th>
                            <th onclick="sortTable(1)">Nombre</th>
                            <th onclick="sortTable(2)">Ap-P</th>
                            <th onclick="sortTable(3)">Ap-M</th>
                            <th onclick="sortTable(4)">Doc</th>
                            <th onclick="sortTable(5)">#Doc</th>
                            <th onclick="sortTable(6)">Direcci&oacute;n</th>
                            <th onclick="sortTable(7)">Tel&eacute;fono</th>
                            <th onclick="sortTable(8)">Email</th>
                            <th onclick="sortTable(9)">Usuario</th>
                            <th onclick="sortTable(10)">Contraseña</th>
                            <th onclick="sortTable(11)">Estado</th>
                            <th onclick="sortTable(12)">Registró</th>
                            <th onclick="sortTable(13)">Tarea</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo">
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
    <script src="js/vclienteab.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
