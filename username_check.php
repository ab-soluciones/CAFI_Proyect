<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

if(isset($_POST['username'])){
$con = new Models\Conexion();
$username = $_POST['username'];

 $query = "SELECT login FROM trabajador WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;"> <b>'.$username.'</b> Este usuario ya existe! </div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;"> <b>'.$username.'</b> Usuario disponible! </div>';
 }
}

if(isset($_POST['username2'])){
    $con = new Models\Conexion();
    $username = $_POST['username2'];

 $query = "SELECT login FROM usuariosab WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;"> <b>'.$username.'</b> Este usuario ya existe! </div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;"> <b>'.$username.'</b> Usuario disponible! </div>';
 }
}

if(isset($_POST['username3'])){
    $con = new Models\Conexion();
    $username = $_POST['username3'];

 $query = "SELECT login FROM clientesab WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;"> <b>'.$username.'</b> Este usuario ya existe! </div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;"> <b>'.$username.'</b> Usuario disponible! </div>';
 }
}
?>