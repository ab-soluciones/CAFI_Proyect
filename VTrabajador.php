<?php
session_start();
// se comprueba si hay un rol en la sesion si la cuenta esta activa y si ese rol es diferente a ceo
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEO"
) {
    header('location: index.php');
}
require_once "Config/Autoload.php";
Config\Autoload::run();
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Trabajadores</title>
</head>

<body onload="inicio();">
    <?php 
        $sel = "trabajadores";
        include("NavbarD.php") 
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
                    <form class="form-group" id="formtrabajador">
                        <div class="d-block d-lg-flex row">
                            <div class="col-4">
                                <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" >
                            </div>
                            <div class="col-4">
                                <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" >
                            </div>
                            <div class="col-4">
                                <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" >
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                            <div class="col-4">
                            <h5><label for="doc" class="badge badge-primary">Documento:</label></h5>
                            <select id="documento" class="form form-control">
                                <option value="INE">INE</option>
                                <option value="CURP">CURP</option>
                                <option value="Otro">Otro</option>
                            </select>
                            </div>
                            <div class="col-4">
                                <h5><label for="numdoc" class="badge badge-primary">Documento:</label></h5>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" >
                            </div>
                            <div class="col-4">
                                <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion"  autocomplete="off">
                            </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                            <div class="col-4">
                                <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono"  autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com" autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>
                                <select id="acceso" class="form form-control">
                                    <option value="Manager">Manager</option>
                                    <option value="Employes">Employes</option>
                                </select>
                            </div>
                        </div>
                    <div class="row d-block d-lg-flex">
                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Nombre de Usuario:</label></h5>
                            <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" >
                        </div>

                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Contraseña:</label></h5>
                            <input id="contrasena" class="form form-control" type="text" name="TContrasena" placeholder="Contraseña" autocomplete="off" >
                        </div>

                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Sueldo:</label></h5>
                            <input id="sueldo" class="form form-control" type="text" name="TSueldo" placeholder="Sueldo" autocomplete="off" >
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <h5><label for="email" class="badge badge-primary">Agregarlo a:</label></h5>
                                <select id="agregarloa" class="form form-control" name="SSucursal" >
                                    <?php
                                    $con = new Models\Conexion();
                                    $dueño = $_SESSION['id'];
                                    $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                                WHERE clientesab_idclienteab = '$dueño'";
                                    $row = $con->consultaListar($query);
                                    $con->cerrarConexion();
                                    while ($renglon = mysqli_fetch_array($row)) {
                                        echo "<option value=".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
                                    }
                                    ?>
                                </select> <br>
                                <input type="hidden" id="idDueno" value=<?php echo $_SESSION['id'];?>>
                            </div>
                        </div>
                            <div class="col-4">
                                <h5><label  class="badge badge-primary">Estado:</label></h5>
                                <select id="estado" class="form form-control">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </div>
                        <div class="row">
                            <div class="col-12"><br>
                                <input id="bclose" type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                            </div>
                        </div>
                    </div>
                </form>
                <div id="tableHolder">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
    <p id="nav-title" class="font-weight-bold">
    
    </p>
    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <p>Sucursal:</p>

                        <select id="" class="form form-control sucursal" name="SNegocio">
                            <?php
                            $con = new Models\Conexion();
                            $dueño = $_SESSION['id'];
                            $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                            WHERE clientesab_idclienteab = '$dueño'";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();
                            while ($renglon = mysqli_fetch_array($row)) {
                    
                                echo "<option value=".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" style="display: none;">
                    
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
                    <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div class="contenedorTabla table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">Id trabajador</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Ap-P</th>
                                <th onclick="sortTable(3)">Ap-M</th>
                                <th onclick="sortTable(4)">Doc</th>
                                <th onclick="sortTable(5)">#Doc</th>
                                <th onclick="sortTable(6)">Direccion</th>
                                <th onclick="sortTable(7)">Telefono</th>
                                <th onclick="sortTable(8)">Email</th>
                                <th onclick="sortTable(9)">Acceso</th>
                                <th onclick="sortTable(10)">Usuario</th>
                                <th onclick="sortTable(11)">Contraseña</th>
                                <th onclick="sortTable(12)">Sueldo</th>
                                <th onclick="sortTable(13)">Estado</th>
                                <th onclick="sortTable(14)">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="js/user_jquery.js"></script>
        <script src="js/vtrabajador.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>