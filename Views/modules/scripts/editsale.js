"use strict";
var tabla;
//funcion que se ejecuta al inicio
function init() {
  mostrar_impuesto();
  nombre_impuesto();
  listarArticulos();
  $("#t_pago").hide();
  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  $("#formulariocliente").on("submit", function (e) {
    agregarCliente(e);
  });

  //cargamos los items al select cliente
  $.post("Controllers/Sell.php?op=selectCliente", function (r) {
    $("#idcliente").html(r);
    //$("#idcliente").selectpicker("refresh");
  });

  //cargamos los items al celect comprobantes
  $.post("Controllers/Sell.php?op=selectComprobante", function (c) {
    //alert(c);
    $("#tipo_comprobante").val("Ticket");
    $("#tipo_comprobante").html(c);
    //$("#tipo_comprobante").selectpicker("refresh");
  });

  //cargamos los items al celect tipo de pago
  $.post("Controllers/Sell.php?op=selectTipopago", function (c) {
    $("#tipo_pago").html(c);
    //$("#tipo_pago").selectpicker("refresh");
  });

  url_get();
}

function url_get() {
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
      query_string[pair[0]] = arr;
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  }
  let idventa = query_string.id;
  mostrar(idventa);
}

function mostrar(idventa) {
  $.post(
    "Controllers/Sell.php?op=mostrar",
    {
      idventa: idventa,
    },
    function (data, status) {
      data = JSON.parse(data);

      $("#idventa").val(data.idventa);
      $("#idcliente").val(data.idcliente);
      //$("#idcliente").selectpicker("refresh");
      $("#tipo_comprobante").val(data.tipo_comprobante);
      //$("#tipo_comprobante").selectpicker("refresh");
      $("#serie_comprobante").val(data.serie_comprobante);
      $("#num_comprobante").val(data.num_comprobante);
      $("#fecha_horam").val(data.fecha);
      $("#impuestom").val(data.impuesto);
      $("#idventam").val(data.idventa);
      let impuesto = data.impuesto;

      let im = parseInt(impuesto);
      //console.log(im);
      if (im > 0) {
        //console.log(im);
        $("#aplicar_impuesto").prop("checked", true);
        mostrar_impuesto();
      } else {
        $("#aplicar_impuesto").prop("checked", false);
        mostrar_impuesto();
      }
    }
  );
  $.post(
    "Controllers/Sell.php?op=listarDetalle_editar&id=" + idventa,
    function (r) {
      var data = JSON.parse(r);
      console.log(data);
      // let impuesto = data[4].Impuesto;
      //let impuesto = data.forEach((element) =>console.log(element["Impuesto"]));

      let i = 0;
      while (i < data.length) {
        //$("#detalles").html(data[i]);
        let idarticulo = data[i].Idarticulo;
        let articulo = data[i].Articulo;
        let precio_compra = data[i].Pcompra;
        let precio_venta = data[i].Pventa;
        let cantidad = data[i].Cantidad;
        let stocks = data[i].Stock;
        let op = 2;
        let idingreso = 0;
        agregarDetalle(
          idingreso,
          idarticulo,
          articulo,
          precio_compra,
          precio_venta,
          cantidad,
          stocks,
          op
        );
        i++;
      }
    }
  );
}
//OPCIONES PARA IMPLEMENTAR COSIDO_____________________________________________________________

//funcion limpiar
function limpiar() {
  $("#idventa").val("");
  $("#idcliente").val("");
  $("#cliente").val("");
  $("#serie_comprobante").val("");
  $("#num_comprobante").val("");
  $("#impuesto").val("");
  $("#total_venta").val("");
  $(".filas").remove();
  $("#total").html("0");
  $("#tpagado").val("");
  //marcamos el primer tipo_documento
  //$("#tipo_comprobante").selectpicker("refresh");
  //$("#idcliente").selectpicker("refresh");

  $("#nombre").val("");
  $("#num_documento").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#idpersona").val("");
  $("#Modalcliente").modal("hide");
}
//__________________________________________________________________________
//mostramos el num_comprobante de la fatura

function ShowComprobante() {
  mostrar_impuesto();
  var tipo_comprobante = $("#tipo_comprobante").val();
  if (tipo_comprobante.length == 0) {
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
  } else {
    serie_comp();
    numero_comp();
  }
}

