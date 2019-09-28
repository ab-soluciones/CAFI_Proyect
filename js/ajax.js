function submitContactForm(accion,num,solicitud){
    var cuenta = $('#inputCuenta').val();
    var cantidad = $('#inputCantidad').val();

    if(cuenta.trim() == '' && accion == "agregar"){
        alert('Por favor ingresa una cuenta.');
        $('#inputCuenta').focus();
        return false;
    }else if(cantidad.trim() == '' && accion == "agregar"){
        alert('Por favor ingresa una cantidad.');
        $('#inputCantidad').focus();
        return false;
    }else{
        $.ajax({
            type:'POST',
            url:'cpp.php',
            data:'contactFrmSubmit=1&accion='+accion+'&num='+num+'&solicitud='+solicitud+'&cuenta='+cuenta+'&cantidad='+cantidad,
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(msg){
                
                
                if(msg == 'ok'){
                    $('#inputCuenta').val('');
                    $('#inputCantidad').val('');
                    if(accion == "agregar"){
                        $('.statusMsg').html('<span class="font-weight-bold">Registro <span style="color:green;">agregado</span> exitosamente.</span>');
                    }else{
                        $('.statusMsg').html('<span class="font-weight-bold">Registro <span style="color:red;">eliminado</span> exitosamente.</span>');
                    }
                    
                    $('#inputCuenta').focus();
                    refreshTable(solicitud);
                }else{
                    $('.statusMsg').html('<span class="font-weight-bold" style="color:red;">Ocurrio un problema, porfavor intenta de nuevo.</span>');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
        });
    }
}


/* $(document).ready(function(){
    refreshTable();
});

function refreshTable(solicitud){
    $('#tableHolder').load('getTable.php?id='+solicitud+'');
} */