<?php
require_once "Config/Autoload.php";
session_start();

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

if (isset($_GET['ad'])) {
    $adeudo = $_GET['ad'];

    /*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


    /*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

    $nombre_impresora = "CAFI";


    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);
    #Mando un numero de respuesta para saber que se conecto correctamente.
    echo "impresion exitosa";
    /*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras

	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/

    # Vamos a alinear al centro lo próximo que imprimamos
    $printer->setJustification(Printer::JUSTIFY_CENTER);

    /*
	Intentaremos cargar e imprimir
	el logo
*/
    try {
        $logo = EscposImage::load("img/ticketcafi.png", false);
        $printer->bitImage($logo);
    } catch (Exception $e) { }

    /*
	Ahora vamos a imprimir un encabezado
*/
    Config\Autoload::run();
    $con = new Models\Conexion();
    $idnegocio = $_SESSION['idnegocio'];
    $query = "SELECT pago_minimo,cantidad,abono.pago AS pago_abono,abono.cambio AS cambio_abono,total_deuda,abono.fecha,abono.hora ,idventas ,
    total,descuento, trabajador.nombre,trabajador.apaterno, cliente.nombre AS n_cliente, cliente.apaterno AS ap_cliente,
    cliente.amaterno AS am_cliente,nombre_negocio, domicilio, ciudad,telefono_negocio FROM abono 
    INNER JOIN adeudos ON abono.adeudos_id=adeudos.idadeudos 
    INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente 
    INNER JOIN trabajador ON trabajador.idtrabajador = abono.trabajador_idtrabajador 
    INNER JOIN venta ON venta.idventas = adeudos.ventas_idventas 
    INNER JOIN negocios ON venta.idnegocios=negocios.idnegocios 
    WHERE idabono = (SELECT MAX(idabono) from abono)";

    $row = $con->consultaListar($query);
    $renglon = mysqli_fetch_array($row);

    $printer->text("\n" . "ABONO VENTA A CRÉDITO # $renglon[idventas]");
    $printer->text("\n" . "Cliente: $renglon[n_cliente] $renglon[ap_cliente] $renglon[am_cliente]" . "\n");
    $printer->text("$renglon[nombre_negocio]" . "\n");
    $printer->text("$renglon[domicilio]" . " " . "$renglon[ciudad]" . "\n");
    if (isset($renglon['telefono_negocio'])) {
        $printer->text("Tel: $renglon[telefono_negocio]" . "\n");
    }


    #La fecha también

    $printer->text($renglon['fecha'] . " " . $renglon['hora'] . "\n");
    $printer->text("-----------------------------" . "\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("CANT  DESCRIPCION  P.U  IMP  UM  Talla\n");
    $printer->text("-----------------------------" . "\n");
    /*
	Ahora vamos a imprimir los
	productos
*/
    /*Alinear a la izquierda para la cantidad y el nombre*/
    $query = "SELECT nombre,color,marca,precio_venta, cantidad_producto, unidad_medida,talla_numero,subtotal FROM
	producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
	detalle_venta.idventa='$renglon[idventas]'";
	$row = $con->consultaListar($query);
	while ($renglon2 = mysqli_fetch_array($row)) {
		$printer->setJustification(Printer::JUSTIFY_LEFT);
		$printer->text("$renglon2[nombre] $renglon2[marca] color $renglon2[color].\n");
		$printer->text("$renglon2[cantidad_producto]" . " " . "$ $renglon2[precio_venta]" . " " . " $ $renglon2[subtotal] " . " " . "$renglon2[unidad_medida]" . " " . "$renglon2[talla_numero]"  . "\n");
	}
    $printer->text("-----------------------------" . "\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    if ($renglon['descuento'] > 0.00) {
        $printer->text("DESCUENTO: $ $renglon[descuento]\n");
    }
    $printer->text("TOTAL VENTA: $ $renglon[total]\n");

    if ($renglon['pago_minimo'] > 0.00) {
        $printer->text("PAGO MINIMO: $ $renglon[pago_minimo]\n");
    }
    $printer->text("ABONO ACTUAL: $ $renglon[cantidad]\n");
    if ($renglon['pago_abono'] > 0.00) {
        $printer->text("PAGÓ: $ $renglon[pago_abono]\n");
    }
    if ($renglon['cambio_abono'] > 0.00) {
        $printer->text("      CAMBIO: $ $renglon[cambio_abono]\n");
    }
    $printer->text("ADEUDO ACTUAL: $ $renglon[total_deuda]\n");





    /*
	Podemos poner también un pie de página
*/
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\nMuchas gracias por su nuevo abono :-)\n");
    $printer->text("\nUsted fué atendido por $renglon[nombre] $renglon[apaterno]");



    /*Alimentamos el papel 3 veces*/
    $printer->feed(3);

    /*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
    $printer->cut();

    /*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
    $printer->pulse();

    /*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
    $printer->close();


    header('location: VConsultasAdeudos.php');
}
