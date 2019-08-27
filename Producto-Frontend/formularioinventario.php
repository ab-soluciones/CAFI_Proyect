<form class="form-group" action="#" method="post" id="inventario">
    <div class="row">
        <div class="col-lg-6">
            <h5><label style="color:#E65C00;" for="cantidad" class="badge badge-ligh">Cantidad:</label></h5>
            <input id="cantidad" name="SCantidad" class="form-control" type="number" value="0" min="0" require> <br>
        </div>
        <div class="col-lg-6">
            <div id="productos">
                <h5><label for="inproducto" class="badge badge-ligh">Producto:</label></h5>
                <input id="inproducto" class="form form-control" list="lproductos" name="DlProductos" autocomplete="off" required>
                <datalist id="lproductos">
                    <?php
                    $con = new Models\Conexion();
                    $negocios = $_SESSION['idnegocio'];
                    $datos = false;
                    $query = "SELECT clientesab_idclienteab FROM negocios WHERE idnegocios = '$negocios'";
                    $result = $con->consultaRetorno($query);
                    $query = "SELECT nombre,color,marca,talla_numero FROM producto
                            WHERE clientesab_id_clienteab = '$result[clientesab_idclienteab]' AND pestado = 'A'";
                    $row = $con->consultaListar($query);
                    $con->cerrarConexion();


                    while ($result = mysqli_fetch_array($row)) {
                        ?>

                    <?php $datos = true;
                        echo "<option value='" . $result['nombre'] . " " . $result['marca'] . " color " . $result['color'] . " talla " . $result['talla_numero'] . "'> "; ?>
                    <?php
                    }
                    if ($datos == false) {
                        echo "<script>document.getElementById('inproducto').disabled = true;</script>";
                    } ?>

                </datalist>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <input type="submit" class="col-3 btn btn-lg btn-block btn-dark" name="" value="Guardar">
    </div>
</form>