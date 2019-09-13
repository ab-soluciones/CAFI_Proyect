<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();

if(!empty($_POST)){
    
    if($_POST['action'] == 'datos_id_cliente'){
        $id_cliente = $_POST['id_cliente'];
   
       $query = "SELECT * FROM clientesab WHERE id_clienteab = '$id_cliente'";
        $result = $con->consultaRetorno($query);
        
           echo json_encode($result);
           exit;
    }
    if($_POST['action'] == 'datos_id_usuario_ab'){
        $id_usuarioAb = $_POST['id_usuario_ab'];

        $query = "SELECT * FROM usuariosab WHERE idusuariosab = '$id_usuarioAb'";
        $result = $con->consultaRetorno($query);
        
           echo json_encode($result);
           exit;
    }
    if($_POST['action'] == 'datos_id_suscripcion'){
        $id_subs = $_POST['id_suscripcion'];
        $query =  "SELECT fecha_activacion,fecha_vencimiento,suscripcion.estado,
        monto,nombre_negocio FROM suscripcion
        INNER JOIN negocios ON suscripcion.negocio_id = negocios.idnegocios
        WHERE suscripcion.idsuscripcion = '$id_subs'";
        $result = $con->consultaRetorno($query);
            echo json_encode($result);
            exit;
    }
    if($_POST['action'] == 'datos_id_negocio'){
        $id_negocio = $_POST['id_negocio'];
        $query =  $sql = "SELECT idnegocios,nombre_negocio,domicilio,ciudad,telefono_negocio,impresora,nombre,apaterno,amaterno FROM negocios
        INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
        where idnegocios = '$id_negocio'";
        $result = $con->consultaRetorno($query);
            echo json_encode($result);
            exit;

    }
}
?>