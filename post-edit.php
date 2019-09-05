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
}else if(
        isset($_POST['concepto']) && isset($_POST['pago']) &&  isset($_POST['descripcion']) && isset($_POST['monto']) && isset($_POST['estado'])
         && isset($_POST['fecha'])
    ){
        $id = $_POST['id'];
        $gasto = new Models\Gasto();
        $trabajador = $_SESSION['id'];
        $gasto->setConcepto($_POST['concepto']);
        $gasto->setPago($_POST['pago']);
        $gasto->setDescripcion($_POST['descripcion']);
        $monto = $_POST['monto'];
        $monto = floatval($monto);
        $gasto->setMonto($monto);
        $gasto->setEstado($_POST['estado']);
        $gasto->setFecha($_POST['fecha']);
        $result = $gasto->editar($id, $trabajador);
        echo $result;
    }else if (
        isset($_POST['cantidad']) && isset($_POST['tipo']) && isset($_POST['formaImgreso']) && isset($_POST['fecha'])  && isset($_POST['estatus'])
        ){
                $otro_ingreso = new Models\OtrosIngresos();
                $otro_ingreso->setIdOtrosIngresos($_POST['id']);
                $otro_ingreso->setCantidad($_POST['cantidad']);
                $otro_ingreso->setTipo($_POST['tipo']);
                $otro_ingreso->setFormaIngreso($_POST['formaImgreso']);
                $otro_ingreso->setFecha($_POST['fecha']);
                $otro_ingreso->setEstado($_POST['estatus']);
                $trabajador = $_SESSION['id'];
                $result = $otro_ingreso->editar($trabajador);
                echo $result;
        } else if (
                isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['documento']) 
                && isset($_POST['numdoc']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['estado'])
            ){
                $id = $_POST['id'];
                $cliente = new Models\Cliente();
                $trabajador = $_SESSION['id'];
                $cliente->setNombre($_POST['nombre']);
                $cliente->setApaterno($_POST['apt']);
                $cliente->setAmaterno($_POST['apm']);
                $cliente->setDocumento($_POST['documento']);
                $cliente->setNumDoc($_POST['numdoc']);
                $cliente->setDireccion($_POST['direccion']);
                $cliente->setTelefono($_POST['telefono']);
                $cliente->setCorreo($_POST['email']);
                $cliente->setEstado($_POST['estado']);
                $result = $cliente->editar($id, $trabajador);
                echo $result;
        } else if (
                isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc']) 
                && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['acceso']) 
                && isset($_POST['login']) && isset($_POST['agregarloa']) && isset($_POST['contrasena']) && isset($_POST['sueldo'])
        ){
                $trabajador = new Models\Trabajador();
                $trabajador->setNombre($_POST['nombre']);
                $trabajador->setApaterno($_POST['apt']);
                $trabajador->setAmaterno($_POST['apm']);
                $trabajador->setDocumento($_POST['doc']);
                $trabajador->setNumDoc($_POST['numdoc']);
                $trabajador->setDireccion($_POST['dir']);
                $trabajador->setTelefono($_POST['tel']);
                $trabajador->setCorreo($_POST['email']);
                $trabajador->setAcceso($_POST['acceso']);
                $trabajador->setLogin($_POST['login']);
                $trabajador->setPassword($_POST['contrasena']);
                $sueldo = $_POST['sueldo'];
                $sueldo = floatval($sueldo);
                $trabajador->setSueldo($sueldo);
                $trabajador->setEstado($_POST['estado']);
                $result = $trabajador->editar($_POST['id']);
                echo $result;
        }
