<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();

  $idventa = $_SESSION['idven'];

    $con = new Models\Conexion();

    $query = "SELECT descuento,total,pago, cambio,fecha,hora,nombre,apaterno,nombre_negocio,domicilio, ciudad,telefono_negocio, idventas FROM venta
                INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                INNER JOIN negocios ON venta.idnegocios=negocios.idnegocios
                WHERE idventas = '$idventa'";

    $row = $con->consultaListar($query);
    $renglonVenta = mysqli_fetch_array($row);

    $query = "SELECT pago_minimo, total_deuda,nombre,apaterno,amaterno FROM adeudos INNER JOIN cliente ON adeudos.cliente_idcliente=cliente.idcliente WHERE ventas_idventas ='$idventa'";
    $adeudos = $con->consultaListar($query);
    $abono = mysqli_fetch_array($adeudos);
    $tipoVenta = (isset($abono)) ? "VENTA A CRÉDITO " . $renglonVenta['idventas'] : "VENTA " . $renglonVenta['idventas']; /*Define la descripcion del tipo de venta */
    $cliente = "Cliente: " . " ". $abono['nombre']  . " ".$abono['apaterno'] . " ". $abono['amaterno'];
    $direccion =  $renglonVenta['domicilio'] ." " ." " . $renglonVenta['ciudad'];
    $fechaYHora = $renglonVenta['fecha'] . " " . $renglonVenta['hora'];

    $query = "SELECT nombre,color,marca,precio_venta, cantidad_producto, unidad_medida,talla_numero,subtotal FROM
	producto INNER JOIN detalle_venta ON codigo_barras = producto_codigo_barras WHERE
	detalle_venta.idventa='$idventa'";
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

    <body style="width: 500px;" onmouseover="cerrar()">
        <div class="container justify-content-center">
            <div class="row justify-content-center">
                <img src="img/ticketcafi.png" alt="Logotipo">
            </div>
            
            <div>
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
                <!--Prueba
                <tr>
                    <td class="text-center">Zapatos Louis Vouiton</td>
                    <td class="text-center">Edicion especial</td>
                    <td class="text-center">1</td>
                    <td class="text-center">$12,000</td>
                    <td class="text-center">$12,000</td>
                    <td class="text-center">Par</td>
                    <td class="text-center">28.5</td>
                </tr>
                
                <tr>
                    <td class="text-center">Playera Supreme</td>
                    <td class="text-center"></td>
                    <td class="text-center">1</td>
                    <td class="text-center">$5,000</td>
                    <td class="text-center">$5,000</td>
                    <td class="text-center">Unidad</td>
                    <td class="text-center">Chica</td>
                </tr>

                <tr>
                    <td class="text-center">Lentes Gucci</td>
                    <td class="text-center">Edicion especial</td>
                    <td class="text-center">2</td>
                    <td class="text-center">$120,000</td>
                    <td class="text-center">$120,000</td>
                    <td class="text-center">Unidad</td>
                    <td class="text-center">-</td>
                </tr>

                <tr>
                    <td class="text-center">Cadena de Oro</td>
                    <td class="text-center">24k</td>
                    <td class="text-center">3</td>
                    <td class="text-center">$300,000</td>
                    <td class="text-center">$300,000</td>
                    <td class="text-center">Unidad</td>
                    <td class="text-center">-</td>
                </tr>
                -->
                </tbody>
            </table>
            <?php if(isset($abono)){
                    if ($renglonVenta['descuento'] > 0.00) {?>
                <p class="text-right"><span class="font-weight-bold">DESCUENTO: </span><?php echo "$". $renglonVenta['descuento'];?></p>
            <?php   }?>
                <p class="text-right"><span class="font-weight-bold">TOTAL: </span><?php echo "$". $renglonVenta['total'];?></p>
                <p class="text-right"><span class="font-weight-bold">ANTICIPO: </span><?php echo "$". $abono['pago_minimo'];?></p>
            <?php if ($renglonVenta['pago'] > 0.00){?>
                <p class="text-right"><span class="font-weight-bold">PAGÓ: </span><?php echo "PAGÓ: $". $renglonVenta['pago'];?></p>
            <?php }?>
            <?php if ($renglonVenta['cambio'] > 0.00){?>
                <p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$". $renglonVenta['cambio'];}?></p>
                <p class="text-right"><span class="font-weight-bold">ADEUDO: </span><?php echo "ADEUDO: $". $abono['total_deuda'];?></p>
            <?php }else{
                    if ($renglonVenta['descuento'] > 0.00){?><br><?php echo "DESCUENTO: $". $renglonVenta['descuento'];}?>
                    <p class="text-right"><span class="font-weight-bold">TOTAL: </span><?php echo "$".$renglonVenta['total'];?></p>
                    <p class="text-right"><span class="font-weight-bold">PAGÓ: </span><?php echo "$". $renglonVenta['pago'];?></p>
                
                    <?php if ($renglonVenta['cambio'] > 0.00){?><p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$". $renglonVenta['cambio'];}?></p>
            
            <?php }?>
            
            <br>
            <br>

            <p class="centrado font-weight-bold">¡GRACIAS POR SU COMPRA!</p>
            <p class="centrado">Usted fue atendido por <?php echo $renglonVenta['nombre'] . " " .$renglonVenta['apaterno'] ?></p>
        </div>

        <script >
            window.print();

            function cerrar(){
                window.close();
            }      
        </script>
    </body>

</html>
