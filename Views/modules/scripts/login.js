$("#formAcceso").on("submit", function (e) {
  e.preventDefault();

  nombre = $("#nombre").val();

  clave = $("#clave").val();

  if ($("#nombre").val() == "" || $("#clave").val() == "") {
    alert("Asegúrate de llenar todo los campos");
  } else {
    $.post(
      "Controllers/User.php?op=verificar",
      { nombre: nombre, clave: clave },

      function (data) {
        //console.log(data);
        if (data === "1") {
          $(location).attr("href", "dashboard");
        } else if (data === "0") {
          swal({
            title: "Error",
            text: "Usuario y/o Password incorrectos",
            icon: "error",
            buttons: {
              confirm: "OK",
            },
          });
        } else {
          swal({
            title: "Error",
            text: data,
            icon: "error",
            buttons: {
              confirm: "OK",
            },
          });
        }

        //if (data === false) { }

        //if (data != "null") {
        //$(location).attr("href", "dashboard");
        //} else {
        //alert("Usuario y/o Password incorrectos");
        // }
      }
    );
  }
});
