$(document).ready(function(){
    let idretiro = "";
    let efectivo = "";
    let banco = "";
    let editar = false;
    obtenerDatosDeTabla();

    $('.bclose').click(function(){
        obtenerDinero();
    });
    function obtenerDinero(){
        $.ajax({
            url: 'consultaVRetiros.php',
            type: 'GET',
            success: function(response){
                let datos = JSON.parse(response);
                let template = '';

                datos.forEach(datos => {
                    efectivo = datos.efectivo;
                    banco = datos.banco;
                    console.log(efectivo);
                    console.log(banco);
                    template +=`
                    <td>${datos.efectivo}</td>
                    <td>${datos.banco}</td>
                    `;
                });
                $('#cuerpoEfectivo').html(template);
            }
        })
    }

    $('.bclose').click(function () {
        $('.modal').modal('hide');
    });

    $('.close').click(function () {
        $('#formuventas').trigger('reset');
    });

    function obtenerDatosDeTabla(){
        $.ajax({
            url: 'tablaventas.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';

                datos.forEach(datos => {
                    template +=`
                    <tr>
                    <td>${datos.id}</td>
                    <td>${datos.concepto}</td>
                    <td>${datos.tipo}</td>
                    <td>${datos.cantidad}</td>
                    <td>${datos.descripcion}</td>
                    <td>${datos.fecha}</td>
                    <td>${datos.hora}</td>
                    <td>${datos.estado}</td>
                    <td>${datos.nombre}</td>
                    <th style="width:100px;">
                    <div class="row">
                        <a data-toggle="modal" data-target="#modalForm2" style="margin: 0 auto;" class="beditar btn btn-secondary" href="#">
                            <img src="img/edit.png">
                        </a>
                    </div>
                </th>
                   </tr> `;
                });
                $('#cuerpo').html(template);
            }
        })
    }

    $('#formuventas').submit(function(e){

            const postData = {
                id: idretiro,
                cantidad: $('#cant').val(),
                de: $('#de').val(),
                concepto: $('#concepto').val(),
                descripcion: $('#desc').val(),
                efectivo1: efectivo,
                banco1: banco
            };

            let url = 'post-guardar.php';

        $.post(url,postData,function(response){
            $('#formuventas').trigger('reset');
                if (response === "1") {
                    swal({
                        title: 'Exito',
                        text: 'Datos guardados satisfactoriamente',
                        type: 'success'
                    });
                }else if(response == "CorteErroneo"){
                    swal({
                        title: 'Alerta',
                        text: 'Proceso erroneo, No puede hacer corte de caja en banco',
                        type: 'warning'
                    });
                }else if(response == "SaldoInsufucienteCaja"){
                    swal({
                        title: 'Alerta',
                        text: 'Saldo insuficiente en caja',
                        type: 'warning'
                    });
                }else if(response == "SaldoInsufucienteBanco"){
                    swal({
                        title: 'Alerta',
                        text: 'Saldo insuficiente en Banco',
                        type: 'warning'
                    });
                } else {
                    swal({
                        title: 'Alerta',
                        text: 'Datos no guardados, compruebe los campos unicos',
                        type: 'warning'
                    });
                }
                obtenerDatosDeTabla();
        });
        e.preventDefault();
    });

    $('#formuventas2').submit(function(e){

        const postData = {
            id: idretiro,
            estado: $('#estado').val()
        };

        let url = 'post-edit.php';

    $.post(url,postData,function(response){

        $('#formuventas').trigger('reset');
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
            obtenerDatosDeTabla();
    });
    e.preventDefault();
});


    $(document).on('click', '.beditar', function () {
        var valores = "";
        $(this).parents("tr").find("td").each(function () {
          valores += $(this).html() + "?";
        });

        datos = valores.split("?");
        idretiro = datos[0];
        $('#estado').val(datos[7]);

        editar = true;

      });


});
