<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
}
if (
    isset($_POST['cantidad']) && isset($_POST['tipo']) && isset($_POST['formaImgreso']) 
    && isset($_POST['fecha']) && isset($_POST['estatus']) &&
    !empty($_POST['cantidad']) && !empty($_POST['tipo']) && !empty($_POST['formaImgreso']) 
    && !empty($_POST['fecha'])
) {
    $otro_ingreso = new Models\OtrosIngresos();
    $con = new Models\Conexion();
    $otro_ingreso->setIdOtrosIngresos(null);
    $otro_ingreso->setCantidad($con->eliminar_simbolos($_POST['cantidad']));
    $otro_ingreso->setTipo($con->eliminar_simbolos($_POST['tipo']));
    $otro_ingreso->setFormaIngreso($con->eliminar_simbolos($_POST['formaImgreso']));
    $otro_ingreso->setFecha($con->eliminar_simbolos($_POST['fecha']));
    $otro_ingreso->setEstado($con->eliminar_simbolos($_POST['estatus']));
    $result = $otro_ingreso->guardar($_SESSION['id'], $_SESSION['idnegocio']);
    echo $result;
}
if (
    isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['domicilio'])
    && isset($_POST['ciudad']) && isset($_POST['telefono']) && isset($_POST['impresora'])
    && isset($_POST['clienteab']) &&
    !empty($_POST['nombre']) && !empty($_POST['domicilio'])
    && !empty($_POST['ciudad']) && !empty($_POST['telefono'])

) {
    $con = new Models\Conexion();
    $idusuario = $_SESSION['id'];
    $clienteab = $con->eliminar_simbolos($_POST['clienteab']);
    $negocio = new Models\Negocio();
    $con = new Models\Conexion();
    $negocio->setNombre($con->eliminar_simbolos($_POST['nombre']));
    $negocio->setDomicilio($con->eliminar_simbolos($_POST['domicilio']));
    $negocio->setCiudad($con->eliminar_simbolos($_POST['ciudad']));
    $negocio->setTelefono($con->eliminar_simbolos($_POST['telefono']));
    $negocio->setImpresora($con->eliminar_simbolos($_POST['impresora']));
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
    && isset($_POST['acceso']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['estado'])  &&
    !empty($_POST['nombre']) && !empty($_POST['apt']) && !empty($_POST['apm']) &&
    !empty($_POST['login']) && !empty($_POST['password'])
) {
    $usab = new Models\Usuarioab();
    $con = new Models\Conexion();
    $usab->setNombre($con->eliminar_simbolos($_POST['nombre']));
    $usab->setApaterno($con->eliminar_simbolos($_POST['apt']));
    $usab->setAmaterno($con->eliminar_simbolos($_POST['apm']));
    $usab->setAcceso($con->eliminar_simbolos($_POST['acceso']));
    $usab->setLogin($con->eliminar_simbolos($_POST['login']));
    $usab->setPassword($con->eliminar_simbolos($_POST['password']));
    $usab->setEstado($con->eliminar_simbolos($_POST['estado']));
    $result = $usab->guardar();
    echo $result;
} else if (
    isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc'])
    && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['login'])
    && isset($_POST['password']) && isset($_POST['estado']) &&
    !empty($_POST['nombre']) && !empty($_POST['apt']) && !empty($_POST['apm']) && !empty($_POST['numdoc'])
    && !empty($_POST['dir']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['login'])
    && !empty($_POST['password'])
) {
    $idusuario = $_SESSION['id'];
    $cliente = new Models\Clienteab();
    $con = new Models\Conexion();
    $cliente->setNombre($con->eliminar_simbolos($_POST['nombre']));
    $cliente->setApaterno($con->eliminar_simbolos($_POST['apt']));
    $cliente->setAmaterno($con->eliminar_simbolos($_POST['apm']));
    $cliente->setDocumento($con->eliminar_simbolos($_POST['doc']));
    $cliente->setNumDoc($con->eliminar_simbolos($_POST['numdoc']));
    $cliente->setDireccion($con->eliminar_simbolos($_POST['dir']));
    $cliente->setTelefono($con->eliminar_simbolos($_POST['tel']));
    $cliente->setCorreo($con->eliminar_simbolos($_POST['email']));
    $cliente->setAcceso("CEO");
    $cliente->setLogin($con->eliminar_simbolos($_POST['login']));
    $cliente->setPassword($con->eliminar_simbolos($_POST['password']));
    $cliente->setEstado($con->eliminar_simbolos($_POST['estado']));
    $result = $cliente->guardar($idusuario);
    echo $result;
} else if(isset($_POST['id']) && isset($_POST['fecha1']) && !empty($_POST['fecha1']) && isset($_POST['fecha2']) && !empty($_POST['fecha2'])
&& isset($_POST['estado']) && !empty($_POST['estado']) && isset($_POST['negocio']) && !empty($_POST['negocio'])
&& isset($_POST['paquete']) && !empty($_POST['paquete']) && isset($_POST['monto'])){
    $con = new Models\Conexion();
    $sus = new Models\Suscripcion();
    $idusuario = $_SESSION['id'];
    $sus->setId($con->eliminar_simbolos($_POST['id']));
    $sus->setActivacion($con->eliminar_simbolos($_POST['fecha1']));
    $sus->setVencimiento($con->eliminar_simbolos($_POST['fecha2']));
    $sus->setEstado($con->eliminar_simbolos($_POST['estado']));
    $sus->setPaquete($con->eliminar_simbolos($_POST['paquete']));
    $sus->setMonto($con->eliminar_simbolos($_POST['monto']));
    $sus->setIdNegocio($con->eliminar_simbolos($_POST['negocio']));
    $result = $sus->guardar($idusuario);
    echo $result;
} else if (
    isset($_POST['concepto']) && isset($_POST['pago']) &&  isset($_POST['descripcion']) && isset($_POST['monto'])
    && isset($_POST['estado']) && isset($_POST['fecha']) &&
    !empty($_POST['concepto']) && !empty($_POST['pago']) && !empty($_POST['monto']) && !empty($_POST['fecha'])
) {
    $gasto = new Models\Gasto();
    $con = new Models\Conexion();
    $descripcion = $con->eliminar_simbolos($_POST['descripcion']);
    if (strlen($descripcion) === 0) {
        $descripcion = null;
    }
    $gasto->setConcepto($con->eliminar_simbolos($_POST['concepto']));
    $gasto->setPago($con->eliminar_simbolos($_POST['pago']));
    $gasto->setDescripcion($descripcion);
    $monto = $con->eliminar_simbolos($_POST['monto']);
    $monto = floatval($monto);
    $gasto->setMonto($monto);
    $gasto->setEstado($con->eliminar_simbolos($_POST['estado']));
    $gasto->setFecha($con->eliminar_simbolos($_POST['fecha']));
    $result = $gasto->guardar($_SESSION['idnegocio'], $_SESSION['id']);
    echo $result;
} else if (
    isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['documento'])
    && isset($_POST['numdoc']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email'])
    && isset($_POST['estado']) &&
    !empty($_POST['nombre']) && !empty($_POST['apt']) && !empty($_POST['apm']) && !empty($_POST['numdoc'])
    && !empty($_POST['direccion']) && !empty($_POST['telefono']) && !empty($_POST['email'])
) {
    $cliente = new Models\Cliente();
    $con = new Models\Conexion();
    $cliente->setNombre($con->eliminar_simbolos($_POST['nombre']));
    $cliente->setApaterno($con->eliminar_simbolos($_POST['apt']));
    $cliente->setAmaterno($con->eliminar_simbolos($_POST['apm']));
    $cliente->setDocumento($con->eliminar_simbolos($_POST['documento']));
    $cliente->setNumDoc($con->eliminar_simbolos($_POST['numdoc']));
    $cliente->setDireccion($con->eliminar_simbolos($_POST['direccion']));
    $cliente->setTelefono($con->eliminar_simbolos($_POST['telefono']));
    $cliente->setCorreo($con->eliminar_simbolos($_POST['email']));
    $cliente->setEstado($con->eliminar_simbolos($_POST['estado']));
    $result = $cliente->guardar($_SESSION['idnegocio'], $_SESSION['id']);
    echo $result;
} else if (
    isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc'])
    && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email'])
    && isset($_POST['acceso']) && isset($_POST['login']) && isset($_POST['agregarloa'])
    && isset($_POST['contrasena']) && isset($_POST['sueldo']) &&
    !empty($_POST['nombre']) && !empty($_POST['apt']) && !empty($_POST['apm']) && !empty($_POST['numdoc']) &&
    !empty($_POST['dir']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['login']) &&
    !empty($_POST['contrasena']) && !empty($_POST['sueldo'])
) {
    $trabajador = new Models\Trabajador(); // se hace la instancia a la clase trabajador
    $con = new Models\Conexion();
    $trabajador->setNombre($con->eliminar_simbolos($_POST['nombre']));
    $trabajador->setApaterno($con->eliminar_simbolos($_POST['apt']));
    $trabajador->setAmaterno($con->eliminar_simbolos($_POST['apm']));
    $trabajador->setDocumento($con->eliminar_simbolos($_POST['doc']));
    $trabajador->setNumDoc($con->eliminar_simbolos($_POST['numdoc']));
    $trabajador->setDireccion($con->eliminar_simbolos($_POST['dir']));
    $trabajador->setTelefono($con->eliminar_simbolos($_POST['tel']));
    $trabajador->setCorreo($con->eliminar_simbolos($_POST['email']));
    $trabajador->setAcceso($con->eliminar_simbolos($_POST['acceso']));
    $trabajador->setLogin($con->eliminar_simbolos($_POST['login']));
    $trabajador->setPassword($con->eliminar_simbolos($_POST['contrasena']));
    $sueldo = $con->eliminar_simbolos($_POST['sueldo']);
    $sueldo = floatval($sueldo);
    $trabajador->setSueldo($sueldo);
    $trabajador->setEstado($con->eliminar_simbolos($_POST['estado']));
    $result = $trabajador->guardar($con->eliminar_simbolos($_POST['agregarloa']));
    echo $result;
    
} else if (
    isset($_POST['codigo']) && isset($_POST['existencia']) && isset($_POST['precio']) && isset($_POST['cantidad']) &&
    !empty($_POST['existencia']) && !empty($_POST['precio']) && !empty($_POST['cantidad'])
) {
    $con = new Models\Conexion();
    if (is_null($_SESSION['idven'])) {
        $venta = new Models\Venta();
        $id = $venta->guardar();
        $_SESSION['idven'] = $id['id'];
    }
    $codigo = $_POST['codigo'];
    $existencia = (int) $con->eliminar_simbolos($_POST['existencia']);
    $precio = floatval($con->eliminar_simbolos($_POST['precio']));
    $cantidad = (int) $con->eliminar_simbolos($_POST['cantidad']);
    $con = new Models\Conexion();
    $query = "SELECT cantidad_producto FROM detalle_venta WHERE usuario = '$_SESSION[login]' AND idventa IS NULL AND producto_codigo_barras = '$codigo'";
    $result = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $cantidad = $cantidad + (int) $result['cantidad_producto'];

    if ($cantidad > $existencia) {
        echo "stock";
    } else {
        $dv = new Models\DetalleVenta();
        if (isset($result['cantidad_producto'])) {
            $cantidad = $result['cantidad_producto'] + $con->eliminar_simbolos($_POST['cantidad']);
            $costo = floatval($con->eliminar_simbolos($_POST['precio']));
            $subtotal = $cantidad * $costo;
            $dv->setUsuario($_SESSION['login']);
            $dv->setCantidad($cantidad);
            $dv->setSubtotal($subtotal);
            $dv->setCodigodeBarras($con->eliminar_simbolos($_POST['codigo']));
            $result = $dv->editar();
            echo $result;
        } else {
            $subtotal = $precio * $cantidad;
            $dv->setUsuario($_SESSION['login']);
            $dv->setCodigodeBarras($con->eliminar_simbolos($_POST['codigo']));
            $dv->setCantidad($con->eliminar_simbolos($_POST['cantidad']));
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
    isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio']) && isset($_POST['descuento']) && isset($_POST['formapago'])
    && !isset($_POST['totaldeuda']) && !isset($_POST['anticipo'])
) {
    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $total = $_POST['total'];
    $pago = $_POST['pago'];
    $cambio = $_POST['cambio'];
    $dv = new Models\DetalleVenta();
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
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
    $result2 = $venta->guardar();
    $sql = "SELECT MAX(idventas) AS id FROM venta";
    $ultimaventa = $con->consultaRetorno($sql);
    $con->cerrarConexion();
    $dv->setUsuario($_SESSION['login']);
    $dv->quitarNullIdVenta($ultimaventa['id']);
    $inventario->actualizarStock($ultimaventa['id'], $_SESSION['idnegocio']); //se actualiza el stock
    $_SESSION['clienteid'] = null;
    $_SESSION['idven'] = $ultimaventa['id'];
    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "Exitoprinter";
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "Exito";
    }
} else if (
    isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio'])
    && isset($_POST['totaldeuda']) && isset($_POST['anticipo']) && isset($_POST['descuento']) && isset($_POST['formapago'])
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
    $dv = new Models\DetalleVenta();
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
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
    $result2 = $venta->guardar();

    $sql = "SELECT MAX(idventas) AS id FROM venta";
    $ultimaventa = $con->consultaRetorno($sql);
    $con->cerrarConexion();
    $dv->setUsuario($_SESSION['login']);
    $dv->quitarNullIdVenta($ultimaventa['id']);
    $inventario->actualizarStock($ultimaventa['id'], $_SESSION['idnegocio']); //se actualiza el stock
    $_SESSION['idven'] = $ultimaventa['id'];
    $adeudo = new Models\Adeudo();
    $adeudo->setTotal($total_deuda);
    $adeudo->setPagoMinimo($abono);
    $adeudo->setEstado("A");
    $adeudo->setVenta($ultimaventa['id']);
    $adeudo->setNegocio($_SESSION['idnegocio']);
    $adeudo->setCliente($_SESSION['clienteid']);
    $adeudo->guardar();

    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "Exitoprinter";
        $_SESSION['clienteid'] = null;
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "Exito";
        $_SESSION['idven'] = null;
        $_SESSION['clienteid'] = null;
    }
} else if (isset($_POST['total']) && isset($_POST['formapago']) && isset($_POST['descuento']) && !isset($_POST['pago']) && !isset($_POST['cambio'])) {
    //si la venta fue con tarjeta solo se pasa el total de la venta
    $total = $_POST['total'];
    $forma_pago = $_POST['formapago'];
    $descuento = $_POST['descuento'];
    $dv = new Models\DetalleVenta();
    $inventario = new Models\Inventario();
    $venta = new Models\Venta();
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$_SESSION[idnegocio]'";
    $result = $con->consultaRetorno($query);
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
    $result2 = $venta->guardar(); //se modifican los datos de la venta ya que todos los campos estaban en null

    $sql = "SELECT MAX(idventas) AS id FROM venta";
    $ultimaventa = $con->consultaRetorno($sql);
    $con->cerrarConexion();
    $dv->setUsuario($_SESSION['login']);
    $dv->quitarNullIdVenta($ultimaventa['id']);
    $inventario->actualizarStock($ultimaventa['id'], $_SESSION['idnegocio']); //se actualiza el stock
    $_SESSION['idven'] = $ultimaventa['id'];
    if ($result['impresora'] === "A" && $result2 === 1) {
        echo "Exitoprinter";
    } else if ($result['impresora'] === "I" && $result2 === 1) {
        echo "Exito";
        $_SESSION['idven'] = null;
        $_SESSION['clienteid'] = null;
    }

    //se emprime el ticket
} else if (
    isset($_POST['abono']) && isset($_POST['pago']) && isset($_POST['adeudo'])
    && isset($_POST['total']) && isset($_POST['cambio']) && isset($_POST['formapago'])
) {
    $negocio = $_SESSION['idnegocio'];
    $con = new Models\Conexion();
    $query = "SELECT impresora FROM negocios WHERE idnegocios = '$negocio'";
    $resultado = $con->consultaRetorno($query);
    $con->cerrarConexion();
    $abono = new Models\Abono();
    $abono->setCantidad($_POST['abono']);
    $abono->setPago($_POST['pago']);
    $abono->setFormaPago($_POST['formapago']);
    $abono->setCambio($_POST['cambio']);
    $abono->setFecha();
    $abono->setHora();
    $abono->setNegocio($_SESSION['idnegocio']);
    $abono->setTrabajador($_SESSION['id']);
    $result = $abono->guardar($_POST['adeudo'], $_POST['total']);
    if ($resultado['impresora'] === "A" && $result === 1) {
        echo "Exitoprinter";
    } else if ($resultado['impresora'] === "I" && $result === 1) {
        echo "Exito";
    }
} else if (
    isset($_POST['cantidad']) && isset($_POST['de']) && isset($_POST['concepto']) && isset($_POST['descripcion']) &&
    !empty($_POST['cantidad']) && !empty($_POST['concepto'])
) {

    function retirar($concepto, $tipo, $cantidad, $descripcion)
    {
        $retiro = new Models\Retiro();
        $retiro->setConcepto($concepto);
        $retiro->setTipo($tipo);
        $retiro->setCantidad($cantidad);
        $retiro->setDescripcion($descripcion);
        $retiro->setFecha();
        $retiro->setHora();
        $retiro->setEstado("R");
        $retiro->setNegocio($_SESSION['idnegocio']);
        $retiro->setTrabajador($_SESSION['id']);
        $result = $retiro->guardar();
        echo $result;
    }
    $con = new Models\Conexion();
    $cantidad = $con->eliminar_simbolos($_POST['cantidad']);
    $concepto = $con->eliminar_simbolos($_POST['concepto']);
    $tipo = $con->eliminar_simbolos($_POST['de']);
    $descripcion = $con->eliminar_simbolos($_POST['descripcion']);
    $efectivo = $con->eliminar_simbolos($_POST['efectivo1']);
    $banco = $con->eliminar_simbolos($_POST['banco1']);

    if ($concepto == "Corte de caja" && $tipo == "Banco") {
        //se compara que la cantidad a retirar en efectivo no sea superior a la cantidad en en efectivo que hay en caja
        echo $result = "CorteErroneo";
    } else {
        if ($tipo == "Caja" && $cantidad <= $efectivo) {
            retirar($concepto, $tipo, $cantidad, $descripcion);
        } else if ($tipo == "Caja" && $cantidad > $efectivo) {
            echo $result = "SaldoInsufucienteCaja";
        } else if ($tipo == "Banco" && $cantidad <= $banco) {
            //se compara que la cantidad a retirar en banco no sea superior a la cantidad que hay en banco
            retirar($concepto, $tipo, $cantidad, $descripcion);
        } else if ($tipo == "Banco" && $cantidad > $banco) {
            echo $result = "SaldoInsufucienteBanco";
        }
    }
} else if (
    isset($_POST['TCodigoB']) && isset($_POST['TNombre']) && isset($_POST['TColor']) && isset($_POST['TMarca']) &&
    isset($_POST['TADescription']) && isset($_POST['DLUnidad']) && isset($_POST['TTipoP']) &&
    isset($_POST['SlcTalla']) && isset($_POST['SlcMedida']) && isset($_POST['TPrecioC']) && isset($_POST['TPrecioVen']) &&
    !empty($_POST['TNombre'])  && !empty($_POST['TColor']) && !empty($_POST['TMarca']) && !empty($_POST['TPrecioC'])
    && !empty($_POST['TPrecioVen'])
) {
    function registrar($imagen, $negocio)
    {
        $producto = new Models\Producto();
        $con = new Models\Conexion();
        if (strlen($_POST['TCodigoB']) === 0) {
            $numRand = rand(1000000, 9999999);
            $numRand2 = rand(100000, 999999);
            $codigob = $numRand . $numRand2;
        } else {
            $codigob  = $_POST['TCodigoB'];
        }

        $descripcion = $_POST['TADescription'];

        if (strlen($descripcion) === 0) {
            $descripcion = "";
        }

        $producto->setCodigoBarras($codigob);
        $producto->setNombre($con->eliminar_simbolos($_POST['TNombre']));
        $producto->setImagen($imagen);
        $producto->setColor($con->eliminar_simbolos($_POST['TColor']));
        $producto->setMarca($con->eliminar_simbolos($_POST['TMarca']));
        $producto->setDescripcion($descripcion);
        $producto->setUnidad_Medida($_POST['DLUnidad']);
        if ($_POST['TTipoP'] === "Calzado") {
            $producto->setTalla_numero($_POST['SlcMedida']);
        } else if ($_POST['TTipoP'] === "Ropa") {
            $producto->setTalla_numero($_POST['SlcTalla']);
        }else if($_POST['TTipoP'] === "Otro"){
            $producto->setTalla_numero("N.A");
    }
        $producto->setTipo($con->eliminar_simbolos($_POST['TTipoP']));
        $producto->setPrecioCompra($con->eliminar_simbolos($_POST['TPrecioC']));
        $producto->setPrecioVenta($con->eliminar_simbolos($_POST['TPrecioVen']));
        $producto->setPestado($con->eliminar_simbolos($_POST['REstado']));
        $query = "SELECT clientesab_idclienteab FROM negocios WHERE idnegocios = '$negocio'";
        $result2 = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $clienteab = $result2['clientesab_idclienteab'];
        $result = $producto->guardar($clienteab, $_SESSION['id']);
        echo $result;
    }

    if (strlen($_FILES['FImagen']['tmp_name']) != 0) {
        //si el usuario cargó un archivo
        //se optiene la ruta
        $tipo_imagen = $_FILES['FImagen']['type'];
        //se optine la extencion de la imagen
        $bytes = $_FILES['FImagen']['size'];
        //se optiene el tamaño de la imagen
        if ($bytes <= 1000000) {
            //si la imagen es menor a 1 mega se comprueba la extencion, si la extencion es igual a alguna de la condiconal se registra la imagen
            if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                $temp = explode(".", $_FILES["FImagen"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $imagen2 = "http://test.cafionline.com/img/productos/" . $newfilename . "";
                $carpeta_destino = "img/productos/";
                move_uploaded_file($_FILES["FImagen"]["tmp_name"], $carpeta_destino . $newfilename);
                $negocio = $_SESSION['idnegocio'];

                registrar($imagen2, $negocio);
            } else {
                echo "imagenNoValida";
            }
        } else {
            echo "imagenGrande";
        }
    } else {
        $negocio = $_SESSION['idnegocio'];
        registrar("", $negocio);
    }
} else if (
    isset($_POST['SCantidad']) && isset($_POST['DlProductos']) &&
    !empty($_POST['SCantidad']) && !empty($_POST['DlProductos'])
) {

    $con = new Models\Conexion();
    $inventario = new Models\Inventario();
    $inventario->setCantidad($con->eliminar_simbolos($_POST['SCantidad']));
    $inventario->setCodigoB($con->eliminar_simbolos($_POST['DlProductos']));
    $codigob = $inventario->getCodigoBarras();
    $inventario->setNegocio($_SESSION['idnegocio']);
    $inventario->setTrabajador($_SESSION['id']);
    $query = "SELECT producto_codigo_barras FROM inventario WHERE producto_codigo_barras = '$codigob' AND negocios_idnegocios = '$_SESSION[idnegocio]'";
    $datos = $con->consultaRetorno($query);
    if ($datos['producto_codigo_barras'] != "") {
        echo "yaExiste";
    } else {
        $result = $inventario->guardar();
        echo $result;
    }
}