function ShowTipopago() {
  var t_pago = $("#tipo_pago").val();
  if (t_pago == "Pago en efectivo" || t_pago == "Efectivo") {
    $("#t_pago").hide();
    $("#num_transac").val("");
  } else {
    $("#t_pago").show();
    $("#num_transac").val("");
  }
}

//mostramos la serie del comprobante
function serie_comp() {
  var tipo_comprobante = $("#tipo_comprobante").val();

  $.post(
    "Controllers/Sell.php?op=mostrar_serie",
    {
      tipo_comprobante: tipo_comprobante,
    },
    function (data, status) {
      data = JSON.parse(data);
      //alert(data.letra);
      $("#serie_comprobante").val(data.letra + ("000" + data.serie).slice(-3)); // "0001"
    }
  );
}

//mostramos el numero de comprobante
function numero_comp() {
  var tipo_comprobante = $("#tipo_comprobante").val();
  $.ajax({
    url: "Controllers/Sell.php?op=mostrar_numero",
    data: {
      tipo_comprobante: tipo_comprobante,
    },
    type: "get",
    dataType: "json",
    success: function (d) {
      num_comp = d;
      $("#num_comprobante").val(("0000000" + num_comp).slice(-7)); // "0001"
      $("#nFacturas").html(("0000000" + num_comp).slice(-7)); // "0001"
    },
  });
}

$("#aplicar_impuesto").change(function () {
  if ($("#aplicar_impuesto").is(":checked")) {
    mostrar_impuesto();
  } else {
    mostrar_impuesto();
  }
});
//mostramos el impuesto
var no_aplica = 0;
function mostrar_impuesto() {
  $.ajax({
    url: "Controllers/Company.php?op=mostrar_impuesto",
    type: "get",
    dataType: "json",
    success: function (i) {
      var impuesto = i;
      var sin_imp = 0;
      if ($("#aplicar_impuesto").is(":checked")) {
        $("#impuesto").val(impuesto);
        no_aplica = impuesto;
        calcularTotales();
        nombre_impuesto();
      } else {
        $("#impuesto").val(sin_imp);
        no_aplica = 0;
        calcularTotales();
        nombre_impuesto();
      }
    },
  });
}

//declaramos variables necesarias para trabajar con las compras y sus detalles
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();

//_______________________________________________________________________________________________

function listarArticulos() {
  tabla = $("#tblarticulos")
    .dataTable({
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      dom: "Bfrtip", //definimos los elementos del control de la tabla
      buttons: [],
      ajax: {
        url: "Controllers/Sell.php?op=listarArticulos",
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
  //alert( 'Rows '+tabla.rows( '.selected' ).count()+' are selected' );
  //borrar_filas();
}
//funcion para guardaryeditar
function guardaryeditar(e) {
  e.preventDefault(); //no se activara la accion predeterminada
  //$("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "Controllers/Sell.php?op=guardaryeditar",
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
        tabla.ajax.reload();
    },
  });
  init();
  limpiar();
  listarArticulos();
}

