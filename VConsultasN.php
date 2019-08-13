<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager") {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Busquedas Negocios AB</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Busquedas Negocios</a>
        </div>
    </nav>
    <div class="row" style="margin-left: 5px; margin-top: 5px;">
        <div class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="VConsultasN.php" method="post">
                    <div>
                        <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
                        <datalist id="negocios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio FROM negocios ORDER BY nombre_negocio ASC";
                            $row = $con->consultaListar($query);

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre_negocio'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('innegocio').disabled = true;</script>";
                            } ?>

                        </datalist>
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>Cliente</th>
                        <th>Registró</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['DlNegocios'])) {
                        $con = new Models\Conexion();
                        $negocio = $_POST['DlNegocios'];
                        $query = "SELECT idnegocios,nombre_negocio,domicilio,ciudad,telefono_negocio,
                        clientesab_idclienteab,usuariosab.nombre AS unombre,usuariosab.apaterno FROM negocios 
                        INNER JOIN usuariosab ON negocios.usuariosab_idusuariosab=usuariosab.idusuariosab
                        WHERE nombre_negocio = '$negocio'";
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
                                <td><a href="VConsultasC.php?id= <?php echo $renglon['clientesab_idclienteab']; ?>"># <?php echo $renglon['clientesab_idclienteab']; ?></a></td>
                                <td><?php echo $renglon['unombre'] . " " . $renglon['apaterno']; ?></td>
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
            <?php
            } ?>
            <?php
            if (isset($_GET['id'])) {
                $con = new Models\Conexion();
                $id = $_GET['id'];
                $query = "SELECT idnegocios,nombre_negocio,domicilio,ciudad,telefono_negocio,
                clientesab_idclienteab,usuariosab.nombre AS unombre,usuariosab.apaterno FROM negocios 
                INNER JOIN usuariosab ON negocios.usuariosab_idusuariosab=usuariosab.idusuariosab
                WHERE idnegocios = '$id'";
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
                        <td><a href="VConsultasC.php?id= <?php echo $renglon['clientesab_idclienteab']; ?>"># <?php echo $renglon['clientesab_idclienteab']; ?></a></td>
                        <td><?php echo $renglon['unombre'] . " " . $renglon['apaterno']; ?></td>
                        <td style="width:100px;">
                            <div class="row">
                                <a style="margin: 0 auto;" class="btn btn-secondary" href="EditNegocio.php?id=<?php echo $renglon['idnegocios'] ?>">
                                    <img src="img/edit.png">
                                </a>
                            </div>
                        </td>
                    </tr>

                <?php
                } ?>
                </tbody>
                </table>
            <?php
            } ?>
        </div>
    </div>
</body>

</html>