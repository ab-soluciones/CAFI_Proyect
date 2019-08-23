<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    !$_SESSION['acceso'] == "Manager"
) {
    header('location: OPCAFI.php');
}
$negocio = $_SESSION['idnegocio'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <title>Productos</title>
    <script type="text/javascript">
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 15 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 15 min
        }
        //funcion para la vista previa de la imagen
        function ejecutar() {

            document.getElementById("imagen").onchange = function(e) {
                // Creamos el objeto de la clase FileReader
                let reader = new FileReader();

                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                reader.readAsDataURL(e.target.files[0]);

                // Le decimos que cuando este listo ejecute el código interno
                reader.onload = function() {
                    let preview = document.getElementById('preview'),
                        image = document.createElement('img');

                    image.src = reader.result;
                    image.height = 100;
                    image.width = 100;
                    preview.innerHTML = '';
                    preview.append(image);
                };
            }
        }
        //funciones para mostrar y ocultar los divs
        function activarDivTalla() {
            document.getElementById("divtalla").style.display = "block";
            document.getElementById("divmedida").style.display = "none";
            document.getElementById('tpr').disabled = true;
            document.getElementById('tpc').disabled = false;
            document.getElementById('tpo').disabled = false;
            document.getElementById('tipo_produc').value = "Ropa";
            document.getElementById('ta').value = "";
            document.getElementById('ta').setAttribute("required", true);
            document.getElementById('med').removeAttribute("required");
        }

        function activarDivMedida() {
            document.getElementById("divtalla").style.display = "none";
            document.getElementById("divmedida").style.display = "block";
            document.getElementById('tpc').disabled = true;
            document.getElementById('tpr').disabled = false;
            document.getElementById('tpo').disabled = false;
            document.getElementById('tipo_produc').value = "Calzado";
            document.getElementById('med').value = "";
            document.getElementById('med').setAttribute("required", true);
            document.getElementById('ta').removeAttribute("required");
        }

        function activarDivOtro() {
            document.getElementById("divtalla").style.display = "none";
            document.getElementById("divmedida").style.display = "none";
            document.getElementById('tpo').disabled = true;
            document.getElementById('tpc').disabled = false;
            document.getElementById('tpr').disabled = false;
            document.getElementById('tipo_produc').value = "Otro";
            document.getElementById('ta').removeAttribute("required");
            document.getElementById('med').removeAttribute("required");
        }
    </script>
</head>


