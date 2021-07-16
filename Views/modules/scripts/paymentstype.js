var tabla;

//funcion que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });
}

//funcion limpiar
function limpiar() {
  $("#idtipopago").val("");
  $("#nombre").val("");
  $("#descripcion").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
    $("#btnagregar").hide();
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
  }
}

//cancelar form
function cancelarform() {
  limpiar();
  mostrarform(false);
}

//funcion listar
function listar() {
  tabla = $("#tbllistado")
    .dataTable({
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      dom: "Bfrtip", //definimos los elementos del control de la tabla
      buttons: [
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel-o"></i> Excel',
          titleAttr: "Exportar a Excel",
          title: "Reporte de Tipo de pagos",
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          titleAttr: "Exportar a PDF",
          title: "Reporte de Tipo de pagos",
        },
      ],
      ajax: {
        url: "Controllers/Paymentstype.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 10, //paginacion
      order: [[0, "desc"]], //ordenar (columna, orden)
    })
    .DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e) {
  e.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "Controllers/Paymentstype.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var tabla = $("#tbllistado").DataTable();
      swal({
        title: "Registro",
        text: datos,
        icon: "info",
        buttons: {
          confirm: "OK",
        },
      }),
        mostrarform(false);
      tabla.ajax.reload();
    },
  });

  limpiar();
}

function mostrar(idtipopago) {
  $.post(
    "Controllers/Paymentstype.php?op=mostrar",
    { idtipopago: idtipopago },
    function (data, status) {
      data = JSON.parse(data);
      mostrarform(true);

      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#idtipopago").val(data.idtipopago);
    }
  );
}

//funcion para desactivar
function desactivar(idtipopago) {
  swal({
    title: "Desactivar?",
    text: "Esá seguro de desactivar?",
    icon: "warning",
    buttons: {
      cancel: "No, cancelar",
      confirm: "Si, desactivar",
    },
    //buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.post(
        "Controllers/Paymentstype.php?op=desactivar",
        { idtipopago: idtipopago },
        function (e) {
          swal(e, "Desactivado!", {
            icon: "success",
          });
          var tabla = $("#tbllistado").DataTable();
          tabla.ajax.reload();
        }
      );
    }
  });
}

function activar(idtipopago) {
  swal({
    //title: "Activar?",
    text: "Esá seguro de activar?",
    icon: "warning",
    buttons: {
      cancel: "No, cancelar",
      confirm: "Si, activar",
    },
    //buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.post(
        "Controllers/Paymentstype.php?op=activar",
        { idtipopago: idtipopago },
        function (e) {
          swal(e, "Activado!", {
            icon: "success",
          });
          var tabla = $("#tbllistado").DataTable();
          tabla.ajax.reload();
        }
      );
    }
  });
}

init();
