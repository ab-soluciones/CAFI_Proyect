<?php

/*El mayor porcentaje del codigo del sistema se basa en un CRUD atraves de formularios php,
 no estarán comentados todos los archivos de CRUD para evitar comentar con ambiguedad, solo se comentarán
las partes de los CRUD en donde se hagan procedimientos diferentes.. El CRUD Comentado es el CRUD de trabajador*/

session_start();

//se inicializa las variables globales
$_SESSION['idven'] = null;
require_once "Config/Autoload.php";
Config\Autoload::run();
if (isset($_SESSION['acceso'])) {

  header('location: OPCAFI.php');

   //si el usuario ya esta logiado y se dirige al index se le redirige a la pagina que en debe de estar segun su rol para evitar el relogeo
 }

function comprobar($negocio, $idnegocio)
{
  if (
    // roles de los usuariosab = CEOAB, ManagerAB, rol de los clientesab = CEO, rol de los trabajadores = Manager, Employes

    strcasecmp($_SESSION['acceso'], "Manager") == 0 && strcasecmp($_SESSION['estado'], "A") == 0
    || strcasecmp($_SESSION['acceso'], "Employes") == 0  && strcasecmp($_SESSION['estado'], "A") == 0

    //se comprueban los strings a nivel de bits con la funcion strcasecmp. Si el usuario es manager o employe se redirige a la ventana de principal de opciones

  ) {
    header('Location: OPCAFI.php');
  } else if (
    strcasecmp($_SESSION['acceso'], "CEO") == 0
    && strcasecmp($_SESSION['estado'], "A") == 0

    //si es CEO se redirige a la pagina principal de opciones o a la pagina de seleccion de negocio

  ) {

    if (sizeof($negocio) > 1) {

      //si el array contiene mas de un negocio , se serilizan los arrays para ser enviados por la URL a la pagina de seleccion de negocio

      $negocio = serialize($negocio);
      $idnegocio = serialize($idnegocio);
      header("Location: VSelectNegocio.php?n360c10=$negocio&idn360c10=$idnegocio");
    } else if (sizeof($negocio) === 1) {

      $_SESSION['idnegocio'] = $idnegocio[0];
      $_SESSION['nombrenegocio'] = $negocio[0];
      header("Location: OPCAFI.php");

      //si solo es un negocio, se redirige al usuario a la pagina de opciones directamente
    }
  } else if (
    strcasecmp($_SESSION['acceso'], "CEOAB") == 0 ||
    strcasecmp($_SESSION['acceso'], "ManagerAB") == 0
  ) {

    //si el rol pertenece a los usuariosab se les redirige a su pagina de opciones

    header('Location: VABOptions.php');
  }
}


