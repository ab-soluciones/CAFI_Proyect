<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

  

    $con = new Models\Conexion();

    $query = "SELECT descuento,total,pago, cambio,fecha,hora,nombre,apaterno,nombre_negocio,domicilio, ciudad,telefono_negocio, idventas FROM venta
                INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                INNER JOIN negocios ON venta.idnegocios=negocios.idnegocios
                WHERE idventas = '2'";

    $row = $con->consultaListar($query);
    $renglonVenta = mysqli_fetch_array($row);

    $query = "SELECT pago_minimo, total_deuda,nombre,apaterno,amaterno FROM adeudos INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente WHERE ventas_idventas ='1'";
    $adeudos = $con->consultaListar($query);
    $abono = mysqli_fetch_array($adeudos);
    $tipoVenta = (isset($abono)) ? "VENTA A CRÉDITO " . $renglonVenta['idventas'] : "VENTA " . $renglonVenta['idventas']; /*Define la descripcion del tipo de venta */
    $cliente = "Cliente: " . " ". $abono['nombre']  . " ".$abono['apaterno'] . " ". $abono['amaterno'];
    $direccion =  $renglonVenta['domicilio'] ." " ." " . $renglonVenta['ciudad'];
    $fechaYHora = $renglonVenta['fecha'] . " " . $renglonVenta['hora'];

    $query = "SELECT nombre,color,marca,precio_venta, cantidad_producto, unidad_medida,talla_numero,subtotal FROM
	producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
	detalle_venta.idventa='2'";
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
        <script >


                window.print();

        </script>
    </head>
    <body class="border" style="width: 400px;">
        <div class="ticket justify-content-center">
            <div class="border">
                <img
                    src="img/ticketcafi.png"
                    alt="Logotipo">

                    <p class="centrado"> <?php echo $tipoVenta;?>
                <?php if(isset($abono)){?>
                    <br> <?php echo $cliente;}?>

                <p class="centrado"> <?php echo $renglonVenta['nombre_negocio'];?>
                    <br> <?php echo $direccion;?>
                <?php if(isset($renglonVenta['telefono_negocio'])){?>
                    <br> <?php echo "Tel: ". $renglonVenta['telefono_negocio'];}?>
                    <br> <?php echo $fechaYHora;?>
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
                <?php while ($productos = mysqli_fetch_array($rowPro)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $productos['nombre'];?> <?php echo $productos['marca'];?></td>
                        <td class="text-center"><?php echo $productos['color'];?></td>
                        <td class="text-center"><?php echo $productos['cantidad_producto']; ?></td>
                        <td class="text-center"><?php echo $productos['precio_venta']; ?></td>
                        <td class="text-center"><?php echo $productos['subtotal']; ?></td>
                        <td class="text-center"><?php echo $productos['unidad_medida']; ?></td>
                        <td class="text-center"><?php echo $productos['talla_numero']; ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <?php if(isset($abono)){
                    if ($renglonVenta['descuento'] > 0.00) {?>
                <br><?php echo "DESCUENTO: ". $renglonVenta['descuento'];?>
            <?php   }?>
                <br><?php echo "TOTAL: ". $renglonVenta['total'];?>
                <br><?php echo "ABONO: ". $abono['pago_minimo'];?>
            <?php   if ($renglonVenta['pago'] > 0.00){?>
                <br><?php echo "PAGÓ: ". $renglonVenta['pago'];?>
            <?php   }?>
                <br><?php echo "ADEUDO: ". $abono['total_deuda'];?>
            <?php }else{
                if ($renglonVenta['descuento'] > 0.00){?>
                    <br><?php echo "DESCUENTO: ". $renglonVenta['descuento'];}?>
                    <br><p class="text-right"><span class="font-weight-bold">TOTAL: </span><?php echo "$".$renglonVenta['total'];?></p>
                    <br><span class="font-weight-bold">PAGÓ: </span><?php echo "$". $renglonVenta['pago'];?>
                <?php if ($renglonVenta['cambio'] > 0.00){?>
                    <br><?php echo "CAMBIO: ". $renglonVenta['cambio'];}?>
            <?php }?>

            <br>
            <br>
            <p class="centrado">¡GRACIAS POR SU COMPRA :-)!
            <p class="centrado">USTED FUÉ ATENDIDO POR <?php echo $renglonVenta['nombre'] . " " .$renglonVenta['apaterno'] ?>
        </div>
    </body>

</html>
