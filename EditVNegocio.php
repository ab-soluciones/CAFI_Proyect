<?php

    require_once "Config/Autoload.php";
    Config\Autoload::run();
    session_start();

    if (
        isset($_POST['TNombre']) && isset($_POST['TDomicilio']) &&
        isset($_POST['TCiudad']) && isset($_POST['DlCliente']) &&
        isset($_POST['TTelefono']) && isset($_POST['RImpresora'])
    ) {
        $idusuario = $_SESSION['id'];
        $id = $_POST['id_negocio'];
         var_dump($id);
        $nombres = $_POST['DlCliente'];
        $negocio = new Models\Negocio();
        $con = new Models\Conexion();
        $negocio->setNombre($_POST['TNombre']);
        $negocio->setDomicilio($_POST['TDomicilio']);
        $negocio->setCiudad($_POST['TCiudad']);
        $negocio->setTelefono($_POST['TTelefono']);
        $negocio->setImpresora($_POST['RImpresora']);
        $query = "SELECT id_clienteab FROM clientesab WHERE (SELECT CONCAT(nombre,
        ' ', apaterno,' ',amaterno))='$nombres'";
        $idc = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $idc = (int) $idc['id_clienteab'];
        $negocio->setIdCliente($idc);
        $result = $negocio->editar($id, $idusuario);
        if ($result == 1) {
            header('Location: VNegociosab.php');
        } else {
           
        }
    }
?>