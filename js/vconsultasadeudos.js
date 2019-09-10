
$(document).ready(function () {
    let abono;
    let pago;
    let adeudo;
    let total;
    let formapago;

    function ejecutarImpresionTermica() {
        let idventa = "";
        const postData = {
            adeudo: adeudo
        };

        $.post('ticketabono.php', postData, function (response) {
            if (response) {
                var explode = function () {
                    swal({
                        title: 'Exito',
                        text: 'Abono realizado exitosamente',
                        type: 'success'
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                };
                setTimeout(explode, 600);
            }
        });
    }

    $(document).on('click', '.befectivo', function () {
        formapago = "Efectivo";
        let valores = "";
        $(this).parents("tr").find(".datos").each(function () {
            valores += $(this).html() + "?";
        });
        renglon = valores.split("?");
        adeudo = renglon[0];
        total = renglon[1];
        total = parseFloat(total);
        $('.modal').modal('show');
        $('#divefectivo').show();
        $('#msjtarjeta').html("");

    });
    $(document).on('click', '.babonar', function () {
        if ($('.inabono').val() && $('.tpago').val()) {
            let totalif;
            abono = parseFloat($('.inabono').val());
            pago = parseFloat($('.tpago').val());
            cambio = pago - abono;
            cambiostring = cambio.toString();
            totalif = total;
            total = total - abono;
            if (pago >= abono && abono <= totalif) {
                swal({
                    title: 'Su cambio es de $ ' + cambiostring,
                    text: 'Confirme la venta',
                    imageUrl: 'img/cambio.png',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'Ok',
                    cancelButtonClass: 'btn-danger',
                    cancelButtonText: 'Cancelar',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            const postData = {
                                abono: abono,
                                pago: pago,
                                adeudo: adeudo,
                                total: total,
                                cambio: cambio,
                                formapago: formapago
                            };
                            $.post('post-guardar.php', postData, function (response) {
                                if (response === "con impresora") {
                                    ejecutarImpresionTermica();
                                } else if (response === "sin impresora") {
                                    var explode = function () {
                                        swal({
                                            title: 'Exito',
                                            text: 'Venta realizada exitosamente',
                                            type: 'success'
                                        },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    location.reload();
                                                }
                                            });
                                    };
                                    setTimeout(explode, 600);

                                } else if (response != "con impresora" && response != "sin impresora") {
                                    var explode = function () {
                                        swal({
                                            title: 'Alerta',
                                            text: 'No se a realizado la venta',
                                            type: 'warning'
                                        },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    location.reload();
                                                }
                                            });
                                    };
                                    setTimeout(explode, 600);
                                }

                            });
                        } else {
                            $('.inabono').val("");
                            $('.tpago').val("");
                        }
                    });
            } else {
                swal({
                    title: 'Alerta',
                    text: 'Puede que esté agregando un pago menor que la cantidad a abonar, o una cantidad de abono mayor al adeudo',
                    type: 'warning'
                });

            }
        } else if ($('.inabono').val().length > 0 && $('.tpago').val().length < 1) {
            let totalif;
            abono = parseFloat($('.inabono').val());
            total = parseFloat(total);
            totalif = total;
            total = total - abono;
            cambio = 0;
            pago = 0;
            if (abono <= totalif) {
           
                const postData = {
                    abono: abono,
                    pago: pago,
                    adeudo: adeudo,
                    total: total,
                    cambio: cambio,
                    formapago: formapago
                };
                console.log(postData);
                $.post('post-guardar.php', postData, function (response) {
                    console.log(response);
                    if (response === "con impresora") {
                        ejecutarImpresionTermica();
                    } else if (response === "sin impresora") {
                        var explode = function () {
                            swal({
                                title: 'Exito',
                                text: 'Abono realizado exitosamente',
                                type: 'success'
                            },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });
                        };
                        setTimeout(explode, 600);

                    } else if (response != "con impresora" && response != "sin impresora") {
                        var explode = function () {
                            swal({
                                title: 'Alerta',
                                text: 'No se a realizado el abono',
                                type: 'warning'
                            },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });
                        };
                        setTimeout(explode, 600);
                    }

                });
            } else {
                swal({
                    title: 'Alerta',
                    text: 'Está ingresando una cantidad de abono mayor al adeudo',
                    type: 'warning'
                });

            }
        }
    });


    $(document).on('click', '.btarjeta', function () {
        formapago = "Tarjeta";
        $('.modal').modal('show');
        $('#divefectivo').hide();
        $('#msjtarjeta').html("Recuerde cargar el abono a la tarjeta despues de registrarlo");
        let valores = "";
        $(this).parents("tr").find(".datos").each(function () {
            valores += $(this).html() + "?";
        });
        renglon = valores.split("?");
        adeudo = renglon[0];
        total = renglon[1];

    });

});