<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <link rel="icon" href="img/logo/nav1.png">

    <title>Clientes</title>
</head>


<body>
    <?php
    $sel = "clientes";
    include("Navbar.php")
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content administrador">
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
                    <form class="form-group" id="formclientes">
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="general">Nombre:</p>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" >
                            </div>
                            <div class="col-lg-4">
                                <p class="general">Apellido Paterno:</p>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" >
                            </div>
                            <div class="col-lg-4">
                                <p class="general">Apellido Materno:</p>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="general">Documento:</p>

                                <div class="row" style="margin: 0 auto;">
                                    <select class="form form-control" id="documento">
                                        <option value="INE">INE</option>
                                        <option value="CURP">CURP</option>
                                        <option value="Otros">Otros</option>
                                    </select>  
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <p class="general">#Documento:</p>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" >
                            </div>
                            <div class="col-lg-4">
                                <p class="general">Direccion:</p>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" autocomplete="off"  >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="general">Telefono:</p>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" >
                            </div>
                            <div class="col-lg-4">
                                <p class="general">E-mail:</p>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com" autocomplete="off" >
                            </div>
                            <div class="col-lg-4">
                            <div class="d-block col-lg-12">
                                    <p class="general">Estatus:</p>
                                        <select class="form form-control" id="vcestado">
                                            <option value="A">Activo</option>
                                            <option value="I">Inactivo</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <input id="bclose" type="submit" class="mt-3 btn btn-lg btn-block btn-primary" name="" value="Guardar">
                    </form>
                    <div id="tableHolder">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div class="col-md-12">
              <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>

                    <div class="contenedorTabla table-responsive">
                        <table class="table table-hover table-striped table-dark">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center bg-primary" onclick="sortTable(0)">Id</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(2)">Apellido Paterno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(3)">Apellido Materno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(4)">Tipo de Documento</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(5)">Numero Documento</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(6)">Direccion</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(7)">Telefono</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(8)">Correo</th>
                                    <th style="background-color: orangered;" class="text-nowrap text-center bg-importante" onclick="sortTable(9)">Estado</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(10)"></tr>
                            </thead>

                    <tbody  id="cuerpo">
                    </tbody>
                </table>
            </div>
        </div>
      </div>
          </div>
</div>
    <script src="js/user_jquery.js"></script>
    <script src="js/clientes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>