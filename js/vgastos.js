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
                    <td>${datos.id}</td>
                    <td>${datos.concepto}</td>
                    <td>${datos.pago}</td>
                    <td>${datos.descripcion}</td>
                    <td>${datos.monto}</td>
                    <td>${datos.estado}</td>
                    <td>${datos.fecha}</td>
                    <td>${datos.nombre}</td>
                    <th style="width:100px;">
                        <div class="row">
                            <a  data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-secondary" href="#">
                                <img src="img/edit.png">
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