if (isset($_POST['nombre-us']) && isset($_POST['password'])) {

  //Optencion del nombre de usuario y contraseña por medio del metodo post

  $comprobar = new Models\Comprobar();
  $comprobar->comprobarFv();
  $comprobar->eliminarVentasNull();

  /*Ejecucion de la funcion comprobar de la clase Comprobar.. su tarea es cambiar a estado inactivo
   la cuenta del dueño del negocio y las cuentas de todos los trabajadores pertenecientes a dicho negocio
   cuando la fecha actual sea igual a la fecha de vencimiento de la suscripcion */

  $nombre = $_POST['nombre-us'];
  $password = $_POST['password'];
  $con = new Models\Conexion();

  //Consultas para comprobar si existe una cuenta con el nombre de usuario y contraseña optenida.

  $query = "SELECT acceso,estado,idusuariosab FROM usuariosab WHERE login= '$nombre' AND password='$password'";
  $query2 = "SELECT acceso,estado,negocios_idnegocios,idtrabajador FROM trabajador WHERE login= '$nombre' AND password='$password'";
  $query3 = "SELECT nombre_negocio,acceso,estado,idnegocios,id_clienteab FROM clientesab INNER JOIN negocios ON negocios.clientesab_idclienteab=clientesab.id_clienteab
  WHERE login = '$nombre' AND password ='$password'";
  $datos1 = $con->consultaRetorno($query);
  $datos2 = $con->consultaRetorno($query2);

  //la funcion consultaRetorno de la clase conexion regresa un array asociativo, son usadas en el sistema para consultas que regresan un solo renglon como resultado

  $datos3 = $con->consultaListar($query3);
  //la funcion consultaListar de la clase conexion regresa los parametros del resultado de una consulta como por ejemplo el numero de renglones

  $renglones = $datos3->num_rows;

  $con->cerrarConexion();

  if (isset($datos1)) {

    //si existe una cuenta en la tabla usuariosab se guarda en la variable sesion el rol de la cuenta el estado y su id

    $_SESSION['acceso'] = $datos1['acceso'];
    $_SESSION['estado'] = $datos1['estado'];
    $_SESSION['id'] = $datos1['idusuariosab'];
    comprobar(null, null);

    /*esta funcion comprueba el rol/acceso de la cuenta para mandar al usuario al apartado correspodiente
    en caso de que se logie un dueño/clienteab la funcion recibe como parametro dos arreglos,
    uno con el nombre de cada negocio perteneciente al dueño y otro con el id, estos arreglos son utilizados para que el usuario
    seleccione en que negocio registrara trabajadores o consultara informacion financiera  */
  } else if (isset($datos2)) {

    //si existe una cuenta en la tabla trabajador se guarda en la variable sesion el rol de la cuenta, el estado, su id y a que negocio pertenece

    $_SESSION['acceso'] = $datos2['acceso'];
    $_SESSION['estado'] = $datos2['estado'];
    $_SESSION['idnegocio'] = $datos2['negocios_idnegocios'];
    $_SESSION['id'] = $datos2['idtrabajador'];
    comprobar(null, null);
  } else if ($renglones != 0) {

    //si la consultalistar regresa un valor de renglones diferente a cero es por que el usuario logiado es el dueño de un negocio o mas

    $contador = 0;
    while ($result = mysqli_fetch_array($datos3)) {

      //conversion a un array asociativo y numerico el valor de la variable datos3 //esta funcion si hace asociativo a cada renglon que regrese la consulta

      $_SESSION['acceso'] = $result['acceso'];
      $_SESSION['estado'] = $result['estado'];
      $_SESSION['id'] = $result['id_clienteab'];

      //se almacena en la variable sesion los datos del usuario

      $negocio[$contador] = $result['nombre_negocio'];
      $id_negocio[$contador] = $result['idnegocios'];

      //en el array negocio se gurdan los nombres de cada negocio perteneciente al usuario y en el array idnegocio el id de cada negocio
      //la relacion de cada negocio con su id se hace por la pocicion de los arrays es decir al negocio[0] le pertenece el idnegocio[0]

      $contador++;
    }
    $datos3->close();
    comprobar($negocio, $id_negocio);
  } else echo "<script>alert('Datos Incorrectos');</script>";

  //si ninguna consulta regreso nada es por el el usuario y contraseña son incorrectos
}


if (isset($_GET['cerrar_sesion'])) {
  session_unset();
  session_destroy();
  header('location: index.php');

  //se destruye la sesion al dar click en los botones de salir
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="menu_back">
  <div class="container text-center">

    <div id="index_logo" class="row d-block">
      <img src="img/logo/2.png" alt="" id="logo" class="img-fluid">
    <div>

      <div id="index_form" class="card card-body row d-block col-md-4">
        <legend>Ingrese su usuario y contraseña:</legend>
        <form class="form-group" action="index.php" method="post">
          <input class="index_input form-control" type="text" name="nombre-us" placeholder="Usuario" autocomplete="off" required><br>
          <input class="index_input form-control" type="password" name="password" value="" placeholder="Contraseña" required><br>
          <input id="index_button" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="Login" value="Continuar">
        </form>
      </div>

  </div>
</body>

</html>
