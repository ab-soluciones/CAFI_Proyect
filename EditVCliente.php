<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();

    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
        && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
        && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
        && isset($_POST['REstado'])
    ) {
        $id = $_POST['id_clienteab'];
        echo $id.'<br>';
        echo $_POST['REstado'].'<br>';
        $cliente = new Models\Cliente();
        $trabajador = $_SESSION['id'];
        echo $trabajador.'<br>';
        $cliente->setNombre($_POST['TNombre']);
        echo 'Nombre: ' .$_POST['TNombre'].'<br>';
        $cliente->setApaterno($_POST['TApellidoP']);
        echo 'ApellidoP: ' .$_POST['TApellidoP'].'<br>';
        $cliente->setAmaterno($_POST['TApellidoM']);
        echo 'ApellidoM: ' .$_POST['TApellidoM'].'<br>';
        $cliente->setDocumento($_POST['RDoc']);
        echo 'Doc: ' .$_POST['RDoc'].'<br>';
        $cliente->setNumDoc($_POST['TNumDoc']);
        echo 'Num: ' .$_POST['TNumDoc'].'<br>';
        $cliente->setDireccion($_POST['TDireccion']);
        echo 'Direccion: ' .$_POST['TDireccion'].'<br>';
        $cliente->setTelefono($_POST['TTelefono']);
        echo 'Telefono: ' .$_POST['TTelefono'].'<br>';
        $cliente->setCorreo($_POST['TCorreo']);
        echo 'Correo: ' .$_POST['TCorreo'].'<br>';
        $cliente->setEstado($_POST['REstado']);
        $result = $cliente->editar($id, $trabajador);
        echo $result;   
        if ($result == 1) {
            header('Location: VClienteab.php');
        } else {
            
        } 
    } 
    ?>
