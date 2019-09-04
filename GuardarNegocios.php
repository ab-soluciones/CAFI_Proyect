<?php
    require_once "Config/Autoload.php";
    Config\Autoload::run();
    session_start();

    if (
        isset($_POST['TNombre']) && isset($_POST['TDomicilio']) &&
        isset($_POST['TCiudad']) && isset($_POST['DlCliente']) &&
        isset($_POST['TTelefono']) && isset($_POST['RImpresora'])
    ) {

        $negocio = new Models\Negocio();
        $con = new Models\Conexion();
        $idusuario = $_SESSION['id'];
        $negocio->setNombre($_POST['TNombre']);
        $negocio->setDomicilio($_POST['TDomicilio']);
        $negocio->setCiudad($_POST['TCiudad']);
        $negocio->setTelefono($_POST['TTelefono']);
        $nombre = $_POST['DlCliente'];
        $negocio->setImpresora($_POST['RImpresora']);
        $query = "SELECT id_clienteab FROM clientesab WHERE(SELECT CONCAT(clientesab.nombre,' ', clientesab.apaterno,' ' ,clientesab.amaterno))='$nombre'";
        $id = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $id = (int) $id['id_clienteab'];
        $negocio->setIdCliente($id);
        $result = $negocio->guardar($idusuario);
        if ($result == 1) {
            header('Location: VNegociosab.php');
        } else {
            header('Location: VNegociosab.php');
        }
    }
        ?>