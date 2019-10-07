<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

$_SESSION['clienteid'] = null;
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <link rel="icon" href="img/logo/nav1.png">
    <title>Ventas</title>
</head>

<body>
    <?php
    $sel = "venta";
    include("Navbar.php");
    ?>
    <div class="contenedor container-fluid">
        <div class="row">
            <div class="col-12 col-lg-5 p-3 order-2 order-lg-1">
                <h3 style="background-color: #262626; border-radius: 7px;" class="text-center text-white mb-3">Venta</h3>
                <div class="table-wrapper">
                    <div class="rounded table-responsive">
                        <table class="scroll table table-hover table-striped table-light">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center d-none">Código</th>
                                    <th class="text-nowrap text-center">Producto</th>
                                    <th class="text-nowrap text-center">Costo</th>
                                    <th class="text-nowrap text-center">Cant</th>
                                    <th class="text-nowrap text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="renglones">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="divtotal" style="background:  #262626; border-radius: 7px;" class="text-white text-right font-weight-bold p-1 col-12">
                </div>
                <div class="d-block d-lg-flex mt-4 justify-content-center">
                    <button value="Efectivo" class="col-12 col-lg-4 m-1 bpago1 btn btn-primary text-white" type="button">Pago en efectivo</button>
                    <button value="Crédito" class="col-12 col-lg-4 m-1 bpago2 btn btn-primary text-white" type="button">Pago a crédito</button>
                    <button value="Tarjeta" class="col-12 col-lg-4 m-1 bpago3 btn btn-primary text-white" type="button">Pago con tarjeta</button>
                </div>
            </div>
            <div class="col-12 col-lg-7 p-3 order-1 order-lg-2">
                <h3 style="background-color: #262626; border-radius: 7px;" class="text-center text-white mb-3">Búsqueda de Producto</h3>
                <div class="input-group mb-2">
                    <!-- <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button> -->
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input autofocus onkeypress="return check(event)" class="form-control col-12 col-lg-4" type="search" id="busquedap" autocomplete="off" placeholder="Buscar Producto...">
                </div>
                <div style="border-radius: 10px;" class="contenedorTabla table-responsive table-wrapper-productos">
                    <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center"></th>
                                <th class="text-nowrap text-center">Imagen</th>
                                <th class="text-nowrap text-center">Producto</th>
                                <th style="text: orangered;" class="text-nowrap text-center bg-dark">Código</th>
                                <th class="text-nowrap text-center">Existencia</th>
                                <th style="text: orangered;" class="text-nowrap text-center bg-dark">Precio</th>
                                <th class="text-nowrap text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Contenedor -->
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
                    <div>
                        <td class="text-nowrap text-center" colspan="8">
                            <h3 style="text-align: right;" class="hmtotal p-2 font-weight-bold"></h3>
                        </td>
                    </div>
                    <div class="divpagotarjeta text-center my-5">
                        <h5>Ingrese la tarjeta en la terminal y cobre el total</h5>
                    </div>
                    <button class="bdescuento btn btn-block btn-large btn-dark text-primary" type="button">Aplicar descuento</button><br>
                    <div id="divdescuento">
                        <h6>Descuento:</h6>
                        <input class="indescuento form form-control" onkeypress="return check(event)" type="text" placeholder="Ingrese el descuento" autocomplete="off"><br>
                        <button type="button" class="bporcentaje btn btn-dark btn-lg">%</button>
                        <button type="button" class="bpesos btn btn-dark btn-lg">$</button>
                    </div>

                    <div id="tablacliente" class="mt-4">
                        <div class="input-group mb-2">
                            <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i></div>
                            </div>
                            <input autocomplete="off" class="form-control col-12 col-lg-4" type="search" id="busquedac" placeholder="Buscar Cliente...">
                        </div>

                        <table class="scroll table table-hover table-striped table-light">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center d-none">idcliente</th>
                                    <th class="text-nowrap text-center">Cliente</th>
                                    <th class="text-nowrap text-center">Teléfono</th>
                                    <th class="text-nowrap text-center">Estado</th>
                                    <th class="text-nowrap text-center">Adeudos</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpotcliente">

                            </tbody>
                        </table>

                    </div>

                    <div id="divanticipo">
                        <h6>Anticipo:</h6>
                        <input class="tanticipo form form-control" type="text" onkeypress="return check(event)" placeholder="" autocomplete="off"><br>
                    </div>
                    <div id="divpago" class="mt-4">
                        <h6>Cantidad Recibida/Pago:</h6>
                        <input class="tpago form form-control" type="text" onkeypress="return check(event)" placeholder="" autocomplete="off"><br>
                    </div>
                    <button style="color: orangered;" type="button" class="bvender btn btn-block bg-dark font-weight-bold p-3">
                        <h5>Vender</h5>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script src="js/vventas.js"></script>
    <script src="js/user_jquery.js"></script>
    <script src="js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>