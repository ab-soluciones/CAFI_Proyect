<?php
    require_once "Config/Autoload.php";
    Config\Autoload::run();
    session_start();
    if (!isset($_SESSION['acceso'])) {
        header('location: index.php');
    } else if ($_SESSION['estado'] == "I") {
        header('location: index.php');
    } else if (
        $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
    ) {
        header('location: index.php');
    }
    $con = new Models\Conexion();
    $negocios = $_SESSION['idnegocio'];
    $query = "SELECT idabono,abono.estado AS a_estado,cantidad,pago,cambio,fecha,hora,cliente.nombre AS nombre_cliente,
                        cliente.apaterno AS ap_cliente, cliente.amaterno AS am_cliente,trabajador.nombre,
                        trabajador.apaterno, adeudos_id FROM abono
                        INNER JOIN adeudos ON abono.adeudos_id=adeudos.idadeudos
                        INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente
                        INNER JOIN trabajador ON trabajador.idtrabajador=abono.trabajador_idtrabajador
                        WHERE adeudos.negocios_idnegocios = '$negocios'
                        ORDER BY adeudos_id DESC";
    $row = $con->consultaListar($query);
    $json = array();
    while ($renglon = mysqli_fetch_array($row)) {
        $json[] = array(
            'id' =>  $renglon['idabono'],
            'a_estado' => $renglon['a_estado'],
            'cantidad' => $renglon['cantidad'],
            'pago' => $renglon['pago'],
            'cambio' =>  $renglon['cambio'],
            'fecha' =>  $renglon['fecha'],
            'hora' =>  $renglon['hora'],
            'nombre_cliente' =>  $renglon['nombre_cliente'] ." ".$renglon['ap_cliente']. " ". $renglon['am_cliente'],
            'nombre' =>  $renglon['nombre'] . " ".$renglon['apaterno'],
            'adeudos_id' =>  $renglon['adeudos_id']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;

?>