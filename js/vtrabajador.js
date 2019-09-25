$(document).ready(function(){
    //Trabajadores
    let editar = false;
    let idtrabajador = "";
    let idnego = "";
    var id = $('.sucursal').val();
    idSesion(id);
    obtenerDatosTablaTrabajador();

    function idSesion(id){
        $.ajax({
            url: 'sesionTrabajador.php',
            type: 'POST',
            data: {idSucursal:id}
        });
        obtenerDatosTablaTrabajador();
    }
    
    $('#login').keyup(function(){
        var username = $('#login').val();
        if(username.length >= 3){

            $.post("username_check.php", {username: username}, function(data, status){
                $("#status").html(data);
                });
        }
    });

    $('.sucursal').change(function(){
        idSesion($(this).val());
    });


    $('.close').click(function(){
        $('#formtrabajador').trigger('reset');
    });

    function obtenerDatosTablaTrabajador(){

        $.ajax({
            url: 'tablaTrabajador.php',
            type: 'GET',
            success: function(response){
                
                let datos = JSON.parse(response);
                let template = '';
                datos.forEach(datos => {
                    template+=`
                    <tr>
                    <td class="text-nowrap text-center">${datos.id}</td>
                    <td class="text-nowrap text-center">${datos.nombre}</td>
                    <td class="text-nowrap text-center">${datos.apaterno}</td>
                    <td class="text-nowrap text-center">${datos.amaterno}</td>
                    <td class="text-nowrap text-center">${datos.tipo_documento}</td>
                    <td class="text-nowrap text-center">${datos.numero_documento}</td>
                    <td class="text-nowrap text-center">${datos.direccion}</td>
                    <td class="text-nowrap text-center">${datos.telefono}</td>
                    <td class="text-nowrap text-center">${datos.correo}</td>
                    <td class="text-nowrap text-center">${datos.acceso}</td>
                    <td class="text-nowrap text-center">${datos.login}</td>
                    <td class="text-nowrap text-center">${datos.password}</td>
                    <td class="text-nowrap text-center">${datos.sueldo}</td>
                    <td class="text-nowrap text-center">${datos.estado}</td>
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

    $('#bclose').click(function () {
        $('.modal').modal('hide');
    });

    $('#formtrabajador').submit(function(e){

        idnego = $('#agregarloa').val();

        const postData = {
            id: idtrabajador,
            nombre: $('#nombre').val(),
            apt: $('#apt').val(),
            apm: $('#apm').val(),
            doc: $('#documento').val(),
            numdoc: $('#numdoc').val(),
            dir: $('#dir').val(),
            tel: $('#tel').val(),
            email: $('#email').val(),
            acceso: $('#acceso').val(),
            login: $('#login').val(),
            contrasena: $('#contrasena').val(),
            sueldo: $('#sueldo').val(),
            agregarloa: $('#agregarloa').val(),
            estado:$('#estado').val()
        };

        let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
        $.post(url,postData, function (response) {
            $('#formclienteab').trigger('reset');
            idSesion(idnego);
            obtenerDatosTablaTrabajador();
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
        $('#formtrabajador').trigger('reset');
        e.preventDefault();
    });

    $(document).on('click','.beditar', function () {
        var valores = "";
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        datos = valores.split("?");
       console.log(datos);
        idtrabajador = datos[0];
        $('#nombre').val(datos[1]);
        $('#apt').val(datos[2]);
        $('#apm').val(datos[3]);
        $('#documento').val(datos[4]);
        $('#numdoc').val(datos[5]);
        $('#dir').val(datos[6]);
        $('#tel').val(datos[7]);
        $('#email').val(datos[8]);
        $('#acceso').val(datos[9])
        $('#login').val(datos[10]);
        $('#contrasena').val(datos[11]);
        $('#sueldo').val(datos[12]);
        $('#estado').val(datos[13]);
        $('#agregarloa').val(datos[14]);
        editar = true;
    });
});