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
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
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
    <?php
    $sel = "productos"; 
    include("Navbar.php") 
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
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
                                <div class="tab-pane fade inventario" id="Inventario" role="tabpanel" aria-labelledby="Inventario-tab">
                                    <div class="col-12">
                                        <?php include("Producto-Frontend/formularioinventario.php"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3 agrega" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <p>Sucursal:</p>
                    <form action="#" method="POST">
                        <select id="sucursal" class="form form-control" name="SNegocio">
                            <option></option>
                            <?php
                            $negocio = $_SESSION['idnegocio'];
                            $con = new Models\Conexion();
                            $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                            WHERE clientesab_idclienteab = (SELECT clientesab_idclienteab AS dueno FROM negocios WHERE negocios.idnegocios='$negocio')";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();
                            $cont = 0;
                            while ($renglon = mysqli_fetch_array($row)) {
                                $nombre[$cont] = $renglon['nombre_negocio'];
                                $id[$cont] = $renglon['idnegocios'];
                                $cont++;
                                echo "<option>" . $renglon['nombre_negocio'] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" style="display: none;">
                    </form>
                    <button class="d-none d-lg-flex btn btn-primary ml-3 mostra" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div data-spy="scroll" class="contenedorTabla">
                    <table class="scroll table width="100%" table-hover fixed_headers table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">C_Barras</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Imagen</th>
                                <th onclick="sortTable(3)">Color</th>
                                <th onclick="sortTable(4)">Marca</th>
                                <th onclick="sortTable(5)">Descripcion</th>
                                <th onclick="sortTable(6)">Cantidad</th>
                                <th onclick="sortTable(7)">Unidad de Medida</th>
                                <th onclick="sortTable(8)">Talla</th>
                                <th onclick="sortTable(9)">Compra</th>
                                <th onclick="sortTable(10)">Venta</th>
                                <th onclick="sortTable(11)">Estado</th>
                                <th onclick="sortTable(12)">Cantidad</th>
                                <th onclick="sortTable(13)">Tarea</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                            <?php
                            if (isset($_POST['SNegocio'])) {
                                for ($i = 0; $i < sizeof($id); $i++) {
                                    if (strcasecmp($_POST['SNegocio'], $nombre[$i]) == 0) {
                                        $negocio = $id[$i];
                                    }
                                }
                            } else {
                                        $negocio = $_SESSION['idnegocio'];
                            }?>
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

    <script src="js/user_jquery.js"></script>
    <script src="js/vproductos.js"></script>
</body>

</html>
