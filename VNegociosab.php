<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    || $_SESSION['acceso'] == "CEO"
) {
    header('location: OPCAFI.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Negocios</title>
</head>

<body onload="inicio();">
    <?php
    $sel = "negocios";
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
                    <form class="form-group" id="formunegocio">
                        <div class="row">
                            <div class="col-lg-4">
                                <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5><label for="dom" class="badge badge-primary">Domicilio:</label></h5>
                                <input id="dom" class="form form-control" type="text" name="TDomicilio" placeholder="Domicilio" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5><label for="cd" class="badge badge-primary">Ciudad:</label></h5>
                                <input id="cd" class="form form-control" type="text" name="TCiudad" placeholder="Ciudad" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h5><label for="tel" class="badge badge-primary">Teléfono:</label></h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Teléfono" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5><label for="impresora" class="badge badge-primary">Impresora</label></h5>
                                <select class="form form-control" id="impresora">
                                    <option value="A">A</option>
                                    <option value="I">I</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <h5><label class="badge badge-primary">Cliente:</label></h5>
                                <div>
                                    <input id="incliente" class="form form-control" list="clientes" name="DlCliente" required autocomplete="off">
                                    <datalist id="clientes">
                                        <?php
                                        $datos = false;
                                        $con = new Models\Conexion();
                                        $query = "SELECT nombre, apaterno, amaterno FROM clientesab WHERE estado = 'A' ORDER BY apaterno ASC";
                                        $row = $con->consultaListar($query);
                                        $con->cerrarConexion();

                                        while ($result = mysqli_fetch_array($row)) {
                                            ?>

                                            <?php $datos = true;
                                                echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                                        <?php
                                        }
                                        if ($datos == false) {
                                            echo "<script>document.getElementById('incliente').disabled = true;</script>";
                                        } ?>
                                    </datalist>
                                </div>
                            </div>
                        </div>

                        <input id="bclose" type="submit" class="mt-3 btn btn-secondary btn-lg btn-block btn-dark" value="Guardar">
                    </form>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>
                    <div class="contenedorTabla">
                        <table class="table width=" 100%" display:block; table-bordered table-hover fixed_headers table-responsive">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th onclick="sortTable(0)">Id negocio</th>
                                    <th onclick="sortTable(1)">Nombre</th>
                                    <th onclick="sortTable(2)">Domicilio</th>
                                    <th onclick="sortTable(3)">Ciudad</th>
                                    <th onclick="sortTable(4)">Telefono</th>
                                    <th onclick="sortTable(5)">Impresora</th>
                                    <th onclick="sortTable(6)">Cliente</th>
                                    <th onclick="sortTable(7)">Registró</th>
                                    <th onclick="sortTable(8)">Tarea</th>
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
    <script src="js/vnegocios.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
