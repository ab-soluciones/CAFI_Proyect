<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RAcceso']) &&
        isset($_POST['TLogin']) && isset($_POST['TPContraseña']) && isset($_POST['REstado'])
    ) {
        $id = $_POST['id_usuario'];
        $usab = new Models\Usuarioab();
        $usab->setNombre($_POST['TNombre']);
        $usab->setApaterno($_POST['TApellidoP']);
        $usab->setAmaterno($_POST['TApellidoM']);
        $usab->setAcceso($_POST['RAcceso']);
        $usab->setLogin($_POST['TLogin']);
        $usab->setPassword($_POST['TPContraseña']);
        $usab->setEstado($_POST['REstado']);
        $result = $usab->editar($id);
        if ($result == 1) {
            header ('Location: VUsuarios_ab.php');
        } else{
            header ('Location: VUsuarios_ab.php');
        }
    }
