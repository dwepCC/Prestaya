var tabla;

//funcion que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  //cargamos los items al select proveedor
  $.post("Controllers/Buy.php?op=selectProveedor", function (r) {
    $("#idproveedor").html(r);
    //$("#idproveedor").selectpicker("refresh");
  });
}

//funcion limpiar
function limpiar() {
  $("#idproveedor").val("");
  $("#proveedor").val("");
  $("#serie_comprobante").val("");
  $("#num_comprobante").val("");
  // $("#impuesto").val("");

  $("#total_compra").val("");
  $(".filas").remove();
  $("#total").html("0");

  //obtenemos la fecha actual
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;
  $("#fecha_hora").val(today);

  //marcamos el primer tipo_documento
  $("#tipo_comprobante").val("Boleta");
  //$("#tipo_comprobante").selectpicker("refresh");
  //$("#idproveedor").selectpicker("refresh");
}

//funcion mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    //$("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
    listarArticulos();

    $("#btnGuardar").hide();
    $("#btnCancelar").show();
    detalles = 0;
    $("#btnAgregarArt").show();
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
          text: '<i class="fa fa-file-excel-o bg-green"></i> Excel',
          titleAttr: "Exportar a Excel",
          title: "Reporte de Ingresos",
          sheetName: "Ingresos",
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7],
          },
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o bg-red"></i> PDF',
          titleAttr: "Exportar a PDF",
          title: "Reporte de Ingresos",
          //messageTop: "Reporte de usuarios",
          pageSize: "A4",
          //orientation: 'landscape',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7],
          },
        },
      ],
      ajax: {
        url: "Controllers/Buy.php?op=listar",
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

function listarArticulos() {
  tabla = $("#tblarticulos")
    .dataTable({
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      dom: "Bfrtip", //definimos los elementos del control de la tabla
      buttons: [],
      ajax: {
        url: "Controllers/Buy.php?op=listarArticulos",
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
  //$("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "Controllers/Buy.php?op=guardaryeditar",
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

function mostrar(idingreso) {
  $("#getCodeModal").modal("show");
  $.post(
    "Controllers/Buy.php?op=mostrar",
    { idingreso: idingreso },
    function (data, status) {
      data = JSON.parse(data);

      $("#idproveedorm").val(data.proveedor);
      $("#tipo_comprobantem").val(data.tipo_comprobante);
      $("#serie_comprobantem").val(data.serie_comprobante);
      $("#num_comprobantem").val(data.num_comprobante);
      $("#fecha_horam").val(data.fecha);
      $("#impuestom").val("18");
      $("#idingresom").val(data.idingreso);
    }
  );
  $.post("Controllers/Buy.php?op=listarDetalle&id=" + idingreso, function (r) {
    $("#detallesm").html(r);
  });
}

function anular(idingreso) {
  swal({
    title: "Anular?",
    text: "Esá seguro de anular el ingreso?",
    icon: "warning",
    buttons: {
      cancel: "No, cancelar",
      confirm: "Si, anular",
    },
    //buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.post(
        "Controllers/Buy.php?op=anular",
        { idingreso: idingreso },
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
//declaramos variables necesarias para trabajar con las compras y sus detalles
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();

function agregarDetalle(idarticulo, articulo) {
  var cantidad = 1;
  var precio_compra = 1;
  var precio_venta = 1;

  if (idarticulo != "") {
    var subtotal = cantidad * precio_compra;
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(' +
      cont +
      ')">X</button></td>' +
      '<td><input type="hidden" name="idarticulo[]" value="' +
      idarticulo +
      '">' +
      articulo +
      "</td>" +
      '<td><input type="number" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input type="number" step="0.01" onchange="modificarSubtotales()" name="precio_compra[]" id="precio_compra[]" value="' +
      precio_compra +
      '"></td>' +
      '<td><input type="number" step="0.01" name="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      "</span></td>" +
      "</tr>";
    cont++;
    detalles++;
    $("#detalles").append(fila);
    modificarSubtotales();
  } else {
    alert("error al ingresar el detalle, revisar las datos del articulo ");
  }
}

//borrar filas del datables
function borrar_filas() {
  $('#tblarticulos tbody tr[role="row"] #addetalle').prop("disabled", false);
  for (let i = 0; i < $(".filas").length; i++) {
    const element = $('input[name="idarticulo[]"]').get(i);
    for (let f = 0; f < $('#tblarticulos tbody tr[role="row"]').length; f++) {
      const button = $('#tblarticulos tbody tr[role="row"] #addetalle').get(f);
      if (button["name"] === element["value"]) {
        button["disabled"] = true;
      }
    }
  }
}

function modificarSubtotales() {
  var cant = document.getElementsByName("cantidad[]");
  var prec = document.getElementsByName("precio_compra[]");
  var sub = document.getElementsByName("subtotal");

  for (var i = 0; i < cant.length; i++) {
    var inpC = cant[i];
    var inpP = prec[i];
    var inpS = sub[i];

    inpS.value = parseFloat(inpP.value);
    document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
  }

  calcularTotales();
}

// Conclusión
(function () {
  function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === "undefined" || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === "number" && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split("e");
    value = Math[type](+(value[0] + "e" + (value[1] ? +value[1] - exp : -exp)));
    // Shift back
    value = value.toString().split("e");
    return +(value[0] + "e" + (value[1] ? +value[1] + exp : exp));
  }

  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function (value, exp) {
      return decimalAdjust("ceil", value, exp);
    };
  }
})();
function calcularTotales() {
  var sub = document.getElementsByName("subtotal");
  var total = 0.0;
  //La formula seria Valor total = 160/1.18= 135.60 (valor neto)  //// 160-135.60= 24.40 (IGV)
  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName("subtotal")[i].value;
    //igv = total * ($("#impuesto").val() / 100);
    var total_monto = parseFloat(total);
    var igv_dec = parseFloat(total_monto / 1.18);
  }
  var stotal = parseFloat(Math.ceil10(igv_dec, -1)).toFixed(2);
  var igv_total = total_monto - stotal;
  $("#total").html(stotal);
  $("#total_compra").val(parseFloat(total_monto).toFixed(2));
  $("#most_total").html(parseFloat(total_monto).toFixed(2));
  $("#most_imp").html(parseFloat(igv_total).toFixed(2));

  evaluar();
  borrar_filas();
}

function evaluar() {
  if (detalles > 0) {
    $("#btnGuardar").show();
  } else {
    $("#btnGuardar").hide();
    cont = 0;
  }
}

function eliminarDetalle(indice) {
  $("#fila" + indice).remove();
  calcularTotales();
  detalles = detalles - 1;
}

init();
