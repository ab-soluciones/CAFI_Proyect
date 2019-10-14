<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] != "CEOAB") {
    header('location: index.php');
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo/nav1.png">
    
    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/index.js"></script>

    <title>Usuarios</title>
    <script>
        function cerrar() {
            window.close();
        }
    </script>
</head>

<body onload="inicio();">
    <?php
    $sel = "usuarios";
    include("NavbarAB.php");
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header administrador">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <form class="form-group" id="formuusers">
                        <div class="d-block d-lg-flex row">
                            <div class="col-lg-4">
                                <h5 class="general">Nombre:</h5>
                                <input id="nombre" class="form form-control"  onkeypress="return check(event)" type="text" name="TNombre" placeholder="Nombre" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <h5 class="general">Apellido P:</h5>
                                <input id="apt" class="form form-control"  onkeypress="return check(event)" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <h5 class="general">Apellido M:</h5>
                                <input id="apm" class="form form-control"  onkeypress="return check(event)" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off">
                            </div>
                        </div>
                        <div class="d-block d-lg-flex row">
                            <div class="col-lg-4">
                                <h5 class="general">Usuario:</h5>
                                <input id="login" class="form form-control" type="text"  onkeypress="return check(event)" name="TLogin" placeholder="Nombre de usuario" autocomplete="off"><br>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="general">Contrase&ntilde;a:</h5>
                                <input id="pass" class="form form-control" type="password" onkeypress="return check(event)" name="TPContraseña" placeholder="Contrase&ntilde;a"><br>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="general">Acceso:</h5>

                                <select class="form form-control" id="acceso">
                                    <option value="CEOAB">CEOAB</option>
                                    <option value="ManagerAB">Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div id="status" class="col-12">

                            </div>
                        </div>
                        <div class="d-block d-lg-flex row">
                            <div class="col-lg-12">
                                <h5 class="general">Estado:</h5>
                                <select class="form form-control" id="estadousers">
                                    <option value="A">A</option>
                                    <option value="I">I</option>
                                </select>
                            </div>
                        </div>

                        <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
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
            <div class="col-lg-12">
                <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda"  onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                        <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">ID Usuarios AB</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(2)">Apellido Paterno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(3)">Apellido Materno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(4)">Acceso</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(5)">Usuario</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(6)">Contraseña</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(7)">Estado</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(8)">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/user_jquery.js"></script>
    <script src="js/vusuariosab.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>