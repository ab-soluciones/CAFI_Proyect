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

date_default_timezone_set("America/Mexico_City");
$año = date("Y");
$mes = date("m");
$dia = date("d");
$fecha = $año . "-" . $mes . "-" . $dia;

if (
    isset($_POST['SConcepto']) && isset($_POST['SPago'])
    && isset($_POST['TADescription'])
    && isset($_POST['TMonto']) && isset($_POST['DFecha'])
) {
    $descripcion = $_POST['TADescription'];
    if (strlen($descripcion) === 0) {
        $descripcion = null;
    }
    $gasto = new Models\Gasto();
    $gasto->setConcepto($_POST['SConcepto']);
    $gasto->setPago($_POST['SPago']);
    $gasto->setDescripcion($descripcion);
    $monto = $_POST['TMonto'];
    $monto = floatval($monto);
    $gasto->setMonto($monto);
    $gasto->setEstado("A");
    $gasto->setFecha($_POST['DFecha']);
    $gasto->guardar($_SESSION['idnegocio'], $_SESSION['id']);
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

    <title>Administracion Gastos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
    <nav class="container-fluid navbar navbar-dark bg-dark">
        <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Gastos</a>
    </nav>

    <div class="container-fluid">
        <div class="row align-items-start">
            <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">
                <form class="form-group" action="#" method="post">
                    <div class="container">
                        <div class="row">
                            <div class="d-block col-lg-6">
                                <h5><label for="desc" class="badge badge-primary">Concepto:</label></h5>
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
                                <h5><label for="pago" class="badge badge-primary">Forma de pago:</label></h5>
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
                                <h5><label for="desc" class="badge badge-primary">Descripcion:</label></h5>
                                <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion" maxlength="50"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-block col-lg-6">
                                <h5><label for="monto" class="badge badge-primary">Monto $:</label></h5>
                                <input id="monto" class="form form-control" type="text" name="TMonto" placeholder="$" autocomplete="off" required>
                            </div>
                            <div class="d-block col-lg-6">
                                <h5><label for="fecha" class="badge badge-primary">Fecha:</label></h5>
                                <input class="form-control" id="fecha" type="date" name="DFecha" required>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-around">
                            <input id="formButton_guardar" type="submit" class="col-4 col-lg-4 btn btn-lg btn-primary" name="" value="Guardar">
                            <button id="formButton_cancelar" class="col-4 d-lg-none btn btn-lg btn-danger" name="">Cancelar</button>     
                        </div>
                    </div>
                </form>
            </div><!--col-5-->
            <button id="formButton_nuevo" class="d-lg-none col-12 btn btn-lg btn-primary" name="">Nuevo Gasto</button>
            <div id="tableContainer" class="d-block col-lg-8">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                <div class="contenedorTabla">
                    <table id="tabla" class="table table-bordered table-hover fixed_headers table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">Concepto</th>
                                <th onclick="sortTable(1)">Pago</th>
                                <th onclick="sortTable(2)">Descripcion</th>
                                <th onclick="sortTable(3)">Monto</th>
                                <th onclick="sortTable(4)">Estado</th>
                                <th onclick="sortTable(5)">Fecha</th>
                                <th onclick="sortTable(6)">Registró</th>
                                <th onclick="sortTable(7)">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $negocio = $_SESSION['idnegocio'];
                            $con = new Models\Conexion();
                            $query = "SELECT idgastos,concepto,pago,descripcion,monto,gastos.estado,fecha,nombre,apaterno FROM gastos
                            INNER JOIN trabajador ON trabajador_idtrabajador = idtrabajador
                            WHERE gastos.negocios_idnegocios ='$negocio' ORDER BY idgastos DESC";
                            $row = $con->consultaListar($query);

                            while ($renglon = mysqli_fetch_array($row)) {
                                ?>
                                <tr>
                                    <td><?php echo $renglon['concepto']; ?></td>
                                    <td><?php echo $renglon['pago']; ?></td>
                                    <td><?php if (strlen($renglon['descripcion']) === 0) {
                                            echo "Sin descripción";
                                        } else {
                                            echo $renglon['descripcion'];
                                        }  ?></td>
                                    <td>$<?php echo $renglon['monto']; ?></td>
                                    <td><?php echo $renglon['estado']; ?></td>
                                    <td><?php echo $renglon['fecha']; ?></td>
                                    <td><?php echo $renglon['nombre']." ".$renglon['apaterno']; ?></td>
                                    <td style="width:100px;">
                                        <div class="row">
                                            <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVGastos.php?id=<?php echo $renglon['idgastos']; ?>">
                                                <img src="img/edit.png">
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div><!--Tabla contenedor-->
            </div><!--col-7-->
        </div><!--row-->
    </div><!--container-->

    <script src="js/jquery_1.js"></script>
</body>

</html>