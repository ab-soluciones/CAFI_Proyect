<?php
        session_start();
        require_once "Config/Autoload.php";
        Config\Autoload::run();

    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
        && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
        && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
        && isset($_POST['TLogin']) && isset($_POST['TPContraseña'])
    ) {
        $cliente = new Models\Clienteab();
        $cliente->setNombre($_POST['TNombre']);
        $cliente->setApaterno($_POST['TApellidoP']);
        $cliente->setAmaterno($_POST['TApellidoM']);
        $cliente->setDocumento($_POST['RDoc']);
        $cliente->setNumDoc($_POST['TNumDoc']);
        $cliente->setDireccion($_POST['TDireccion']);
        $cliente->setTelefono($_POST['TTelefono']);
        $cliente->setCorreo($_POST['TCorreo']);
        $cliente->setAcceso("CEO");
        $cliente->setLogin($_POST['TLogin']);
        $cliente->setPassword($_POST['TPContraseña']);
        $cliente->setEstado("A");
        $result = $cliente->guardar($_SESSION['id']);
        if ($result == 1) {
            header('Location: VClienteab.php');
        } else {
            header('Location: VClienteab.php');
        }
    }
    ?>