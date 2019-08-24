<?php
require_once "config.php";

// Submitted form data
$form = $_POST['contactFrmSubmit'];
$accion = $_POST['accion'];
$num = $_POST['num'];
$cuenta = $_POST['cuenta'];
$cantidad = $_POST['cantidad'];
$solicitud = $_POST['solicitud'];

if(isset($form) && (!empty($accion)=="agregar") && !empty($cuenta) && !empty($cantidad) && !empty($solicitud)){

    $consulta = "INSERT INTO cpp (Num, Solicitud, Cuenta, Cantidad) VALUES ('', '$solicitud', '$cuenta', '$cantidad')";    
    $result = mysqli_query($link, $consulta);

    //Send status
    if($result){
        $status = "ok";
    }else{
        $status = "err";
    }
    // Output status
    echo $status;
    die;
}else if(isset($form) && (!empty($accion)=="eliminar") && !empty($num)){
    
    $consulta = "DELETE FROM cpp WHERE Num = '$num'";
    $result = mysqli_query($link, $consulta);

    //Send status
    if($result){
        $status = "ok";
    }else{
        $status = "err";
    }
    // Output status
    echo $status;
    die;
}