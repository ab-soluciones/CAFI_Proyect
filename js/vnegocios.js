 //vnegocios
 $(document).ready(function () {
 let idnegocio = "";
 let editar = false;
 optenerDatosTabla();



 $('.close').click(function () {
    $('#formulario').trigger('reset');
    $("#mensaje").css("display", "none");
  });

 function optenerDatosTabla() {
   $.ajax({
     url: 'tablanegocio.php',
     type: 'GET',
     success: function (response) {
       let datos = JSON.parse(response);
       let template = '';
       datos.forEach(datos => {
         template += `
               <tr>
               <td class="text-nowrap text-center">${datos.id}</td>
               <td class="text-nowrap text-center">${datos.nombre}</td>
               <td class="text-nowrap text-center">${datos.giro}</td>
               <td class="text-nowrap text-center">${datos.domicilio}</td>
               <td class="text-nowrap text-center">${datos.ciudad}</td>
               <td class="text-nowrap text-center">${datos.telefono}</td>
               <td class="text-nowrap text-center">${datos.impresora}</td>
               <td class="text-nowrap text-center">${datos.cliente}</td>
               <td class="text-nowrap text-center">${datos.usuarioab}</td>
               <th class="text-nowrap text-center" style="width:100px;">
                   <div class="row">
                       <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
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


 $('#formulario').submit(function (e) {
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

     if (response === "1") {
       swal({
         title: 'Exito',
         text: 'Datos guardados satisfactoriamente',
         type: 'success'
       },
       function (isConfirm){
           if(isConfirm){
            $('#formulario').trigger('reset');
            $('.modal').modal('hide');
            editar = false;
           }
           $('.modal').modal('hide');       });
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
 });


 $(document).on('click', '.beditar', function () {
   var valores = "";
   // Obtenemos todos los valores contenidos en los <td> de la fila
   // seleccionada
   $(this).parents("tr").find("td").each(function () {
     valores += $(this).html() + "?";
   });
   datos = valores.split("?");
   idnegocio = datos[0];
   $('#Tnombre').val(datos[1]);
   $('#Tgiro').val(datos[2]);
   $('#Tdomicilio').val(datos[3]);
   $('#Tcalle_numero').val(datos[4]);
   $('#Tcolonia').val(datos[5]);
   $('#Tlocalidad').val(datos[6]);
   $('#Tmunicipio').val(datos[7]);
   $('#Testado').val(datos[8]);
   $('#Tpais').val(datos[9]);
   $('#Ttelefono').val(datos[10]);
   $('#Simpresora').val(datos[11]);
   $('#Sdueno').val(datos[12]);
   $('#Susuarioab').val(datos[13]);
   editar = true;

 });
});
