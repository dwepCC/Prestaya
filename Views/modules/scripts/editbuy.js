"use strict";
var tabla;

//funcion que se ejecuta al inicio
function init() {
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//cargamos los items al select proveedor
	$.post("Controllers/Buy.php?op=selectProveedor", function (r) {
		$("#idproveedor").html(r);
		//$("#idproveedor").selectpicker("refresh");
	});
	listarArticulos();
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
	let idingreso = query_string.id;
	mostrar(idingreso);
}
//funcion limpiar
function limpiar() {
	$("#idproveedor").val("");
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("");

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	//obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + month + "-" + day;
	$("#fecha_hora").val(today);
}

//cancelar form
function cancelarform() {
	limpiar();
	$(location).attr("href", "buy");
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
				tabla.ajax.reload();
		},
	});

	limpiar();
}

function mostrar(idingreso) {
	$.post(
		"Controllers/Buy.php?op=mostrar",
		{ idingreso: idingreso },
		function (data, status) {
			data = JSON.parse(data);

			$("#idproveedor").val(data.idproveedor);
			$("#tipo_comprobante").val(data.tipo_comprobante);
			$("#serie_comprobante").val(data.serie_comprobante);
			$("#num_comprobante").val(data.num_comprobante);
			$("#fecha_hora").val(data.fecha);
			$("#impuesto").val(data.impuesto);
			$("#idingreso").val(data.idingreso);
		}
	);
	$.post(
		"Controllers/Buy.php?op=listarDetalle_editar&id=" + idingreso,
		function (r) {
			var data = JSON.parse(r);
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

				let op = 2;
				agregarDetalle(
					idarticulo,
					articulo,
					precio_compra,
					precio_venta,
					cantidad,
					op
				);
				i++;
			}
		}
	);
}

//declaramos variables necesarias para trabajar con las compras y sus detalles
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();

function agregarDetalle(
	idarticulo,
	articulo,
	precio_compra,
	precio_venta,
	cantidad,
	op
) {
	var numero_cantidad;
	var nprecio_compra;
	var nprecio_venta;
	op === 2 ? (numero_cantidad = cantidad) : (numero_cantidad = 1);
	op === 2 ? (nprecio_compra = precio_compra) : (nprecio_compra = 1);
	op === 2 ? (nprecio_venta = precio_venta) : (nprecio_venta = 1);

	if (idarticulo != "") {
		var subtotal = cantidad * nprecio_compra;
		var fila =
			'<tr class="filas" id="fila' +
			cont +
			'">' +
			'<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(' +
			cont +
			')">X</button></td>' +
			'<td><input type="hidden" name="idarticulo[]" value="' +
			idarticulo +
			'"><input type="hidden" name="nstock[]" value="' +
			numero_cantidad +
			'"><input type="hidden" name="nuevostock[]" id="nuevostock[]">' +
			articulo +
			"</td>" +
			'<td><input type="number" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad[]" value="' +
			numero_cantidad +
			'"></td>' +
			'<td><input type="number" step="0.01" onchange="modificarSubtotales()" name="precio_compra[]" id="precio_compra[]" value="' +
			nprecio_compra +
			'"></td>' +
			'<td><input type="number" step="0.01" name="precio_venta[]" value="' +
			nprecio_venta +
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
	var nstock = document.getElementsByName("nstock[]");
	var nuevostock = document.getElementsByName("nuevostock[]");

	for (var i = 0; i < cant.length; i++) {
		var inpC = cant[i];
		var inpP = prec[i];
		var inpS = sub[i];
		var ns = nstock[i];
		var news = nuevostock[i];

		inpS.value = inpC.value * inpP.value;
		news.value = parseFloat(inpC.value) - parseFloat(ns.value);
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value.toFixed(2);
		$("#nuevostock[" + i + "]").val(news.value);
	}

	calcularTotales();
}

/*function calcularTotales() { 
  var sub = document.getElementsByName("subtotal");
  var total = 0.0;

  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName("subtotal")[i].value;
    var igv = total * ($("#impuesto").val() / 100);
    var total_monto = total + igv;
    var igv_dec = igv.toFixed(2);
  }

  $("#total").html(total.toFixed(2));
  $("#total_compra").val(parseFloat(total_monto).toFixed(2));
  $("#most_total").html(parseFloat(total_monto).toFixed(2));
  $("#most_imp").html(igv_dec);

  evaluar();
  borrar_filas();
}*/
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
