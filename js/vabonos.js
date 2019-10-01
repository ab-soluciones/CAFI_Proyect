$(document).ready(function () {

    obtenerDatosTabla();

    function obtenerDatosTabla() {
        $.ajax({
          url: 'tablaAbonos.php',
          type: 'GET',
          success: function (response) {
            let datos = JSON.parse(response);
            let template = '';
            datos.forEach(datos => {
              template += `
                    <tr>
                    <td class="text-nowrap text-center d-none">${datos.id}</td>
                    <td class="text-nowrap text-center">${datos.a_estado}</td>
                    <td class="text-nowrap text-center">${datos.cantidad}</td>
                    <td class="text-nowrap text-center">${datos.pago}</td>
                    <td class="text-nowrap text-center">${datos.cambio}</td>
                    <td class="text-nowrap text-center">${datos.fecha}</td>
                    <td class="text-nowrap text-center">${datos.hora}</td>
                    <td class="text-nowrap text-center">${datos.nombre_cliente}</td>
                    <td class="text-nowrap text-center">${datos.nombre}</td>
                    <td class="text-nowrap text-center"><a href="VConsultasAdeudos.php?ad=${datos.adeudos_id}"># ${datos.adeudos_id} </a></td>
                    <th style="width:100px;">
                    <div class="row">
                        <a data-toggle="modal" data-target="#modalForm" id="beditar" style="margin: 0 auto;" class="btn btn-danger" href="#">
                            Editar
                        </a>
                    </div>
                </th>
                </tr>`;
            });
            $('#cuerpo').html(template);
          }
        })
      }

      $(document).on('click','#beditar', function () {
        var valores = "";
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
          valores += $(this).html() + "?";
        });
        datos = valores.split("?");
        $('#id').val(datos[0]);
        $('#estadoActual').val(datos[1]);
        $('#estado').val(datos[1]);
     
      });

      $('#bclose').click(function(){
        $('.modal').modal('hide');
      });

      $('#formabonos').submit(function(e){
        const postData = {
            idAbono: $('#id').val(),
            estadoActual: $('#estadoActual').val(),
            estadoNuevo: $('#estado').val()
          };
          
          $.post('post-edit.php', postData, function (response) {

            $('#formabonos').trigger('reset');  
            console.log(response);
            obtenerDatosTabla();
            if (response) {
              swal({
                title: 'Exito',
                text: 'Datos guardados satisfactoriamente',
                type: 'success'
              });
            } 

          });
          e.preventDefault();
    });

});