var numero_cantidad;
function agregarDetalle(
  idngreso,
  idarticulo,
  articulo,
  precio_compra,
  precio_venta,
  cantidad,
  stocks,
  op
) {
  var stock = stocks;

  if (op === 2) {
    numero_cantidad = cantidad;
  } else {
    numero_cantidad = 1;
  }
  // op === 1 ? (numero_cantidad = 1) : (numero_cantidad = cantidad);
  var descuento = 0;

  if (idarticulo != "") {
    var subtotal = cantidad * precio_venta;
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td class=""><button type="button" id="del" class="btn btn-danger btn-sm del" onclick="eliminarDetalle(' +
      cont +
      ')"><i class="fa fa-times"></i></button></td>' +
      '<td class="col-xs-6"><input style="width : 70px;" type="hidden" name="idarticulo[]" value="' +
      idarticulo +
      '"><input style="width : 70px;" type="hidden" name="precio_compra[]" value="' +
      precio_compra +
      '"><input type="hidden" name="nstock[]" value="' +
      numero_cantidad +
      '"><input type="hidden" name="nuevostock[]" id="nuevostock[]">' +
      articulo +
      '<td class="col-xs-1"><input style="width : 70px;" type="number" min="1" max="' +
      stock +
      '" onchange="ver_stock(this.value,' +
      stock +
      ')" name="cantidad[]" id="cantidad[]" value="' +
      numero_cantidad +
      '"></td>' +
      '<td class="col-xs-1"><input style="width : 70px;" type="number" min="1" step="0.01" onchange="modificarSubtotales()" name="precio_venta[]" id="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td class="col-xs-1"><input style="width : 70px;" type="number" min="0" step="0.01" onchange="modificarSubtotales()" name="descuento[]" value="' +
      descuento +
      '"></td>' +
      '<td class="col-xs-1"><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      "</span></td>" +
      "</tr>";
    var product = null;
    var shelf = null;
    var status = null;

    //submit

    cont++;
    detalles++;
    $("#detalles").append(fila);
    modificarSubtotales();
  } else {
    bootbox.alert(
      "error al ingresar el detalle, revisar las datos del articulo "
    );
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

//esta funcion valida la cantidad a vender con el stock
function ver_stock(valor, cantidad) {
  //alert(cantidad);
  var msj = "la cantidad supera al stock actual";
  valor = parseInt(valor);
  if (valor > cantidad) {
    bootbox.alert(valor + " " + msj + " " + cantidad);
    $("#btnGuardar").hide();
  } else {
    $("#btnGuardar").show();
    modificarSubtotales();
  }
}

function modificarSubtotales() {
  var cant = document.getElementsByName("cantidad[]");
  var prev = document.getElementsByName("precio_venta[]");
  var desc = document.getElementsByName("descuento[]");
  var sub = document.getElementsByName("subtotal");
  var nstock = document.getElementsByName("nstock[]");
  var nuevostock = document.getElementsByName("nuevostock[]");

  for (var i = 0; i < cant.length; i++) {
    var inpV = cant[i];
    var inpP = prev[i];
    var inpS = sub[i];
    var des = desc[i];
    var ns = nstock[i];
    var news = nuevostock[i];

    inpS.value = inpV.value * inpP.value - des.value;
    news.value = parseFloat(ns.value) - parseFloat(inpV.value);
    document.getElementsByName("subtotal")[i].innerHTML = inpS.value.toFixed(2);
    $("#nuevostock[" + i + "]").val(news.value);
  }

  calcularTotales();
}

function calcularTotales() {
  var sub = document.getElementsByName("subtotal");
  var total = 0.0;
  var simbolo = "";

  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName("subtotal")[i].value;
    var igv = total * (no_aplica / 100);
    var total_monto = total + igv;
    var igv_dec = igv.toFixed(2);
  }
  $.ajax({
    url: "Controllers/Company.php?op=mostrar_simbolo",
    type: "get",
    dataType: "json",
    success: function (sim) {
      var simbolo = sim;
      $("#total").html(simbolo + " " + total.toFixed(2));
      $("#total_venta").val(parseFloat(total_monto).toFixed(2));

      $("#most_total").html(simbolo + parseFloat(total_monto).toFixed(2));
      $("#most_imp").html(simbolo + igv_dec);
      var tpagado = $("#tpagado").val();
      var totalvuelto = 0;

      if (tpagado > 0) {
        totalvuelto = tpagado - total_monto;
        $("#vuelto").html(simbolo + " " + totalvuelto.toFixed(2));
      } else {
        totalvuelto = 0.0;
        $("#vuelto").html(simbolo + " " + totalvuelto.toFixed(2));
      }

      evaluar();
    },
  });
  borrar_filas();
}

function nombre_impuesto() {
  $.ajax({
    url: "Controllers/Company.php?op=nombre_impuesto",
    type: "get",
    dataType: "json",
    success: function (n) {
      var nomp = n;
      var valor_impuesto = no_aplica;
      $("#valor_impuesto").html(nomp + " " + valor_impuesto + "%");
    },
  });
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

//funcion para guardar nuevo cliente
function agregarCliente(e) {
  $("#Modalcliente").modal("show");
  e.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardarcliente").prop("disabled", true);
  var formData = new FormData($("#formulariocliente")[0]);

  $.ajax({
    url: "../ajax/persona.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      bootbox.alert(datos);
      mostrarform(false);
      tabla.ajax.reload();
    },
  });

  limpiar();
  location.reload(true);
}

init();
