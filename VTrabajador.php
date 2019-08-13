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
    $trabajador->guardar($_SESSION['idnegocio']);

    //se guarda el trabajador
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Administracion Trabajadores</title>
    <script>
        //con la funcion mostrar y agregar se hace el dinamismo de la aplicacion: ocultando la tabla cada que se va agregar un trabajador y mostrandola cada que el usuario quiera

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

        // con este script se destruye la sesion despues de 25 min de inactividad

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

<body onload="ini();" onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="#" class="navbar-brand"> Administracion Trabajadores</a>
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
    <div class="row" style="">
        <div class="col-md-3" style="margin: 0 auto;" id="formulario">
            <script>
                document.getElementById('formulario').style.display = 'none';
            </script>
            <div class="card card-body">
                <form class="form-group" action="#" method="post">
                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="on" required><br>
                    <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                    <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="on" required><br>
                    <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                    <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="on" required><br>
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
                    </div><br>

                    <h5><label for="numdoc" class="badge badge-primary">#Documento:</label></h5>
                    <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="on" required><br>
                    <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                    <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required><br>
                    <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                    <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required><br>
                    <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                    <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com"><br>

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
                    </div><br>

                    <h5><label for="login" class="badge badge-primary">Nombre de Usuario:</label></h5>
                    <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="on" required><br>
                    <h5><label for="pass" class="badge badge-primary">Contraseña:</label></h5>
                    <input id="pass" class="form form-control" type="password" name="TPContraseña" placeholder="Contraseña" required><br>
                    <h5><label for="sueldo" class="badge badge-primary">Sueldo:</label></h5>
                    <input id="sueldo" class="form form-control" type="text" name="TSueldo" placeholder="$" autocomplete="on"><br>
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
                    </div><br>
                    <input onclick="location.reload()" type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                </form>
            </div>
        </div>

        <div id="tabla" class="col-lg-12" style="margin-top: 10px;">
            <script>
                document.getElementById('tabla').style.display = 'none';
            </script>
            <h5 style="margin: 0 auto;"><label class="badge badge-info">
                    <a style="color: white;" href="VConsultasT.php">BUSCAR--></a>
                </label></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ap-P</th>
                        <th>Ap-M</th>
                        <th>Doc</th>
                        <th>#Doc</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Acceso</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Sueldo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
</body>

</html>