<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Gastos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <?php
    $sel = "gastos";
    include("Navbar.php")
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
                    <form class="form-group" id="formgastos">
                        <div class="container">
                            <div class="row">
                                <div class="d-block col-lg-6">
                                    <h5 class="importante">Concepto:</h5>
                                    <select name="SConcepto" id="concepto" class="form form-control" required>
                                        <option></option>
                                        <option>Renta</option>
                                        <option>Luz</option>
                                        <option>Agua</option>
                                        <option>Teléfono</option>
                                        <option>Internet</option>
                                        <option>Transporte</option>
                                        <option>Sueldo</option>
                                        <option>Articulos de Venta</option>
                                        <option>Pago de Prestamo</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                                <div class="d-block col-lg-6">
                                    <h5 class="general">Forma de pago:</h5>
                                    <select name="SPago" id="pago" class="form form-control" required>
                                        <option></option>
                                        <option>Efectivo</option>
                                        <option>Transferencia</option>
                                        <option>Tarjeta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="d-block col-lg-12">
                                    <h5 class="general">Descripcion:</h5>
                                    <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion" maxlength="50"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-block col-lg-6">
                                    <h5 class="general">Monto $:</h5>
                                    <input id="monto" class="form form-control" type="text" name="TMonto" placeholder="$" autocomplete="off" required>

                                <div class="d-block col-lg-12">
                                    <h5><label class="general">Estatus:</label></h5>
                                        <select class="form form-control" id="vgestado">
                                            <option value="A">Activo</option>
                                            <option value="I">Inactivo</option>
                                        </select>
                                </div>
                            </div>
                                <div class="d-block col-lg-6">
                                    <h5 class="general">Fecha:</h5>
                                    <input class="form-control" id="fecha" type="date" name="DFecha" required>
                                </div>
                            </div>
                            <div class="row mt-3 justify-content-around">
                                <button type="submit" id="bclose" class="col-4 col-lg-4 btn btn-lg btn-primary" name="">Guardar</button>
                            </div>
                        </div>
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
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button id="bclose" class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div class="contenedorTabla table-responsive">
                    <table class="table table-hover table-striped table-dark">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center" onclick="sortTable(0)">Id</th>
                                <th class="text-nowrap text-center" onclick="sortTable(1)">Concepto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(2)">Pago</th>
                                <th class="text-nowrap text-center" onclick="sortTable(3)">Descripcion</th>
                                <th class="text-nowrap text-center" onclick="sortTable(4)">Monto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(5)">Estado</th>
                                <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha</th>
                                <th class="text-nowrap text-center" onclick="sortTable(7)">Registró</th>
                                <th class="text-nowrap text-center" onclick="sortTable(8)"></th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div><!--Tabla contenedor-->
            </div><!--col-7-->
        </div><!--row-->
    </div><!--container-->
    <script src="js/user_jquery.js"></script>
    <script src="js/vgastos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>