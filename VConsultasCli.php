<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
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
    <title>Busquedas Clientes</title>
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


<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Busquedas Clientes</a>
        </div>
    </nav>
    <div class="row" style=" margin-top: 15px;">
        <div class="col-xs-4" style="margin: 0 auto;">
            <div class=" card card-body">
                <form class="form-group" action="VConsultasCli.php" method="post">
                    <div>
                        <input id="inclientes" class="form form-control" list="clientes" name="DlClientes" required autocomplete="off">
                        <datalist id="clientes">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre,apaterno,amaterno FROM cliente WHERE negocios_idnegocios ='$negocios' ORDER BY apaterno ASC";
                            $row = $con->consultaListar($query);

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

        <div class="col-md-12" style="margin-top:15px;">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ap-P</th>
                        <th>Ap-M</th>
                        <th>Doc</th>
                        <th>#Doc</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Est</th>
                        <th>Registró</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['DlClientes'])) {
                        $con = new Models\Conexion();
                        $nombre = $_POST['DlClientes'];
                        $negocios = $_SESSION['idnegocio'];
                        $query = "SELECT cliente.idcliente,cliente.nombre AS cnombre,cliente.apaterno AS capaterno,cliente.amaterno AS camaterno, cliente.tipo_documento, cliente.numero_documento,cliente.direccion,cliente.telefono,cliente.correo,cliente.estado,
                        trabajador.nombre AS tnombre, trabajador.apaterno AS tapaterno
                        FROM cliente INNER JOIN trabajador ON cliente.trabajador_idtrabajador=trabajador.idtrabajador
                        WHERE (SELECT CONCAT(cliente.nombre,' ', cliente.apaterno,' ' ,cliente.amaterno))='$nombre' 
                        AND cliente.negocios_idnegocios ='$negocios'";
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
                                <td><?php echo $renglon['estado']; ?></td>
                                <td><?php echo $renglon['tnombre'] . " " . $renglon['tapaterno']; ?></td>
                                <td>
                                    <div class="row">
                                        <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVCliente.php?id=<?php echo $renglon['idcliente'] ?>">
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
                $query = "SELECT cliente.idcliente,cliente.nombre AS cnombre,cliente.apaterno AS capaterno,cliente.amaterno AS camaterno, cliente.tipo_documento, cliente.numero_documento,cliente.direccion,cliente.telefono,cliente.correo,cliente.estado,
                trabajador.nombre AS tnombre, trabajador.apaterno AS tapaterno
                FROM cliente INNER JOIN trabajador ON cliente.trabajador_idtrabajador=trabajador.idtrabajador
                WHERE idcliente = '$id'";
                $row = $con->consultaListar($query);

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
                        <td><?php echo $renglon['estado']; ?></td>
                        <td><?php echo $renglon['tnombre'] . " " . $renglon['tapaterno']; ?></td>c
                        <td>
                            <div class="row">
                                <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVCliente.php?id=<?php echo $renglon['idcliente'] ?>">
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