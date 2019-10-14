<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
$con = new Models\Conexion();
$data = json_decode($_POST['array']);
//var_dump($data);
$cont = 0;

$datos = array();
foreach($data as $k => $v) {
    if($v != ""){
        if($cont <= 4){
            array_push($datos,$con->eliminar_simbolos($v));
            $cont++;
            if($cont == 5){
                //Aqui va el codigo de registro

                $cont=0;
                $datos = array();
            }
        }
    }

}
?>