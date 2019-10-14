<?php
if (isset($_SESSION['login'])) {
  $con = new Models\Conexion();
  $result = $con->consultaRetorno("SELECT token FROM sesiones WHERE usuario='$_SESSION[login]'");

  if (isset($result['token'])) {

    $token = $result['token'];

    if ($_SESSION['token'] != $token) {
      header('Location: index.php');
    }
  }
}
