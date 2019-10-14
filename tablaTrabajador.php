<?php 
    require_once "Config/Autoload.php";
    Config\Autoload::run();
    session_start();
    if (!isset($_SESSION['acceso'])) {
        header('location: index.php');
    } else if ($_SESSION['estado'] == "I") {
        header('location: index.php');
    } else if (
        $_SESSION['acceso'] != "CEO"
    ) {
        header('location: index.php');
    }
    $con = new Models\Conexion();
    $idnegocio =  $_SESSION['idnegocio'];
    $query = "SELECT * FROM trabajador WHERE negocios_idnegocios = '$idnegocio' ORDER BY idtrabajador DESC";
    $row = $con->consultaListar($query);
    $con->cerrarConexion();
    $json = array();
    while ($renglon = mysqli_fetch_array($row)) {
        $json[] = array(
            'id' =>  $renglon['idtrabajador'],
            'nombre' => $renglon['nombre'],
            'apaterno' =>  $renglon['apaterno'],
            'amaterno' =>  $renglon['amaterno'],
            'tipo_documento' =>  $renglon['tipo_documento'],
            'numero_documento' =>  $renglon['numero_documento'],
            'direccion' =>  $renglon['direccion'],
            'telefono' => $renglon['telefono'],
            'correo' => $renglon['correo'],
            'acceso' => $renglon['acceso'],
            'login' => $renglon['login'],
            'password' => $renglon['password'],
            'sueldo' => $renglon['sueldo'],
            'estado' => $renglon['estado'],
            'negocios_idnegocios' => $renglon['negocios_idnegocios']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>