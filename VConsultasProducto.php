<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
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

        function activarListaN() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("productos").style.display = "block";
            document.getElementById("codigos").style.display = "none";
            document.getElementById("desc").style.display = "none";
            document.getElementById("botones").style.display = "none";
            document.getElementById('marca').style.display = 'none';
            document.getElementById('tipo').style.display = 'none';
            document.getElementById('estado').style.display = 'none';

        }

        function activarListaC() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("productos").style.display = "none";
            document.getElementById("codigos").style.display = "block";
            document.getElementById("desc").style.display = "none";
            document.getElementById("botones").style.display = "none";
            document.getElementById('marca').style.display = 'none';
            document.getElementById('tipo').style.display = 'none';
            document.getElementById('estado').style.display = 'none';


        }

        function aD() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById("productos").style.display = "none";
            document.getElementById("codigos").style.display = "none";
            document.getElementById("desc").style.display = "block";
            document.getElementById("botones").style.display = "none";
            document.getElementById('marca').style.display = 'none';
            document.getElementById('tipo').style.display = 'none';
            document.getElementById('estado').style.display = 'none';

        }

        function activarM() {
            comprobarRows();
            document.getElementById("busqueda").style.display = "none";
            document.getElementById("botones").style.display = "block";

        }

        function activarListaMca() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById('marca').style.display = 'block'
            document.getElementById('estado').style.display = 'none';;
            document.getElementById('tipo').style.display = 'none';
            document.getElementById("productos").style.display = "none";
            document.getElementById("codigos").style.display = "none";
            document.getElementById("desc").style.display = "none";
            document.getElementById("botones").style.display = "none";

        }

        function activarListaT() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById('tipo').style.display = 'block';
            document.getElementById('estado').style.display = 'none';
            document.getElementById('marca').style.display = 'none';
            document.getElementById("productos").style.display = "none";
            document.getElementById("codigos").style.display = "none";
            document.getElementById("desc").style.display = "none";
            document.getElementById("botones").style.display = "none";
        }

        function aE() {
            comprobarRows();
            document.getElementById('busqueda').style.display = 'block';
            document.getElementById('estado').style.display = 'block';
            document.getElementById('tipo').style.display = 'none';
            document.getElementById('marca').style.display = 'none';
            document.getElementById("productos").style.display = "none";
            document.getElementById("codigos").style.display = "none";
            document.getElementById("desc").style.display = "none";
            document.getElementById("botones").style.display = "none";

        }
    </script>
