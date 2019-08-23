<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "ManagerAB"
    || $_SESSION['acceso'] == "CEOAB"
) {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php include("Navbar.php") ?>

    <div class="row">
        <div style="margin: 0 auto; margin-top: 15px;" class="col-md-3">
            <nav class="navbar navbar-dark bg-dark">
                <div class="container">
                    <a style="margin: 0 auto;" href="#" class="navbar-brand">Inventario</a>
                </div>
            </nav>
            <div class="card card-body">
                <form action="#" method="post">
                    <h5><label for="tipo" class="badge badge-primary">Tipo producto:</label></h5>
                    <select id="tipo" class="form form-control" name="STipo" id="">
                        <option value="Ropa">Ropa</option>
                        <option value="Calzado">Calzado</option>
                    </select><br>
                    <input class="btn btn-lg btn-block btn-primary" type="submit" value="Inventariar">
                </form>
            </div>
        </div>

    </div>
    <div class="row">
        <?php if (isset($_POST['STipo']) && $_POST['STipo'] === "Ropa") {
            $tipo = $_POST['STipo'];
            ?>
            <div class="col-md-8" style=" margin: 0 auto; margin-top:15px;">
                <table class="table table-bordered table-responsive-md">
                    <tr>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>UM</th>
                        <th>XXL</th>
                        <th>XL</th>
                        <th>L</th>
                        <th>M</th>
                        <th>S</th>
                        <th>XS</th>
                        <?php
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        $query = "SELECT  nombre,imagen,marca,color,talla_numero,unidad_medida,cantidad,COUNT(*) AS repetido FROM producto
                        INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                        WHERE tipo='$tipo' AND inventario.negocios_idnegocios='$negocio' GROUP BY nombre,color,talla_numero";
                        $row = $con->consultaListar($query);
                        $con->cerrarConexion();
                        $nombretemporal = "";
                        $marcatemporal = "";
                        $colortemporal = "";
                        while ($result = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <?php if ($nombretemporal === $result['nombre'] && $marcatemporal ===  $result['marca'] && $colortemporal === $result['color']) {
                                ?>
                                <?php
                                $ambiguedad = $result['repetido'];
                                if ($ambiguedad > 1) {
                                    echo "<script>alert('¡Cuidado! el producto $result[nombre] $result[marca] $result[color] talla $result[talla_numero] esta registrado $result[repetido] veces vaya a productos y solucionelo para evitar fallas o anomalias en el sistema');</script>";
                                }


                                ?>
                                <script>
                                    document.getElementById("<?php echo $result['talla_numero'] ?>").innerHTML = "<?php echo $result['cantidad'] ?>";

                                    document.getElementById("<?php echo $result['talla_numero'] ?>").style = "backgrount: white;";
                                </script>

                            <?php                } else {
                                ?>
                                <script>
                                    document.getElementById("XXL").id = "";
                                    document.getElementById("XL").id = "";
                                    document.getElementById("L").id = "";
                                    document.getElementById("M").id = "";
                                    document.getElementById("S").id = "";
                                    document.getElementById("XS").id = "";
                                </script>
                                <td><?php echo $result['nombre'] ?></td>
                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($result['imagen']) ?>" height="30" width="30" /> </td>
                                <td><?php echo $result['marca'] ?></td>
                                <td><?php echo $result['color'] ?></td>
                                <td><?php echo $result['unidad_medida'] ?></td>
                                <td id="XXL" style="background: blue;"></td>
                                <td id="XL" style="background: blue;"></td>
                                <td id="L" style="background: blue;"></td>
                                <td id="M" style="background: blue;"></td>
                                <td id="S" style="background: blue;"></td>
                                <td id="XS" style="background: blue;"></td>
                                <script>
                                    document.getElementById("<?php echo $result['talla_numero'] ?>").innerHTML = "<?php echo $result['cantidad'] ?>";
                                    document.getElementById("<?php echo $result['talla_numero'] ?>").style = "backgrount: white;";
                                </script>



                            <?php } ?>

                        </tr>
                        <?php $nombretemporal = $result['nombre'];
                        $marcatemporal = $result['marca'];
                        $colortemporal = $result['color'];
                    }
                    ?>


                    </tr>

                <?php } else if (isset($_POST['STipo']) && $_POST['STipo'] === "Calzado") {
                    $tipo = $_POST['STipo'];
                    ?>
                    <div class="col-xl-12" style=" margin: 0 auto; margin-top:15px;">
                        <table class="table table-bordered table-responsive-xl">
                            <tr>
                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Marca</th>
                                <th>Color</th>
                                <th>UM</th>

                                <?php
                                for ($i = 1; $i < 34; $i++) {
                                    for ($j = 0; $j < 2; $j++) {
                                        if ($j === 0) {
                                            echo "<th class = '$i'>$i</th>";
                                        } else if ($j > 0) {
                                            $media = $i + 0.5;
                                            echo "<th class = '$media'>$media</th>";
                                        }
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                            $negocio = $_SESSION['idnegocio'];
                            $con = new Models\Conexion();
                            $query = "SELECT  nombre,imagen,marca,color,talla_numero,unidad_medida,cantidad,COUNT(*) AS repetido FROM producto
                            INNER JOIN inventario ON codigo_barras = producto_codigo_barras
                            WHERE tipo='$tipo' AND inventario.negocios_idnegocios='$negocio' GROUP BY nombre,color,talla_numero";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();
                            $nombretemporal = "";
                            $marcatemporal = "";
                            $colortemporal = "";
                            while ($result = mysqli_fetch_array($row)) {
                                ?>
                                <tr>
                                    <?php if ($nombretemporal === $result['nombre'] && $marcatemporal ===  $result['marca'] && $colortemporal === $result['color']) {
                                        ?>
                                        <script>
                                            document.getElementById("<?php echo $result['talla_numero'] ?>").innerHTML = "<?php echo $result['cantidad'] ?>";

                                            document.getElementById("<?php echo $result['talla_numero'] ?>").style = "backgrount: white;";
                                        </script>

                                    <?php                } else {
                                        ?>
                                        <td><?php echo $result['nombre'] ?></td>
                                        <td><img src="data:image/jpg;base64,<?php echo base64_encode($result['imagen']) ?>" height="30" width="30" /> </td>
                                        <td><?php echo $result['marca'] ?></td>
                                        <td><?php echo $result['color'] ?></td>
                                        <td><?php echo $result['unidad_medida'] ?></td>
                                        <?php
                                        $numero = floatval($result['talla_numero']);
                                        $ambiguedad = $result['repetido'];
                                        if ($ambiguedad > 1) {
                                            echo "<script>alert('¡Cuidado! el producto $result[nombre] $result[marca] $result[color] talla $result[talla_numero] esta registrado $result[repetido] veces vaya a productos y solucionelo para evitar fallas o anomalias en el sistema');</script>";
                                        }
                                        for ($i = 1; $i < 34; $i++) {
                                            for ($j = 0; $j < 2; $j++) {
                                                if ($j === 0) {
                                                    if ($numero == $i) {
                                                        echo "<td>$result[cantidad]</td>";
                                                    } else {
                                                        echo "<td id='$i' style='background: blue;'></td>";
                                                    }
                                                } else if ($j > 0) {
                                                    $media = $i + 0.5;
                                                    if ($numero == $media) {
                                                        echo "<td>$result[cantidad]</td>";
                                                    } else {
                                                        echo "<td id='$media' style='background: blue;'></td>";
                                                    }
                                                }
                                            }
                                        }

                                        ?>

                                    <?php } ?>

                                </tr>
                                <?php $nombretemporal = $result['nombre'];
                                $marcatemporal = $result['marca'];
                                $colortemporal = $result['color'];
                            }
                            ?>
                        <?php  } ?>

                    </table>

                </div>

        </div>
        <script src="js/user_jquery.js"></script>
</body>

</html>