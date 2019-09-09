<?php
//en esta pagina se optiene el id del cliente al que se le va asignar la deuda
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEO" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}

if (isset($_GET['t0t41v34'])) {
    $totalv =  $_GET['t0t41v34'];
    if (isset($_POST['TID'])) {
        $_SESSION['clienteid'] = $_POST['TID'];
        //se guarda el id del cliente en la sesion
        header("location: VPago.php?v3nd3rpr0=v3nd3r&total=$totalv");
        //el total de la venta se manda de nuevo por la url
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <title>Adeudos</title>
    </head>


    <body onload="inicio(); " onkeypress="parar();" onclick="parar();">
        <div class="jumbotron" style="background: #3366ff; color:white; text-align: center;">
            <h1>Agregue un cliente para completar la venta a crédito</h1>
        </div>
        <div class="row" style=" margin-top: 15px;">
            <div class="col-xs-4" style="margin: 0 auto;">
                <div class=" card card-body text-center">
                    <div><button onclick="window.location.href='VVentas.php';" class="btn btn-danger">Cancelar x</button></div><br>
                    <form class="form-group" action="#" method="post">
                        <div>
                            <input id="inclientes" class="form form-control" list="clientes" name="DlClientes" required autocomplete="off">
                            <datalist id="clientes">
                                <?php
                                    //se enlistan todos los clientes del negocio
                                    $negocios = $_SESSION['idnegocio'];
                                    $datos = false;
                                    $con = new Models\Conexion();
                                    $query = "SELECT nombre,apaterno,amaterno FROM cliente WHERE negocios_idnegocios ='$negocios' ORDER BY apaterno ASC";
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
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Mostrar datos">
                    </form>

                </div>
            </div>

            <div class="col-md-12" style="margin-top:30px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ap-P</th>
                            <th>Ap-M</th>
                            <th>Doc</th>
                            <th>#Doc</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Adeudos</th>
                            <th>Agragar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['DlClientes'])) {
                                $con = new Models\Conexion();
                                $negocios = $_SESSION['idnegocio'];
                                $nombre =  $_POST['DlClientes'];
                                //se optienen los datos del cliente para mostrarlos en la tabla para que el usuario compruebe si es el cliente
                                $query = "SELECT idcliente,nombre,apaterno,amaterno,tipo_documento,
                            numero_documento,direccion,telefono,correo, estado FROM cliente
                            WHERE (SELECT CONCAT(nombre,' ',apaterno,' ' ,amaterno))='$nombre'
                            AND negocios_idnegocios= '$negocios' ";
                                $row = $con->consultaListar($query);

                                while ($renglon = mysqli_fetch_array($row)) {
                                    //se suman el total de adeudos sin liquidar para mostrarle al usuario cuantas cuentas sin pagar tiene antes de realizar la venta
                                    $query2 = "SELECT COUNT(idadeudos) AS total FROM adeudos
                                WHERE cliente_idcliente='$renglon[idcliente]' AND estado_deuda='A'";

                                    $totaladeudos = $con->consultaRetorno($query2);
                                    $con->cerrarConexion();
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
                                    <?php if ($totaladeudos['total'] > 0) {
                                                    ?>
                                        <td style="color:red;">
                                            <h4><?php echo $totaladeudos['total']; ?></h4>
                                        </td>
                                    <?php } else {
                                                    ?> <td><?php echo $totaladeudos['total']; ?></td>
                                    <?php } ?>
                                    <td style="margin: 0 auto; width:100px;">
                                        <div class="row" style="margin: 0 auto;">
                                            <form action="#" method="post">
                                                <input style="display: none;" type="text" name="TID" value="<?php echo $renglon['idcliente']; ?>">
                                                <button id="inagregar" class="btn btn-lg btn-block btn-success" type="submit"><img src="img/ok.png"></button>
                                                <?php if ($renglon['estado'] == "I") {
                                                                echo "<script>document.getElementById('inagregar').disabled = true;
                                                    alert('No es posible realizar la venta a crédito por que el cliente se encuentra inactivo');</script>";
                                                            } //al confirmar que es el cliente se comprueba si esta acitvo o inactivo antes de continuar con la venta
                                                            ?>
                                            </form>
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
        <script src="js/user_jquery.js"></script>
    </body>

    </html>
<?php } ?>