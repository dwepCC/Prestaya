"use strict";
var tabla;
//funcion que se ejecuta al inicio
function init() {
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	$("#formularioArticulo").on("submit", function (e) {
		agregarArticulo(e);
	});

	//cargamos los items al celect categoria
	$.post("Controllers/Category.php?op=selectCategoria", function (r) {
		$("#idcategoria").html(r);
		//$("#idcategoria").selectpicker("refresh");
	});

	$("#divKm").hide();
	$("#divMetal").hide();
	$("#divPeso").hide();
	$("#divPureza").hide();

	$("#divFechaFinPago").hide();
	$("#cantidad_cuotas").show();
	$("#divPlazo").show();
}

$("#tipo_credito").change(function () {
	if ($(this).val() === "PRENDARIO") {
		$("#divFechaFinPago").show();
		$("#cantidad_cuotas").hide();
		$("#divPlazo").hide();
		$("#cantidad_cuotas").val("1");
	} else {
		$("#divFechaFinPago").hide();
		$("#cantidad_cuotas").show();
		$("#cantidad_cuotas").val("");
		$("#divPlazo").show();
	}
});

$("#tipo_articulo").change(function () {
	var tipo = $(this).val();
	if (tipo === "1") {
		$("#divKm").hide();
		$("#divMetal").hide();
		$("#divPeso").hide();
		$("#divPureza").hide();
	} else if (tipo === "2") {
		$("#divKm").hide();
		$("#divMetal").show();
		$("#divPeso").show();
		$("#divPureza").show();
	} else if (tipo === "3") {
		$("#divKm").show();
		$("#divMetal").hide();
		$("#divPeso").hide();
		$("#divPureza").hide();
	}
});

var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();
//funcion limpiar
function limpiar() {
	$("#idventa").val("");
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#tipo_credito").val("");
	$("#cantidad_cuotas").val("");
	$("#tasa_interes").val("");
	$("#total_venta").val("");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#most_total").html("0.00");
	$("#tpagado").val("");
	//marcamos el primer tipo_documento
	//$("#tipo_credito").selectpicker("refresh");
	//$("#idcliente").selectpicker("refresh");

	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
	$("#Modalcliente").modal("hide");
	// $("#detalles").append("");

	detalles = 0;
	evaluar();
	$("#btnGuardar").prop("disabled", false);
	$("#crono").empty();
}

function limpiarArticulo() {
	$("#tipo_articulo").val("");
	$("#idcategoria").val("");
	$("#nombreArticulo").val("");
	$("#serieArticulo").val("");
	$("#marcaArticulo").val("");
	$("#modeloArticulo").val("");
	$("#metalArticulo").val("");
	$("#pesoArticulo").val("");
	$("#purezArticulo").val("");
	$("#kmArticulo").val("");
	$("#observacionArticulo").val("");
	$("#evaluoArticulo").val("");
	$("#valorArticulo").val("");
	$("#btnGuardarArticulo").prop("disabled", false);
}

