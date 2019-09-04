<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['domicilio'])
        && isset($_POST['ciudad']) && isset($_POST['telefono']) && isset($_POST['impresora'])
        && isset($_POST['clienteab'])
) {
        $idusuario = $_SESSION['id'];
        $clienteab = $_POST['clienteab'];
        $negocio = new Models\Negocio();
        $con = new Models\Conexion();
        $negocio->setNombre($_POST['nombre']);
        $negocio->setDomicilio($_POST['domicilio']);
        $negocio->setCiudad($_POST['ciudad']);
        $negocio->setTelefono($_POST['telefono']);
        $negocio->setImpresora($_POST['impresora']);
        $query = "SELECT id_clienteab FROM clientesab WHERE (SELECT CONCAT(nombre,
        ' ', apaterno,' ' ,amaterno))='$clienteab'";
        $idc = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $idc = (int) $idc['id_clienteab'];
        $negocio->setIdCliente($idc);
        $result = $negocio->editar($_POST['id'], $idusuario);
        echo $result;
} else if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm'])
        && isset($_POST['acceso']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['estado'])
) {
        $usab = new Models\Usuarioab();
        $usab->setNombre($_POST['nombre']);
        $usab->setApaterno($_POST['apt']);
        $usab->setAmaterno($_POST['apm']);
        $usab->setAcceso($_POST['acceso']);
        $usab->setLogin($_POST['login']);
        $usab->setPassword($_POST['password']);
        $usab->setEstado($_POST['estado']);
        $result = $usab->editar($_POST['id']);
        echo $result;
} else if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc'])
        && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['login'])
        && isset($_POST['password']) && isset($_POST['estado'])

) {
        $idusuario = $_SESSION['id'];
        $cliente = new Models\Clienteab();
        $cliente->setNombre($_POST['nombre']);
        $cliente->setApaterno($_POST['apt']);
        $cliente->setAmaterno($_POST['apm']);
        $cliente->setDocumento($_POST['doc']);
        $cliente->setNumDoc($_POST['numdoc']);
        $cliente->setDireccion($_POST['dir']);
        $cliente->setTelefono($_POST['tel']);
        $cliente->setCorreo($_POST['email']);
        $cliente->setLogin($_POST['login']);
        $cliente->setPassword($_POST['password']);
        $cliente->setEstado($_POST['estado']);
        $result = $cliente->editar($_POST['id'], $idusuario);
        echo $result;
} else if (isset($_POST['id']) && isset($_POST['fecha1']) && isset($_POST['fecha2']) && isset($_POST['estado']) && isset($_POST['negocio']) && isset($_POST['monto'])) {
        $sus = new Models\Suscripcion();
        $idusuario = $_SESSION['id'];
        $sus->setId($_POST['id']);
        $sus->setActivacion($_POST['fecha1']);
        $sus->setVencimiento($_POST['fecha2']);
        $sus->setEstado($_POST['estado']);
        $sus->setMonto($_POST['monto']);
        $result = $sus->editar($idusuario);
        echo $result;
}
