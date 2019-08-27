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
                    <div class="d-block d-lg-flex row">
                        <div class="col-lg-4">
                            <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                            <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                            <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                            <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                        <div class="col-lg-4">
                            <h5><label for="doc" class="badge badge-primary">Documento:</label></h5>

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
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="numdoc" class="badge badge-primary">Documento:</label></h5>
                            <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                            <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required>
                        </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                        <div class="col-lg-4">
                            <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                            <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                            <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com">
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>
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
                    <div class="row d-block d-lg-flex">
                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Nombre de Usuario:</label></h5>
                            <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                            <input id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña" required>
                        </div>
                        <div class="col-lg-4">
                            <h5><label for="sueldo" class="badge badge-primary">Sueldo:</label></h5>
                            <input id="sueldo" class="form form-control" type="text" name="TSueldo" placeholder="$" autocomplete="off">
                        </div>
                    </div>
                    <div class="row d-block d-lg-flex">
                        <div class="col-12">
                            <h5><label for="acceso" class="badge badge-primary">Estado:</label></h5>

                            <div class="row" style="margin-left: 5px;">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="estado" name="REstado" value="A" checked autofocus>Activo
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="REstado" value="I">Inactivo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-block d-lg-flex">
                        <div class="col-12">
                            <input type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
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
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div class="contenedorTabla">
                    <table class="table table-bordered table-hover fixed_headers table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">Nombre</th>
                                <th onclick="sortTable(1)">Ap-P</th>
                                <th onclick="sortTable(2)">Ap-M</th>
                                <th onclick="sortTable(3)">Doc</th>
                                <th onclick="sortTable(4)">#Doc</th>
                                <th onclick="sortTable(5)">Direccion</th>
                                <th onclick="sortTable(6)">Telefono</th>
                                <th onclick="sortTable(7)">Email</th>
                                <th onclick="sortTable(8)">Acceso</th>
                                <th onclick="sortTable(9)">Usuario</th>
                                <th onclick="sortTable(10)">Contraseña</th>
                                <th onclick="sortTable(11)">Sueldo</th>
                                <th onclick="sortTable(12)">Estado</th>
                                <th onclick="sortTable(13)">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idnegocio = $_SESSION['idnegocio'];
                            //se optiene el id del negocio para hacer la consulta ..se escoge el id por que puede haber muchos negocios con el mismo nombre pertenecientes a otro dueño
                            $con = new Models\Conexion();
                            $query = "SELECT * FROM trabajador WHERE negocios_idnegocios = '$idnegocio' ORDER BY idtrabajador DESC";
                            $row = $con->consultaListar($query);

                            //a continuacion se mustra en la tabla el resultado de la consulta
                            while ($renglon = mysqli_fetch_array($row)) {
                                ?>
                            <tr>
                                <td><?php echo $renglon['nombre']; ?></td>
                                <td><?php echo $renglon['apaterno']; ?></td>
                                <td><?php echo $renglon['amaterno']; ?></td>
                                <td><?php echo $renglon['tipo_documento']; ?></td>
                                <td><?php echo $renglon['numero_documento']; ?></td>
                                <td><?php echo $renglon['direccion']; ?></td>
                                <td><?php echo $renglon['telefono']; ?></td>
                                <td><?php echo $renglon['correo']; ?></td>
                                <td><?php echo $renglon['acceso']; ?></td>
                                <td><?php echo $renglon['login']; ?></td>
                                <td><?php echo $renglon['password']; ?></td>
                                <td><?php echo $renglon['sueldo']; ?></td>
                                <td><?php echo $renglon['estado']; ?></td>
                                <td style="width:100px;">
                                    <div class="row">
                                        <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVTrabajador.php?id=<?php echo $renglon['idtrabajador'];
                                                                                                                                //se envia el id del registro para ser editado
                                                                                                                                ?>">
                                            <img src="img/edit.png">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if (
            isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
            && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
            && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
            && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
            && isset($_POST['RAcceso'])  && isset($_POST['TLogin'])
            && isset($_POST['TPContraseña']) && isset($_POST['TSueldo'])
            && isset($_POST['REstado'])
            //se comprueba que existan todos los datos del formulario
        ) {
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
            $negocio = $_SESSION['idnegocio'];
            $trabajador->setEstado($_POST['REstado']);
            $result = $trabajador->guardar($_SESSION['idnegocio']);
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