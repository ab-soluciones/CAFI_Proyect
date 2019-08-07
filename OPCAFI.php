<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
}

if (isset($_POST['nuevaventa'])) {
    /*se crea una nueva venta para poder hacer uso de la tabla detalle venta(describe el concepto de la venta)
     ya que tiene relacion de muchos a muchos con la tabla productos y la tabla venta */
    $venta = new Models\Venta();
    $id = $venta->guardar();
    $_SESSION['idven'] = $id['id'];
    header('location: VVentas.php');
}
if (!is_null($_SESSION['idven'])) {
   ?>
<script>
alert("Termine la venta actual");
window.location.href = 'VVentas.php';
</script>

<?php } ?>
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/botones.css">
    <link rel="stylesheet" href="css/style.css">

<title>CAFI System</title>
    <script type="text/javascript">
        var parametro;

        function ini() {
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }

        function parar() {
            clearTimeout(parametro);
            parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
        }
    </script>

</head>

<body onload="ini(); " onkeypress="parar();" onclick="parar();">
    <div id="">
        <div class="col-md-10" style="margin: auto;">
            <div class="card card-body bg-dark">
                <h5 id="op_titulo" class="font-weight-bold text-center">Bienvenido a CAFI</h5>
            </div>
            <div id="op_card_body" class="container card card-body">
                <?php if (strcasecmp($_SESSION['acceso'], "CEO") == 0) {
                    ?>
                    <button onclick="window.open('VTrabajador.php')" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Trabajadores</label><br><img src="img/trabajadores.png"> </button>
                    <button onclick="window.open('VEstadoResultados.php')" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Estado de Resultados</label><br><img src="img/estado_resultados.png"> </button>
                    <button onclick="window.open('VFlujoEfectivo.php')" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Flujo de efectivo</label><br><img src="img/flujo_efectivo.png"> </button>
                    <a class="btn btn-danger btn-lg btn-block" href="index.php?cerrar_sesion">
                        <label class="badge badge-danger">Salir</label><br><img src="img/salir.png"> </a>
                <?php } else if (
                    strcasecmp($_SESSION['acceso'], "Manager") == 0 || strcasecmp($_SESSION['acceso'], "Employes") == 0
                ) {
                    ?>
                    <div class="row mt-3 justify-content-around">
                        <div class="col-4">
                            <form action="#" method="post">
                            <button type="submit" class="btn btn-dark btn-lg btn-block" name="nuevaventa">
                            <label class="badge badge-dark" style="color: #0066ff;">Vender</label><br><img src="img/cash_register.png"></button>
                            </form>
                        </div>
                        <div class="col-4">
                            <button onclick="window.open('VAbonos.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge" style="color: white;">Abonos</label><br><img src="img/abonos.png"></button></button>
                        </div>
                        <div class="col-4">
                            <button onclick="window.open('VConsultasAdeudos.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge">Adeudos</label><br><img src="img/adeudos.png"></button></button>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-around">
                        <div class="col-4">  
                            <button onclick="window.open('VGastos.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge badge-dark">Gastos</label><br><img src="img/gastos.png"></button></button>
                        </div>
                        <div class="col-4">
                            <button onclick="window.open('VRetiros.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge badge-dark">Retiros</label><br><img src="img/retiro.png"> </button>
                        </div>
                        <div class="col-4">
                            <button onclick="window.open('VOtrosIngresos.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge badge-dark">Otros Ingresos</label><br><img src="img/otrosingresos.png"></button></button>    
                        </div>
                    </div>
                    
                    <div class="row mt-3 justify-content-around">                             
                        <div class="col-4">
                        <button onclick="window.open('VClientes.php')" type="button" class="btn btn-dark btn-lg btn-block">
                                <label class="badge badge-dark">Clientes</label><br><img src="img/clientes.png"></button></button>
                        
                       
                        </div>
                        <div class="col-4">
                        <button onclick="window.open('VInventario.php')" type="button" class="btn btn-dark btn-lg btn-block">
                                <label class="badge badge-dark">Inventario</label><br><img src="img/Inventory.png"> </button>
                       
                             
                        </div>
                        <div class="col-4">
                        <button onclick="window.open('VProductos.php')" type="button" class="btn btn-dark btn-lg btn-block">
                                <label class="badge badge-dark">Productos</label><br><img src="img/productos.png"> </button>
                        
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-4">
                        <button onclick="window.open('VConsultasVentas.php')" type="button" class="btn btn-dark btn-lg btn-block">
                            <label class="badge badge-dark">Ventas</label><br><img src="img/venta.png"> </button>
                        </div>
                        <div class="col-4">
                            <a class="btn btn-danger btn-lg btn-block" href="index.php?cerrar_sesion">
                                <label class="badge badge-danger">Salir</label><br><img src="img/salir.png"> </a>
                        <?php } ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>