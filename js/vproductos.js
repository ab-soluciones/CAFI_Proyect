$(document).ready(function(){
    //productos
    let editar = false;
    let codigoBarras = "";
    idSesion($('.sucursal').val());
    //obtenerInventario();

    $('#generador').click(function(){
        $.ajax({
            url: 'generador.php',
            type: 'GET',

            success: function(response){
                $('#cb').val(response);
            }

        });
    });

    function idSesion(id){
        $.ajax({
            url: 'sesionProduc.php',
            type: 'POST',
            data: {idProducto:id},

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
                let stockrequerido = 0;
                let stock_minimo = 0;
                let cantidad = 0;
                datos.forEach(datos => {
                stockrequerido = 0;
                cantidad =  parseInt(datos.cantidad);
                stock_minimo =  parseInt(datos.stockmin);
                if(cantidad < stock_minimo){
                    stockrequerido = stock_minimo - stockrequerido;
                }
                    template += `
                    <tr>
                    <td>${datos.codigo_barras}</td>
                    <td>${datos.nombre}</td>
                    <td><img src= "${datos.imagen}" height="100" width="100" /></td>
                    <td>${datos.color}</td>
                    <td>${datos.marca}</td>
                    <td>${datos.proveedor}</td>
                    <td>${datos.descripcion}</td>
                    <td>${datos.unidad_medida}</td>
                    <td>${datos.tipo}</td>
                    <td>${datos.talla_numero}</td>
                    <td>${datos.precio_compra}</td>
                    <td>${datos.precio_venta}</td>
                    <td>${datos.pestado}</td>
                    <td>${datos.cantidad}</td>
                    <td>${datos.stockmin}</td>
                    <td>${stockrequerido}</td>
                    `;
                    if(datos.idNegocio == $('.sucursal').val()){
                        template += `<th style="width:100px;">
                        <div class="row">
                            <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                                Editar
                            </a>
                        </div>
                    </th>
                </tr>`;   
                    }else{
                        template +=`<th style="width:100px;">
                        <div class="row">
                            <button data-toggle="modal" disabled="false" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                                Editar
                            </button>
                        </div>
                    </th>
                </tr>`;
                    }
                });
                $('#cuerpo').html(template);
            }
        });

    }

/*
    function obtenerInventario(){
        $.ajax({
            url: 'datosInventario.php',
            type: 'GET',

            success: function(response){
                
                let datos = JSON.parse(response);
                let template2 = '';
                
                datos.forEach(datos => {
                    template2 += `
                    <option value="${datos.nombre +" "+ datos.marca + " color " + datos.color + " talla " + datos.talla_numero}"> 
                    `;
                });
                $('#lproductos').html(template2);
            }
        });
    }
    */

    $('.sucursal').change(function(){
        idSesion($('.sucursal').val());
    });

    $('.close').click(function(){
        $('#formproducto').trigger('reset');
        $('#inventario').trigger('reset');
        $('.divCantidad').hide();
    });

    function limpiar(){
        
        document.getElementById('tpo').disabled = false;
        document.getElementById('tpc').disabled = false;
        document.getElementById('tpr').disabled = false;
        document.getElementById("divtalla").style.display = "none";
        document.getElementById("divmedida").style.display = "none";
        $('#preview img').remove();
        $("#preview").append("<img src='..' width='100' height='100'/>");
        $('#formproducto').trigger('reset');
        $('#inventario').trigger('reset');
        $('.divCantidad').hide();
        //obtenerInventario();
    }

   $('#formproducto').submit(function(e){
    
        var formData = new FormData(this);
        console.log(formData);  
        console.log ("Esto es :"+$('#tipo_produc').val() )
        let url2 = editar === false ? 'post-guardar.php' : 'post-edit.php';
                $.ajax({
                    url: url2,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    
                    success: function(response) {
                        console.log("Respuesta: "+response);
                       
                        if (response == "1" || response == "2") {
                            swal({
                                title: 'Exito',
                                text: 'Datos guardados satisfactoriamente',
                                type: 'success'
                            },
                            function (isConfirm) {
                              if (isConfirm){
                                $('.modal').modal('hide');
                                 editar = false;
                                var idne = $('#negocioActual').val()
                                idSesion(idne);
                              }
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
                                text: 'Error, favor de comprovar los campos',
                                type: 'warning'
                            });
                        }
                    }
                });
        e.preventDefault();
       
    });

/*
    $('#inventario').submit(function(e){
    
        var formData = new FormData(this);

        $("#imagen").remove();

                $.ajax({
                    url: 'post-guardar.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    
                    success: function(response) {
                        $('#formproducto').trigger('reset');
                        $('#inventario').trigger('reset');
                        obtenerDatosTablaProducto();
                        obtenerInventario();
                        
                        if (response === "1") {
                            swal({
                                title: 'Exito',
                                text: 'Datos guardados satisfactoriamente',
                                type: 'success'
                            },
                            function (isConfirm) {
                              if (isConfirm) {
                                idSesion($('#negocioActual').val());
                              }
                              });
                        } else if( response == "yaExiste"){
                            swal({
                                title: 'Alerta',
                                text: 'El producto no se ha agregado al inventario, compruebe que el producto que intenta agregar no exista en el inventario',
                                type: 'warning'
                            },
                            function (isConfirm) {
                              if (isConfirm) {
                                idSesion($('#negocioActual').val());
                              }
                              });
                        } else {
                            swal({
                                title: 'Alerta',
                                text: 'Datos no guardados, compruebe los campos unicos',
                                type: 'warning'
                            },
                            function (isConfirm) {
                              if (isConfirm) {
                                idSesion($('#negocioActual').val());
                              }
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
*/
    $(document).on('click', '.beditar', function () {
        var valores = "";
        $('.divCantidad').css('display', 'block');
        $('#imagenmostrar').css('display', 'none');
        $('.rowMostrar').css('display', 'block');
        $('#preview').css('display', 'block');
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
        });
        
        

        datos = valores.split("?");
        console.log(datos);
        $('#nav-Producto-tab').click();
        $('.row1').css("display","none");
        $('#cb').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('.rowMostrar').html(datos[2]);
        $('#color').val(datos[3]);
        $('#marca').val(datos[4]);
        $('#proveedor').val(datos[5]);
        $('#desc').val(datos[6]);
        $('#um').val(datos[7]);
        if(datos[8] == "Ropa"){
            $('#tpr').trigger('click');
        }else if(datos[8] == "Calzado"){
            $('#tpc').trigger('click');
        }else if(datos[8] == "Otro"){
            $('#tpo').trigger('click');
        }
        $('#tipo_produc').val(datos[8]);
        if(datos[9] > 0){
            $('#med').val(datos[9]);
        }else{
            $('#ta').val(datos[9]);
        }
        $('#precioc').val(datos[10]);
        $('#preciov').val(datos[11]);
        $('#estado').val(datos[12]);
        $('#cantidadEditar').val(datos[13]);
        $('#stockminimo').val(datos[14]);
        $('#nav-Inventario-tab').hide();
        editar = true;

    });

    $('.mostra').click(function(){
        $('#nav-Inventario-tab').show();
        $('.divCantidad').hide();
        $('#nav-Producto-tab').click();
        $('.divCantidad').show();
        $('#imagenmostrar').show();
        $('.rowMostrar').hide();
    });

});