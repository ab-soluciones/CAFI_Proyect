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
    <title>Busquedas Gastos</title>
    <script>
        var datos = false;
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function comprobarRows() {
            if (datos == true) {
                var rengolnes;
                renglones = document.getElementById("renglones");
                renglones.innerHTML = "";
            }

        }

        function activarListaC() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("VConcepto").style.display = "block";
            document.getElementById("fechas").style.display = "none";
            document.getElementById("botones").style.display = "none";
            document.getElementById("mes").style.display = "none";

        }

        function activarListaF() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("fechas").style.display = "block";
            document.getElementById("botones").style.display = "none";
            document.getElementById("VConcepto").style.display = "none";
            document.getElementById("mes").style.display = "none";


        }

        function activarListaM() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("VConcepto").style.display = "none";
            document.getElementById("fechas").style.display = "none";
            document.getElementById("botones").style.display = "none";
            document.getElementById("mes").style.display = "block";

        }

        function activarM() {
            comprobarRows();
            document.getElementById("busqueda").style.display = "none";
            document.getElementById("botones").style.display = "block";

        }
    </script>
</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busqueda de gastos por:</a>
        </div>
    </nav>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <button onclick="activarListaC();" class="btn btn-lg btn-block btn-info">Concepto</button>
                <button onclick="activarListaF();" class="btn btn-lg btn-block btn-info">Fecha</button>
                <button onclick="activarListaM();" class="btn btn-lg btn-block btn-info">Mes</button>
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
                <form class="form-group" action="#" method="post">
                    <div id="VConcepto">
                        <input list="conceptos" class="form form-control" name="DlConceptos">
                        <datalist id="conceptos">
                            <option>Renta</option>
                            <option>Luz</option>
                            <option>Agua</option>
                            <option>Teléfono</option>
                            <option>Internet</option>
                            <option>Transporte</option>
                            <option>Sueldo</option>
                            <option>Articulos de Venta</option>
                            <option>Pago de Prestamo</option>
                            <option>Otro</option>
                        </datalist>

                    </div>
                    <div id="fechas">
                        <input class="form-control" type="date" name="DFecha">
                    </div>
                    <div id="mes">
                        <input id="inmes" class="form-control" type="month" name="DMes">
                    </div><br>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                </form>

            </div>
        </div>

        <div class="col-md-8" style=" margin: 0 auto; margin-top:15px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Pago</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Registró</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['DlConceptos']) || isset($_POST['DFecha']) || isset($_POST['DMes'])
                    ) {
                        $concepto = $_POST['DlConceptos'];
                        $fecha = $_POST['DFecha'];
                        if (isset($_POST['DMes']) && strlen($_POST['DMes']) != 0) {
                            $mesdelaño = explode("-", $_POST['DMes']);
                            $año = $mesdelaño[0];
                            $mes = $mesdelaño[1];
                        } else {
                            $mes = "";
                            $año = "";
                        }
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        $query = "SELECT idgastos,concepto,pago,descripcion,monto,gastos.estado,fecha,
                        trabajador_idtrabajador,nombre,apaterno 
                        FROM gastos 
                        INNER JOIN trabajador ON gastos.trabajador_idtrabajador=trabajador.idtrabajador
                        WHERE concepto = '$concepto' AND gastos.negocios_idnegocios ='$negocio' 
                        OR fecha = '$fecha' AND gastos.negocios_idnegocios = '$negocio'
                        OR MONTH(gastos.fecha) = '$mes' AND YEAR(gastos.fecha)='$año' 
                        AND gastos.negocios_idnegocios = '$negocio'";

                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td><?php echo $renglon['concepto']; ?></td>
                                <td><?php echo $renglon['pago']; ?></td>
                                <td><?php if (strlen($renglon['descripcion']) === 0) {
                                        echo "Sin descripción";
                                    } else {
                                        echo $renglon['descripcion'];
                                    }  ?></td>
                                <td><?php echo $renglon['monto']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td><?php echo $renglon['fecha']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>

                                <td style="width:100px;">
                                    <div class="row">
                                        <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVGastos.php?id=<?php echo $renglon['idgastos']; ?>">
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