</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand">Buscar productos</a>
        </div>
    </nav>
    <div id="botones" class="row" style="margin-top: 5px;">
        <div class="col-md-6" style="margin: 0 auto;">
            <div class="card card-body">
                <table>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="container">
                                    <button onclick="activarListaN();" class="btn btn-lg btn-block btn-primary">Producto</button>
                                    <button onclick="activarListaC();" class="btn btn-lg btn-block btn-primary">Codigo de barras</button>
                                    <button onclick="aD();" class="btn btn-lg btn-block btn-primary">Descripcion</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="container">
                                    <button onclick="activarListaMca();" class="btn btn-lg btn-block btn-primary">Marca</button>
                                    <button onclick="activarListaT();" class="btn btn-lg btn-block btn-primary">Tipo de producto</button>
                                    <button onclick="aE();" class="btn btn-lg btn-block btn-primary">Estado</button>
                                </div>
                            </div>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row" style=" margin-top: 15px;">
        <div id="busqueda" class="col-xs-4" style="margin: 0 auto; display: none;">
            <div class=" card card-body">
                <div><button onclick="activarM();" class="btn btn-danger">x</button></div><br>
                <form class="form-group" action="#" method="post">
                    <div id="productos">
                        <input id="innombrep" class="form form-control" list="nombresp" name="DlNombresP" autocomplete="off">
                        <datalist id="nombresp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT nombre,color,marca,talla_numero FROM producto INNER JOIN 
                            inventario ON producto.codigo_barras = inventario.producto_codigo_barras
                            WHERE negocios_idnegocios = '$negocios'";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>
                                 <?php $datos = true;
                                  echo "<option value='" . $result['nombre'] . " " . $result['marca'] . " color " . $result['color'] . " talla " . $result['talla_numero'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('innombrep').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>
                    <div id="codigos">
                        <input id="incodigo" class="form form-control" list="codigosp" name="DlCodigosP" autocomplete="off">
                        <datalist id="codigosp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT codigo_barras FROM producto  INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                            WHERE negocios_idnegocios ='$negocios' ORDER BY codigo_barras ASC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['codigo_barras'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('incodigo').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>
                    <div id="desc">
                        <input id="indescripcion" class="form form-control" list="descripcionp" name="DlDescripciones" autocomplete="off">
                        <datalist id="descripcionp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT DISTINCT descripcion FROM producto  INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                            WHERE negocios_idnegocios ='$negocios' ORDER BY descripcion ASC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['descripcion'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('indescripcion').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>

                    <div id="marca">
                        <input id="inmarca" class="form form-control" list="marcasp" name="DlMarcasP" autocomplete="off">
                        <datalist id="marcasp">
                            <?php
                            $negocios = $_SESSION['idnegocio'];
                            $datos = false;
                            $con = new Models\Conexion();
                            $query = "SELECT DISTINCT marca FROM producto INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                            WHERE negocios_idnegocios ='$negocios' ORDER BY marca ASC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($result = mysqli_fetch_array($row)) {
                                ?>

                                <?php $datos = true;
                                echo "<option value='" . $result['marca'] . "'> "; ?>
                            <?php
                            }
                            if ($datos == false) {
                                echo "<script>document.getElementById('inmarca').disabled = true;</script>";
                            } ?>

                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>
                    <div id="tipo">
                        <input list="tipop" name="DlTipo" autocomplete="off" class="form-control">
                        <datalist id="tipop">
                            <option>Ropa</option>
                            <option>Calzado</option>
                            <option>Otro</option>
                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>
                    <div id="estado">
                        <input list="estadop" name="DlEstado" autocomplete="off" class="form-control">
                        <datalist id="estadop">
                            <option>A</option>
                            <option>I</option>
                        </datalist><br>
                        <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                    </div>
            </div>
            </form>

        </div>
    </div>

    <div class="col-md-12" style=" margin: 0 auto; margin-top:15px;">
        <table class="table table-bordered">
            <div id="lmv">
                <h5 style="margin: 0 auto;"><label class="badge badge-info">
                        <a style="color: white;" href="VMasVendidosNegocio.php">Más vendidos--></a>
                    </label></h5>
            </div>
            <thead>
                <tr>
                    <th>C_Barras</th>
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
                    <th>Estado</th>
                    <th>Registró</th>
                    <th>Tarea</th>
                </tr>
            </thead>
            <tbody id="renglones">
                <?php
                if (
                    isset($_POST['DlNombresP']) || isset($_POST['DlCodigosP'])
                    || isset($_POST['DlDescripciones']) || isset($_POST['DlMarcasP'])
                    || isset($_POST['DlTipo']) || isset($_POST['DlEstado'])
                ) {
                    
                    $producto = $_POST['DlNombresP'];
                    $producto = explode(" ", $producto);
                    
                    if (sizeof($producto) === 6) {
                     $nombre = $producto[0];
                     $marca = $producto[1];
                     $color = $producto[3];
                     $talla = $producto[5];

                    }else{
                        $nombre = "";
                        $marca = "";
                        $color = "";
                        $talla = "";

                    }
         
                    $codigo = $_POST['DlCodigosP'];
                    $descripcion = $_POST['DlDescripciones'];

                    if (strlen($descripcion) === 0) {
                        $descripcion = null;
                    }

                    var_dump($descripcion);
                 
                    $marca2 =  $_POST['DlMarcasP'];
                    $tipo = $_POST['DlTipo'];
                    $estado = $_POST['DlEstado'];
                    $negocio = $_SESSION['idnegocio'];
                    $con = new Models\Conexion();

                    $query = "SELECT codigo_barras,producto.nombre,imagen,color,marca,descripcion,cantidad,unidad_medida,
                    talla_numero,precio_compra,precio_venta,pestado,trabajador.nombre AS tnombre,apaterno
                    FROM producto INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                    INNER JOIN trabajador ON producto.trabajador_idtrabajador=trabajador.idtrabajador
                    WHERE producto.nombre = '$nombre' AND marca = '$marca' AND color = '$color' 
                    AND talla_numero = '$talla' AND inventario.negocios_idnegocios ='$negocio'
                    OR codigo_barras = '$codigo' AND inventario.negocios_idnegocios ='$negocio' 
                    OR marca='$marca2' AND inventario.negocios_idnegocios ='$negocio'
                    OR tipo='$tipo' AND inventario.negocios_idnegocios ='$negocio'
                    OR pestado='$estado' AND inventario.negocios_idnegocios ='$negocio'";

                    $row = $con->consultaListar($query);
                    $con->cerrarConexion();

                    while ($renglon = mysqli_fetch_array($row)) {
                        echo "<script>datos = true;</script>";
                        ?>
                        <tr>
                            <td><?php echo $renglon['codigo_barras']; ?></td>
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
                            <td><?php echo $renglon['pestado']; ?></td>
                            <td><?php echo $renglon['tnombre'] . " " . $renglon['apaterno'] ?></td>
                            <td>
                                <div class="row" style="position: absolute;">
                                    <div class="container" style="margin: 0 auto;">
                                        <a style="margin-top: 50%;" class="btn btn-secondary" href="EditVProducto.php?id=<?php echo $renglon['codigo_barras']; ?>">
                                            <img src="img/edit.png">
                                        </a>
                                    </div>
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