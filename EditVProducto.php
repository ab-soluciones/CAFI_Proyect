<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "CEO"
    || $_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB"
) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Manager"
) {

    if (isset($_GET['id'])) {
        ?>
<?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT * FROM producto where idproducto = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        if (isset($result)) {
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


    <title> Edicion Producto</title>
    <script>
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

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
            document.getElementById('ta').removeAttribute("required");
            document.getElementById('med').removeAttribute("required");
            document.getElementById('tpo').disabled = true;
            document.getElementById('tpc').disabled = false;
            document.getElementById('tpr').disabled = false;
            document.getElementById('tipo_produc').value = "Otro";

        }
    </script>
</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion de Producto</a>
            <h5></h5>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-3" style="  margin: 0 auto; margin-top:5px;">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post" enctype="multipart/form-data">

                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input value="<?php echo $result['nombre'] ?>" id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required><br>
                    <h5><label for="imagen" class="badge badge-primary">Imagen:</label></h5>

                    <div class="row">
                        <div style="margin-left: 15px;" id="preview" class="card">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($result['imagen']) ?>" height="100" width="100" />
                        </div>
                        <input onclick="ejecutar();" style="margin-left: 10px; margin-top: 10px;" id="imagen" style="margin-left: 4px;" type="file" name="FImagen" />
                    </div><br>

                    <h5><label for="color" class="badge badge-primary">Color:</label></h5>
                    <input id="color" class="form form-control" type="text" name="TColor" placeholder="Color" value="<?php echo $result['color'];  ?>" autocomplete="off" required><br>
                    <h5><label for=" marca" class="badge badge-primary">Marca:</label></h5>
                    <input value="<?php echo $result['marca']; ?>" id="marca" class="form form-control" type="text" name="TMarca" placeholder="Marca" autocomplete="off" required><br>

                    <h5><label for="desc" class="badge badge-primary">Descripcion:</label></h5>
                    <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion"><?php echo $result['descripcion'] ?></textarea><br>
                    <h5><label for="cant" class="badge badge-primary">Cantidad:</label></h5>
                    <input value="<?php echo $result['cantidad'] ?>" id="cant" class="form form-control" type="number" name="SCantidad" min="1"><br>
                    <h5><label for="um" class="badge badge-primary">Unidad de Medida:</label></h5>

                    <select id="um" class="form form-control" type="text" list="unidad" name="DLUnidad">

                        <option value="Pieza">Pieza</option>
                        <option value="Par">Par</option>
                        <option value="Paquete">Paquete</option>

                    </select> <br>
                    <script>
                        document.getElementById('um').value = "<?php echo $result['unidad_medida'] ?>";
                    </script>
                    <h5><label for="tpr" class="badge badge-primary">Tipo de producto:</label></h5>
                    <div class="row" style="margin: 0 auto;">
                        <div>
                            <button onclick="activarDivTalla();" id="tpr" type="button" class="btn btn-danger">Ropa</button>
                            <button onclick="activarDivMedida();" id="tpc" type="button" class="btn btn-success">Calzado</button>
                            <button onclick="activarDivOtro();" id="tpo" type="button" class="btn btn-warning">Otro</button>
                            <br>
                            <input style="display: none" id="tipo_produc" type="text" required name="TTipoP">
                        </div>
                    </div><br>
                    <div style="display: none;" id="divtalla">
                        <h5><label for="ta" class="badge badge-danger">Tallas de ropa:</label></h5>
                        <select id="ta" class="form form-control" name="SlcTalla">
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
                        <select id="med" class="form form-control" name="SlcMedida" value="">
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
                    <?php if ($result['tipo'] == "Ropa") {
                                    ?>
                    <script>
                        activarDivTalla();
                        document.getElementById('ta').value = "<?php echo $result['talla_numero'] ?>";
                    </script>
                    <?php } else if ($result['tipo'] == "Calzado") {
                                    ?>
                    <script>
                        activarDivMedida();
                        document.getElementById('med').value = "<?php echo $result['talla_numero'] ?>";
                    </script>

                    <?php } else if ($result['tipo'] == "Otro") {
                                    ?>
                    <script>
                        activarDivOtro();
                    </script>

                    <?php } ?>

                    <h5><label for="precioc" class="badge badge-primary">Precio de Compra $:</label></h5>
                    <input value="<?php echo $result['precio_compra'] ?>" id="precioc" class="form form-control" type="text" name="TPrecioC" placeholder="$" autocomplete="off" required><br>
                    <h5><label for="preciov" class="badge badge-primary">Precio de Venta $:</label></h5>
                    <input value="<?php echo $result['precio_venta'] ?>" id="preciov" class="form form-control" type="text" name="TPrecioVen" placeholder="$" autocomplete="off" required><br>
                    <h5><label for="cb" class="badge badge-primary">Codigo de Barras:</label></h5>
                    <input value="<?php echo $result['codigo_barras'] ?>" id="cb" class="form form-control" type="text" name="TCodigoB" placeholder="0000000000000" required><br>
                    <h5><label for="fecha2" class="badge badge-primary">Estado:</label></h5>

                    <?php if ($result['pestado'] == "A") {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="estado" name="REstado" value="A" checked>Activo
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="estado" name="REstado" value="I">Inactivo
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } else {
                                    ?>
                    <div class="row" style="margin: 0 auto;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="estado" name="REstado" value="A">Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="estado" name="REstado" value="I" checked>Inactiva
                            </label>
                        </div>
                    </div><br>
                    <?php

                                } ?>
                    <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Editar">

                </form>
            </div>
        </div>
    </div>
    <?php
                function registrar($imagen, $id)
                {
                    $producto = new Models\Producto();
                    $producto->setNombre($_POST['TNombre']);
                    $producto->setImagen($imagen);
                    $producto->setColor($_POST['TColor']);
                    $producto->setMarca($_POST['TMarca']);
                    $producto->setDescripcion($_POST['TADescription']);
                    $producto->setCantidad($_POST['SCantidad']);
                    $producto->setUnidad_Medida($_POST['DLUnidad']);
                    if ($_POST['TTipoP'] === "Calzado") {
                        $producto->setTalla_numero($_POST['SlcMedida']);
                    } else if ($_POST['TTipoP'] === "Ropa") {
                        $producto->setTalla_numero($_POST['SlcTalla']);
                    }
                    $producto->setTipo($_POST['TTipoP']);
                    $producto->setPrecioCompra($_POST['TPrecioC']);
                    $producto->setPrecioVenta($_POST['TPrecioVen']);
                    $producto->setCodigoBarras($_POST['TCodigoB']);
                    $producto->setPestado($_POST['REstado']);
                    if (!is_null($imagen)) {
                        $result = $producto->editar($id, $_SESSION['id']);
                        if ($result === 1) {
                            ?>
    <script>
        swal({
            title: 'Exito',
            text: 'Editado exitosamente!',
            type: 'success'
        });
    </script>
    <?php } else if ($result === 0) {
                            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No se ha realizado ningun cambio!',
            type: 'error'
        });
    </script>
    <?php } else if ($result === -1) {
                            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No editado compruebe los campos unicos',
            type: 'error'
        });
    </script>
    <?php }
                    } else {
                        $result = $producto->editarSinImagen($id, $_SESSION['id']);
                        if ($result === 1) {
                            ?>
    <script>
        swal({
            title: 'Exito',
            text: 'Editado exitosamente!',
            type: 'success'
        });
    </script>
    <?php } else if ($result === 0) {
                            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No se ha realizado ningun cambio!',
            type: 'error'
        });
    </script>
    <?php } else if ($result === -1) {
                            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No editado compruebe los campos unicos',
            type: 'error'
        });
    </script>
    <?php }
                    }
                    header('location: VProductos.php');
                }
                if (
                    isset($_POST['TNombre'])  && isset($_POST['TColor'])
                    && isset($_POST['TMarca']) && isset($_POST['TADescription'])
                    && isset($_POST['SCantidad']) && isset($_POST['DLUnidad'])
                    && isset($_POST['SlcMedida']) || isset($_POST['SlcTalla'])
                    && isset($_POST['TTipoP']) && isset($_POST['TPrecioC'])
                    && isset($_POST['TPrecioVen']) && isset($_POST['TCodigoB'])
                    && isset($_POST['REstado'])
                ) {
                    if (strlen($_FILES['FImagen']['tmp_name']) != 0) {
                        $imagen = addslashes(file_get_contents($_FILES['FImagen']['tmp_name']));
                        $tipo_imagen = $_FILES['FImagen']['type'];
                        $bytes = $_FILES['FImagen']['size'];
                        if ($bytes <= 1000000) {

                            if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png'  || $tipo_imagen == 'image/gif') {
                                registrar($imagen, $id);
                            } else echo "<script> alert('Seleccione una imagen de tipo jpg , gif, jpeg o png');</script>";
                        } else echo "<script> alert('Seleccione una imagen mas pequeña');</script>";
                    } else {
                        registrar(null, $id);
                    }
                }
                ?>
</body>

</html>
<?php
        } ?>
<?php
    }
}
?>