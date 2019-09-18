$(document).ready(function () {

    $('.mostrar').click(function(){
        var valores = "";
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
          valores += $(this).html() + "?";
        });
        datos = valores.split("?");

        const postData = {
            venta: datos[1]
        }
        console.log(postData);
        $.post('datosMostrarVenta.php', postData, function (response) {
            let datos = JSON.parse(response);
            console.log(datos);
            let template = '';
            datos.forEach(datos => {
              template += `
                    <tr>
                    <td>${datos.cantidad_producto}</td>
                    <td>${datos.nombre}</td>
                    <td><img width=150% height=50% src=${datos.imagen} ></td>
                    <td>${datos.marca}</td>
                    <td>${datos.color}</td>
                    <td>${datos.unidad_medida}</td>
                    <td>${datos.talla_numero}</td>
                    <td>${datos.precio_venta}</td>
                    <td>${datos.subtotal}</td>
                </tr>`;
            });
            $('#cuerpo').html(template);
          });
      });


    $(document).on('click','#beditar', function () {
        var valores = "";
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
          valores += $(this).html() + "?";
        });
        datos = valores.split("?");
        console.log(datos);
        $('#id').val(datos[1]);
        $('#estado').val(datos[9]);
        $('#estadoActual').val(datos[9]);
        console.log(datos);
      });

      $('#bclose').click(function(){
        $('.modal').modal('hide');
      });

    $('#formConsulta').submit(function(e){
        const postData = {
            idConsulta: $('#id').val(),
            estadoActualConsulta: $('#estadoActual').val(),
            estadoNuevoConsulta: $('#estado').val()
          };
          
          $.post('post-edit.php', postData, function (response) {
            $('#formConsulta').trigger('reset');  
            console.log(response);
            if (response == "1") {
              swal({
                title: 'Exito',
                text: 'Datos guardados satisfactoriamente',
                type: 'success'
              },
              function (isConfirm){
                  if(isConfirm){
                    location.reload();
                  }
              });
            } else if(response == "2"){
                swal({
                    title: 'Exito',
                    text: 'Datos guardados satisfactoriamente',
                    type: 'success'
                  },
                  function (isConfirm){
                      if(isConfirm){
                        location.reload();
                      }
                  }
                  );
            } else {
              swal({
                title: 'Alerta',
                text: 'Datos no guardados, comprovar datos unicos',
                type: 'warning'
              });
            }
          });
          e.preventDefault();
    });
});