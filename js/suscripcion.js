$(document).ready (function(){



  $('.Bagregar').click(function(){
    let template='';
    template=`
    <div id="divnegocio">
        <input id="innegocio" class="form form-control" list="negocios" name="DlNegocios" required autocomplete="off">
        <datalist id="negocios">
            <?php
            $datos = false;
            $con = new Models\Conexion();
            $query = "SELECT nombre_negocio,ciudad,domicilio FROM negocios ORDER BY nombre_negocio ASC";
            $row = $con->consultaListar($query);

            while ($result = mysqli_fetch_array($row)) {
                ?>

            <?php $datos = true;
                echo "<option value='" . $result['nombre_negocio'] . " " . $result['domicilio'] . " " . $result['ciudad'] . "'> "; ?>
            <?php
            }
            if ($datos == false) {
                echo "<script>document.getElementById('innegocio').disabled = true;</script>";
            } ?>

        </datalist>
        <br>
    </div>
  `;
  $('#pintar').html(template);
  });
  $('.beditar').click(function(){
    $("#divnegocio").remove();
  });
  });
