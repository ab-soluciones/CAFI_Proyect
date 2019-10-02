$(document).ready(function () {
    //clientesab
    let editar = false;
    let idclienteab = "";
    optenerDatosTablaClientesab();


    
    function optenerDatosTablaClientesab() {
        $.ajax({
            url: 'tablaclientesab.php',
            type: 'GET',
            success: function (response) {
                let datos = JSON.parse(response);
                let template = '';
                datos.forEach(datos => {
                    template += `
                    <tr>
                    <td  class="text-nowrap text-center">${datos.id}</td>
                    <td  class="text-nowrap text-center">${datos.nombre}</td>
                    <td  class="text-nowrap text-center">${datos.apt}</td>
                    <td  class="text-nowrap text-center">${datos.apm}</td>
                    <td  class="text-nowrap text-center">${datos.tipodoc}</td>
                    <td  class="text-nowrap text-center">${datos.numdoc}</td>
                    <td  class="text-nowrap text-center">${datos.direccion}</td>
                    <td  class="text-nowrap text-center">${datos.telefono}</td>
                    <td  class="text-nowrap text-center">${datos.correo}</td>
                    <td  class="text-nowrap text-center">${datos.login}</td>
                    <td  class="text-nowrap text-center">${datos.password}</td>
                    <td  class="text-nowrap text-center">${datos.estado}</td>
                    <td  class="text-nowrap text-center">${datos.registro}</td>
                    <th  class="text-nowrap text-center" style="width:100px;">
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

    $('.close').click(function () {
        $('#formclienteab').trigger('reset');
        $('.contro').hide();
    });

    $('#login').keyup(function(){
        var username = $('#login').val();
        if(username.length >= 3){
            $('.contro').show();
            $.post("username_check.php", {username3: username}, function(data, status){
                $("#status").html(data);
                });
        }else{
            $('.contro').hide();
        }
    });

    $('#formclienteab').submit(function (e) {
        const postData = {
            id: idclienteab,
            nombre: $('#nombre').val(),
            apt: $('#apt').val(),
            apm: $('#apm').val(),
            doc: $('#documento').val(),
            numdoc: $('#numdoc').val(),
            dir: $('#dir').val(),
            tel: $('#tel').val(),
            email: $('#email').val(),
            login: $('#login').val(),
            password: $('#pass').val(),
            estado: $('#estado').val()
        };

        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
        $.post(url, postData, function (response) {
            

            optenerDatosTablaClientesab();
            
            if (response === "1") {
                swal({
                    title: 'Exito',
                    text: 'Datos guardados satisfactoriamente',
                    type: 'success'
                },
                function (isConfirm){
                    if(isConfirm){
                        editar = false;
                        $('#formclienteab').trigger('reset');
                        $('.contro').hide();
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
            
        });
        e.preventDefault();
    })


    $(document).on('click', '.beditar', function () {
        var valores = "";
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        datos = valores.split("?");
       
        idclienteab = datos[0];
        $('#nombre').val(datos[1]);
        $('#apt').val(datos[2]);
        $('#apm').val(datos[3]);
        $('#documento').val(datos[4]);
        $('#numdoc').val(datos[5]);
        $('#dir').val(datos[6]);
        $('#tel').val(datos[7]);
        $('#email').val(datos[8]);
        $('#login').val(datos[9]);
        $('#pass').val(datos[10]);
        $('#estado').val(datos[11]);
        editar = true;

    })
});