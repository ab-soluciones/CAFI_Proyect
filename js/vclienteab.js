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
                    <td>${datos.id}</td>
                    <td>${datos.nombre}</td>
                    <td>${datos.apt}</td>
                    <td>${datos.apm}</td>
                    <td>${datos.tipodoc}</td>
                    <td>${datos.numdoc}</td>
                    <td>${datos.direccion}</td>
                    <td>${datos.telefono}</td>
                    <td>${datos.correo}</td>
                    <td>${datos.login}</td>
                    <td>${datos.password}</td>
                    <td>${datos.estado}</td>
                    <td>${datos.registro}</td>
                    <th style="width:100px;">
                        <div class="row">
                            <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-secondary" href="#">
                                <img src="img/edit.png">
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
    });

    $('#bclose').click(function () {
        $('.modal').modal('hide');
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
            console.log(response);
            $('#formclienteab').trigger('reset');
            optenerDatosTablaClientesab();
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