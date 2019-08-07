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

        function activarListaT() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("dtipo").style.display = "block";
            document.getElementById("fechas").style.display = "none";
            document.getElementById("botones").style.display = "none";
            document.getElementById("mes").style.display = "none";

        }

        function activarListaF() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("fechas").style.display = "block";
            document.getElementById("botones").style.display = "none";
            document.getElementById("dtipo").style.display = "none";
            document.getElementById("mes").style.display = "none";


        }

        function activarListaM() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("dtipo").style.display = "none";
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
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Busqueda de otros ingresos por :</a>
        </div>
    </nav>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <button onclick="activarListaT();" class="btn btn-lg btn-block btn-info">Tipo</button>
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
                    <div id="dtipo">
                        <select id="tipo" name="STipo" id="concepto" class="form form-control">
                            <option></option>
                            <option>Capital Externo</option>
                            <option>Prestamo</option>
                        </select>

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
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Forma de Ingreso</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Registró</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody id="renglones">
                    <?php
                    if (
                        isset($_POST['STipo']) || isset($_POST['DFecha']) || isset($_POST['DMes'])
                    ) {
                        $tipo = $_POST['STipo'];
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
                        $query = "SELECT id_otros_ingresos,cantidad, tipo, forma_ingreso,fecha,otros_ingresos.estado,nombre,apaterno
                        FROM otros_ingresos
                        INNER JOIN trabajador ON otros_ingresos.trabajador_idpersona =trabajador.idtrabajador
                        WHERE tipo = '$tipo' AND otros_ingresos.negocios_idnegocios ='$negocio' 
                        OR fecha = '$fecha' AND otros_ingresos.negocios_idnegocios = '$negocio'
                        OR MONTH(otros_ingresos.fecha) = '$mes' AND YEAR(otros_ingresos.fecha)='$año' 
                        AND otros_ingresos.negocios_idnegocios = '$negocio'";

                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            echo "<script>datos = true;</script>";
                            ?>
                            <tr>
                                <td><?php echo $renglon['cantidad']; ?></td>
                                <td><?php echo $renglon['tipo']; ?></td>
                                <td><?php echo $renglon['forma_ingreso']; ?></td>
                                <td><?php echo $renglon['fecha']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                                <td style="width:100px;">
                                    <div class="row">
                                        <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVOtrosIngresos.php?id=<?php echo $renglon['id_otros_ingresos']; ?>">
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