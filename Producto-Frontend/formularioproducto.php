<form class="form-group" enctype="multipart/form-data" id="formproducto" method="post">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="general">Codigo:</h5>
            <input id="cb" class="form form-control" type="text" name="TCodigoB" onkeypress="return check(event)" placeholder="0000000000000">
        </div>
        <div class="col-lg-6">
            <h5 class="general">Nombre:</h5>
            <input id="nombre" class="form form-control" type="text" name="TNombre" onkeypress="return check(event)" placeholder="Nombre" autocomplete="off" required>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-lg-12">
            <h5><label for="imagen" class="general">Imagen:</label></h5>
            
            <div id="preview">
                <img id="imagenmostrar" src="" width="100" height="100" />
            </div>

            <div class="rowMostrar">
            </div>

            <div>
                <input onclick="ejecutar();" style="margin-left: 10px; margin-top: 10px;" id="imagen" style="margin-left: 4px;" type="file" name="FImagen" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h5 class="general">Color:</h5>
            <input id="color" class="form form-control" type="text" onkeypress="return check(event)" name="TColor" placeholder="Color" autocomplete="off" required>
        </div>
        <div class="col-lg-6">
            <h5 class="general">Marca:</h5>
            <input id="marca" class="form form-control" type="text" onkeypress="return check(event)" name="TMarca" placeholder="Marca" autocomplete="off" required>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h5 class="general">Descripcion:</h5>
            <textarea id="desc" name="TADescription" rows="2" class="form-control bg-dark text-white" placeholder="Agregue su descripcion"></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h5 class="general">Unidad de Medida:</h5>
            <select id="um" class="form form-control" type="text" name="DLUnidad">
                <option value="Pieza">Pieza</option>
                <option value="Par">Par</option>
                <option value="Paquete">Paquete</option>
            </select>
        </div>
        <div class="col-lg-6">
            <h5 class="general">Tipo de producto:</h5>
            <div class="row" style="margin: 0 auto;">
                <div>
                    <button onclick="activarDivTalla();" id="tpr" type="button" class="btn btn-danger">Ropa</button>
                    <button onclick="activarDivMedida();" id="tpc" type="button" class="btn btn-success">Calzado</button>
                    <button onclick="activarDivOtro();" id="tpo" type="button" class="btn btn-warning">Otro</button><br>
                    <input style="display: none" id="tipo_produc" type="text" name="TTipoP">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div style="display: none;" id="divtalla">
                <h5 class="general">Tallas de ropa:</h5>
                <select id="ta" class="form form-control" name="SlcTalla" placeholder="Ingrese la talla" value="">
                    <option>XS</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                </select> <br>
            </div>
            <div style="display: none;" id="divmedida">
                <h5 class="general">Medidas de calzado:</h5>
                <select id="med" class="form form-control" name="SlcMedida" placeholder="Ingrese la Medida" value="">
                    <?php
                    for ($i = 1; $i < 34; $i++) {
                        for ($j = 0; $j < 2; $j++) {
                            if ($j === 0) {
                                echo "<option>$i </option>";
                            } else if ($j > 0) {
                                $media = $i + 0.5;
                                echo "<option>$media</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h5 class="general">Precio de Compra:</h5>
            <input id="precioc" class="form form-control" type="text" onkeypress="return check(event)" name="TPrecioC" placeholder="$" autocomplete="off" required><br>
        </div>
        <div class="col-lg-6">
            <h5 class="general">Precio de Venta:</h5>
            <input id="preciov" class="form form-control" type="text" onkeypress="return check(event)" name="TPrecioVen" placeholder="$" autocomplete="off" required><br>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h5 class="general">Estado:</h5>
            <select name="REstado" id="estado" class="form form-control">
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="mt-4 col-12 btn btn-lg btn-block btn-primary bclose">Guardar</button><br>
    </div>  
</form>
