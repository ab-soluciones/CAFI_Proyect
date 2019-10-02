$(document).ready(function () {
  //VUsuarios_ab
  let editar=false;
  let idusuario="";
  optenerDatosTablaUsuarios();

  $('.close').click(function () {
    $('#formuusers').trigger('reset');
    $(".contro").hide();
  });
  
  $('.clearForm').click(function () {
    $('#formuusers').trigger('reset');
  });

  $('#login').keyup(function(){
    var username = $('#login').val();
    if(username.length >= 3){
      $(".contro").show();
        $.post("username_check.php", {username2: username}, function(data, status){
            $("#status").html(data);
            });
    }else{
            $(".contro").hide();
    }
});
  


  $('#formuusers').submit(function (e) {
    const postData = {
      id: idusuario,
      nombre:$('#nombre').val(),
      apt: $('#apt').val(),
      apm: $('#apm').val(),
      acceso:$('#acceso').val(),
      login: $('#login').val(),
      password: $('#pass').val(),
      estado: $('#estadousers').val()
    };
 
    let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
    $.post(url, postData, function (response) {

   
      if (response === "1") {
        swal({
          title: 'Exito',
          text: 'Datos guardados satisfactoriamente',
          type: 'success'
        },
        function (isConfirm){
            if(isConfirm){
              editar = false;
              $('#formunegocio').trigger('reset');
              $(".contro").hide();
              $('.modal').modal('hide');
            }
        });
      } else {
        swal({
          title: 'Alerta',
          text: 'Datos no guardados, compruebe los campos unicos',
          type: 'warning'
        });
      }
      optenerDatosTablaUsuarios();
    });
    e.preventDefault();
  })

  function optenerDatosTablaUsuarios() {
    $.ajax({
      url: 'tablausuariosab.php',
      type: 'GET',
      success: function (response) {
        let datos = JSON.parse(response);
        let template = '';
        datos.forEach(datos => {
          template += `
                <tr>
                <td class="text-nowrap text-center">${datos.id}</td>
                <td class="text-nowrap text-center">${datos.nombre}</td>
                <td class="text-nowrap text-center">${datos.apaterno}</td>
                <td class="text-nowrap text-center">${datos.amaterno}</td>
                <td class="text-nowrap text-center">${datos.acceso}</td>
                <td class="text-nowrap text-center">${datos.login}</td>
                <td class="text-nowrap text-center">${datos.password}</td>
                <td class="text-nowrap text-center">${datos.estado}</td>
                <th class="text-nowrap text-center" style="width:100px;">
                <div class="row">
                    <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditarusers btn btn-danger" href="#">
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

  $(document).on('click', '.beditarusers', function () {
    var valores = "";
    // Obtenemos todos los valores contenidos en los <td> de la fila
    // seleccionada
    $(this).parents("tr").find("td").each(function () {
      valores += $(this).html() + "?";
    });
    datos = valores.split("?");
    idusuario = datos[0];
    $('#nombre').val(datos[1]);
    $('#apt').val(datos[2]);
    $('#apm').val(datos[3]);
    $('#acceso').val(datos[4]);
    $('#login').val(datos[5]);
    $('#pass').val(datos[6]);
    $('#estadousers').val(datos[7]);
    editar = true;

  })
   });