
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        div.barcodes{
            display: inline;
            border: 1px solid black;
            padding: 80px;
        }

        table{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <table>
        <thead>
        </thead>
        <tbody>
        <?php
            require_once "Config/Autoload.php";
            Config\Autoload::run();
            session_start();
            $con = new Models\Conexion();
            $negocios = $_SESSION['idnegocio'];
            $cantidad = 5;
            $numeracion = true;
            $sql = "SELECT producto_codigo_barras,cantidad FROM inventario WHERE negocios_idnegocios = '$negocios'";
            $resultado = $con->consultaListar($sql);
            while ($row = mysqli_fetch_array($resultado)){
                for ($i=0; $i<$cantidad; $i++){
                    ?>
                        <tr>
                            <td><img src="barcode.php?text=<?php echo $row['producto_codigo_barras'];?>&size=50&orientation=horizontal&codetype=Code39&print=true&sizefactor=1"/></td>
                        </tr>
                    <?php 
                }
            }
        ?>
        </tbody>
    </table>


</body>
</html>