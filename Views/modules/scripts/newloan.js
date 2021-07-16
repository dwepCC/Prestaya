var tabla;
("use strict");
//funcion que se ejecuta al inicio
function init() {
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + month + "-" + day;
	$("#fechaInicioPago").val(today);
}

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
	$("#numDocumento").val("");
	$("#tpagado").val("");

	$("#capital").val("");
	$("#clienteDocumento").val("");
	$("#clienteNombre").val("");

	$("#idpersona").val("");
	// $("#detalles").append("");

	$("#btnGuardar").prop("disabled", false);
	$("#crono").empty();
}

//funcion para guardaryeditar
function guardaryeditar(e) {
	e.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "Controllers/Sell.php?op=guardarCredito",
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

function generarCronograma() {
	$("#crono").empty();
	$("#btnGuardar").show();
	var fechaInicioPago = $("#fechaInicioPago").val();
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
init();
