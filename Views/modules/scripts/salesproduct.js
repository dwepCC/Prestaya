var tabla;

//funcion que se ejecuta al inicio
function init() {
  listar();
}

$("#fecha_inicio").change(function () {
  listar();
});

$("#fecha_fin").change(function () {
  listar();
});

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
          sheetName: "VentaArticulos",
          title:
            "Reporte de Venta de articulos de " +
            fecha_inicio +
            " a " +
            fecha_fin,
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          titleAttr: "Exportar a PDF",
          title:
            "Reporte de Venta de articulos de " +
            fecha_inicio +
            " a " +
            fecha_fin,
          //orientation: 'landscape',
          pageSize: "A4",
          exportOptions: {
            columns: [0, 1, 2, 3, 4],
            alignment: "center",
          },
          customize: function (doc) {
            doc.content[1].table.widths = ["5%", "20%", "50%", "10%", "12%"];
          },
        },
      ],
      ajax: {
        url: "Controllers/Consult.php?op=listaventasarticulos",
        data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 20, //paginacion
      //""
      //"order":[[0,"desc"]]//ordenar (columna, orden)
    })
    .DataTable();
}

init();
