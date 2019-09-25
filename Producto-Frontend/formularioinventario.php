<form class="form-group" id="inventario" method="POST">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="importante">Cantidad:</h5>
            <input id="cantidad" name="SCantidad" class="form-control bg-dark text-white" type="number" value="0" min="0" require> <br>
        </div>
        <div class="col-lg-6">
            <div id="productos">
                <h5 class="general">Producto:</h5>
                <input id="inproducto" class="form form-control" list="lproductos" name="DlProductos" autocomplete="off" required>
                <datalist id="lproductos">
                </datalist>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <button type="submit" class="col-12 btn btn-lg btn-primary bclose">Guardar</button>
    </div>
</form>
