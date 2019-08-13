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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Busquedas Clientes AB</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Busquedas Clientes</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px;">
        <div class="col-xs-4" style="margin: 0 auto;">
            <div class=" card card-body">
                <form class="form-group" action="VConsultasC.php" method="post">
                    <div>
                        <input id="inclientes" class="form form-control" list="clientes" name="DlClientes" required autocomplete="off">
                        <datalist id="clientes">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre,apaterno,amaterno FROM clientesab";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('inclientes').disabled = true;</script>";
                            } ?>

                        </datalist>
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>


            </div>
        </div>

        <div class="col-md-12" style="margin-top: 15px;">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>A-P</th>
                        <th>A-M</th>
                        <th>Doc</th>
                        <th>#Doc</th>
                        <th>Direcci&oacute;n</th>
                        <th>Tel&eacute;fono</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Contrase&ntilde;a</th>
                        <th>Estado</th>
                        <th>Registr&oacute;</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (
                        isset($_POST['DlClientes'])
                    ) {
                        $nombre = $_POST['DlClientes'];
                        $con = new Models\Conexion();
                        $query = "SELECT id_clienteab,clientesab.nombre AS cnombre , clientesab.apaterno AS capaterno,
                        clientesab.amaterno AS camaterno, tipo_documento,numero_documento,direccion,telefono,correo,clientesab.login,
                        clientesab.password,clientesab.estado,usuariosab.nombre AS unombre,usuariosab.apaterno AS uapaterno
                        FROM clientesab INNER JOIN usuariosab ON clientesab.usuariosab_idusuariosab = usuariosab.idusuariosab
                        WHERE (SELECT CONCAT(clientesab.nombre,' ', clientesab.apaterno,' ' ,clientesab.amaterno))='$nombre'";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                            <tr>
                                <td><?php echo $renglon['cnombre']; ?></td>
                                <td><?php echo $renglon['capaterno']; ?></td>
                                <td><?php echo $renglon['camaterno']; ?></td>
                                <td><?php echo $renglon['tipo_documento']; ?></td>
                                <td><?php echo $renglon['numero_documento']; ?></td>
                                <td><?php echo $renglon['direccion']; ?></td>
                                <td><?php echo $renglon['telefono']; ?></td>
                                <td><?php echo $renglon['correo']; ?></td>
                                <td><?php echo $renglon['login']; ?></td>
                                <td><?php echo $renglon['password']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td><?php echo $renglon['unombre'] . " " . $renglon['uapaterno']; ?></td>
                                <td style="width:100px;">
                                    <div style="margin: 0 auto;" class="row">
                                        <a style="margin-top:2px;" class="btn btn-secondary" href="EditVClienteAB.php?id=<?php echo $renglon['id_clienteab'] ?>">
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
                $query = "SELECT id_clienteab,clientesab.nombre AS cnombre , clientesab.apaterno AS capaterno,
                clientesab.amaterno AS camaterno, tipo_documento,numero_documento,direccion,telefono,correo,clientesab.login,
                clientesab.password,clientesab.estado,usuariosab.nombre AS unombre,usuariosab.apaterno AS uapaterno
                FROM clientesab INNER JOIN usuariosab ON clientesab.usuariosab_idusuariosab = usuariosab.idusuariosab
                WHERE id_clienteab = '$id'";
                $row = $con->consultaListar($query);
                $con->cerrarConexion();

                while ($renglon = mysqli_fetch_array($row)) {
                    ?>
                    <tr>
                        <td><?php echo $renglon['cnombre']; ?></td>
                        <td><?php echo $renglon['capaterno']; ?></td>
                        <td><?php echo $renglon['camaterno']; ?></td>
                        <td><?php echo $renglon['tipo_documento']; ?></td>
                        <td><?php echo $renglon['numero_documento']; ?></td>
                        <td><?php echo $renglon['direccion']; ?></td>
                        <td><?php echo $renglon['telefono']; ?></td>
                        <td><?php echo $renglon['correo']; ?></td>
                        <td><?php echo $renglon['login']; ?></td>
                        <td><?php echo $renglon['password']; ?></td>
                        <td><?php echo $renglon['estado']; ?></td>
                        <td><?php echo $renglon['unombre'] . " " . $renglon['uapaterno']; ?></td>
                        <td style="width:100px;">
                            <div style="margin: 0 auto;" class="row">
                                <a class="btn btn-secondary" href="EditVClienteAB.php?id=<?php echo $renglon['id_clienteab'] ?>">
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