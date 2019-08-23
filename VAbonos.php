<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEO" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <title>Abonos</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php include("Navbar.php") ?>
    
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <h5 style="margin: 0 auto;"><label class="badge badge-warning">BUSQUEDA POR:</label></h5><br>
                <button onclick="activarListaC();" class="btn btn-lg btn-block btn-info">Cliente</button>
                <button onclick="activarListaF();" class="btn btn-lg btn-block btn-info">Fecha</button>
            </div>
        </div>
    </div>
    <div class="row" style=" margin-top: 15px;">
        <div id="busqueda" class="col-xs-4" style="margin: 0 auto;">
            <script>
                document.getElementById('busqueda').style.display = 'none';
            </script>
            <div class=" card card-body">
                <div><button onclick="activarM();" class="btn btn-danger">x</button></div><br>

                <div id="clientes">
                    <form class="form-group" action="#" method="post">
                        <input id="inclientes" class="form form-control" list="clientesv" name="DlClientes" required autocomplete="off">
                        <datalist id="clientesv">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
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

                        </datalist><br>
                        <input class="btn btn-block btn-dark" type="submit" value="Buscar">
                    </form>
                </div>

                <div id="fechas">
                    <form class="form-group" action="#" method="post">
                        <input class="form-control" type="date" name="DFecha" required><br>
                        <input class="btn btn-block btn-dark" type="submit" value="Buscar">
                    </form>
                </div><br>
            </div>
        </div>

        <div class="col-md-12" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Edit estado</th>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Pago</th>
                        <th>Cambio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Registró</th>
                        <th>Adeudo</th>



                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['DlClientes'])
                    ) {

                        $con = new Models\Conexion();
                        $nombre = $_POST['DlClientes'];

                        $query = "SELECT idabono,abono.estado AS a_estado,cantidad,pago,cambio,fecha,hora,cliente.nombre AS nombre_cliente,
                            cliente.apaterno AS ap_cliente, cliente.amaterno AS am_cliente,trabajador.nombre,
                            trabajador.apaterno, adeudos_id FROM abono 
                            INNER JOIN adeudos ON abono.adeudos_id=adeudos.idadeudos
                            INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente
                            INNER join trabajador ON trabajador.idtrabajador=abono.trabajador_idtrabajador
                            WHERE (SELECT CONCAT(cliente.nombre,' ', cliente.apaterno,' ' ,cliente.amaterno))='$nombre'
                            ORDER BY adeudos_id DESC";
                        $row = $con->consultaListar($query);

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td style="width:100px;">
                                    <div class="row" style="margin: 0 auto;">
                                        <?php if ($_SESSION['acceso'] == "Employes") {
                                            ?>
                                            <button style="margin: 0 auto;" class="btn btn-secondary" disabled><img src="img/edit.png"></button>
                                        <?php } else {
                                            ?>
                                            <a style="margin-left:2px;" class="btn btn-secondary" href="EditAbonos.php?id=<?php echo $renglon['idabono']; ?>&estado=<?php echo $renglon['a_estado']; ?>">
                                                <img src="img/edit.png">
                                            </a>
                                        <?php   } ?>

                                    </div>
                                </td>
                                <td><?php echo $renglon['a_estado']; ?></td>
                                <td>$ <?php echo $renglon['cantidad']; ?></td>
                                <td>$ <?php echo $renglon['pago']; ?></td>
                                <td>$ <?php echo $renglon['cambio']; ?></td>
                                <td><?php echo $renglon['fecha']; ?></td>
                                <td><?php echo $renglon['hora']; ?></td>
                                <td><?php echo $renglon['nombre_cliente'] . " " . $renglon['ap_cliente'] . " " . $renglon['am_cliente']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                                <td><a href="VConsultasAdeudos.php?ad= <?php echo $renglon['adeudos_id']; ?>"># <?php echo $renglon['adeudos_id']; ?></a></td>
                            </tr>
                        <?php
                        } ?>

                    </tbody>
                </table>

            <?php
            } ?>
            <?php
            if (isset($_POST['DFecha'])) {
                $fecha = $_POST['DFecha'];
                $query = "SELECT idabono,abono.estado AS a_estado,cantidad,pago,cambio,fecha,hora,cliente.nombre AS nombre_cliente,
                cliente.apaterno AS ap_cliente, cliente.amaterno AS am_cliente,trabajador.nombre,
                trabajador.apaterno,adeudos_id FROM abono 
                INNER JOIN adeudos ON abono.adeudos_id=adeudos.idadeudos
                INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente
                INNER JOIN trabajador ON trabajador.idtrabajador=abono.trabajador_idtrabajador
                WHERE abono.fecha= '$fecha'
                ORDER BY adeudos_id DESC";
                $row = $con->consultaListar($query);

                while ($renglon = mysqli_fetch_array($row)) {
                    echo "<script>datos = true;</script>";
                    ?>
                    <tr>
                        <td style="width:100px;">
                            <div class="row" style="margin: 0 auto;">
                                <?php if ($_SESSION['acceso'] == "Employes") {
                                    ?>
                                    <button style="margin: 0 auto;" class="btn btn-secondary" disabled><img src="img/edit.png"></button>
                                <?php } else {
                                    ?>
                                    <a style="margin-left:2px;" class="btn btn-secondary" href="EditAbonos.php?id=<?php echo $renglon['idabono']; ?>&estado=<?php echo $renglon['a_estado']; ?>">
                                        <img src="img/edit.png">
                                    </a>
                                <?php   } ?>

                            </div>
                        </td>
                        <td><?php echo $renglon['a_estado']; ?></td>
                        <td>$ <?php echo $renglon['cantidad']; ?></td>
                        <td>$ <?php echo $renglon['pago']; ?></td>
                        <td>$ <?php echo $renglon['cambio']; ?></td>
                        <td><?php echo $renglon['fecha']; ?></td>
                        <td><?php echo $renglon['hora']; ?></td>
                        <td><?php echo $renglon['nombre_cliente'] . " " . $renglon['ap_cliente'] . " " . $renglon['am_cliente']; ?></td>
                        <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                        <td><a href="VConsultasAdeudos.php?ad= <?php echo $renglon['adeudos_id']; ?>"># <?php echo $renglon['adeudos_id']; ?></a></td>
 </tr>
                <?php
                } ?>
                </tbody>
                </table>
            <?php } ?>

        </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>