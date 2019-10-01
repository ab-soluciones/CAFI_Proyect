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
                    <td class="text-nowrap text-center">${datos.id}</td>
                    <td class="text-nowrap text-center">${datos.cantidad}</td>
                    <td class="text-nowrap text-center">${datos.tipo}</td>
                    <td class="text-nowrap text-center">${datos.forma_ingreso}</td>
                    <td class="text-nowrap text-center">${datos.fecha}</td>
                    <td class="text-nowrap text-center">${datos.estado}</td>
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

    $('#formotrosingresos').submit(function(e){
        
        const postData = {
            id: idotrosIngresos,
            cantidad: $('#can').val(),
            tipo: $('#tipo').val(),
            formaImgreso: $('#fingreso').val(),
            fecha: $('#fecha').val(),
            estatus: $('#voestado').val(),
        };
        
        

        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: postData,

            success: function(response) {
                
           $('#formotrosingresos').trigger('reset');
           obtenerDatosTablaOtrosIngresos();
           editar = false;
           if(response == "1"){
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