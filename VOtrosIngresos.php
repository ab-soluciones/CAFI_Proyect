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
    <link rel="stylesheet" href="css/style.css">

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

    <div class="container-fluid">
        <div class="row align-items-start">
            <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">

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
              <div class="col-md-8">
                <div id="tableContainer" class="d-block col-lg-8">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                      <div class="contenedorTabla">
                          <table class="table table-bordered table-hover fixed_headers table-responsive">
                              <thead class="thead-dark">
                                  <tr class="encabezados">
                                      <th onclick="sortTable(0)">Cantidad</th>
                                      <th onclick="sortTable(1)">Tipo</th>
                                      <th onclick="sortTable(2)">Forma de Ingreso</th>
                                      <th onclick="sortTable(3)">Fecha</th>
                                      <th onclick="sortTable(4)">Estado</th>
                                      <th onclick="sortTable(5)">Tarea</th>
                                  </tr>
                              </thead>
                      <tbody>
                          <?php
                          $negocio = $_SESSION['idnegocio'];
                          $con = new Models\Conexion();
                          $query = "SELECT * FROM otros_ingresos WHERE negocios_idnegocios ='$negocio' ORDER BY id_otros_ingresos DESC";
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
          </div>
            </div>
        </div>
  </div>
    <?php
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
        swal({
            title: 'Exito',
            text: 'Se han registrado los datos exitosamente!',
            type: 'success'
        });
    </script>

    <?php } else {
            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No se han guardado los datos',
            type: 'error'
        });
    </script>
    <?php }
    }
    ?>
    <script src="js/user_jquery.js"></script>
</body>

</html>
