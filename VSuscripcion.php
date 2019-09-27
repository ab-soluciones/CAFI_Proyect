<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
    || $_SESSION['acceso'] == "CEO"
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
    <link rel="stylesheet" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/index.js"></script>

    <title>Suscripciones</title>
</head>

<body onload="inicio();">
    <?php
    $sel = "suscripciones";
    include("NavbarAB.php")
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
                    <div class="modal-body administrador">
                        <p class="statusMsg"></p>
                        <form class="form-group" id="formulario">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="importante">Fecha Activacion:</h5>
                                    <input class="form-control bg-dark text-white" id="fecha1" type="date" name="DFecha">
                                </div>
                                <div class="col-6">
                                    <h5 class="importante">Fecha Vencimiento:</h5>
                                    <input class="form-control bg-dark text-white" id="fecha2" type="date" name="DFecha2">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="general">Estado:</h5>
                                    <select class="form form-control" id="estado">
                                        <option value="A">A</option>
                                        <option value="I">I</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <h5 class="general">Negocio:</h5>
                                    <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" autocomplete="off">
                                    <datalist id="negocios">
                                        <?php
                                        $datos = false;
                                        $con = new Models\Conexion();
                                        $query = "SELECT nombre_negocio,ciudad,domicilio FROM negocios ORDER BY nombre_negocio ASC";
                                        $row = $con->consultaListar($query);

                                        while ($result = mysqli_fetch_array($row)) {
                                            ?>

                                            <?php $datos = true;
                                                echo "<option value='" . $result['nombre_negocio'] . " " . $result['domicilio'] . " " . $result['ciudad'] . "'> "; ?>
                                        <?php
                                        }
                                        if ($datos == false) {
                                            echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                                        } ?>

                                    </datalist> <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h5 class="general">Monto:</h5>
                                    <input id="monto" type="text" onkeypress="return check(event)" class="form form-control" name="TMonto" placeholder="Monto $" autocomplete="off">
                                </div>
                            </div>

                            <input id="bclose" type="submit" class="btn btn-primary btn-lg btn-block mt-4" name="" value="Guardar">
                        </form>
                        <div id="tableHolder" class="row justify-content-center">

                        <div id="divnegocio">
                            <h5 class="admin">Negocio:</h5>
                            <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" autocomplete="off">
                            <datalist id="negocios">
                                <?php
                                $datos = false;
                                $con = new Models\Conexion();
                                $query = "SELECT nombre_negocio,ciudad,domicilio FROM negocios ORDER BY nombre_negocio ASC";
                                $row = $con->consultaListar($query);

                                while ($result = mysqli_fetch_array($row)) {
                                    ?>

                                    <?php $datos = true;
                                        echo "<option value='" . $result['nombre_negocio'] . " " . $result['domicilio'] . " " . $result['ciudad'] . "'> "; ?>
                                <?php
                                }
                                if ($datos == false) {
                                    echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                                } ?>

                            </datalist> <br>
                        </div>
                        <h5 class="admin">Monto:</h5>
                        <input id="monto" type="text" onkeypress="return check(event)" class="form form-control" name="TMonto" placeholder="Monto $"><br>
                        <input id="bclose" type="submit" class="btn btn-primary btn-lg btn-block" name="" value="Guardar">
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
            <div class="col-md-12">
                <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="bmodal d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="bmodal d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>
                    <div class="contenedorTabla table-responsive">
                        <table class="table table-hover table-striped table-dark">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">ID</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Activacion</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(2)">Vencimiento</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(3)">Estado</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(4)">Negocio</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(5)">Monto</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(6)">Registró</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(7)">Tarea</th>
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
    <script src="js/vsuscripciones.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
