var tabla;

//funcion que se ejecuta al inicio
function init() {
  listar();
  //cargamos los items al select cliente
  $.post("Controllers/Person.php?op=selectCliente", function (r) {
    $("#idcliente").html(r);
    $("#idcliente").selectpicker("refresh");
  });
}

//funcion listar
function listar() {
  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  var idcliente = $("#idcliente").val();

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
          title: "Reporte de Ventas por fecha y cliente",
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          titleAttr: "Exportar a PDF",
          title: "Reporte de Ventas por fecha y cliente",
        },
      ],
      ajax: {
        url: "Controllers/Consult.php?op=ventasfechacliente",
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin,
          idcliente: idcliente,
        },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //paginacion
      order: [[0, "desc"]], //ordenar (columna, orden)
    })
    .DataTable();
}

init();
