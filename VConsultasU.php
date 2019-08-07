<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] != "CEOAB") {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Busquedas Usuarios AB</title>
    <script>
        function regresar() {
            window.location.href = 'VUsuarios_ab.php';
        }

        function cerrar() {
            window.close();
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div style="margin-left: -6.5%;" class="row">
                <button onclick="regresar();" style="width: 100px;" class="btn btn-success"><img src="img/previous.png"></button>
                <button onclick="cerrar();" style="width: 100px; margin-left: 5px;" class="btn btn-danger"><img src="img/salir2.png"></button>
            </div>
            <a style="margin: 0 auto;" href="Vusuarios_ab.php" class="navbar-brand">Busquedas Usuarios</a>
        </div>
    </nav>
    <div class="row" style="margin-left: -6px; margin-top: 5px;">
        <div class="col-md-3">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <div>
                        <input id="inusuarios" class="form form-control" list="usuarios" name="DlUsuarios" required autocomplete="off">
                        <datalist id="usuarios">
                            <?php
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre,apaterno,amaterno FROM usuariosab";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                            <?php
                        }
                        if ($datos == false) {
                            echo "<script>document.getElementById('inusuarios').disabled = true;</script>";
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
                        <th>Apellido-P</th>
                        <th>Apellido-M</th>
                        <th>Acceso</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (
                        isset($_POST['DlUsuarios'])
                    ) {
                        $con = new Models\Conexion();
                        $nombre = $_POST['DlUsuarios'];

                        $query = "SELECT * FROM usuariosab WHERE (SELECT CONCAT(nombre,
                        ' ', apaterno,' ' ,amaterno))='$nombre'";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                            <tr>
                                <td><?php echo $renglon['idusuariosab']; ?></td>
                                <td><?php echo $renglon['nombre']; ?></td>
                                <td><?php echo $renglon['apaterno']; ?></td>
                                <td><?php echo $renglon['amaterno']; ?></td>
                                <td><?php echo $renglon['acceso']; ?></td>
                                <td><?php echo $renglon['login']; ?></td>
                                <td><?php echo $renglon['password']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td style="width:100px;">
                                    <div class="row">
                                        <a class="btn btn-warning" href="deleteVUAB.php?id=<?php echo $renglon['idusuariosab'] ?>">
                                            <img src="img/usr.png">
                                        </a>
                                        <a style="margin-left:2px;" class="btn btn-secondary" href="EditVUAB.php?id=<?php echo $renglon['idusuariosab'] ?>">
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