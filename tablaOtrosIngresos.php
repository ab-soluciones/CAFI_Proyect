<?php 
 session_start();
 require_once "Config/Autoload.php";
 Config\Autoload::run();

 $negocio = $_SESSION['idnegocio'];
 $con = new Models\Conexion();
 $query = "SELECT * FROM otros_ingresos WHERE negocios_idnegocios ='$negocio' ORDER BY id_otros_ingresos DESC";
 $row = $con->consultaListar($query);
 $con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) { 
    $json[] = array(
        'id' =>  $renglon['id_otros_ingresos'],
        'cantidad' => $renglon['cantidad'],
        'tipo' => $renglon['tipo'],
        'forma_ingreso' => $renglon['forma_ingreso'],
        'fecha' =>  $renglon['fecha'],
        'estado' =>  $renglon['estado'],
        'trabajador_idpersona' =>  $renglon['trabajador_idpersona'],
        'negocios_idnegocios' =>  $renglon['negocios_idnegocios'],
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
?>