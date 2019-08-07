<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if (is_null($_SESSION['idven'])) {
    header('location: VVender.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "CEO" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}
if (isset($_GET['total']) && !isset($_GET['pago'])) {
    //si la venta fue con tarjeta solo se pasa el total de la venta
    $total = $_GET['total'];
    $pro = new Models\Producto();
    $venta = new Models\Venta();
    $idventa = (int) $_SESSION['idven'];
    $pro->actualizarStock($idventa); //se actualiza el stock
    $venta->setDescuento($_SESSION['descuento']);
    $venta->setTotal($total);
    $venta->setPago($total);
    $venta->setFormaPago($_SESSION['forma_pago']);
    $venta->setCambio(null);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $venta->editar($idventa); //se modifican los datos de la venta ya que todos los campos estaban en null
    $_SESSION['idven'] = null;
    $_SESSION['forma_pago'] = null;
    $_SESSION['clienteid'] = null;
    header("location: ticket.php?idventa=$idventa");
    //se emprime el ticket
}
if (
    isset($_GET['total']) && isset($_GET['pago']) && isset($_GET['cambio'])
    && !isset($_GET['totald']) && !isset($_GET['abono'])
) {
    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $total = $_GET['total'];
    $pago = $_GET['pago'];
    $cambio = $_GET['cambio'];
    $pro = new Models\Producto();
    $venta = new Models\Venta();
    $idventa = (int) $_SESSION['idven'];
    $pro->actualizarStock($idventa);
    $venta->setDescuento($_SESSION['descuento']);
    $venta->setTotal($total);
    $venta->setPago($pago);
    $venta->setFormaPago($_SESSION['forma_pago']);
    $venta->setCambio($cambio);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $venta->editar($idventa);
    $_SESSION['idven'] = null;
    $_SESSION['forma_pago'] = null;
    $_SESSION['clienteid'] = null;
    header("location: ticket.php?idventa=$idventa");
}
if (
    isset($_GET['total']) && isset($_GET['pago']) && isset($_GET['cambio'])
    && isset($_GET['totald']) && !is_null($_SESSION['clienteid']) && isset($_GET['abono'])
) {
    /*si la venta es a credito se actualizan los datos de la tabla venta y se crea un nuevo registro en la tabla 
    adeudos con el total de la deuda y con el pago minimo/anticipo/o abono como pago minimo */
    $total = $_GET['total'];
    $pago = $_GET['pago'];
    $cambio = $_GET['cambio'];
    $total_deuda = $_GET['totald'];
    $abono = $_GET['abono'];
    $pro = new Models\Producto();
    $venta = new Models\Venta();
    $idventa = (int) $_SESSION['idven'];
    $pro->actualizarStock($idventa);
    $venta->setDescuento($_SESSION['descuento']);
    $venta->setTotal($total);
    $venta->setPago($pago);
    $venta->setFormaPago($_SESSION['forma_pago']);
    $venta->setCambio($cambio);
    $venta->setFecha();
    $venta->setHora();
    $venta->setEstado('R');
    $venta->setTrabajador($_SESSION['id']);
    $venta->setNegocio($_SESSION['idnegocio']);
    $venta->editar($idventa);
    $adeudo = new Models\Adeudo();
    $adeudo->setTotal($total_deuda);
    $adeudo->setPagoMinimo($abono);
    $adeudo->setEstado("A");
    $adeudo->setVenta($idventa);
    $adeudo->setNegocio($_SESSION['idnegocio']);
    $adeudo->setCliente($_SESSION['clienteid']);
    $adeudo->guardar();
    $_SESSION['clienteid'] = null;
    $_SESSION['idven'] = null;
    $_SESSION['forma_pago'] = null;
    header("location: ticket.php?idventa=$idventa");
}
