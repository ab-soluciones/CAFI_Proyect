$(document).ready(function () {
  //VUsuarios_ab
  let editar = false;
  let idusuario = "";
  optenerDatosTablaUsuarios();

  $(".close").click(function () {
    $("#formulario").trigger("reset");
    $("#mensaje").css("display", "none");
  });

  $(".clearForm").click(function () {
    $("#formuusers").trigger("reset");
  });

  $("#login").keyup(function () {
    var username = $("#login").val();
    if (username.length >= 3) {
      $(".contro").show();
      $.post("username_check.php", {
        username2: username
      }, function (data, status) {
        $("#status").html(data);
      });
    } else {
      $(".contro").hide();
    }
  });

  $("#formulario").submit(function (e) {
    $.post("../Controllers/usuariosab.php?accion=" + editar, $("#formulario").serialize(), function (response) {
      console.log(response);
      $("#mensaje").css("display", "block");
      if (response === "11") {
        $("#mensaje").text("Registro Exitoso");
        $("#mensaje").css("color", "green");
        $("#email").focus();
        $("#formulario").trigger("reset");
      } else {
        $("#mensaje").text("Registro fallido");
        $("#mensaje").css("color", "red");
        $("#email").focus();
      }
      optenerDatosTablaUsuarios();
    });
    e.preventDefault();
  });

  function optenerDatosTablaUsuarios() {
    $.ajax({
      url: "../Controllers/usuariosab.php",
      type: "POST",
      data: "tabla=tabla",
      success: function (response) {
        
       let datos = JSON.parse(response);
       console.log(datos);
        let template = "";
        $.each(datos, function (i, item) {
         
          template += `
          <tr>
                <td class="text-nowrap text-center">${datos[item].PageName}</td>
          `;
        });
        $("#cuerpo").html(template); 
        /*datos.forEach(datos => {
                  template += `
                        <tr>
                        <td class="text-nowrap text-center">${datos.id}</td>
                        <td class="text-nowrap text-center">${datos.nombre}</td>
                        <td class="text-nowrap text-center">${datos.apaterno}</td>
                        <td class="text-nowrap text-center">${datos.amaterno}</td>
                        <td class="text-nowrap text-center">${datos.acceso}</td>
                        <td class="text-nowrap text-center">${datos.login}</td>
                        <td class="text-nowrap text-center">${datos.password}</td>
                        <td class="text-nowrap text-center">${datos.estado}</td>
                        <th class="text-nowrap text-center" style="width:100px;">
                        <div class="row">
                            <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditarusers btn btn-danger" href="#">
                              Editar
                            </a>
                        </div>
                    </th>
                    </tr>`;
                });*/
        // $('#cuerpo').html(template);
      }
    });
  }

  $(document).on("click", ".beditarusers", function () {
    var valores = "";
    // Obtenemos todos los valores contenidos en los <td> de la fila
    // seleccionada
    $(this).parents("tr").find("td").each(function () {
      valores += $(this).html() + "?";
    });
    datos = valores.split("?");
    idusuario = datos[0];
    $("#nombre").val(datos[1]);
    $("#apt").val(datos[2]);
    $("#apm").val(datos[3]);
    $("#acceso").val(datos[4]);
    $("#login").val(datos[5]);
    $("#pass").val(datos[6]);
    $("#estadousers").val(datos[7]);
    editar = true;
  });
});
