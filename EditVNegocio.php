<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "Employes" || $_SESSION['acceso'] == "Manager") {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if ($_SESSION['acceso'] == "CEOAB" || $_SESSION['acceso'] == "ManagerAB") {
    if (isset($_GET['id'])) {
        ?>
<?php
        $id = $_GET['id'];
        $con = new Models\Conexion();
        $query =  $sql = "SELECT nombre_negocio,domicilio,ciudad,telefono_negocio,impresora,nombre,apaterno,amaterno FROM negocios
        INNER JOIN clientesab ON negocios.clientesab_idclienteab=clientesab.id_clienteab
        where idnegocios = '$id'";
        $result = mysqli_fetch_assoc($con->consultaListar($query));
        $con->cerrarConexion();
        if (isset($result)) {

            ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> Edicion de Negocio AB</title>
</head>

<body style="background: #f2f2f2;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a style="margin: 0 auto;" href="" class="navbar-brand">Edicion de Negocio</a>
            <h5></h5>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-3" style="margin: 0 auto; margin-top:5px;">
            <div class=" card card-body">
                <form class="form-group" action="#" method="post">

                    <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                    <input value="<?php echo $result['nombre_negocio'] ?>" id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="on" required><br>
                    <h5><label for="dom" class="badge badge-primary">Domicilio:</label></h5>
                    <input value="<?php echo $result['domicilio'] ?>" id="dom" class="form form-control" type="text" name="TDomicilio" placeholder="Domicilio" autocomplete="on" required><br>
                    <h5><label for="cd" class="badge badge-primary">Ciudad:</label></h5>
                    <input value="<?php echo $result['ciudad'] ?>" id="cd" class="form form-control" type="text" name="TCiudad" placeholder="Ciudad" autocomplete="on" required><br>
                    <h5><label for="tel" class="badge badge-primary">Teléfono:</label></h5>
                    <input id="tel" value="<?php echo $result['telefono_negocio'] ?>" class="form form-control" type="text" name="TTelefono" placeholder="Teléfono" autocomplete="off" required><br>
                    <h5><label for="impresora" class="badge badge-primary">Configuracion de impresora:</label></h5>
                    <div class="row" style="margin: 0 auto;">
                        <?php if ($result['impresora'] === "A") {
                                        ?>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="RImpresora" value="A" checked>Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="impresora" name="RImpresora" value="I">Inactiva
                            </label>
                        </div>
                        <?php  } else {
                                        ?>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="RImpresora" value="A">Activa
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="impresora" name="RImpresora" value="I" checked>Inactiva
                            </label>
                        </div>
                        <?php } ?>

                    </div><br>
                    <h5><label class="badge badge-primary">Cliente:</label></h5>
                    <div>
                        <input value="<?php echo $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] ?>" onclick="document.getElementById('inclientes').value =''" id="inclientes" class="form form-control" list="clientes" name="DlClientes" required autocomplete="off">
                        <datalist id="clientes">
                            <?php
                                        $datos = false;
                                        $con = new Models\Conexion();
                                        $query = "SELECT nombre,apaterno,amaterno FROM clientesab ORDER BY apaterno ASC";
                                        $row = $con->consultaListar($query);
                                        $con->cerrarConexion();

                                        while ($result = mysqli_fetch_array($row)) {
                                            ?>
                            <?php $datos = true;
                                            echo "<option value='" . $result['nombre'] . " " . $result['apaterno'] . " " . $result['amaterno'] . "'> "; ?>
                            <?php
                                        }
                                        if ($datos == false) {
                                            echo "<script>document.getElementById('inclientes').disabled = true;</script>";
                                        } ?>

                        </datalist>
                    </div><br>
                    <input style="margin-top:15px;" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Editar">
                </form>

            </div>
        </div>
    </div>
</body>

</html>
<?php
        } ?>
<?php

    }
    if (
        isset($_POST['TNombre']) && isset($_POST['TDomicilio'])
        && isset($_POST['TCiudad']) && isset($_POST['DlClientes'])
        && isset($_POST['TTelefono'])  && isset($_POST['RImpresora'])
    ) {
        $idusuario = $_SESSION['id'];
        $nombres = $_POST['DlClientes'];
        $negocio = new Models\Negocio();
        $con = new Models\Conexion();
        $negocio->setNombre($_POST['TNombre']);
        $negocio->setDomicilio($_POST['TDomicilio']);
        $negocio->setCiudad($_POST['TCiudad']);
        $negocio->setTelefono($_POST['TTelefono']);
        $negocio->setImpresora($_POST['RImpresora']);
        $query = "SELECT id_clienteab FROM clientesab WHERE (SELECT CONCAT(nombre,
        ' ', apaterno,' ' ,amaterno))='$nombres'";
        $idc = $con->consultaRetorno($query);
        $con->cerrarConexion();
        $idc = (int) $idc['id_clienteab'];
        var_dump($idc);
        $negocio->setIdCliente($idc);
        $result = $negocio->editar($id, $idusuario);
        if ($result === 1) {
            ?>
<script>
    alert('editado Exitosamente');
</script>
<?php } else if ($result === 0) {
            ?>
<script>
    alert('No se a realizado ningún cambio');
</script>
<?php } else if ($result === -1) {
            ?>
<script>
    alert('no editado compruebe los campos unicos');
</script>
<?php }
    }
}
?>