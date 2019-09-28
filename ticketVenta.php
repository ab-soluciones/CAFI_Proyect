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

    <body style="width: 380px;">
            <div style="width: 380px; max-width: 380px;" class="font-weight-bold">
                <div class="row justify-content-center">
                    <img src="img/ticketcafi.png" alt="Logotipo">
                </div>
                
                <div class="justify-content-center">
                        <p class="centrado font-weight-bold"> <?php echo $tipoVenta;?>
                    <?php if(isset($abono)){?>
                        <br> <?php echo $cliente;}?>

                    <p class="centrado font-weight-bold"> <?php echo $renglonVenta['nombre_negocio'];?>
                        <br> <?php echo $direccion;?>
                    <?php if(isset($renglonVenta['telefono_negocio'])){?>
                        <br> <?php echo "Tel: ". $renglonVenta['telefono_negocio'];}?>
                        <br> <?php echo $fechaYHora;?>
                        <br>
                </div>
            </div>
            <div style="border-top: 1px solid black; margin-bottom: 1rem;">

            </div>
            <div style="width: 380px; max-width: 380px; line-height: 13px;" class="ml-1">
                    <?php while ($productos = mysqli_fetch_array($rowPro)){ ?>
                            <span class="font-weight-bold"><?php echo $productos['cantidad_producto']."x"; ?></span>
                            <span class="font-weight-bold"><?php echo $productos['nombre'];?> <?php echo $productos['marca'];?></span>
                            <span class="font-weight-bold"><?php echo $productos['color'];?></span>
                            <span class="font-weight-bold"><?php echo $productos['unidad_medida']; ?></span>
                            <span class="font-weight-bold"><?php echo $productos['talla_numero']; ?></span>
                            <p class="text-right">
                                <span class="font-weight-bold text-right"><?php echo "$".$productos['subtotal']; ?></span>
                            <p>
                    <?php }?>
            </div>
            <div style="border-top: 1px solid black; margin-bottom: 1rem;">

            </div>
            <div class="font-weight-bold" style="width: 380px; max-width: 380px; line-height: 13px;" class="">
                <div class="justify-content-right">
                    <?php if(isset($abono)){
                            if ($renglonVenta['descuento'] > 0.00) {?>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">DESCUENTO: </span><?php echo "$". $renglonVenta['descuento'];?></p>
                    <?php   }?>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">TOTAL: </span><?php echo "$". $renglonVenta['total'];?></p>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">ANTICIPO: </span><?php echo "$". $abono['pago_minimo'];?></p>
                    <?php if ($renglonVenta['pago'] > 0.00){?>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">PAGO: </span><?php echo "$". $renglonVenta['pago'];?></p>
                    <?php }?>
                    <?php if ($renglonVenta['cambio'] > 0.00){?>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">CAMBIO: </span><?php echo "$". $renglonVenta['cambio'];}?></p>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">ADEUDO: </span><?php echo "$". $abono['total_deuda'];?></p>
                    <?php }else{
                            if ($renglonVenta['descuento'] > 0.00){?><br><?php echo "DESCUENTO: $". $renglonVenta['descuento'];}?>
                            <p class="text-right font-weight-bold"><span class="font-weight-bold">TOTAL: </span><?php echo "$".$renglonVenta['total'];?></p>
                            <p class="text-right font-weight-bold"><span class="font-weight-bold">PAGO: </span><?php echo "$". $renglonVenta['pago'];?></p>
                        
                            <?php if ($renglonVenta['cambio'] > 0.00){?><p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$". $renglonVenta['cambio'];}?></p>
                    
                    <?php }?>
                </div>

                <br>
                <br>

                <p class="centrado font-weight-bold">¡GRACIAS POR SU COMPRA =)!</p>
                <p class="centrado font-weight-bold">Usted fue atendido por <?php echo $renglonVenta['nombre'] . " " .$renglonVenta['apaterno'] ?></p>
            </div>

        <script >
            window.print();
            window.close();    
        </script>
    </body>

</html>
