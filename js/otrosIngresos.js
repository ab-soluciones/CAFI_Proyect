$(document).ready(function (){
    //Otros ingresos
    let editar = false;
    let idotrosIngresos = "";
    obtenerDatosTablaOtrosIngresos();

    $('.close').click(function(){
        $('#formotrosingresos').trigger('reset');
    });

    function obtenerDatosTablaOtrosIngresos(){
        $.ajax({
            url: 'tablaOtrosIngresos.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
                datos.forEach(datos => {
                    template+=`
                    <tr>
                    <td>${datos.id}</td>
                    <td>${datos.cantidad}</td>
                    <td>${datos.tipo}</td>
                    <td>${datos.forma_ingreso}</td>
                    <td>${datos.fecha}</td>
                    <td>${datos.estado}</td>
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

    $('#formotrosingresos').submit(function(e){
        const postData = {
            id: idotrosIngresos,
            cantidad: $('#can').val(),
            tipo: $('#tipo').val(),
            formaImgreso: $('#fingreso').val(),
            fecha: $('#fecha').val(),
            estatus: $('#voestado').val(),
        };

        console.log(postData);

        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
        $.post(url,postData,function(response){
            console.log(response);
           $('#formotrosingresos').trigger('reset');
           obtenerDatosTablaOtrosIngresos();
           editar = false;
           if(response === "1"){
            swal({
                title: 'Exito',
                text: 'Datos guardados satisfactoriamente',
                type: 'success'
            });
           } else{
            swal({
                title: 'Alerta',
                text: 'Datos no guardados, compruebe los campos unicos',
                type: 'warning'
            });
           }
        });
        e.preventDefault();
    });

    $(document).on('click','.beditar',function(){
        var valores = "";
        $(this).parents("tr").find("td").each(function(){
            valores+= $(this).html() + "?";
        });
        datos = valores.split("?");
        idotrosIngresos = datos[0];
        $('#can').val(datos[1]);
        $('#tipo').val(datos[2]);
        $('#fingreso').val(datos[3]);
        $('#fecha').val(datos[4]);
        $('#voestado').val(datos[5]);
        editar = true;
    });

});