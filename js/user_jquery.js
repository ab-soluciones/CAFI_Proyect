//Busqueda general en tablas//
$(document).ready(function () {
$('#busqueda').on('keyup', function () {
var value = $(this).val();
var patt = new RegExp(value, "i");
$('.table').find('tr').each(function () {
if (!($(this).find('td').text().search(patt) >= 0)) {
$(this).not('.encabezados').hide();
}

  if (($(this).find('td').text().search(patt) >= 0)) {
    $(this).show();
  }
});
});
});

//Autofocus en el primer input de los modales y las ventanas
$(document).ready(function () {
//Focus en el input de la ventana
$("input:text:visible:first").focus();
//$('input[@type="text"]')[0].focus();
//Focus en el modal
$('#modalForm').on('shown.bs.modal', function () {
$("input:text:visible:first").focus();
})
});

$(document).ready(function () {
//Estilo de los componetes

//text inputs
/* $("input:text, select, .input-group-prepend, .input-group-text").addClass("bg-dark").css({
'color' : 'white',
'border-color' : 'grey'
}); */
//Selectors
});



//Resaltar columna//
$('.table th').on('click', function () {
var $currentTable = $(this).closest('table');
var index = $(this).index();
$currentTable.find('th').removeClass('selectedTh');
$currentTable.find('td').removeClass('selectedTds');

$currentTable.find('tr').each(function () {
$(this).find('td').eq(index).addClass('selectedTds');
$(this).find('th').eq(index).addClass('selectedTh');
});
});

//Botones formulario mobiles/
$(document).ready(function () {
$('#formButton_nuevo').on('click', function () {
$('#formulario').toggleClass("d-none d-block");
$('#tableContainer').toggleClass("d-none d-block");
$(this).toggleClass("d-none");
});
$('#formButton_cancelar').on('click', function () {
$('#formulario').toggleClass("d-none d-block");
$('#tableContainer').toggleClass("d-none d-block");
$('#formButton_nuevo').toggleClass("d-none");
});
});

//Inactividad

$(document).ready(function () {
$('body').on('click keyup', function () {
parar();
});
});

var datos = false;
var parametro;

function inicio() {
parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 mi
}

function parar() {
clearTimeout(parametro);
parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
}

/*Enviar Formulario con select*/
$(document).ready(function () {
  $('#sucursal').on('change', function () {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
  });
});



