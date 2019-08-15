<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEO"  || $_SESSION['acceso'] == "Employes"
) {
    header('location: OPCAFI.php');
}
$negocio = $_SESSION['idnegocio'];

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
    swal({title:'Exito',text:'Se han registrado los datos exitosamente!',type:'success'});
</script>

<?php } else {
        ?>
<script>
    swal({title:'Error',text:'No se han realizado los cambios compruebe los campos unicos',type:'error'});
</script>
<?php }
}

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
        if ($bytes <= 1000000) {
            //si la imagen es menor a 1 mega se comprueba la extencion, si la extencion es igual a alguna de la condiconal se registra la imagen
            if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png'  || $tipo_imagen == 'image/gif') {
                registrar($imagen, $negocio);
            } else echo "<script> alert('Seleccione una imagen de tipo jpg , gif, jpeg o png');</script>";
        } else echo "<script> alert('Seleccione una imagen mas pequeña');</script>";
    } else {
        //si el usuario no cargo una imagen se manda un valor nulo a la columna imagen de la base de datos
        registrar(null, $negocio);
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Administracion Productos</title>
    <script type="text/javascript">
        var parametro;

  funcion mensaje(){
    alert('hola');
  }

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 15 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 15 min
        }

        function agregar() {
            document.getElementById("formulario").style.display = "block";
            document.getElementById("tabla").style.display = "none";
            document.getElementById("bagregar").style.display = "none";
            document.getElementById("bmostrar").style.display = "block";
        }

        function mostrar() {
            document.getElementById("bagregar").style.display = "block";
            document.getElementById("bmostrar").style.display = "none";
            document.getElementById("formulario").style.display = "none";
            document.getElementById("tabla").style.display = "block";

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


<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Productos</a>
        </div>
    </nav>
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-3" style="margin: 0 auto;">
            <div class="card card-body">
                <button id="bagregar" onclick="agregar();" class="btn btn-lg btn-block btn-primary">Agregar</button>
                <button id="bmostrar" onclick="mostrar();" class="btn btn-lg btn-block btn-info">Mostrar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div style="margin: 0 auto; display: none;" id="formulario" class="col-xs-4">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post" enctype="multipart/form-data">
                    <h5><label for="cb" class="badge badge-primary">Codigo de Barras:</label></h5>
                    <input id="cb" class="form form-control" type="text" name="TCodigoB" placeholder="0000000000000"><br>
                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5><label for="imagen" class="badge badge-primary">Imagen:</label></h5>
                    <div class="row">
                        <div style="margin-left: 15px;" id="preview" class="card">
                            <img src="" width="100" height="100" />
                        </div><br>
                    </div>
                    <div class="row">
                        <input onclick="ejecutar();" style="margin-left: 10px; margin-top: 10px;" id="imagen" style="margin-left: 4px;" type="file" name="FImagen" />
                    </div><br>
                    <h5><label for="color" class="badge badge-primary">Color:</label></h5>
                    <input id="color" class="form form-control" type="text" name="TColor" placeholder="Color" autocomplete="on" required><br>
                    <h5><label for=" marca" class="badge badge-primary">Marca:</label></h5>
                    <input id="marca" class="form form-control" type="text" name="TMarca" placeholder="Marca" autocomplete="on" required><br>
                    <h5><label for="desc" class="badge badge-primary">Descripcion:</label></h5>
                    <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion"></textarea><br>
                    <h5><label for="um" class="badge badge-primary">Unidad de Medida:</label></h5>

                    <select id="um" class="form form-control" type="text" name="DLUnidad">
                        <option value="Pieza">Pieza</option>
                        <option value="Par">Par</option>
                        <option value="Paquete">Paquete</option>
                    </select> <br>

                    <h5><label for="tpr" class="badge badge-primary">Tipo de producto:</label></h5>
                    <div class="row" style="margin: 0 auto;">
                        <div>
                            <button onclick="activarDivTalla();" id="tpr" type="button" class="btn btn-danger">Ropa</button>
                            <button onclick="activarDivMedida();" id="tpc" type="button" class="btn btn-success">Calzado</button>
                            <button onclick="activarDivOtro();" id="tpo" type="button" class="btn btn-warning">Otro</button><br>
                            <input style="display: none" id="tipo_produc" type="text" required name="TTipoP">
                        </div>
                    </div><br>

                    <div style="display: none;" id="divtalla">
                        <h5><label for="ta" class="badge badge-danger">Tallas de ropa:</label></h5>
                        <select id="ta" class="form form-control" name="SlcTalla" placeholder="Ingrese la talla" value="">
                            <option>XS</option>
                            <option>S</option>
                            <option>M</option>
                            <option>L</option>
                            <option>XL</option>
                            <option>XXL</option>
                        </select> <br>

                    </div>
                    <div style="display: none;" id="divmedida">
                        <h5><label for="med" class="badge badge-success">Medidas de calzado:</label></h5>
                        <select id="med" class="form form-control" name="SlcMedida" placeholder="Ingrese la Medida" value="">
                            <?php
                            for ($i = 1; $i < 34; $i++) {
                                for ($j = 0; $j < 2; $j++) {
                                    if ($j === 0) {
                                        echo "<option>$i </option>";
                                    } else if ($j > 0) {
                                        $media = $i + 0.5;
                                        echo "<option>$media</option>";
                                    }
                                }
                            }
                            ?>


                        </select> <br>
                    </div>
                    <h5><label for="precioc" class="badge badge-primary">Precio de Compra $:</label></h5>
                    <input id="precioc" class="form form-control" type="text" name="TPrecioC" placeholder="$" autocomplete="off" required><br>
                    <h5><label for="preciov" class="badge badge-primary">Precio de Venta $:</label></h5>
                    <input id="preciov" class="form form-control" type="text" name="TPrecioVen" placeholder="$" autocomplete="off" required><br>
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                </form>
            </div>

        </div>
        <div id="tabla" class="col-md-12" style="margin: 0 auto; display: none;">
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VOpBusqueda.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
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
                        <th>Tarea</th>
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

    </div>
</body>

</html>
