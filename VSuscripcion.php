<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager"
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

    <title>Suscripciones</title>
</head>

<body onload="inicio();">
<?php include("NavbarAB.php") ?>

<!-- Modal -->
<div class="modal fade unicModal" id="modalForm" role="dialog">
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
                <form class="form-group" action="GuardarSuscripcion.php" method="post">
                        <div>
                            <h5><label for="fecha1" class="badge badge-primary">Fecha Activacion:</label></h5>
                            <input class="form-control" id="vsfecha" type="date" name="DFecha" required>
                        </div><br>

                        <div>
                            <h5><label for="fecha2" class="badge badge-primary">Fecha Vencimiento:</label></h5>
                            <input class="form-control" id="vsfecha" type="date" name="DFecha2" required><br>
                        </div>
                        <h5><label for="monto" class="badge badge-primary">Monto:</label></h5>
                        <input id="vsmont" type="text" class="form form-control" name="TMonto" required placeholder="Monto $"><br>
                        <h5><label for="innegocio" class="badge badge-primary">Negocio:</label></h5>
                        <div>
                            <input id="innegoci" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
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

                            </datalist>
                        </div><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Guardar">
                    </form>
                    <div id="tableHolder" class="row justify-content-center">
                    
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal2 -->
<div class="modal fade unicModal" id="modalForm2" role="dialog">
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
                <form class="form-group" action="EditVSuscripcion.php" method="post">
                    <input type="hidden" id="id_subs" name="id_subs">
                        <div>
                            <h5><label for="fecha1" class="badge badge-primary">Fecha Activacion:</label></h5>
                            <input class="form-control" id="vsfecha1" type="date" name="DFecha" required>
                        </div><br>

                        <div>
                            <h5><label for="fecha2" class="badge badge-primary">Fecha Vencimiento:</label></h5>
                            <input class="form-control" id="vsfecha2" type="date" name="DFecha2" required><br>
                        </div>
                        <h5><label for="monto" class="badge badge-primary">Monto:</label></h5>
                        <input id="vsmonto" type="text" class="form form-control" name="TMonto" required placeholder="Monto $"><br>
                        <h5><label for="innegocio" class="badge badge-primary">Negocio:</label></h5>
                        <div>

                        <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaA();" class="form-check-input" type="radio" id="vsestadoA" name="REstado" value="A" checked>Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input onchange="alertaI();" class="form-check-input" type="radio" id="vsestadoI" name="REstado" value="I">Inactiva
                            </label>
                        </div>
                    </div><br>

                        </div><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Editar">
                    </form>
                    <div id="tableHolder" class="row justify-content-center">
                    
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal2 -->

    <div class="container-fluid">
        <div class="row align-items-start">
          <div class="col-md-12">
            <div id="tableContainer" class="d-block col-lg-12">
                  <div class="input-group mb-2">
                      <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-search"></i></div>
                      </div>
                      <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                      <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>  
                  </div>
                  <div class="contenedorTabla">
                      <table class="table table-bordered table-hover fixed_headers table-responsive">
                          <thead class="thead-dark">
                              <tr class="encabezados">
                                  <th onclick="sortTable(0)">ID</th>
                                  <th onclick="sortTable(1)">Activacion</th>
                                  <th onclick="sortTable(2)">Vencimiento</th>
                                  <th onclick="sortTable(3)">Estado</th>
                                  <th onclick="sortTable(4)">Negocio</th>
                                  <th onclick="sortTable(5)">Monto</th>
                                  <th onclick="sortTable(6)">Tarea</th>
                              </tr>
                          </thead>

                  <tbody>
                      <?php
                      $con = new Models\Conexion();
                      $query = "SELECT * FROM suscripcion ORDER BY idsuscripcion DESC";
                      $row = $con->consultaListar($query);

                      while ($renglon = mysqli_fetch_array($row)) {
                          ?>
                      <tr>
                          <td><?php echo $renglon['idsuscripcion']; ?></td>
                          <td><?php echo $renglon['fecha_activacion']; ?></td>
                          <td><?php echo $renglon['fecha_vencimiento']; ?></td>
                          <td><?php echo $renglon['estado']; ?></td>
                          <td><a href="VConsultasN.php?id=<?php echo $renglon['negocio_id']; ?>"># <?php echo $renglon['negocio_id']; ?></a></td>
                          <td>$ <?php echo $renglon['monto']; ?></td>
                          <td style="width:100px;">
                              <div class="row">
                                  <a style="margin: 0 auto;" data-toggle="modal" data-target="#modalForm2" class="btn btn-secondary vsEditmodal" product="<?php echo $renglon['idsuscripcion'] ?>" href="#">
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
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
