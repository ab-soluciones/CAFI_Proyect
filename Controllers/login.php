<?php
session_start();
require_once '../Models/Conexion.php';
if(isset($_POST['Pcontrasena']) && isset($_POST['Temail'])){
$conexion = new Models\Conexion();

$login = array();
array_push($login,
           $conexion->eliminar_simbolos($_POST['Temail']) , 
           $conexion->eliminar_simbolos($_POST['Pcontrasena'])
      
);
$consulta="SELECT email,acceso,entrada_sistema FROM usuarioscafi WHERE BINARY  email = ?  AND BINARY contrasena = ?";
$tipo_datos="ss";
$respuesta = json_encode($conexion->consultaPreparada($login,$consulta,2,$tipo_datos));
if($respuesta === "[]"){
    $consulta="SELECT email,acceso,entrada_sistema FROM usuariosab WHERE BINARY  email = ?  AND BINARY contrasena = ?";
    $tipo_datos="ss";
    $respuesta = json_encode($conexion->consultaPreparada($login,$consulta,2,$tipo_datos));
}
if($respuesta != "[]"){
    $_SESSION['email'] 
}
 echo $respuesta;

}