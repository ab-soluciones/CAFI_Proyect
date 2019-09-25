<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();

$con = new Models\Conexion();
$datos= array();
$query='INSERT INTO prueva VALUES(?,?,?)';
array_push($datos,'Uno',883,3.90);
$result = $con->executeStatements(1,$datos,$query);
echo $result;
?>