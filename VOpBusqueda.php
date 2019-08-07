<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Busqueda Productos</title>
    <script>
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

    <div class="row">

        <div class="col-md-4" style="margin: 0 auto; margin-top: 10%;">
            <div id="jum">
                <nav class="navbar navbar-dark bg-dark">
                    <div class="container">
                        <a style="margin: 0 auto;" href="#" class="navbar-brand">Buscar productos en:</a>
                    </div>
                </nav>
            </div>
            <div class="card card-body text-center">
                <div>
                    <form class="form-group" action="#" method="post">
                        <input id="innegocios" class="form form-control" list="nombresn" name="DlNombresN" autocomplete="off">
                        <datalist id="nombresn">
                            <?php
                            $trabajador = $_SESSION['id'];
                            $negocioactual = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT clientesab.id_clienteab FROM clientesab
                            INNER JOIN negocios ON negocios.clientesab_idclienteab=clientesab.id_clienteab
                            INNER JOIN trabajador ON trabajador.negocios_idnegocios=negocios.idnegocios
                            WHERE trabajador.idtrabajador='$trabajador'";

                            $row = $con->consultaRetorno($query);
                            $dueño = $row['id_clienteab'];
                            $query = "SELECT idnegocios, nombre_negocio FROM negocios WHERE clientesab_idclienteab = '$dueño'";
                            $row = $con->consultaListar($query);
                            $contador = 0;
                            $negocio = array();
                            $id_negocio = array();
                            while ($result = mysqli_fetch_array($row)) {
                                $datos = true;
                                $negocio[$contador] = $result['nombre_negocio'];
                                $id_negocio[$contador] = $result['idnegocios'];
                                $contador++;
                                echo "<option value='" . $result['nombre_negocio'] . "'> ";
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('innegocios').disabled = true;</script>";
                            } ?>

                        </datalist> <br>
                        <input type="submit" class="btn btn-info btn-lg btn-block" name="" value="Buscar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
if (isset($_POST['DlNombresN'])) {
    $nombre = $_POST['DlNombresN'];
    for ($i = 0; $i < sizeof($negocio); $i++) {
        if ($negocio[$i] === $nombre) {
            $id = $id_negocio[$i];
            $nnegocio = $negocio[$i];
        }
    }
    if ($negocioactual === $id) {
        header('location: VConsultasProducto.php');
    } else {
        header("location: VProductosSucursal.php?n360c10=$id&nn360c10=$nnegocio");
    }
}
?>