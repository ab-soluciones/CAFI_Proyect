<?php

use Models\DetalleVenta;

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
} else if (
        isset($_POST['concepto']) && isset($_POST['pago']) &&  isset($_POST['descripcion']) && isset($_POST['monto']) && isset($_POST['estado'])
        && isset($_POST['fecha'])
) {
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
} else if (
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
        } else if( isset($_POST['estado']) && isset($_POST['id'])){
        
        $trabajador = $_SESSION['id'];
        $retiro = new Models\Retiro();
        $retiro->setEstado($_POST['estado']);
        $retiro->setTrabajador($trabajador);
        $result = $retiro->editar($_POST['id']);
        echo $result;
} else if(
        isset($_POST['TCodigoB']) && isset($_POST['TNombre']) && isset($_POST['TColor']) && isset($_POST['TMarca']) &&
        isset($_POST['TADescription']) && isset($_POST['DLUnidad']) && isset($_POST['TTipoP']) &&
        isset($_POST['SlcTalla']) && isset($_POST['SlcMedida']) && isset($_POST['TPrecioC']) && isset($_POST['TPrecioVen']) &&
        isset($_POST['SCantidad']) && isset($_POST['REstado'])
){
        function registrar($imagen, $id){
            $producto = new Models\Producto();
            $producto->setNombre($_POST['TNombre']);
            $producto->setImagen($imagen);
            $producto->setColor($_POST['TColor']);
            $producto->setMarca($_POST['TMarca']);
            $producto->setDescripcion($_POST['TADescription']);
            $producto->setCantidad($_POST['SCantidad']);
            $producto->setUnidad_Medida($_POST['DLUnidad']);
            if ($_POST['TTipoP'] === "Calzado") {
                $producto->setTalla_numero($_POST['SlcMedida']);
            } else if ($_POST['TTipoP'] === "Ropa") {
                $producto->setTalla_numero($_POST['SlcTalla']);
            }
            $producto->setTipo($_POST['TTipoP']);
            $producto->setPrecioCompra($_POST['TPrecioC']);
            $producto->setPrecioVenta($_POST['TPrecioVen']);
            $producto->setCodigoBarras($_POST['TCodigoB']);
            $producto->setPestado($_POST['REstado']);
            $result = $producto->editar($_POST['TCodigoB'],$_SESSION['id']);
                echo $result;
            
        }
        
        if (strlen($_FILES['FImagen']['tmp_name']) != 0) {

                $tipo_imagen = $_FILES['FImagen']['type'];
                $bytes = $_FILES['FImagen']['size'];
                if ($bytes <= 1000000) {
                    if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                        $temp = explode(".", $_FILES["FImagen"]["name"]);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        $imagen2 = "http://localhost/CAFI_System/img/productos/".$newfilename."";
                        $carpeta_destino = "img/productos/";
                        move_uploaded_file($_FILES["FImagen"]["tmp_name"],$carpeta_destino.$newfilename);
                        $negocio = $_SESSION['idnegocio'];
                        registrar($imagen2,$_POST['TCodigoB']);

                    } else{
                    echo "imagenNoValida";
                    }
                } else{
                    echo "imagenGrande";
                } 
            }else{
                $query = "SELECT imagen FROM producto WHERE codigo_barras = ".$_POST['TCodigoB'];
                $con = new Models\Conexion();
                $result2 = $con->consultaRetorno($query);
                $con->cerrarConexion();
                $negocio = $_SESSION['idnegocio'];
                registrar($result2['imagen'] ,$_POST['TCodigoB']);
            }
} else if ( isset($_POST['idAbono']) &&  isset($_POST['estadoActual']) &&  isset($_POST['estadoNuevo'])){
        $id = $_POST['idAbono'];
        $estado = $_POST['estadoActual'];
        $idusuario = $_SESSION['id'];

            $adeudo = new Models\Adeudo();
            if ($estado == "R" && $_POST['estadoNuevo'] == "C") {
                $result = $adeudo->editarTotalEstadoC($id, $idusuario);
                echo $result;
            } else if ($estado == "C" && $_POST['estadoNuevo'] == "R") {
                $result = $adeudo->editarTotalEstadoR($id, $idusuario);
                echo $result;
            }
        
} else if ( isset($_POST['idConsulta']) &&  isset($_POST['estadoActualConsulta']) &&  isset($_POST['estadoNuevoConsulta'])){

        $id = $_POST['idConsulta'];
        $estado = $_POST['estadoActualConsulta'];
        $negocio = $_SESSION['idnegocio'];
        if (isset($_POST['estadoNuevoConsulta'])) {
            $trabajador = $_SESSION['id'];
            $v = new Models\Venta();
            $inventario = new Models\Inventario();
            $v->setEstado($_POST['estadoNuevoConsulta']);
            if ($estado == "R" && $_POST['estadoNuevoConsulta'] == "C") {
                $inventario->actualizarStock2($id,$negocio);
                $v->setTrabajador($trabajador);
                $adeudo = "L";
                $result = $v->editarEstadoV($id, $adeudo);
                echo $result;
            } else if ($estado == "C" && $_POST['estadoNuevoConsulta'] == "R") {
                $inventario->actualizarStock($id,$negocio);
                $v->setTrabajador($trabajador);
                $adeudo = "A";
                $result = $v->editarEstadoV($id, $adeudo);
                echo $result;
            }
        }
} 
