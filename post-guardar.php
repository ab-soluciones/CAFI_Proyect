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
    $result = $negocio->guardar($idusuario);
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
    $result = $usab->guardar();
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
    $result = $cliente->guardar($idusuario);
    echo $result;
} else if (isset($_POST['id']) && isset($_POST['fecha1']) && isset($_POST['fecha2']) && isset($_POST['estado']) && isset($_POST['negocio']) && isset($_POST['monto'])) {
    $sus = new Models\Suscripcion();
    $idusuario = $_SESSION['id'];
    $sus->setId($_POST['id']);
    $sus->setActivacion($_POST['fecha1']);
    $sus->setVencimiento($_POST['fecha2']);
    $sus->setEstado($_POST['estado']);
    $sus->setMonto($_POST['monto']);
    $sus->setIdNegocio($_POST['negocio']);
    $result = $sus->guardar($idusuario);
} else if (
    isset($_POST['concepto']) && isset($_POST['pago']) &&  isset($_POST['descripcion']) && isset($_POST['monto']) && isset($_POST['estado'])
    && isset($_POST['fecha'])
) {
    $gasto = new Models\Gasto();
    $descripcion = $_POST['descripcion'];
    if (strlen($descripcion) === 0) {
        $descripcion = null;
    }

    $gasto->setConcepto($_POST['concepto']);
    $gasto->setPago($_POST['pago']);
    $gasto->setDescripcion($descripcion);
    $monto = $_POST['monto'];
    $monto = floatval($monto);
    $gasto->setMonto($monto);
    $gasto->setEstado("estado");
    $gasto->setFecha($_POST['fecha']);
    $result = $gasto->guardar($_SESSION['idnegocio'], $_SESSION['id']);
    echo $result;
} else if (
    isset($_POST['cantidad']) && isset($_POST['tipo']) && isset($_POST['formaImgreso']) && isset($_POST['fecha']) && isset($_POST['estatus'])
) {
    $otro_ingreso = new Models\OtrosIngresos();
    $otro_ingreso->setIdOtrosIngresos(null);
    $otro_ingreso->setCantidad($_POST['cantidad']);
    $otro_ingreso->setTipo($_POST['tipo']);
    $otro_ingreso->setFormaIngreso($_POST['formaImgreso']);
    $otro_ingreso->setFecha($_POST['fecha']);
    $otro_ingreso->setEstado($_POST['estatus']);
    $result = $otro_ingreso->guardar($_SESSION['id'], $_SESSION['idnegocio']);
    echo $result;
} else if (
    isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['documento'])
    && isset($_POST['numdoc']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['estado'])
) {
    $cliente = new Models\Cliente();
    $cliente->setNombre($_POST['nombre']);
    $cliente->setApaterno($_POST['apt']);
    $cliente->setAmaterno($_POST['apm']);
    $cliente->setDocumento($_POST['documento']);
    $cliente->setNumDoc($_POST['numdoc']);
    $cliente->setDireccion($_POST['direccion']);
    $cliente->setTelefono($_POST['telefono']);
    $cliente->setCorreo($_POST['email']);
    $cliente->setEstado($_POST['estado']);
    $result = $cliente->guardar($_SESSION['idnegocio'], $_SESSION['id']);
    echo $result;
} else if (
    isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc'])
    && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['acceso'])
    && isset($_POST['login']) && isset($_POST['agregarloa']) && isset($_POST['contrasena']) && isset($_POST['sueldo'])
) {
    $trabajador = new Models\Trabajador(); // se hace la instancia a la clase trabajador
    $trabajador->setNombre($_POST['nombre']); //se pasan a los atributos de la clase todos los valores del formulario por el metodo set
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
    $result = $trabajador->guardar($_POST['agregarloa']);
    echo $result;
} else if (
    isset($_POST['codigo']) && isset($_POST['existencia']) && isset($_POST['precio']) && isset($_POST['cantidad'])
) {
    if (is_null($_SESSION['idven'])) {
        $venta = new Models\Venta();
        $id = $venta->guardar();
        $_SESSION['idven'] = $id['id'];
    }
    $codigo = $_POST['codigo'];
    $existencia = (int) $_POST['existencia'];
    $precio = floatval($_POST['precio']);
    $cantidad = (int) $_POST['cantidad'];

    if ($cantidad > $existencia) {
        echo "stock";
    } else {
        $dv = new Models\DetalleVenta();
        $con = new Models\Conexion();
        $query = "SELECT subtotal FROM detalle_venta WHERE producto_codigo_barras ='$codigo' AND idventa ='$_SESSION[idven]'";
        $result = $con->consultaRetorno($query);
        if (isset($result['subtotal'])) {
            echo "producto existente";
        } else {
            $subtotal = $precio * $cantidad;
            $dv->setVenta($_SESSION['idven']);
            $dv->setCodigodeBarras($_POST['codigo']);
            $dv->setCantidad($_POST['cantidad']);
            $dv->setSubtotal($subtotal);
            $result = $dv->guardar();
            echo $result;
        }
    }
} else if (isset($_POST['idcliente']) && isset($_POST['estcliente'])) {

    if ($_POST['estcliente'] === "A") {
        $_SESSION['clienteid'] = $_POST['idcliente'];
    } else {
        echo "no agregado a la sesion";
    }
} else if (
    isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio'])  && isset($_POST['descuento'])  && isset($_POST['formapago'])
    && !isset($_POST['totaldeuda']) && !isset($_POST['anticipo'])
) {
    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $total = $_POST['total'];
    $pago = $_POST['pago'];
    $cambio = $_POST['cambio'];
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $idventa = (int) $_SESSION['idven'];
    $inventario->actualizarStock($idventa, $_SESSION['idnegocio']); //se actualiza el stock
    $venta->setDescuento($_POST['descuento']);
    $venta->setTotal($total);
    $venta->setPago($pago);
    $venta->setFormaPago($_POST['formapago']);
    $venta->setCambio($cambio);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $result2 = $venta->editar($idventa);
    $_SESSION['clienteid'] = null;
    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "con impresora";
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "sin impresora";
        $_SESSION['idven'] = null;
    }
} else if (
    isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio']) 
    && isset($_POST['totaldeuda']) && isset($_POST['anticipo']) && isset($_POST['descuento'])  && isset($_POST['formapago'])
) {
    /*si la venta es a credito se actualizan los datos de la tabla venta y se crea un nuevo registro en la tabla 
    adeudos con el total de la deuda y con el pago minimo/anticipo/o abono como pago minimo */
    $total = $_POST['total'];
    $pago = $_POST['pago'];
    $cambio = $_POST['cambio'];
    $total_deuda = $_POST['totaldeuda'];
    $abono = $_POST['anticipo'];
    $descuento = $_POST['descuento'];
    $forma_pago = $_POST['formapago'];
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $idventa = (int) $_SESSION['idven'];
    $inventario->actualizarStock($idventa, $_SESSION['idnegocio']); //se actualiza el stock
    $venta->setDescuento($descuento);
    $venta->setTotal($total);
    $venta->setPago($pago);
    $venta->setFormaPago($forma_pago);
    $venta->setCambio($cambio);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $result2 = $venta->editar($idventa);
    $adeudo = new Models\Adeudo();
    $adeudo->setTotal($total_deuda);
    $adeudo->setPagoMinimo($abono);
    $adeudo->setEstado("A");
    $adeudo->setVenta($idventa);
    $adeudo->setNegocio($_SESSION['idnegocio']);
    $adeudo->setCliente($_SESSION['clienteid']);
    $adeudo->guardar();
    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "con impresora";
        $_SESSION['clienteid'] = null;
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "sin impresora";
        $_SESSION['idven'] = null;
        $_SESSION['clienteid'] = null;
    }
}else if (isset($_POST['total']) && isset($_POST['formapago'])  && isset($_POST['descuento']) && !isset($_POST['pago']) && !isset($_POST['cambio'])) {
    //si la venta fue con tarjeta solo se pasa el total de la venta
    $total = $_POST['total'];
    $forma_pago = $_POST['formapago'];
    $descuento = $_POST['descuento'];
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $idventa = (int) $_SESSION['idven'];
    $inventario->actualizarStock($idventa, $_SESSION['idnegocio']); //se actualiza el stock
    $venta->setDescuento($descuento);
    $venta->setTotal($total);
    $venta->setPago($total);
    $venta->setFormaPago($forma_pago);
    $venta->setCambio(null);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $result2 = $venta->editar($idventa); //se modifican los datos de la venta ya que todos los campos estaban en null
    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "con impresora";
        $_SESSION['clienteid'] = null;
        $_SESSION['clienteid'] = null;
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "sin impresora";
        $_SESSION['idven'] = null;
        $_SESSION['clienteid'] = null;
    }
   
    //se emprime el ticket
}
