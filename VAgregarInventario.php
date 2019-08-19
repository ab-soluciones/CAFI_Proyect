<?php 
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    ! $_SESSION['acceso'] == "Manager" 
) {
    header('location: OPCAFI.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <title>Agragar a inventario</title>
</head>
<body>
<div class="row">
        <div class="col-lg-12">
            <div class="card card-body" style="background: #000000;">
                <h5 style="margin: 0 auto; color: #0066ff;">Agregar a inventario</h5>
            </div>
        </div>
        </div>

        
    </body>
</html>