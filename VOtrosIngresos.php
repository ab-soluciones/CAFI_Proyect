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
    isset($_POST['TCantidad']) && isset($_POST['STipo'])
    && isset($_POST['SFIngreso']) && isset($_POST['DFecha'])
) {
    $otro_ingreso = new Models\OtrosIngresos();
    $otro_ingreso->setIdOtrosIngresos(null);
    $otro_ingreso->setCantidad($_POST['TCantidad']);
    $otro_ingreso->setTipo($_POST['STipo']);
    $otro_ingreso->setFormaIngreso($_POST['SFIngreso']);
    $otro_ingreso->setFecha($_POST['DFecha']);
    $otro_ingreso->setEstado("A");
    $result = $otro_ingreso->guardar($_SESSION['id'], $_SESSION['idnegocio']);
    if ($result === 1) {
        ?>
<script>
    alert('Producto Registrado Exitosamente');
</script>

<?php } else {
        ?>
<script>
    alert('Producto no registrado compruebe los campos unicos');
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Otros Ingresos</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px; margin-left:5px;">
        <div class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="can" class="badge badge-primary">Cantidad $ :</label></h5>
                    <input id="can" name="TCantidad" class="form form-control" type="text" placeholder="Ingrese la cantidad $" autocomplete="off" required><br>

                    <h5><label for="tipo" class="badge badge-primary">Tipo :</label></h5>
                    <select id="tipo" name="STipo" id="concepto" class="form form-control" required>
                        <option></option>
                        <option>Dinero a caja</option>
                        <option>Capital Externo</option>
                        <option>Prestamo</option>
                    </select> <br>

                    <h5><label for="fingreso" class="badge badge-primary">Forma de Ingreso :</label></h5>
                    <select name="SFIngreso" id="fingreso" class="form form-control" required>
                        <option></option>
                        <option>Efectivo</option>
                        <option>Banco</option>
                    </select> <br>
                    <div>
                        <h5><label for="fecha" class="badge badge-primary">Fecha :</label></h5>
                        <input class="form-control" id="fecha" type="date" name="DFecha" required>
                    </div><br>
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">

                </form>
            </div>

        </div>
        <div class="col-md-8" style="margin-top: 10px; margin-left: 10px;">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasOtrosIngresos.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Forma de Ingreso</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $negocio = $_SESSION['idnegocio'];
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM otros_ingresos WHERE negocios_idnegocios ='$negocio' AND fecha='$fecha' ORDER BY id_otros_ingresos DESC";
                    $row = $con->consultaListar($query);

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                        <tr>
                            <td><?php echo $renglon['cantidad']; ?></td>
                            <td><?php echo $renglon['tipo']; ?></td>
                            <td><?php echo $renglon['forma_ingreso']; ?></td>
                            <td><?php echo $renglon['fecha']; ?></td>
                            <td><?php echo $renglon['estado']; ?></td>
                            <td style="width:100px;">
                                <div class="row">
                                    <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVOtrosIngresos.php?id=<?php echo $renglon['id_otros_ingresos']; ?>">
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