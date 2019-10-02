$(document).ready(function(){
    //clientes
    let editar = false;
    let idclientes = "";
    obtenerDatosTablaCliente();

    $('.close').click(function(){
        $('#formclientes').trigger('reset');
    });

    function obtenerDatosTablaCliente(){
        $.ajax({
            url: 'tablaClientes.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
                datos.forEach(datos => {
                    template+=`
                    <tr>
                    <td class="text-nowrap text-center">${datos.id}</td>
                    <td class="text-nowrap text-center">${datos.nombre}</td>
                    <td class="text-nowrap text-center">${datos.apt}</td>
                    <td class="text-nowrap text-center">${datos.apm}</td>
                    <td class="text-nowrap text-center">${datos.tipodoc}</td>
                    <td class="text-nowrap text-center">${datos.numdoc}</td>
                    <td class="text-nowrap text-center">${datos.direccion}</td>
                    <td class="text-nowrap text-center">${datos.telefono}</td>
                    <td class="text-nowrap text-center">${datos.correo}</td>
                    <td class="text-nowrap text-center">${datos.estado}</td>
                    <th style="width:100px; class="p-1">
                        <div class="row">
                            <a  data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                                Editar
                            </a>
                        </div>
                    </th>`;
                });
                $('#cuerpo').html(template);
            }
        });
    }

    $('#bclose').click(function(){
        
    });

    $('#formclientes').submit(function(e){
        const postData = {
            id: idclientes,
            nombre: $('#nombre').val(),
            apt: $('#apt').val(),
            apm: $('#apm').val(),
            documento: $('#documento').val(),
            numdoc: $('#numdoc').val(),
            direccion: $('#dir').val(),
            telefono: $('#tel').val(),
            email: $('#email').val(),
            estado: $('#vcestado').val(),
        };

        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';

        $.post(url,postData,function(response){

            obtenerDatosTablaCliente();
            if(response === "1"){
                swal({
                    title: 'Exito',
                    text: 'Datos guardados satisfactoriamente',
                    type: 'success'
                },
                function (isConfirm) {
                    if (isConfirm) {
                        console.log("si entro");
                        $('#formclientes').trigger('reset');
                        $('.modal').modal('hide');
                        editar = false;
                    }
                  });     
            }else{
                swal({
                    title: 'Alerta',
                    text: 'Datos no guardados, compruebe los campos unicos',
                    type: 'warning'
                });
            }
        });
        e.preventDefault();
    });

    $(document).on('click','.beditar', function(){
        var valores = "";
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        datos = valores.split("?");

        idclientes = datos[0];
        $('#nombre').val(datos[1]);
        $('#apt').val(datos[2]);
        $('#apm').val(datos[3]);
        $('#documento').val(datos[4]);
        $('#numdoc').val(datos[5]);
        $('#dir').val(datos[6]);
        $('#tel').val(datos[7]);
        $('#email').val(datos[8]);
        $('#vcestado').val(datos[9]);
        editar = true;
    })
    
});