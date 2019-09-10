$(document).ready(function () {
    //Vgastos
    let editar = false;
    let idgastos = "";
    obtenerDatosTablaGastos();

    $('.close').click(function(){
        $('#formgastos').trigger('reset');
    });

    function obtenerDatosTablaGastos(){
        $.ajax({
            url: 'tablaGastos.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
                datos.forEach(datos => {
                    template+=`
                    <tr>
                    <td class="text-nowrap text-center">${datos.id}</td>
                    <td class="text-nowrap text-center">${datos.concepto}</td>
                    <td class="text-nowrap text-center">${datos.pago}</td>
                    <td class="text-nowrap text-center">${datos.descripcion}</td>
                    <td class="text-nowrap text-center">${datos.monto}</td>
                    <td class="text-nowrap text-center">${datos.estado}</td>
                    <td class="text-nowrap text-center">${datos.fecha}</td>
                    <td class="text-nowrap text-center">${datos.nombre}</td>
                    <th style="width:100px;">
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
        $('.modal').modal('hide');
    });

    $('#formgastos').submit(function(e){
        const postData = {
            id: idgastos,
            concepto: $('#concepto').val(),
            pago: $('#pago').val(),
            descripcion: $('#desc').val(),
            monto: $('#monto').val(),
            estado: $('#vgestado').val(),
            fecha: $('#fecha').val(),
        };


        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
        
        $.post(url,postData,function(response){
            $('#formgastos').trigger('reset');
            obtenerDatosTablaGastos();
            editar = false;
            if(response === "1"){
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
        });
        e.preventDefault();
    });

    $(document).on('click','.beditar', function(){
        var valores = "";
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        datos = valores.split("?");

        idgastos = datos[0];
        $('#concepto').val(datos[1]);
        $('#pago').val(datos[2]);
        $('#desc').val(datos[3]);
        $('#monto').val(datos[4]);
        $('#vgestado').val(datos[5]);
        $('#fecha').val(datos[6]);
        editar = true;
    });
});