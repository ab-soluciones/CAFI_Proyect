<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();



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

<body class="border" style="width: 400px;" onmouseover="cerrar()">
    <div class="ticket justify-content-center">
        <div class="border">
            <img src="img/ticketcafi.png" alt="Logotipo">

            <p class="centrado"> <?php echo $titulo; ?>
                <br> <?php echo $cliente; ?>

                <p class="centrado"> <?php echo $renglon['nombre_negocio']; ?>
                    <br> <?php echo $direccion; ?>
                    <?php if (isset($renglonVenta['telefono_negocio'])) { ?>
                        <br> <?php echo "Tel: " . $renglonVenta['telefono_negocio'];
                                } ?>
                    <br> <?php echo $fechaYHora; ?>
                    <br> -----------------------------------
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">PROD</th>
                    <th class="text-center">DESC</th>
                    <th class="text-center">CANT</th>
                    <th class="text-center">P.U</th>
                    <th class="text-center">IMP</th>
                    <th class="text-center">UM</th>
                    <th class="text-center">Talla</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($productos = mysqli_fetch_array($rowPro)) { ?>
                    <tr>
                        <td class="text-center"><?php echo $productos['nombre']; ?> <?php echo $productos['marca']; ?></td>
                        <td class="text-center"><?php echo $productos['color']; ?></td>
                        <td class="text-center"><?php echo $productos['cantidad_producto']; ?></td>
                        <td class="text-center"><?php echo $productos['precio_venta']; ?></td>
                        <td class="text-center"><?php echo $productos['subtotal']; ?></td>
                        <td class="text-center"><?php echo $productos['unidad_medida']; ?></td>
                        <td class="text-center"><?php echo $productos['talla_numero']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        if ($renglon['descuento'] > 0.00) { ?>
            <br><?php echo "DESCUENTO: $" . $renglon['descuento']; ?>
        <?php   } ?>
        <br><?php echo "TOTAL: $" . $renglon['total']; ?>
        <br>
        <?php
        if ($renglon['pago_minimo'] > 0.00) {
            echo "ANTICIPO: $" . $renglon['pago_minimo']; ?> <?php } ?>
        <br>
        <?php echo "ABONO ACTUAL: $ $renglon[cantidad]"; ?>
        <?php if ($renglon['pago_abono'] > 0.00) { ?>
            <br><?php echo "PAGO: $ $renglon[pago_abono]"; ?>
        <?php   } ?>
        <br>
        <?php if ($renglon['cambio_abono'] > 0.00) {
            echo "CAMBIO: $ $renglon[cambio_abono]";
        } ?>
        <br><?php echo"ADEUDO ACTUAL: $ $renglon[total_deuda]";?>

        <br>
        <br>
        <p class="centrado">¡GRACIAS POR SU COMPRA :-)!
            <p class="centrado">USTED FUÉ ATENDIDO POR <?php echo $renglon['nombre'] . " " . $renglon['apaterno'] ?>
    </div>
    <script >
            window.print();

            function cerrar(){
                window.close();
            }      
        </script>
</body>

</html>