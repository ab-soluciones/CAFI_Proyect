<?php

use Models\DetalleVenta;

require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
        header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
        header('location: index.php');
}
if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['domicilio'])
        && isset($_POST['ciudad']) && isset($_POST['telefono']) && isset($_POST['impresora'])
        && isset($_POST['clienteab'])
) {
        $con = new Models\Conexion();
        $idusuario = $_SESSION['id'];
        $clienteab = $con->eliminar_simbolos($_POST['clienteab']);
        $negocio = new Models\Negocio();
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
        $result = $negocio->editar($_POST['id'], $idusuario);
        echo $result;
} else if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm'])
        && isset($_POST['acceso']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['estado'])
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
        $result = $usab->editar($con->eliminar_simbolos($_POST['id']));
        echo $result;
} else if (
        isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc'])
        && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['login'])
        && isset($_POST['password']) && isset($_POST['estado'])
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
        $cliente->setLogin($con->eliminar_simbolos($_POST['login']));
        $cliente->setPassword($con->eliminar_simbolos($_POST['password']));
        $cliente->setEstado($con->eliminar_simbolos($_POST['estado']));
        $result = $cliente->editar($con->eliminar_simbolos($_POST['id']), $idusuario);
        echo $result;
} else if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['fecha1']) && !empty($_POST['fecha1']) && isset($_POST['fecha2']) && !empty($_POST['fecha2'])
&& isset($_POST['estado']) && !empty($_POST['estado']) && isset($_POST['negocio'])
&& isset($_POST['paquete']) && !empty($_POST['paquete']) && isset($_POST['monto'])  && isset($_POST['usextra']))  {

        $con = new Models\Conexion();
        $sus = new Models\Suscripcion();
        $idusuario = $_SESSION['id'];
        $sus->setId($con->eliminar_simbolos($_POST['id']));
        $sus->setActivacion($con->eliminar_simbolos($_POST['fecha1']));
        $sus->setVencimiento($con->eliminar_simbolos($_POST['fecha2']));
        $sus->setEstado($con->eliminar_simbolos($_POST['estado']));
        $sus->setPaquete($con->eliminar_simbolos($_POST['paquete']));
        $sus->setUsuarioExtra($con->eliminar_simbolos($_POST['usextra']));
        $sus->setMonto($con->eliminar_simbolos($_POST['monto']));
        if($_POST['estado'] === "A"){
         $result = $sus->ponerSuscripcionActiva($idusuario);
        }else if($_POST['estado'] === "I"){
         $result = $sus->ponerSuscripcionInactiva($idusuario);
        }
       

        echo $result;
} else if (
        isset($_POST['concepto']) && isset($_POST['pago']) &&  isset($_POST['descripcion']) && isset($_POST['monto'])
        && isset($_POST['estado']) && isset($_POST['fecha'])
) {
        $id = $_POST['id'];
        $con = new Models\Conexion();
        $gasto = new Models\Gasto();
        $trabajador = $_SESSION['id'];
        $gasto->setConcepto($con->eliminar_simbolos($_POST['concepto']));
        $gasto->setPago($con->eliminar_simbolos($_POST['pago']));
        $gasto->setDescripcion($con->eliminar_simbolos($_POST['descripcion']));
        $monto = $con->eliminar_simbolos($_POST['monto']);
        $monto = floatval($monto);
        $gasto->setMonto($monto);
        $gasto->setEstado($con->eliminar_simbolos($_POST['estado']));
        $gasto->setFecha($con->eliminar_simbolos($_POST['fecha']));
        $result = $gasto->editar($id, $trabajador);
        echo $result;
} else if (
        isset($_POST['cantidad']) && isset($_POST['tipo']) && isset($_POST['formaImgreso']) && isset($_POST['fecha'])
        && isset($_POST['estatus'])
) {
        $otro_ingreso = new Models\OtrosIngresos();
        $con = new Models\Conexion();
        $otro_ingreso->setIdOtrosIngresos($con->eliminar_simbolos($_POST['id']));
        $otro_ingreso->setCantidad($con->eliminar_simbolos($_POST['cantidad']));
        $otro_ingreso->setTipo($con->eliminar_simbolos($_POST['tipo']));
        $otro_ingreso->setFormaIngreso($con->eliminar_simbolos($_POST['formaImgreso']));
        $otro_ingreso->setFecha($con->eliminar_simbolos($_POST['fecha']));
        $otro_ingreso->setEstado($con->eliminar_simbolos($_POST['estatus']));
        $trabajador = $_SESSION['id'];
        $result = $otro_ingreso->editar($trabajador);
        echo $result;
} else if (
        isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['documento'])
        && isset($_POST['numdoc']) && isset($_POST['direccion']) && isset($_POST['telefono'])
        && isset($_POST['email']) && isset($_POST['estado'])
) {
        $id = $_POST['id'];
        $cliente = new Models\Cliente();
        $con = new Models\Conexion();
        $trabajador = $_SESSION['id'];
        $cliente->setNombre($con->eliminar_simbolos($_POST['nombre']));
        $cliente->setApaterno($con->eliminar_simbolos($_POST['apt']));
        $cliente->setAmaterno($con->eliminar_simbolos($_POST['apm']));
        $cliente->setDocumento($con->eliminar_simbolos($_POST['documento']));
        $cliente->setNumDoc($con->eliminar_simbolos($_POST['numdoc']));
        $cliente->setDireccion($con->eliminar_simbolos($_POST['direccion']));
        $cliente->setTelefono($con->eliminar_simbolos($_POST['telefono']));
        $cliente->setCorreo($con->eliminar_simbolos($_POST['email']));
        $cliente->setEstado($con->eliminar_simbolos($_POST['estado']));
        $result = $cliente->editar($id, $trabajador);
        echo $result;
} else if (
                isset($_POST['nombre']) && isset($_POST['apt']) && isset($_POST['apm']) && isset($_POST['doc']) 
                && isset($_POST['numdoc']) && isset($_POST['dir']) && isset($_POST['tel']) && isset($_POST['email']) 
                && isset($_POST['acceso']) && isset($_POST['login']) && isset($_POST['agregarloa']) && 
                isset($_POST['contrasena']) && isset($_POST['sueldo'])
        ){
                $trabajador = new Models\Trabajador();
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
                $result = $trabajador->editar($con->eliminar_simbolos($_POST['id']),$_POST['agregarloa'],$_POST['estado']);
                echo $result;
} else if (
        isset($_POST['estado']) && isset($_POST['id'])
) {
        $con = new Models\Conexion();
        $trabajador = $_SESSION['id'];
        $retiro = new Models\Retiro();
        $retiro->setEstado($con->eliminar_simbolos($_POST['estado']));
        $retiro->setTrabajador($trabajador);
        $result = $retiro->editar($con->eliminar_simbolos($_POST['id']));
        echo $result;
} else if (
        isset($_POST['TCodigoB']) && isset($_POST['TNombre']) && isset($_POST['TColor']) && isset($_POST['TMarca']) &&
        isset($_POST['TADescription']) && isset($_POST['DLUnidad']) && isset($_POST['TTipoP'])  && isset($_POST['TPrecioC']) && isset($_POST['TPrecioVen']) &&
        isset($_POST['SCantidad']) && isset($_POST['REstado'])
) {
        function registrar($imagen, $id)
        {
                
                $producto = new Models\Producto();
                $con = new Models\Conexion();
                $producto->setNombre($con->eliminar_simbolos($_POST['TNombre']));
                $producto->setImagen($imagen);
                $producto->setColor($con->eliminar_simbolos($_POST['TColor']));
                $producto->setMarca($con->eliminar_simbolos($_POST['TMarca']));
                $producto->setDescripcion($con->eliminar_simbolos($_POST['TADescription']));
                $producto->setCantidad($con->eliminar_simbolos($_POST['SCantidad']));
                $producto->setUnidad_Medida($con->eliminar_simbolos($_POST['DLUnidad']));
                if ($_POST['TTipoP'] === "Calzado") {
                        $producto->setTalla_numero($_POST['SlcMedida']);
                } else if ($_POST['TTipoP'] === "Ropa") {
                        $producto->setTalla_numero($_POST['SlcTalla']);
                } else if($_POST['TTipoP'] == "Otro"){
                        $producto->setTalla_numero("N.A");
                }
                $producto->setTipo($con->eliminar_simbolos($_POST['TTipoP']));
                $producto->setPrecioCompra($con->eliminar_simbolos($_POST['TPrecioC']));
                $producto->setPrecioVenta($con->eliminar_simbolos($_POST['TPrecioVen']));
                $producto->setCodigoBarras($con->eliminar_simbolos($_POST['TCodigoB']));
                $producto->setPestado($con->eliminar_simbolos($_POST['REstado']));
                $result = $producto->editar($con->eliminar_simbolos($_POST['TCodigoB']), $_SESSION['id']);
                echo $result;
        }
        
        if (strlen($_FILES['FImagen']['tmp_name']) != 0) {
                
                $tipo_imagen = $_FILES['FImagen']['type'];
                $bytes = $_FILES['FImagen']['size'];
                if ($bytes <= 1000000) {
                        if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                                $temp = explode(".", $_FILES["FImagen"]["name"]);
                                $newfilename = round(microtime(true)) . '.' . end($temp);
                                $imagen2 = "http://localhost/CAFI_System/img/productos/" . $newfilename . "";
                                $carpeta_destino = "img/productos/";
                                move_uploaded_file($_FILES["FImagen"]["tmp_name"], $carpeta_destino . $newfilename);
                                $negocio = $_SESSION['idnegocio'];
                                registrar($imagen2,$_POST['TCodigoB']);
                        } else {
                                echo "imagenNoValida";
                        }
                } else {
                        echo "imagenGrande";
                }
        } else {
                
                $query = "SELECT imagen FROM producto WHERE codigo_barras = " . $_POST['TCodigoB'];
                $con = new Models\Conexion();
                $result2 = $con->consultaRetorno($query);
                $con->cerrarConexion();
                $negocio = $_SESSION['idnegocio'];
                registrar($result2['imagen'], $_POST['TCodigoB']);
        }
} else if (
        isset($_POST['idAbono']) &&  isset($_POST['estadoActual']) &&  isset($_POST['estadoNuevo'])
) {
        $con = new Models\Conexion();
        $id = $con->eliminar_simbolos($_POST['idAbono']);
        $estado = $con->eliminar_simbolos($_POST['estadoActual']);

        $idusuario = $_SESSION['id'];

        $adeudo = new Models\Adeudo();
        if ($estado == "R" && $_POST['estadoNuevo'] == "C") {
                $result = $adeudo->editarTotalEstadoC($id, $idusuario);
                echo $result;
        } else if ($estado == "C" && $_POST['estadoNuevo'] == "R") {
                $result = $adeudo->editarTotalEstadoR($id, $idusuario);
                echo $result;
        }
} else if (
        isset($_POST['idConsulta']) &&  isset($_POST['estadoActualConsulta']) &&  isset($_POST['estadoNuevoConsulta'])
) {

        $id = $_POST['idConsulta'];
        $estado = $_POST['estadoActualConsulta'];
        $negocio = $_SESSION['idnegocio'];

        $trabajador = $_SESSION['id'];
        $v = new Models\Venta();
        $inventario = new Models\Inventario();
        $v->setEstado($_POST['estadoNuevoConsulta']);
        if ($estado == "R" && $_POST['estadoNuevoConsulta'] == "C") {
                $inventario->actualizarStock2($id, $negocio);
                $v->setTrabajador($trabajador);
                $adeudo = "C";
                $result = $v->editarEstadoV($id, $adeudo);
                echo $result;
        } else if ($estado == "C" && $_POST['estadoNuevoConsulta'] == "R") {
                $inventario->actualizarStock($id, $negocio);
                $v->setTrabajador($trabajador);
                $adeudo = "A";
                $result = $v->editarEstadoV($id, $adeudo);
                echo $result;
        }
}
