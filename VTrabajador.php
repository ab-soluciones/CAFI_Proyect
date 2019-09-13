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
    header('location: OPCAFI.php');
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
                    <form class="form-group" action="#" method="post">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="general">Nombre:</h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5 class="general">Apellido Paterno:</h5>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5 class="general">Apellido Materno:</h5>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                        <div class="col-lg-4">
                            <h5 class="general">Documento:</h5>

                            <div class="row" style="margin: 0 auto;">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="RDoc" value="INE" checked autofocus>INE
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="doc" name="RDoc" value="CURP">CURP
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="RDoc" value="Otro">Otro
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <h5 class="general">Documento:</h5>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5 class="general">Direccion:</h5>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="general">Telefono:</h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5 class="general">Correo electrónico:</h5>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com" autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5 class="general">Tipo de acceso:</h5>
                                <div class="row" style="margin: 0 auto;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="acceso" name="RAcceso" value="Manager">Manajer
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="RAcceso" value="Employes" checked autofocus>Employes
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-block d-lg-flex">
                        <div class="col-lg-4">
                            <h5 class="general">Nombre de Usuario:</h5>
                            <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="general">Agregarlo a:</h5>
                                <select class="form form-control" name="SSucursal" required>
                                    <option></option>
                                    <?php
                                    $con = new Models\Conexion();
                                    $dueño = $_SESSION['id'];
                                    $query = "SELECT nombre_negocio, idnegocios FROM negocios
                                                WHERE clientesab_idclienteab = '$dueño'";
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
                                </select> <br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12"><br>
                                <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
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
                    <form action="#" method="POST">
                        <select id="sucursal" class="form form-control" name="SNegocio">
                            <option></option>
                            <?php
                            $con = new Models\Conexion();
                            $dueño = $_SESSION['id'];
                            $query = "SELECT nombre_negocio, idnegocios FROM negocios
                            WHERE clientesab_idclienteab = '$dueño'";
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
                                <th class="text-nowrap text-center" onclick="sortTable(0)">Nombre</th>
                                <th class="text-nowrap text-center" onclick="sortTable(1)">Ap-P</th>
                                <th class="text-nowrap text-center" onclick="sortTable(2)">Ap-M</th>
                                <th class="text-nowrap text-center" onclick="sortTable(3)">Doc</th>
                                <th class="text-nowrap text-center" onclick="sortTable(4)">#Doc</th>
                                <th class="text-nowrap text-center" onclick="sortTable(5)">Direccion</th>
                                <th class="text-nowrap text-center" onclick="sortTable(6)">Telefono</th>
                                <th class="text-nowrap text-center" onclick="sortTable(7)">Email</th>
                                <th class="text-nowrap text-center" onclick="sortTable(8)">Acceso</th>
                                <th class="text-nowrap text-center" onclick="sortTable(9)">Usuario</th>
                                <th class="text-nowrap text-center" onclick="sortTable(10)">Contraseña</th>
                                <th class="text-nowrap text-center" onclick="sortTable(11)">Sueldo</th>
                                <th class="text-nowrap text-center" onclick="sortTable(12)">Estado</th>
                                <th class="text-nowrap text-center" onclick="sortTable(13)">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="#" method="post">
                                <?php
                                if (isset($_POST['SNegocio'])) {
                                    for ($i = 0; $i < sizeof($id); $i++) {
                                        if (strcasecmp($_POST['SNegocio'], $nombre[$i]) == 0) {
                                            $_SESSION['idnegocio'] =  $idnegocio = $id[$i];
                                        }
                                    }
                                } else {
                                    $idnegocio =  $_SESSION['idnegocio'];
                                }

                                //se optiene el id del negocio para hacer la consulta ..se escoge el id por que puede haber muchos negocios con el mismo nombre pertenecientes a otro dueño
                                $con = new Models\Conexion();
                                $query = "SELECT * FROM trabajador WHERE negocios_idnegocios = '$idnegocio' ORDER BY idtrabajador DESC";
                                $row = $con->consultaListar($query);

                                //a continuacion se mustra en la tabla el resultado de la consulta
                                while ($renglon = mysqli_fetch_array($row)) {
                                    ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo $renglon['nombre']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['apaterno']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['amaterno']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['tipo_documento']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['numero_documento']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['direccion']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['telefono']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['correo']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['acceso']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['login']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['password']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['sueldo']; ?></td>
                                    <td class="text-nowrap text-center"><?php echo $renglon['estado']; ?></td>
                                    <td class="text-nowrap text-center" style="width:100px;">
                                        <div class="row">
                                            <button value="<?php echo $renglon['idtrabajador']; ?>" type="submit" name="BEdit" class="btn btn-secondary" data-toggle="modal" data-target="#modalForm"><img src="img/edit.png"></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                } ?>
                        </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if(isset($_POST['BEdit'])){
            echo$_POST['BEdit'];
        }
        if (
            isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
            && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
            && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
            && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
            && isset($_POST['RAcceso'])  && isset($_POST['TLogin'])
            && isset($_POST['TPContraseña']) && isset($_POST['TSueldo'])
            && isset($_POST['SSucursal'])
            //se comprueba que existan todos los datos del formulario
        ) {
            $negocio = null;
            if (isset($_POST['SSucursal'])) {
                for ($i = 0; $i < sizeof($id); $i++) {
                    if (strcasecmp($_POST['SSucursal'], $nombre[$i]) == 0) {
                        $negocio = $id[$i];
                    }
                }
            }
            $trabajador = new Models\Trabajador(); // se hace la instancia a la clase trabajador
            $trabajador->setNombre($_POST['TNombre']); //se pasan a los atributos de la clase todos los valores del formulario por el metodo set
            $trabajador->setApaterno($_POST['TApellidoP']);
            $trabajador->setAmaterno($_POST['TApellidoM']);
            $trabajador->setDocumento($_POST['RDoc']);
            $trabajador->setNumDoc($_POST['TNumDoc']);
            $trabajador->setDireccion($_POST['TDireccion']);
            $trabajador->setTelefono($_POST['TTelefono']);
            $trabajador->setCorreo($_POST['TCorreo']);
            $trabajador->setAcceso($_POST['RAcceso']);
            $trabajador->setLogin($_POST['TLogin']);
            $trabajador->setPassword($_POST['TPContraseña']);
            $sueldo = $_POST['TSueldo'];
            $sueldo = floatval($sueldo);
            $trabajador->setSueldo($sueldo);
            $trabajador->setEstado("A");
            $result = $trabajador->guardar($negocio);
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
                        window.location.href = "VTrabajador.php";
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
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "VTrabajador.php";
                    }
                });
        </script>
        <?php }
        }
        ?>
        <script src="js/user_jquery.js"></script>
        <script src="js/ajax.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
