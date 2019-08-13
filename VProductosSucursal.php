<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}
if (isset($_GET['n360c10']) && isset($_GET['nn360c10'])) {
    $negocio = $_GET['n360c10'];
    $nnegocio = $_GET['nn360c10'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Busquedas Productos</title>
        <script>
            var datos = false;
            var parametro;

            function ini() {
                parametro = setTimeout("window.location.href = 'Inactividad.php';", 900000); // 15 min
            }

            function parar() {
                clearTimeout(parametro);
                parametro = setTimeout("window.location.href = 'Inactividad.php';", 900000); // 15 min
            }

            function comprobarRows() {
                if (datos == true) {
                    var rengolnes;
                    renglones = document.getElementById("renglones");
                    renglones.innerHTML = "";
                }

            }

            function activarListaN() {
                comprobarRows();
                document.getElementById('busqueda').style.display = 'block';
                document.getElementById("productos").style.display = "block";
                document.getElementById("codigos").style.display = "none";
                document.getElementById("botones").style.display = "none";

            }

            function activarListaC() {
                comprobarRows();
                document.getElementById('busqueda').style.display = 'block';
                document.getElementById("productos").style.display = "none";
                document.getElementById("codigos").style.display = "block";
                document.getElementById("botones").style.display = "none";


            }


            function activarM() {
                comprobarRows();
                document.getElementById("busqueda").style.display = "none";
                document.getElementById("botones").style.display = "block";

            }

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
                <a style="margin: 0 auto;" href="#" class="navbar-brand"><?php echo $nnegocio ?> busqueda de productos por:</a>
            </div>
        </nav>
        <div id="botones" class="row" style="margin-top: 5px;">
            <div class="col-md-3" style="margin: 0 auto;">
                <div class="card card-body">
                    <button onclick="activarListaN();" class="btn btn-lg btn-block btn-info">Nombre</button>
                    <button onclick="activarListaC();" class="btn btn-lg btn-block btn-info">Codigo de Barras</button>
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
                        <div id="productos">
                            <input id="innombrep" class="form form-control" list="nombresp" name="DlNombresP" autocomplete="off">
                            <datalist id="nombresp">
                                <?php
                                $datos = false;
                                $con = new Models\Conexion();
                                $query = "SELECT nombre,color,marca,talla_numero FROM producto INNER JOIN 
                                inventario ON producto.codigo_barras = inventario.producto_codigo_barras
                                WHERE negocios_idnegocios = '$negocio'";
                                $row = $con->consultaListar($query);

                                while ($result = mysqli_fetch_array($row)) {
                                    ?>

                                    <?php $datos = true;
                                    echo "<option value='" . $result['nombre'] . " " . $result['marca'] . " color " . $result['color'] . " talla " . $result['talla_numero'] . "'> "; ?>
                                <?php
                                }
                                if ($datos == false) {
                                    echo "<script>document.getElementById('innombrep').disabled = true;</script>";
                                } ?>

                            </datalist>
                        </div>
                        <div id="codigos">
                            <input id="incodigo" class="form form-control" list="codigosp" name="DlCodigosP" autocomplete="off">
                            <datalist id="codigosp">
                                <?php
                                $datos = false;
                                $con = new Models\Conexion();
                                $query = "SELECT codigo_barras FROM producto  INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                                WHERE negocios_idnegocios ='$negocio' ORDER BY codigo_barras ASC";
                                $row = $con->consultaListar($query);

                                while ($result = mysqli_fetch_array($row)) {
                                    ?>

                                    <?php $datos = true;
                                    echo "<option value='" . $result['codigo_barras'] . "'> "; ?>
                                <?php
                                }
                                if ($datos == false) {
                                    echo "<script>document.getElementById('incodigo').disabled = true;</script>";
                                } ?>

                            </datalist>
                        </div><br>
                     <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </form>

                </div>
            </div>

            <div class="col-md-12" style=" margin: 0 auto; margin-top:15px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Color</th>
                            <th>Marca</th>
                            <th>Descripcion</th>
                            <th>Cant</th>
                            <th>UM</th>
                            <th>Talla</th>
                            <th>Compra</th>
                            <th>Venta</th>
                            <th>C_Barras</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="renglones">
                        <?php
                        if (
                            isset($_POST['DlNombresP']) || isset($_POST['DlCodigosP'])
                        ) {
                            $nombre = $_POST['DlNombresP'];
                            $codigo = $_POST['DlCodigosP'];
                            $descripcion = $_POST['DlDescripciones'];
                            $con = new Models\Conexion();

                            $query = "SELECT producto.nombre,imagen,color,marca,descripcion,
                            cantidad,unidad_medida,talla_numero,precio_compra,precio_venta,codigo_barras,
                            pestado,trabajador.nombre AS tnombre, apaterno FROM producto
                            INNER JOIN trabajador ON producto.trabajador_idtrabajador=trabajador.idtrabajador
                            INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                            WHERE (SELECT CONCAT(producto.nombre,' ', producto.marca,' color ' ,
                            producto.color, ' talla ', producto.talla_numero))='$nombre' AND inventario.negocios_idnegocios ='$negocio' 
                            OR codigo_barras = '$codigo' AND inventario.negocios_idnegocios  ='$negocio'";

                            $row = $con->consultaListar($query);

                            while ($renglon = mysqli_fetch_array($row)) {
                                echo "<script>datos = true;</script>";
                                ?>
                                <tr>
                                    <td><?php echo $renglon['nombre']; ?></td>
                                    <td> <img src="data:image/jpg;base64,<?php echo base64_encode($renglon['imagen']) ?>" height="100" width="100" /></td>
                                    <td><?php echo $renglon['color']; ?></td>
                                    <td><?php echo $renglon['marca']; ?></td>
                                    <td><?php
                                        if (strlen($renglon['descripcion']) === 0) {
                                            echo "Sin descripcion";
                                        } else {
                                            echo $renglon['descripcion'];
                                        }
                                        ?></td>
                                    <td><?php echo $renglon['cantidad']; ?></td>
                                    <td><?php echo $renglon['unidad_medida']; ?></td>
                                    <td><?php
                                        if (strlen($renglon['talla_numero']) === 0) {
                                            echo "N.A";
                                        } else {
                                            echo  $renglon['talla_numero'];
                                        }
                                        ?></td>
                                    <td>$<?php echo $renglon['precio_compra']; ?></td>
                                    <td>$<?php echo $renglon['precio_venta']; ?></td>
                                    <td><?php echo $renglon['codigo_barras']; ?></td>
                                    <td><?php echo $renglon['pestado']; ?></td>
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
<?php } ?>