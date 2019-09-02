 //vsuscripciones
 $(document).ready(function () {
    let idnegocio = "";
    let editar = false;
    optenerDatosTabla();
   
    $('#bclose').click(function () {
      $('.modal').modal('hide');
    });
   
    $('.close').click(function () {
       $('#formunegocio').trigger('reset');
     });
   
    function optenerDatosTabla() {
      $.ajax({
        url: 'tablasuscripcion.php',
        type: 'GET',
        success: function (response) {
          let datos = JSON.parse(response);
          let template = '';
          datos.forEach(datos => {
            template += `
            <tr>
            <td>${datos.id}</td>
            <td>${datos.fecha_activacion}</td>
            <td>${datos.fecha_vencimiento}</td>
            <td>${datos.estado}</td>
            <td>${datos.negocio}</td>
            <td>$${datos.monto}</td>
            <td>${datos.registro}</td>
            <th style="width:100px;">
                <div class="row">
                    <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-secondary" href="#">
                        <img src="img/edit.png">
                    </a>
                </div>
            </th>
        </tr>`;
          });
          $('#cuerpo').html(template);
        }
      })
    }
   
   
    $('#formunegocio').submit(function (e) {
      const postData = {
        id: idnegocio,
        nombre: $('#nombre').val(),
        domicilio: $('#dom').val(),
        ciudad: $('#cd').val(),
        telefono: $('#tel').val(),
        impresora: $('#impresora').val(),
        clienteab: $('#incliente').val()
      };
   
      let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
      $.post(url, postData, function (response) {
        $('#formunegocio').trigger('reset');
        editar = false;
        if (response === "1") {
          swal({
            title: 'Exito',
            text: 'Datos guardados satisfactoriamente',
            type: 'success'
          });
        } else {
          swal({
            title: 'Alerta',
            text: 'Datos no guardados, compruebe los campos unicos',
            type: 'warning'
          });
        }
        optenerDatosTabla();
      });
      e.preventDefault();
    })
   
    $(document).on('click', '.beditar', function () {
      var valores = "";
      // Obtenemos todos los valores contenidos en los <td> de la fila
      // seleccionada
      $(this).parents("tr").find("td").each(function () {
        valores += $(this).html() + "?";
      });
      datos = valores.split("?");
      idsuscripcion = datos[0];
      $('#fecha1').val(datos[1]);
      $('#fecha2').val(datos[2]);
      $('#estado').val(datos[3]);
      $('#monto').val(datos[5]);
      $('#innegocio').val(datos[4]);
      editar = true;
   
    })
   });