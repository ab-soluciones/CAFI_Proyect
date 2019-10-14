 //vnegocios
 $(document).ready(function () {
 let idnegocio = "";
 let editar = false;
 optenerDatosTabla();

 $('.bclose').click(function () {
   $('.modal').modal('hide');
 });

 $('.close').click(function () {
    $('#formunegocio').trigger('reset');
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
   $('#nombre').val(datos[1]);
   $('#dom').val(datos[2]);
   $('#cd').val(datos[3]);
   $('#tel').val(datos[4]);
   $('#impresora').val(datos[5]);
   $('#incliente').val(datos[6]);
   editar = true;

 });
});