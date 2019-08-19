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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Administración de Negocios</title>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administración de Negocios</a>
        </div>
    </nav>
    <div class="row" style="margin-left: -6px; margin-top: 5px;">
        <div class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5><label for="dom" class="badge badge-primary">Domicilio:</label></h5>
                    <input id="dom" class="form form-control" type="text" name="TDomicilio" placeholder="Domicilio" autocomplete="off" required><br>
                    <h5><label for="cd" class="badge badge-primary">Ciudad:</label></h5>
                    <input id="cd" class="form form-control" type="text" name="TCiudad" placeholder="Ciudad" autocomplete="off" required><br>
                    <h5><label for="tel" class="badge badge-primary">Teléfono:</label></h5>
                    <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Teléfono" autocomplete="off" required><br>
                    <h5><label for="impresora" class="badge badge-primary">Configuracion de impresora:</label></h5>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="RImpresora" value="A" checked>Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="impresora" name="RImpresora" value="I">Inactiva
                            </label>
                        </div>
                    </div><br>
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
                    </div><br>

                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Guardar">
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasN.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>Impresora</th>
                        <th>Cliente</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = new Models\Conexion();
                    $query = "SELECT * FROM negocios ORDER BY idnegocios DESC";
                    $row = $con->consultaListar($query);
                    $con->cerrarConexion();

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                    <tr>
                        <td><?php echo $renglon['idnegocios']; ?></td>
                        <td><?php echo $renglon['nombre_negocio']; ?></td>
                        <td><?php echo $renglon['domicilio']; ?></td>
                        <td><?php echo $renglon['ciudad']; ?></td>
                        <td><?php echo $renglon['telefono_negocio']; ?></td>
                        <td><?php echo $renglon['impresora']; ?></td>
                        <td><a href="VConsultasC.php?id= <?php echo $renglon['clientesab_idclienteab']; ?>"># <?php echo $renglon['clientesab_idclienteab']; ?></a></td>
                        <td style="width:100px;">
                            <div class="row">
                                <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVNegocio.php?id=<?php echo $renglon['idnegocios'] ?>">
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
    <?php
    if (
        isset($_POST['TNombre']) && isset($_POST['TDomicilio']) &&
        isset($_POST['TCiudad']) && isset($_POST['DlCliente']) &&
        isset($_POST['TTelefono']) && isset($_POST['RImpresora'])
    ) {

        $negocio = new Models\Negocio();
        $con = new Models\Conexion();
        $idusuario = $_SESSION['id'];
        $negocio->setNombre($_POST['TNombre']);
        $negocio->setDomicilio($_POST['TDomicilio']);
        $negocio->setCiudad($_POST['TCiudad']);
        $negocio->setTelefono($_POST['TTelefono']);
        $nombre = $_POST['DlCliente'];
        $negocio->setImpresora($_POST['RImpresora']);
        $query = "SELECT id_clienteab FROM clientesab WHERE(SELECT CONCAT(clientesab.nombre,' ', clientesab.apaterno,' ' ,clientesab.amaterno))='$nombre'";
        $id = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $id = (int) $id['id_clienteab'];
        $negocio->setIdCliente($id);
        $result = $negocio->guardar($idusuario);
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
</body>

</html>