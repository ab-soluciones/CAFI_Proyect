<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
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
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Ingresos</title>
</head>

<body>
    <?php
    $sel = "ingresos";
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
                    <form class="form-group" id="formotrosingresos">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="importante">Cantidad $ :</h5>
                                <input id="can" name="TCantidad" class="form form-control" type="text" placeholder="Ingrese la cantidad $" autocomplete="off" required>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="general">Tipo :</h5>
                                <select id="tipo" name="STipo" id="concepto" class="form form-control" required>
                                    <option></option>
                                    <option>Dinero a caja</option>
                                    <option>Capital Externo</option>
                                    <option>Prestamo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="general">Forma de Ingreso :</h5>
                                <select name="SFIngreso" id="fingreso" class="form form-control" required>
                                    <option></option>
                                    <option>Efectivo</option>
                                    <option>Banco</option>
                                </select> <br>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="general">Fecha :</h5>
                                <input class="form-control" id="fecha" type="date" name="DFecha" required>
                            </div>
                            
                            <div class="d-block col-lg-6">
                                    <h5 class="general">Estatus:</h5>
                                        <select class="form form-control" id="voestado">
                                            <option value="A">Activo</option>
                                            <option value="I">Inactivo</option>
                                        </select>  
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
                    <button class="d-lg-none btn btn-success col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button class="d-none d-lg-flex btn btn-success ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                      <div class="contenedorTabla table-responsive">
                          <table class="table table-hover table-striped table-darkr">
                              <thead class="thead-dark">
                                  <tr class="encabezados">
                                      <th class="text-nowrap text-center" onclick="sortTable(0)">Id</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(1)">Cantidad</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(2)">Tipo</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(3)">Forma de Ingreso</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(4)">Fecha</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(5)">Estado</th>
                                      <th class="text-nowrap text-center" onclick="sortTable(6)"></th>
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
  </div>

    <script src="js/user_jquery.js"></script>
    <script src="js/otrosingresos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