//funcion para guardaryeditar
function guardaryeditar(e) {
	e.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "Controllers/Sell.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			//console.log(datos);
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

//funcion para anular
function anular(idventa) {
	swal({
		title: "Anular?",
		text: "Esá seguro de anular venta?",
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
				"Controllers/Sell.php?op=anular",
				{ idventa: idventa },
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

function agregarDetalle(idarticulo, articulo, precio_venta, prestamo, op) {
	if (idarticulo != "") {
		var fila =
			'<tr class="filas" id="fila' +
			cont +
			'">' +
			'<td class=""><input style="width:70px;" type="hidden" name="idarticulo[]" value="' +
			idarticulo +
			'"><input type="hidden"  name="precio_venta[]" id="precio_venta[]" value="' +
			precio_venta +
			'"><input type="hidden"  name="prestamo[]" id="prestamo[]" value="' +
			prestamo +
			'">' +
			articulo +
			"</td>" +
			'<td class="col-xs-1"><span id="subtotal' +
			cont +
			'" name="subtotal">' +
			prestamo +
			"</span></td>" +
			"</tr>";
		var product = null;
		var shelf = null;
		var status = null;
		//submit
		cont++;
		detalles++;
		$("#detalles").append(fila);
		calcularTotales();
	} else {
		alert("error al ingresar el detalle, revisar las datos del articulo ");
	}
}

function calcularTotales() {
	var total = 0;
	var totalp = 0;
	var prev = document.getElementsByName("precio_venta[]");
	var prestamo = document.getElementsByName("prestamo[]");

	for (var i = 0; i < prev.length; i++) {
		var inpP = prev[i];
		total += parseInt(inpP.value);
		var pres = prestamo[i];
		totalp += parseInt(pres.value);
	}
	$("#total_avaluo").val(total);
	$("#capital").val(totalp);
	$("#most_total").html(totalp);

	evaluar();
}

function evaluar() {
	if (detalles > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}

//funcion para guardar nuevo cliente
function agregarArticulo(e) {
	e.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardarArticulo").prop("disabled", true);
	var formData = new FormData($("#formularioArticulo")[0]);

	$.ajax({
		url: "Controllers/Product.php?op=agregarArticulo",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			swal({
				//title: "Articulo agregado",
				text: "Articulo agregado",
				icon: "success",
				buttons: {
					confirm: "OK",
				},
			});
			//console.log(datos);
			buscarArticulo(parseInt(datos));
		},
	});
	limpiarArticulo();
	//cargamos los items al select cliente
}

function buscarCliente() {
	var documento = $("#numDocumento").val();
	$.post(
		"Controllers/Person.php?op=buscarCliente",
		{ documento: documento },
		function (data, status) {
			data = JSON.parse(data);
			$("#idcliente").val(data.idpersona);
			$("#clienteDocumento").val(data.num_documento);
			$("#clienteNombre").val(data.nombre + " " + data.ap + " " + data.am);
		}
	);
}

function buscarArticulo(idarticulo) {
	$.post(
		"Controllers/Product.php?op=mostrar",
		{ idarticulo: idarticulo },
		function (data, status) {
			data = JSON.parse(data);
			var articulo = data.idarticulo;
			if (data.idarticulo !== undefined) {
				//console.log("si existe");
				agregarDetalle(
					data.idarticulo,
					data.nombre,
					data.evaluo,
					data.valor_prestamo,
					data.stock,
					1
				);
			}
		}
	);
}

/*tabla = $("#tblCronograma").DataTable({
	bPaginate: false,
	bFilter: false,
	bInfo: false,
	bDestroy: true,
	ordering: false,
});*/

function generarCronograma() {
	$("#crono").empty();
	var cliente = $("#idcliente").val();
	//console.log(cliente.length);
	if (cliente.length <= 0) {
		swal({
			//title: "Articulo agregado",
			text: "Debes seleccionar el cliente",
			icon: "error",
			buttons: {
				confirm: "OK",
			},
		});
	} else {
		var fechaInicioPago = $("#fechaInicioPago").val();
		var fechaFinPago = $("#fechaFinPago").val();
		var montoCredito = $("#capital").val();
		var numCuotas = $("#cantidad_cuotas").val();
		var frecuenciaPago = $("#tipo_credito").val();
		//var tea = $("#tea").val();
		var tea = 0;
		var tem = $("#tasa_interes").val();
		$.post(
			"Controllers/GenerateCrono.php?op=generarCronograma",
			{
				fechaInicioPago: fechaInicioPago,
				fechaFinPago: fechaFinPago,
				montoCredito: montoCredito,
				numCuotas: numCuotas,
				frecuenciaPago: frecuenciaPago,
				tea: tea,
				tem: tem,
			},
			function (data, status) {
				//	data = JSON.parse(data);
				console.log(data);
				$("#crono").append(data);
			}
		);
	}
}
init();
