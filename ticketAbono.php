<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

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


$titulo =  "ABONO A VENTA #" . $renglon['idventas']; /*Define la descripcion del tipo de venta */
$cliente = "Cliente: $renglon[n_cliente] $renglon[ap_cliente] $renglon[am_cliente]";
$direccion =  $renglon['domicilio'] . " " . " " . $renglon['ciudad'];
$fechaYHora = $renglon['fecha'] . " " . $renglon['hora'];

$query = "SELECT nombre,color,marca,precio_venta, cantidad_producto, unidad_medida,talla_numero,subtotal FROM
    producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
    detalle_venta.idventa='$renglon[idventas]'";
$rowPro = $con->consultaListar($query);


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/ticket.css">
    </head>

    <body style="width: 380px;">
        <div style="width: 380px; max-width: 380px;" class="font-weight-bold">
            <div class="row justify-content-center">
                <img src="img/ticketcafi.png" alt="Logotipo">
            </div>
        
            <div class="justify-content-center">
                <p class="centrado"> <?php echo $titulo; ?>
                <br> <?php echo $cliente; ?>

                <p class="centrado"> <?php echo $renglon['nombre_negocio']; ?>
                    <br> <?php echo $direccion; ?>
                    <?php if (isset($renglon['telefono_negocio'])) { ?>
                        <br> <?php echo "Tel: " . $renglon['telefono_negocio'];
                            } ?>
                    <br> <?php echo $fechaYHora; ?>
                    <br>
            </div>
        </div>
        <div style="border-top: 1px solid black; margin-bottom: 1rem;">

        </div>
        <div style="width: 380px; max-width: 380px; line-height: 13px;">
                    <?php while ($productos = mysqli_fetch_array($rowPro)) { ?>
                        <span class="font-weight-bold"><?php echo $productos['cantidad_producto']."x"; ?></span>
                            <span class="font-weight-bold"><?php echo $productos['nombre'];?> <?php echo $productos['marca'];?></span>
                            <span class="font-weight-bold"><?php echo $productos['color'];?></span>
                            <span class="font-weight-bold"><?php echo $productos['unidad_medida']; ?></span>
                            <span class="font-weight-bold"><?php echo $productos['talla_numero']; ?></span>
                            <p class="text-right">
                                <span class="font-weight-bold text-right"><?php echo "$".$productos['subtotal']; ?></span>
                            <p>
                    <?php } ?>
        </div>
        <div style="border-top: 1px solid black; margin-bottom: 1rem;">

        </div>
        <div class="font-weight-bold" style="width: 380px; max-width: 380px; line-height: 13px;">
            <div class="justify-content-right">
                <?php
                if ($renglon['descuento'] > 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">DESCUENTO: </span><?php echo "$" . $renglon['descuento']; ?></p>
                <?php   } ?>
                    <p class="text-right"><span class="font-weight-bold">TOTAL: </span><?php echo "$" . $renglon['total']; ?></p>
                <?php
                if ($renglon['pago_minimo'] > 0.00) {?>
                    <p class="text-right"><span class="font-weight-bold">ANTICIPO: </span><?php echo "$" . $renglon['pago_minimo']; ?> <?php } ?></p>
                    <p class="text-right"><span class="font-weight-bold">ABONO ACTUAL: </span><?php echo "$". $renglon['cantidad']; ?></p>
                <?php if ($renglon['pago_abono'] > 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">PAGO: </span><?php echo "$" . $renglon['pago_abono']; ?></p>
                <?php   } ?>
                <?php if ($renglon['cambio_abono'] > 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$" . $renglon['cambio_abono']; ?></p>
                <?php } ?>
                <p class="text-right"><span class="font-weight-bold">ADEUDO ACTUAL: </span><?php echo "$" . $renglon['total_deuda'];?></p>
            </div>

            <br>
            <br>

            <p class="centrado font-weight-bold">¡GRACIAS POR SU COMPRA =)!</p>
            <p class="centrado">Usted fue atendido por <?php echo $renglon['nombre'] . " " .$renglon['apaterno'] ?></p>
        </div>

        <script >
            window.print();
            window.close();    
        </script>
    </body>

</html>