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

	$("#divParcial").hide();
	$("#divNumCuotas").hide();
	$("#btnGuardar").hide();

	/*$("#tipoPagoCredito1").prop("disabled", true);
	$("#tipoPagoCredito2").prop("disabled", true);
	$("#tipoPagoCredito3").prop("disabled", true);
	$("#tipoPagoCredito4").prop("disabled", true);*/
}

$("input[name=mostrarCreditos]").click(function () {
	//var idCredito = $(this).val();
	//alert(idCredito);
	alert("hola");
});

function buscarCliente() {
	var documento = $("#numDocumento").val();
	if (documento.length > 0) {
		$.post(
			"Controllers/Person.php?op=buscarCliente",
			{ documento: documento },
			function (data, status) {
				if (data === "false") {
					swal({
						title: "Atención..",
						text: "Cliente no se encuantra registrado",
						icon: "warning",
						buttons: {
							confirm: "OK",
						},
					});
				} else {
					data = JSON.parse(data);
					$("#idcliente").val(data.idpersona);
					var idcliente = data.idpersona;
					$("#clienteDocumento").val(data.num_documento);
					$("#clienteNombre").val(data.nombre + " " + data.ap + " " + data.am);
					//mostrarCronograma(idcliente, 0, 0);
					mostrarCreditos(idcliente);
				}
				//console.log(data);
			}
		);
	} else {
		swal({
			title: "Atención..",
			text: "Ingrese el numero de documento",
			icon: "error",
			buttons: {
				confirm: "OK",
			},
		});
	}

	evaluar();
}

var tpago = 10;
$("input[name=tipoPagoCredito]").click(function () {
	var tipopago = $("input:radio[name=tipoPagoCredito]:checked").val();
	var idcliente = $("#idcliente").val();
	//alert(tipopago);
	//alert(id);
	if (tipopago == "1") {
		$("#divParcial").hide();
		$("#pagoParcial").val("");
		$("#pagoNumCuotas").val("");
		$("#divNumCuotas").hide();
		$("#totalPagoCredito").val("");
		//	$("#totalPagoCredito").val(tpago);
		mostrarCronograma(idcliente, 1, 0);
	} /* else if (tipopago == "2") {
		$("#divNumCuotas").show();
		$("#divParcial").hide();
		$("#totalPagoCredito").val("");
		mostrarCronograma(idcliente, 0, 0);
		$("#pagoNumCuotas").val("");
	}*/ else if (tipopago == "3") {
		$("#divParcial").hide();
		$("#divNumCuotas").show();
		//mostrarCronograma(idcliente, tipoPago, 0);
		$("#totalPagoCredito").val("");
		$("#pagoParcial").val("");
	} else if (tipopago == "4") {
		$("#divParcial").hide();
		$("#divNumCuotas").hide();
		$("#pagoParcial").val("");
		$("#pagoNumCuotas").val("");
		$("#totalPagoCredito").val("");
		mostrarCronograma(idcliente, 0, 0);
	}
	evaluar();
});

//FUNCION PARA MOSTRAR EL CRONOGRAMA SEGUN EL NUMERO DE CUOTA DE ADELANTO
$("#pagoNumCuotas").keyup(function () {
	var numCuotas = $(this).val();
	var idcliente = $("#idcliente").val();
	if (numCuotas > 0) {
		mostrarCronograma(idcliente, 3, numCuotas);
	} else if (numCuotas === 0) {
		mostrarCronograma(idcliente, 0, 0);
	} else {
		mostrarCronograma(idcliente, 0, 0);
	}
	$("#totalPagoCredito").val("");
});

$("#btnTotalPagar").click(function () {
	var tipopago = $("input:radio[name=tipoPagoCredito]:checked").val();
	var pago = $("#pagoParcial").val();
	var ncuotas = $("#pagoNumCuotas").val();
	if (tipopago == "2") {
		$("#totalPagoCredito").val(pago);
		//calculartotales();
		var nColumnas = $("#tblCronograma tr:last td").length;
		if (nColumnas > 0) {
			evaluar();
		}
	} else if (tipopago == "3") {
		//alert(pago.length);
		//var parcial = $("#pagoParcial").val();
		if (ncuotas.length > 0) {
			calculartotales();
		}
	} else {
		calculartotales();
	}
});
//funcion limpiar
function limpiar() {
	$("#clienteDocumento").val("");
	$("#idcredito").val("");
	$("#idcliente").val("");
	$("#clienteNombre").val("");
	$("#totalPagoCredito").val("");
	$("#pagoParcial").val("");
	$("#pagoNumCuotas").val("");
	$("#numDocumento").val("");
	$("#btnGuardar").prop("disabled", false);
	$("#crono").empty();

	document
		.querySelectorAll("[name=tipoPagoCredito]")
		.forEach((x) => (x.checked = false));

	evaluar();
}

//funcion para guardaryeditar
function guardaryeditar(e) {
	e.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "Controllers/Pagocredito.php?op=guardaryeditar",
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

function mostrarCronograma(idcredito, tipoPago, numCuota) {
	//mostrarOpciones(idcredito);
	$("#crono").empty();

	$.post(
		"Controllers/Pagocredito.php?op=listarCronograma",
		{
			idcredito: idcredito,
			tipoPago: tipoPago,
			numCuota: numCuota,
		},
		function (data, status) {
			//	data = JSON.parse(data);
			//console.log(data);
			var tipopago = $("input:radio[name=tipoPagoCredito]:checked").val();
			var dni = $("#clienteDocumento").val();
			if (tipoPago == 1) {
				if (dni.length < 0) {
					swal({
						title: dni.length,
						text: "No tiene cuotas por pagar a la fecha",
						icon: "warning",
						buttons: {
							confirm: "OK",
						},
					});
				}
				$("#crono").append(data);
				mostrarOpciones(idcredito);
			} else {
				if (data === "false") {
					swal({
						title: "Atención",
						text: "Cliente no tiene creditos vigentes",
						icon: "warning",
						buttons: {
							confirm: "OK",
						},
					});

					limpiar();
				} else {
					$("#crono").append(data);
					mostrarOpciones(idcredito);
				}
			}
		}
	);
}

function mostrarCreditos(idcliente) {
	$("#divMostrarCreditos").empty();

	$.post(
		"Controllers/Pagocredito.php?op=mostrarCreditos",
		{
			idcliente: idcliente,
		},
		function (data, status) {
			$("#divMostrarCreditos").append(data);
		}
	);
}

function mostrarOpciones(idcredito) {
	$("#divMostrarOpciones").empty();

	$.post(
		"Controllers/Pagocredito.php?op=mostrarOpciones",
		{
			idcredito: idcredito,
		},
		function (data, status) {
			console.log(data);
			$("#divMostrarOpciones").append(data);
		}
	);
}

function calculartotales() {
	if (!document.querySelector('input[name="tipoPagoCredito"]:checked')) {
		swal({
			title: "Error...",
			text: "Selecciona tipo de pago",
			icon: "error",
			buttons: {
				confirm: "OK",
			},
		});
	} else {
		var sub = document.getElementsByName("cuotaPagar[]");
		var total = 0;

		for (var i = 0; i < sub.length; i++) {
			var inpS = sub[i];

			total += parseFloat(inpS.value);
		}
		$("#totalPagoCredito").val(total.toFixed(2));
		//console.log(total);
		evaluar();
	}
}

function evaluar() {
	var pago = $("#totalPagoCredito").val();

	if (parseInt(pago) > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
	}
}
init();
