<?php session_start();
if (isset($_GET['n360c10']) && isset($_GET['idn360c10'])) {
    $negocio = unserialize($_GET['n360c10']);
    $id_negocio = unserialize($_GET['idn360c10']);

    //se reciben los arrays y se deserializan 

    if (isset($_POST['Dlnegocios'])) {
        //se recorre el array para saber que id le pertenece al nombre del negocio seleccionado
        for ($i = 0; $i < sizeof($negocio); $i++) {
            if (strcasecmp($_POST['Dlnegocios'], $negocio[$i]) == 0) {
                $_SESSION['idnegocio'] = $id_negocio[$i];
                $_SESSION['nombrenegocio'] = $_POST['Dlnegocios'];
            }
        }
        //se guarda el negocio en la sesion
        $_SESSION['idnegocio'] = (int) $_SESSION['idnegocio'];
        header('location: OPCAFI.php');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Seleccion de Negocio</title>
        <script>
            // Este script sirve para destruir la sesion despues de 25 min de inactividad en el sistema 
            var parametro;

            function ini() {
                parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000)); // 25 min
            }

            function parar() {
                clearTimeout(parametro);
                parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000)); // 25 min
            }
        </script>
    </head>

    <body onload="ini(); " onkeypress="parar();" onclick="parar();">
        <div class="row">
            <div class="col-md-4" style="margin: 0 auto; margin-top: 10%;">
                <div id="jum">
                    <nav class="navbar navbar-dark bg-dark">
                        <div class="container">
                            <a style="margin: 0 auto;" href="#" class="navbar-brand">Seleccionar Negocio:</a>
                        </div>
                    </nav>
                </div>
                <div class="card card-body text-center">
                    <form class="form-group" action="#" method="post">
                        <input class="form form-control " list="nombresn" name="Dlnegocios" autocomplete="off" required>
                        <datalist id="nombresn">
                            <?php
                            for ($i = 0; $i < sizeof($negocio); $i++) {
                                echo "<option value='" . $negocio[$i] . "'> ";
                            }    ?>
                        </datalist><br>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" name="" value="Aceptar">
                    </form>

                </div>

            </div>
        </div>

    </body>


    </html>

<?php }

?>