<body onload="inicio(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <?php include("Navbar.php") ?>

    <div class="container-fluid">
        <div class="row align-items-start">
            <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav-Producto-tab" data-toggle="tab" href="#Producto" role="tab" aria-controls="Producto" aria-selected="false">Producto</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-Inventario-tab" data-toggle="tab" href="#Inventario" role="tab" aria-controls="Inventario" aria-selected="true">Inventario</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="Producto" role="tabpanel" aria-labelledby="Producto-tab">
                                <div class="col-12">
                                    <?php include("Producto-Frontend/formularioproducto.php"); ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Inventario" role="tabpanel" aria-labelledby="Inventario-tab">
                                <div class="col-12">
                                    <?php include("Producto-Frontend/formularioinventario.php"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 </div>
            <div id="tableContainer" class="d-block col-lg-8">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                <div class="contenedorTabla">
                    <table class="table table-bordered table-hover fixed_headers table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">C_Barras</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Imagen</th>
                                <th onclick="sortTable(3)">Color</th>
                                <th onclick="sortTable(4)">Marca</th>
                                <th onclick="sortTable(5)">Descripcion</th>
                                <th onclick="sortTable(6)">Cant</th>
                                <th onclick="sortTable(7)">UM</th>
                                <th onclick="sortTable(8)">Talla</th>
                                <th onclick="sortTable(9)">Compra</th>
                                <th onclick="sortTable(10)">Venta</th>
                                <th onclick="sortTable(11)">Estado</th>
                                <th onclick="sortTable(12)">Tarea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $con = new Models\Conexion();
                            $query = "SELECT codigo_barras,nombre,imagen,color,marca,descripcion,unidad_medida,talla_numero,tipo,precio_compra,precio_venta,pestado,cantidad
                            FROM producto INNER JOIN inventario ON producto.codigo_barras=inventario.producto_codigo_barras
                            WHERE inventario.negocios_idnegocios='$negocio' ORDER BY nombre ASC";
                            $row = $con->consultaListar($query);

                            while ($renglon = mysqli_fetch_array($row)) {
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
                </div>
                <!--Tabla contenedor-->
            </div>
            <!--col-7-->
        </div>
        <!--row-->
    </div>
    <!--container-->
    <?php
    if (
        isset($_POST['TNombre'])  && isset($_POST['TColor'])
        && isset($_POST['TMarca']) && isset($_POST['TADescription'])
        && isset($_POST['DLUnidad']) && isset($_POST['SlcMedida'])
        || isset($_POST['SlcTalla'])  && isset($_POST['TTipoP'])
        && isset($_POST['TPrecioC']) && isset($_POST['TPrecioVen'])
        && isset($_POST['TCodigoB'])
    ) {
        if (strlen($_FILES['FImagen']['tmp_name']) != 0) {
            //si el usuario cargó un archivo
            $imagen = addslashes(file_get_contents($_FILES['FImagen']['tmp_name']));
            //se optiene la ruta
            $tipo_imagen = $_FILES['FImagen']['type'];
            //se optine la extencion de la imagen
            $bytes = $_FILES['FImagen']['size'];
            //se optiene el tamaño de la imagen
            if ($bytes <= 10000) {
                //si la imagen es menor a 1 mega se comprueba la extencion, si la extencion es igual a alguna de la condiconal se registra la imagen
                if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                    registrar($imagen, $negocio);
                } else {
                    ?>
    <script>
        swal({
            title: 'Error',
            text: 'Seleccione una imagen de tipo jpg, jpeg o png',
            type: 'error'
        });
    </script>
    <?php }
            } else {
                ?>
    <script>
        swal({
            title: 'Error',
            text: 'Seleccione una imagen mas pequeña',
            type: 'error'
        });
    </script>
    <?php  }
        } else {
            //si el usuario no cargo una imagen se manda un valor nulo a la columna imagen de la base de datos
            registrar(null, $negocio);
        }
    }
    function registrar($imagen, $negocio)
    {
        $producto = new Models\Producto();
        if (strlen($_POST['TCodigoB']) === 0) {
            $numRand = rand(1000000, 9999999);
            $numRand2 = rand(100000, 999999);
            $codigob = $numRand . $numRand2;
        } else {
            $codigob  = $_POST['TCodigoB'];
        }

        $descripcion = $_POST['TADescription'];

        if (strlen($descripcion) === 0) {
            $descripcion = null;
        }

        $producto->setCodigoBarras($codigob);
        $producto->setNombre($_POST['TNombre']);
        $producto->setImagen($imagen);
        $producto->setColor($_POST['TColor']);
        $producto->setMarca($_POST['TMarca']);
        $producto->setDescripcion($descripcion);
        $producto->setUnidad_Medida($_POST['DLUnidad']);
        if ($_POST['TTipoP'] === "Calzado") {
            $producto->setTalla_numero($_POST['SlcMedida']);
        } else if ($_POST['TTipoP'] === "Ropa") {
            $producto->setTalla_numero($_POST['SlcTalla']);
        }
        $producto->setTipo($_POST['TTipoP']);
        $producto->setPrecioCompra($_POST['TPrecioC']);
        $producto->setPrecioVenta($_POST['TPrecioVen']);
        $producto->setPestado("A");
        $query = "SELECT clientesab_idclienteab FROM negocios WHERE idnegocios = '$negocio'";
        $con = new Models\Conexion();
        $result = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $clienteab = $result['clientesab_idclienteab'];
        $result = $producto->guardar($clienteab, $_SESSION['id']);
        if ($result === 1) {
            ?>
    <script>
        swal({
                title: 'Exito',
                text: 'Se han registrado los datos exitosamente!',
                type: 'success'
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = "VProductos.php";
                }
            });
    </script>

    <?php } else {
            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No se han guardado los datos compruebe los campos unicos',
            type: 'error'
        });
    </script>
    <?php }
    }
    ?>
    <?php
    if (isset($_POST['SCantidad']) && isset($_POST['DlProductos'])) {
        $inventario = new Models\Inventario();
        $con = new Models\Conexion();
        $inventario->setCantidad($_POST['SCantidad']);
        $inventario->setCodigoB($_POST['DlProductos']);
        $codigob = $inventario->getCodigoBarras();
        $inventario->setNegocio($_SESSION['idnegocio']);
        $inventario->setTrabajador($_SESSION['id']);
        $query = "SELECT producto_codigo_barras FROM inventario WHERE producto_codigo_barras = '$codigob' AND negocios_idnegocios = '$_SESSION[idnegocio]'";
        $datos = $con->consultaRetorno($query);
        if (isset($datos)) {
            ?>
    <script>
        swal({
            title: 'Alerta',
            text: 'El producto no se ha agregado al inventario, compruebe que el producto que intenta agregar no exista en el inventario',
            type: 'warning'
        });
    </script>
    <?php
        } else {
            $result = $inventario->guardar();
            if ($result === 1) {
                ?>
    <script>
        swal({
                title: 'Exito',
                text: 'El producto se ha agregado correctamente al inventario',
                type: 'success'
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = "VProductos.php";
                }
            });
    </script>

    <?php } else {
                ?>
    <script>
        swal({
            title: 'Alerta',
            text: 'Producto no agregado consulte a soporte tecnico',
            type: 'warning'
        });
    </script>
    <?php }
        }
    }
    ?>
    <script src="js/user_jquery.js"></script>
</body>

</html>