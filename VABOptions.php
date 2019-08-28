<?php
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager" || $_SESSION['acceso'] == "CEO") {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>CAFI System</title>
    <style>
        body {
            background: #bfbfbf;
        }
    </style>
</head>

<body style="background: #d9d9d9;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav class="navbar navbar-dark bg-dark">
                <div class="container">
                    <a style="margin: 0 auto;" href="VABOptions.php" class="navbar-brand">AB</a>
                </div>
            </nav>
            <div class="card card-body" style="background: #e6e6e6; ">
                <div class="row mt-3 justify-content-around">
                    <div class="col-6">
                        <button onclick="window.location.href='VUsuarios_ab.php'" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Usuarios</label><br><img src="img/usuarios.png"> </button>
                    </div>
                    <div class="col-6">
                        <button onclick="window.location.href='VClienteab.php'" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Clientes</label><br><img src="img/clientes.png"></button></button>
                    </div>
                </div>
                <div class="row mt-3 justify-content-around">
                    <div class="col-6">
                        <button onclick="window.location.href='VNegociosab.php'" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Negocios</label><br><img src="img/negocios.png"> </button>
                    </div>
                    <div class="col-6">
                        <button onclick="window.location.href='VSuscripcion.php'" type="button" class="btn btn-primary btn-lg btn-block">
                        <label class="badge badge-primary">Suscripciones</label><br><img src="img/agenda.png"> </button>
                    </div>
                </div>
                <a class="mt-3 btn btn-danger btn-lg btn-block" href="index.php?cerrar_sesion">
                    <label class="badge badge-danger">Salir</label><br><img src="img/salir.png"> </a>
            </div>
        </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>