<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
//se optienen las cantidades que hay en banco y en efectivo
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
    && $_SESSION['acceso'] != "CEO"
) {
    header('location: index.php');
}
$con = new Models\Conexion();
$negocio = $_SESSION['idnegocio'];

$query = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
WHERE estado_venta='R' AND idnegocios ='$negocio' GROUP BY forma_pago";
$result = $con->consultaListar($query);

$ventas_efectivo = 0;
$ventas_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_pago'] === "Efectivo") {
        $ventas_efectivo = $renglon['totalventas'];
    } else if ($renglon['forma_pago'] === "Tarjeta") {
        $ventas_banco = $renglon['totalventas'];
    }
}
$query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos INNER JOIN venta ON adeudos.ventas_idventas=venta.idventas
WHERE negocios_idnegocios =' $negocio ' AND estado_deuda = 'A'";
$result = $con->consultaRetorno($query);
$anticipos_efectivo = $result['anticipos'];

$query = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono
WHERE forma_pago='Efectivo' AND estado='R' AND negocios_idnegocios ='$negocio' GROUP BY forma_pago ";
$result = $con->consultaListar($query);

$abonos_efectivo = 0;
$abonos_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_pago'] === "Efectivo") {
        $abonos_efectivo = $renglon['totalabonos'];
    } else if ($renglon['forma_pago'] === "Tarjeta") {
        $abonos_banco = $renglon['totalabonos'];
    }
}


$ventas_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos_efectivo;
$ventas_banco = $ventas_banco +  $abonos_banco;

$query = "SELECT pago, SUM(monto) AS totalgastos  FROM gastos WHERE pago='Efectivo' AND estado='A' AND negocios_idnegocios ='$negocio' GROUP BY pago";
$result = $con->consultaListar($query);

$gastos_efectivo = 0;
$gastos_tarjeta = 0;
$gastos_transferencia = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['pago'] === "Efectivo") {
        $gastos_efectivo = $renglon['totalgastos'];
    } else if ($renglon['pago'] === "Tarjeta") {
        $gastos_tarjeta = $renglon['totalgastos'];
    } else if ($renglon['pago'] === "Transferencia") {
        $gastos_transferencia = $renglon['totalgastos'];
    }
}
$gastos_banco = $gastos_tarjeta + $gastos_transferencia;

$query = "SELECT forma_ingreso, SUM(cantidad) AS oingresos  FROM otros_ingresos WHERE forma_ingreso ='Efectivo'
AND estado='A' AND negocios_idnegocios ='$negocio' GROUP BY forma_ingreso";
$result = $con->consultaListar($query);

$otros_ingresos_efectivo = 0;
$otros_ingresos_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_ingreso'] === "Efectivo") {
        $otros_ingresos_efectivo = $renglon['oingresos'];
    } else if ($renglon['forma_ingreso'] === "Banco") {
        $otros_ingresos_banco = $renglon['oingresos'];
    }
}

$query = "SELECT tipo, SUM(cantidad) AS retiro FROM retiros WHERE
negocios_idnegocios ='$negocio' AND estado='R' GROUP BY tipo";
$result = $con->consultaListar($query);

$retiros_efectivo = 0;
$retiros_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['tipo'] === "Caja") {
        $retiros_efectivo = $renglon['retiro'];
    } else if ($renglon['tipo'] === "Banco") {
        $retiros_banco = $renglon['retiro'];
    }
}

$efectivo = $otros_ingresos_efectivo + $ventas_efectivo - $gastos_efectivo - $retiros_efectivo;
$banco = $otros_ingresos_banco + $ventas_banco - $gastos_banco - $retiros_banco;
$con->cerrarConexion();

$json = array();
$json[] = array(
    'efectivo' => $efectivo,
    'banco' => $banco,
);
$jsonstring = json_encode($json);
echo $jsonstring;
?>