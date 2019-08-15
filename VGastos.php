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
    $result = $gasto->guardar($_SESSION['idnegocio'], $_SESSION['id']);
    if ($result === 1) {
        ?>
<script>
    swal({title:'Exito',text:'Se han registrado los datos exitosamente!',type:'success'});
</script>

<?php } else {
        ?>
<script>
    swal({title:'Error',text:'No editado compruebe los campos unicos',type:'error'});
</script>
<?php }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Administracion Gastos</title>
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
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Gastos</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px; margin-left:5px;">
        <div class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="desc" class="badge badge-primary">Concepto:</label></h5>
                    <select name="SConcepto" id="concepto" class="form form-control" required>
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
                    </select> <br>

                    <h5><label for="pago" class="badge badge-primary">Forma de pago:</label></h5>
                    <select name="SPago" id="pago" class="form form-control" required>
                        <option>Efectivo</option>
                        <option>Transferencia</option>
                        <option>Tarjeta</option>
                    </select> <br>
                    <script>
                        document.getElementById('concepto').value = '';
                        document.getElementById('pago').value = '';
                    </script>

                    <h5><label for="desc" class="badge badge-primary">Descripcion:</label></h5>
                    <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion"></textarea><br>
                    <h5><label for="monto" class="badge badge-primary">Monto $:</label></h5>
                    <input id="monto" class="form form-control" type="text" name="TMonto" placeholder="$" autocomplete="off" required><br>
                    <div>
                        <h5><label for="fecha" class="badge badge-primary">Fecha:</label></h5>
                        <input class="form-control" id="fecha" type="date" name="DFecha" required>
                    </div><br>
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">

                </form>
            </div>

        </div>
        <div class="col-md-8" style="margin-top: 10px; margin-left: 10px;">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasGastos.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Pago</th>
                        <th>Descripcion</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $negocio = $_SESSION['idnegocio'];
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM gastos WHERE negocios_idnegocios ='$negocio' AND fecha='$fecha' ORDER BY idgastos DESC";
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
                        <td>$ <?php echo $renglon['monto']; ?></td>
                        <td><?php echo $renglon['estado']; ?></td>
                        <td><?php echo $renglon['fecha']; ?></td>
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
        </div>

    </div>
</body>

</html>
