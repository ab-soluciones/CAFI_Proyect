<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sweetalert.css">
  <link rel="stylesheet" href="css/animations.css">
  <script src="js/sweetalert.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/jquery.js"></script>

  <script type="text/javascript">

  </script>
</head>

<body id="menu_back">
  <div class="container text-center">

    <div id="index_logo" class="row d-block">
      <img src="img/logo/1.png" alt="" id="logo" class="animaLogo">
      <div>

        <div id="index_form" class="card card-body row d-block col-md-4">
          <legend>Ingrese su usuario y contraseña:</legend>
          <form class="form-group" action="index.php" method="post">
            <input id="user" class="index_input form-control" type="text" pattern= "[A-Za-z0-9_-@.]{1,15}" name="nombre-us" placeholder="Usuario" autocomplete="off" required ><br>
            <input id="password" class="index_input form-control" pattern= "[A-Za-z0-9_-@.]{1,15}"type="password" name="password" value="" placeholder="Contraseña" required ><br>
            <input id="index_button" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="Login" value="Continuar">
          </form>
        </div>

      </div>
      <script src="js/index.js"></script>
</body>

</html>
<?php

/*El mayor porcentaje del codigo del sistema se basa en un CRUD atraves de formularios php,
 no estarán comentados todos los archivos de CRUD para evitar comentar con ambiguedad, solo se comentarán
las partes de los CRUD en donde se hagan procedimientos diferentes.. El CRUD Comentado es el CRUD de trabajador*/

session_start();
// Generate token

date_default_timezone_set("America/Mexico_City");
function getDateTime()
{
  $año = date("Y");
  $mes = date("m");
  $dia = date("d");
  $fecha = $año . "-" . $mes . "-" . $dia;
  $hora = date("H");
  $minuto = date("i");
  $segundo = date("s");
  $hora = $hora . ":" . $minuto . ":" . $segundo;

  return  $fecha . " " . $hora;
}

function getToken($length)
{
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet .= "0123456789";
  $max = strlen($codeAlphabet); // edited

  for ($i = 0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max - 1)];
  }

  return $token;
}


require_once "Config/Autoload.php";
Config\Autoload::run();
if (isset($_SESSION['acceso']) && strcasecmp($_SESSION['estado'], "A") == 0) {
  $con = new Models\Conexion();
  $datetime = getDateTime();
  $con->consultaSimple("UPDATE sesiones SET fin = '$datetime' WHERE usuario='$_SESSION[login]'");
  $con->cerrarConexion();
  session_unset();
  session_destroy();
  header('location: index.php');
}

