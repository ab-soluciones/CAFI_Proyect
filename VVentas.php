<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
session_start();
$_SESSION['clienteid'] = null;
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: OPCAFI.php');
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

    <title>Ventas</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php
    $sel = "venta";
    include("Navbar.php")
    ?>
    <div class="contenedor container-fluid border">
        <div class="row">
            <div class="col-5 p-3">
                <h3 class="text-center bg-dark text-white mb-3">Venta</h3>
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="scroll table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center d-none">Codigo</th>
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
                <div id="divtotal" style="background:  #3366ff;">
                </div>
                <h5 class="text-center bg-danger text-white">Realizar Venta :</h5>
                <button value="Efectivo" class="bpago1 btn btn-primary" type="button">Pago en efectivo</button>
                <button value="Crédito" class="bpago2 btn btn-warning" type="button">Pago a crédito</button>
                <button value="Tarjeta" class="bpago3 btn btn-success" type="button">Pago con tarjeta</button>
            </div>
            <div class="col-7 p-3">
                <h3 class="text-center bg-dark text-white mb-3">Busqueda de Producto</h3>
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="search" id="busquedap" placeholder="Buscar Producto...">
                </div>
                <div class="contenedorTabla table-responsive" style="display: table; height: 200px;">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center">Codigo</th>
                                <th class="text-nowrap text-center">Imagen</th>
                                <th class="text-nowrap text-center">Producto</th>
                                <th class="text-nowrap text-center">Existencia</th>
                                <th class="text-nowrap text-center">Precio</th>
                                <th class="text-nowrap text-center">Cantidad</th>
                                <th class="text-nowrap text-center"></th>
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
                <div class="modal-body administrador">
                    <p class="statusMsg"></p>
                    <div>
                        <td class="text-nowrap text-center" colspan="8">
                            <h3 style="color: white; text-align: right;" class="hmtotal p-2 font-weight-bold"></h3>
                        </td>
                    </div>
                    <div id="divpagotarjeta" style="color:white;">
                        <h3>Ingrese la tarjeta en la terminal y cobre el total</h3>
                    </div>
                    <button class="bdescuento btn btn-block btn-large btn-primary" type="button">Aplicar descuento</button><br>
                    <div id="divdescuento">
                        <h6 style="color: white;">Descuento :</h6>
                        <input class="indescuento form form-control" type="text" placeholder="Ingrese el descuento" autocomplete="off"><br>
                        <button type="button" class="bporcentaje btn btn-success btn-lg">%</button>
                        <button type="button" class="bpesos btn btn-success btn-lg">$</button>
                    </div>

                    <div id="tablacliente">
                        <input class="form-control col-12 col-lg-4" type="search" id="busquedac" placeholder="Buscar Cliente...">

                        <table class="scroll table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center d-none">idcliente</th>
                                    <th class="text-nowrap text-center">Cliente</th>
                                    <th class="text-nowrap text-center">Dirección</th>
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
                        <h6 style="color: white;">Anticipo $ :</h6>
                        <input class="tanticipo form form-control" type="text" placeholder="$" autocomplete="off"><br>
                    </div>
                    <div id="divpago">
                        <h6 style="color: white;">$ Cantidad Recibida / $ Pago :</h6>
                        <input class="tpago form form-control" type="text" placeholder="$" autocomplete="off"><br>
                    </div>
                    <button type="button" class="bvender btn btn-danger btn-large btn-block">Vender</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script src="js/vventas.js"></script>
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>