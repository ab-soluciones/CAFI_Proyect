/*Busqueda general en tablas*/
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

/*Ordenar tabla por encabezado*/
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(".table");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc"; 
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        //Each time a switch is done, increase this count by 1:
        switchcount ++;      
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }

/*Resaltar columna*/
$('.table th').on('click', function() {
    var $currentTable = $(this).closest('table');
    var index = $(this).index();
    $currentTable.find('th').removeClass('selectedTh');
    $currentTable.find('td').removeClass('selectedTds');

    $currentTable.find('tr').each(function() {
        $(this).find('td').eq(index).addClass('selectedTds');
        $(this).find('th').eq(index).addClass('selectedTh');
    });
});

/*Botones formulario mobiles*/
$(document).ready(function () {
  $('#formButton_nuevo').on('click', function() {
    $('#formulario').toggleClass("d-none d-block");
    $('#tableContainer').toggleClass("d-none d-block");
    $(this).toggleClass("d-none");
  });
  $('#formButton_cancelar').on('click', function() {
      $('#formulario').toggleClass("d-none d-block");
      $('#tableContainer').toggleClass("d-none d-block");
      $('#formButton_nuevo').toggleClass("d-none");
  });
});


var datos = false;
var parametro;

function inicio() {
  parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min

  var titulo = document.getElementsByTagName("title")[0].innerHTML;
  document.getElementById("nav-title").innerHTML = titulo;
}

function parar() {
  clearTimeout(parametro);
  parametro = setTimeout("window.location.href = 'Inactividad.php';", 1500000); // 25 min
}

/*Enviar Formulario con select*/
$(document).ready(function() {
  $('#sucursal').on('change', function() {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
  });
});