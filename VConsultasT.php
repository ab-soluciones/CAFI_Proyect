<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEO"
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
    <title>Busquedas Trabajadores</title>
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busquedas Trabajadores</a>
        </div>
    </nav>
    <div class="row" style=" margin-top: 15px;">
        <div class="col-xs-4" style="margin: 0 auto;">
            <div id="formulario" class=" card card-body">
                <form class="form-group" action="#" method="post">
                    <div>
                        <input id="intrabajadores" class="form form-control" list="trabajadores" name="DlTrabajadores" required autocomplete="off">
                        <datalist id="trabajadores">
                            <?php
                            //se crea la lista de todos los trabajadore pertenecientes a ese negocio por medio de la consulta
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre,apaterno,amaterno FROM trabajador WHERE negocios_idnegocios ='$negocios' ORDER BY apaterno ASC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('intrabajadores').disabled = true;</script>";
                            } ?>

                        </datalist>
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

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
                    <th>Acceso</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Sueldo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['DlTrabajadores'])) {
                    $nombre = $_POST['DlTrabajadores'];
                    $idnegocio = $_SESSION['idnegocio'];
                    $con = new Models\Conexion();
                    //se optine el nombre del trabajador y se consulta su informacion 
                    $query = "SELECT * FROM trabajador WHERE (SELECT CONCAT(nombre,' ',apaterno,' ' ,amaterno))='$nombre' ORDER BY idtrabajador DESC";
                    $row = $con->consultaListar($query);

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                        <tr>
                            <td><?php echo $renglon['nombre']; ?></td>
                            <td><?php echo $renglon['apaterno']; ?></td>
                            <td><?php echo $renglon['amaterno']; ?></td>
                            <td><?php echo $renglon['tipo_documento']; ?></td>
                            <td><?php echo $renglon['numero_documento']; ?></td>
                            <td><?php echo $renglon['direccion']; ?></td>
                            <td><?php echo $renglon['telefono']; ?></td>
                            <td><?php echo $renglon['correo']; ?></td>
                            <td><?php echo $renglon['acceso']; ?></td>
                            <td><?php echo $renglon['login']; ?></td>
                            <td><?php echo $renglon['password']; ?></td>
                            <td><?php echo $renglon['sueldo']; ?></td>
                            <td><?php echo $renglon['estado']; ?></td>
                            <td style="width:100px;">
                                <div class="row">
                                    <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVTrabajador.php?id=<?php echo $renglon['idtrabajador'] ?>">
                                        <img src="img/edit.png">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            <?php } ?>
        </table>
    </div>
</body>

</html>