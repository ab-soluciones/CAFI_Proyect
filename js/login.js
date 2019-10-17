$(document).ready(function () {
  $("#formulario").submit(function (e) {

    $.post("../Controllers/login.php",$("#formulario").serialize(), function (response) {
      console.log(response);
      $("#mensaje").css("display", "block");
      if (response == "1") {
        document.location.replace='login.html';
        $("#formulario").trigger("reset");
      } else {
        $("#mensaje").text("Usuario incorrecto");
        $("#mensaje").css("color", "red");
      }
    });

    e.preventDefault();
  });
  });
