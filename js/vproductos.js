$(document).ready(function(){
    //productos
    let editar = false;
    let codigoBarras = "";
    obtenerDatosTablaProducto();
    obtenerInventario();
    $('#divCantidad').hide();


    function obtenerInventario(){
        $.ajax({
            url: 'datosInventario.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template2 = '';
                console.log(datos);
                datos.forEach(datos => {
                    template2 += `
                    <option value="${datos.nombre +" "+ datos.marca + " color " + datos.color + " talla " + datos.talla_numero}"> 
                    `;
                });
                $('#lproductos').html(template2);
            }
        });
    }



    function obtenerDatosTablaProducto(){
        $.ajax({
            url: 'tablaProductos.php',
            type: 'GET',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
                console.log(datos);
                datos.forEach(datos => {

                    template += `
                    <tr>
                    <td>${datos.codigo_barras}</td>
                    <td>${datos.nombre}</td>
                    <td><img src= "${datos.imagen}" height="100" width="100" /></td>
                    <td>${datos.color}</td>
                    <td>${datos.marca}</td>
                    <td>${datos.descripcion}</td>
                    <td>${datos.unidad_medida}</td>
                    <td>${datos.tipo}</td>
                    <td>${datos.talla_numero}</td>
                    <td>${datos.precio_compra}</td>
                    <td>${datos.precio_venta}</td>
                    <td>${datos.pestado}</td>
                    <td>${datos.cantidad}</td>
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

    $('.close').click(function(){
        $('#formproducto').trigger('reset');
        $('#inventario').trigger('reset');
    });

    $('.bclose').click(function(){
        $('.modal').modal('hide');
    });

    $('#formproducto').submit(function(e){
    
        var formData = new FormData(this);

        let url2 = editar === false ? 'post-guardar.php' : 'post-edit.php';
                $.ajax({
                    url: url2,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    
                    success: function(response) {

                        console.log("Esto es la respuesta: "+response);
                        if (response === "1") {
                            swal({
                                title: 'Exito',
                                text: 'Datos guardados satisfactoriamente',
                                type: 'success'
                            });
                        } else if( response == "2"){
                            swal({
                                title: 'Exito',
                                text: 'Datos guardados satisfactoriamente',
                                type: 'success'
                            });
                        } else if(response == "imagenGrande"){
                            swal({
                                title: 'Alerta',
                                text: 'Esta imagen es demaciado grande',
                                type: 'warning'
                            });
                        }else if(response == "imagenNoValida"){
                            swal({
                                title: 'Alerta',
                                text: 'Este tipo de imagen no es permitido',
                                type: 'error'
                            });
                        }
                         else {
                            swal({
                                title: 'Alerta',
                                text: 'Datos no guardados, compruebe los campos unicos',
                                type: 'warning'
                            });
                        }
                    }
                });
            $('#formproducto').trigger('reset');
            $('#inventario').trigger('reset');
            obtenerDatosTablaProducto();
            obtenerInventario();
        e.preventDefault();
        editar = false;
    });

    $('#inventario').submit(function(e){
    
        var formData = new FormData(this);
        console.log(formData);
                $.ajax({
                    url: 'post-guardar.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    
                    success: function(response) {
                        console.log("Esto es la respuesta: "+response);
                        if (response === "1") {
                            swal({
                                title: 'Exito',
                                text: 'Datos guardados satisfactoriamente',
                                type: 'success'
                            });
                        } else if( response == "yaExiste"){
                            swal({
                                title: 'Alerta',
                                text: 'El producto no se ha agregado al inventario, compruebe que el producto que intenta agregar no exista en el inventario',
                                type: 'warning'
                            });
                        } else {
                            swal({
                                title: 'Alerta',
                                text: 'Datos no guardados, compruebe los campos unicos',
                                type: 'warning'
                            });
                        }
                    }
                });
                $('#formproducto').trigger('reset');
                $('#inventario').trigger('reset');
                obtenerDatosTablaProducto();
                obtenerInventario();
                e.preventDefault();
    });

    $(document).on('click', '.beditar', function () {
        var valores = "";
        var valores2 = "";
        $('#divCantidad').show();       
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        
        console.log("Esto es el img "+valores2)

        datos = valores.split("?");

        console.log(datos);
        $('.row1').css("display","none");
        $('#cb').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('.rowMostrar').html(datos[2]);
        $('#color').val(datos[3]);
        $('#marca').val(datos[4]);
        $('#desc').val(datos[5]);
        $('#um').val(datos[6]);
        if(datos[7] == "Ropa"){
            $('#tpr').trigger('click');
        }else if(datos[7] == "Calzado"){
            $('#tpc').trigger('click');
        }else if(datos[7] == "Otro"){
            $('#tpo').trigger('click');
        }
        if(datos[8] > 0){
            $('#med').val(datos[8]);
        }else{
            $('#ta').val(datos[8]);
        }
        $('#precioc').val(datos[9]);
        $('#preciov').val(datos[10]);
        $('#estado').val(datos[11]);
        $('#cantidadEditar').val(datos[12]);
        $('#nav-Inventario-tab').hide();
        editar = true;

    });

    $('.mostra').click(function(){
        $('#nav-Inventario-tab').show();
    });

    $('.agrega').click(function(){
        $('#divCantidad').hide(); 
    });


});