function comprobar()
{
  if (
    // roles de los usuariosab = CEOAB, ManagerAB, rol de los clientesab = CEO, rol de los trabajadores = Manager, Employes

    strcasecmp($_SESSION['acceso'], "Manager") == 0 && strcasecmp($_SESSION['estado'], "A") == 0
    || strcasecmp($_SESSION['acceso'], "Employes") == 0  && strcasecmp($_SESSION['estado'], "A") == 0

    //se comprueban los strings a nivel de bits con la funcion strcasecmp. Si el usuario es manager o employe se redirige a la ventana de principal de opciones

  ) {
    header('Location: VVentas.php');
  } else if (
    strcasecmp($_SESSION['acceso'], "CEO") == 0
    && strcasecmp($_SESSION['estado'], "A") == 0

    //si es CEO se redirige a la pagina principal de opciones o a la pagina de seleccion de negocio

  ) {
    header("Location: VTrabajador.php");
    //si solo es un negocio, se redirige al usuario a la pagina de opciones directamente

  } else if (
    strcasecmp($_SESSION['acceso'], "CEOAB") == 0 && strcasecmp($_SESSION['estado'], "A" == 0)

  ) {

    //si el rol pertenece a los usuariosab se les redirige a su pagina de opciones

    header('Location: VUsuarios_ab.php');
  } else if (strcasecmp($_SESSION['acceso'], "ManagerAB") == 0 && strcasecmp($_SESSION['estado'], "A" == 0)) {

    header('Location: VClienteab.php');
  } else if (isset($_SESSION['acceso']) && strcasecmp($_SESSION['estado'], "I") == 0) {
    ?>
    <script>
      swal({
          title: 'Acceso denegado al sistema',
          text: 'Cuenta desactivada',
          type: 'warning'
        },
        function(isConfirm) {
          if (isConfirm) {

          }
        });
    </script>
  <?php

    }
  }


  if (isset($_POST['nombre-us']) && isset($_POST['password'])) {

    //Optencion del nombre de usuario y contraseña por medio del metodo post

    $comprobar = new Models\Comprobar();
    $comprobar->comprobarFv();

    /*Ejecucion de la funcion comprobar de la clase Comprobar.. su tarea es cambiar a estado inactivo
   la cuenta del dueño del negocio y las cuentas de todos los trabajadores pertenecientes a dicho negocio
   cuando la fecha actual sea igual a la fecha de vencimiento de la suscripcion */
    $con = new Models\Conexion();

    $nombre =  $con->eliminar_simbolos($_POST['nombre-us']);
    $password =  $con->eliminar_simbolos($_POST['password']);


    //Consultas para comprobar si existe una cuenta con el nombre de usuario y contraseña optenida.

    $query = "SELECT login,acceso,estado,idusuariosab FROM usuariosab WHERE  BINARY login= '$nombre' AND  BINARY  password='$password'";
    $query2 = "SELECT login,acceso,estado,negocios_idnegocios,idtrabajador FROM trabajador WHERE  BINARY  login= '$nombre' AND  BINARY password='$password'";
    $query3 = "SELECT acceso,estado,id_clienteab FROM clientesab WHERE login = '$nombre' AND password ='$password'";
    $datos1 = $con->consultaRetorno($query);
    $datos2 = $con->consultaRetorno($query2);
    $datos3 = $con->consultaRetorno($query3);
    //la funcion consultaRetorno de la clase conexion regresa un array asociativo, son usadas en el sistema para consultas que regresan un solo renglon como resultado


    $con->cerrarConexion();

    if (isset($datos1)) {
      //si existe una cuenta en la tabla usuariosab se guarda en la variable sesion el rol de la cuenta el estado y su id

      //se inicializa las variables globales
      $_SESSION['comboID'] = null;
      $_SESSION['idven'] = null;

      $_SESSION['login'] = $datos1['login'];
      $_SESSION['acceso'] = $datos1['acceso'];
      $_SESSION['estado'] = $datos1['estado'];
      $_SESSION['id'] = $datos1['idusuariosab'];


      $token = getToken(10);
      $_SESSION['token'] = $token;
      $datetime = getDateTime();

      // Update user token 
      $con = new Models\Conexion();
      $result_token = $con->consultaRetorno("SELECT id FROM sesiones WHERE usuario='$_SESSION[login]'");

      if (isset($result_token['id'])) {
        $con->consultaSimple("UPDATE sesiones SET token='$token', inicio = '$datetime' WHERE usuario='$_SESSION[login]'");
      } else {
        $con->consultaSimple("INSERT INTO sesiones(usuario,token,inicio) VALUES('$_SESSION[login]','$token','$datetime')");
      }

      $con->cerrarConexion();

      comprobar();

      /*esta funcion comprueba el rol/acceso de la cuenta para mandar al usuario al apartado correspodiente
    en caso de que se logie un dueño/clienteab la funcion recibe como parametro dos arreglos,
    uno con el nombre de cada negocio perteneciente al dueño y otro con el id, estos arreglos son utilizados para que el usuario
    seleccione en que negocio registrara trabajadores o consultara informacion financiera  */
    } else if (isset($datos2)) {

      //si existe una cuenta en la tabla trabajador se guarda en la variable sesion el rol de la cuenta, el estado, su id y a que negocio pertenece

      //se inicializa las variables globales
      $_SESSION['comboID'] = null;
      $_SESSION['idven'] = null;
      $_SESSION['login'] = $datos2['login'];
      $_SESSION['acceso'] = $datos2['acceso'];
      $_SESSION['estado'] = $datos2['estado'];
      $_SESSION['idnegocio'] = $datos2['negocios_idnegocios'];
      $_SESSION['id'] = $datos2['idtrabajador'];

      $token = getToken(10);
      $_SESSION['token'] = $token;
      $datetime = getDateTime();

      // Update user token 
      $con = new Models\Conexion();
      $result_token = $con->consultaRetorno("SELECT id FROM sesiones WHERE usuario='$_SESSION[login]'");

      if (isset($result_token['id'])) {
        $con->consultaSimple("UPDATE sesiones SET token='$token',inicio = '$datetime' WHERE usuario='$_SESSION[login]'");
      } else {
        $con->consultaSimple("INSERT INTO sesiones(usuario,token,inicio) VALUES('$_SESSION[login]','$token','$datetime')");
      }
      $con->cerrarConexion();

      comprobar();
    } else if (isset($datos3)) {
      //se inicializa las variables globales
      $_SESSION['comboID'] = null;
      $_SESSION['login'] = $datos3['login'];
      $_SESSION['acceso'] = $datos3['acceso'];
      $_SESSION['estado'] = $datos3['estado'];
      $_SESSION['id'] = $datos3['id_clienteab'];
      $_SESSION['idnegocio'] = null;

      $token = getToken(10);
      $_SESSION['token'] = $token;
      $datetime = getDateTime();
      // Update user token 
      $con = new Models\Conexion();
      $result_token = $con->consultaRetorno("SELECT id FROM sesiones WHERE usuario='$_SESSION[login]'");

      if (isset($result_token['id'])) {
        $con->consultaSimple("UPDATE sesiones SET token='$token', inicio = '$datetime' WHERE usuario='$_SESSION[login]'");
      } else {
        $con->consultaSimple("INSERT INTO sesiones(usuario,token,inicio) VALUES('$_SESSION[login]','$token','$datetime')");
      }

      $con->cerrarConexion();

      comprobar();
    } else {
      ?>
    <script>
      swal({
          title: 'Datos Incorrectos',
          text: 'Compruebe su usuario y contraseña',
          type: 'warning'
        },
        function(isConfirm) {
          if (isConfirm) {

          }
        });
    </script>
<?php
  }

  //si ninguna consulta regreso nada es por el el usuario y contraseña son incorrectos
}


if (isset($_GET['cerrar_sesion'])) {
  session_unset();
  session_destroy();
  header('location: index.php');

  //se destruye la sesion al dar click en los botones de salir
}



?>