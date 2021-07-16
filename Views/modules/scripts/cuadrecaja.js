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
	$("#fechaCaja").val(today);

	listar();

	$.post("Controllers/User.php?op=selectUsuario", function (r) {
		$("#usuarioRecibe").html(r);
		//$("#idcategoria").selectpicker("refresh");
	});

	$("#totalEnvio").val("0");
	$("#btnGuardar").hide();
	//sumarTotales();
}

var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var today = now.getFullYear() + "-" + month + "-" + day;

$("#fechaCaja").change(function () {
	var fecha = $(this).val();
	/*if (fecha != today) {
		$("#btnEnvio").hide();
		$("#btnRecibo").hide();
	} else {
		$("#btnEnvio").show();
		$("#btnRecibo").show();
	}*/
	listar();
});

function sumarTotales(fechaCaja) {
	$.post(
		"Controllers/Cuadrecaja.php?op=sumarTotales",
		{ fechaCaja: fechaCaja },
		function (data, status) {
			data = JSON.parse(data);
			console.log(data);
			//INGRESO
			$("#tIngreso").html(data.totalIngreso);
			//EGRESO
			$("#tEgreso").html(data.totalEgreso);
			var saldo = parseFloat(data.totalIngreso) - parseFloat(data.totalEgreso);
			$("#tSaldo").html(saldo.toFixed(2));
			$("#totalDisponible").val(saldo.toFixed(2));
			//$("#totalDisponible").val(saldo);
		}
	);
}
function totalEgreso() {}
function limpiar() {
	$("#total").val("");

	$("#modalAhorro").modal("hide");
	$("#tituloAhorro").html("");

	$("#totalEnvio").val("0");
	$("#b_200").val("0");
	$("#b_100").val("0");
	$("#b_50").val("0");
	$("#b_20").val("0");
	$("#b_10").val("0");
	$("#m_5").val("0");
	$("#m_2").val("0");
	$("#m_1").val("0");
	$("#m_050").val("0");
	$("#m_020").val("0");
	$("#m_010").val("0");

	$("#tb_200").val("0");
	$("#tb_100").val("0");
	$("#tb_50").val("0");
	$("#tb_20").val("0");
	$("#tb_10").val("0");
	$("#tm_5").val("0");
	$("#tm_2").val("0");
	$("#tm_1").val("0");
	$("#tm_050").val("0");
	$("#tm_020").val("0");
	$("#tm_010").val("0");
}

//cancelar form
function cancelarform() {
	limpiar();
}

//funcion para guardaryeditar
function guardaryeditar(e) {
	e.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "Controllers/Caja.php?op=envioCaja",
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
			});
			var tabla = $("#tbllistado").DataTable();
			tabla.ajax.reload();
		},
	});

	limpiar();
}

//funcion listar
function listar() {
	let fechaCaja = $("#fechaCaja").val();

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
					title: "Reporte de Caja",
					sheetName: "Caja",
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o bg-red"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Caja",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
			],
			ajax: {
				url: "Controllers/Cuadrecaja.php?op=listar",
				data: { fechaCaja: fechaCaja },
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				},
			},
			bDestroy: true,
			iDisplayLength: 10, //paginacion
			//ordering: false,
			//bPaginate: false,
			bFilter: false,
			bInfo: false,

			//			iDisplayLength: 10, //paginacion
			order: [[8, "asc"]], //ordenar (columna, orden)
		})
		.DataTable();
	sumarTotales(fechaCaja);
}

function anular(idventa) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de autorizar?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, autorizar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/Sell.php?op=autorizar",
				{ idventa: idventa },
				function (e) {
					swal(e, "Autorizado!", {
						icon: "success",
					});
					var tabla = $("#tbllistado").DataTable();
					tabla.ajax.reload();
				}
			);
		}
	});
}

function mostrarEnvio() {
	limpiar();
	let fechaCaja = $("#fechaCaja").val();
	$("#modalAhorro").modal("show");
	$("#tituloAhorro").html("Traslado de dinero");
	sumarTotales(fechaCaja);
	/*$("#tipo_mov").val("1");
	$("#clienteNombre").val(titular);
	$("#idpersona").val(idPersona);
	$("#idcuenta").val(id);*/
	//cargamos los items al celect categoria
}

function mostrarRecepcion() {
	$.post("Controllers/Caja.php?op=mostrar", function (data, status) {
		data = JSON.parse(data);
		//mostrarform(true);
		var datos = data.monto_apertura;
		//var d = datos.length;
		if (datos > 0) {
			swal({
				//title: data.monto_apertura,
				title: datos,
				text: "Esá seguro de Recepcionar?",
				icon: "warning",
				buttons: {
					cancel: "No, cancelar",
					confirm: "Si, recepcionar",
				},
				//buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					$.post(
						"Controllers/Cuadrecaja.php?op=recepcionar",
						{
							id: data.id,
							usuarioEnvia: data.usuarioEnvia,
							cantidad: data.monto_apertura,
						},
						function (e) {
							swal(e, "Recepcionado!", {
								icon: "success",
							});
							var tabla = $("#tbllistado").DataTable();
							tabla.ajax.reload();
						}
					);
				}
			});
		} else {
			swal("No hay niguna recepcion!", {
				icon: "warning",
			});
		}
	});
}

function abrirCaja() {
	$.post("Controllers/Caja.php?op=abrirCaja", function (data, status) {
		data = JSON.parse(data);
		//mostrarform(true);
		var datos = data.monto_apertura;
		//var d = datos.length;
		if (datos > 0) {
			swal({
				//title: data.monto_apertura,
				title: datos,
				text: "Saldo disponible?",
				icon: "warning",
				buttons: {
					cancel: "No, cancelar",
					confirm: "Si, aperturar",
				},
				//buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					$.post(
						"Controllers/Cuadrecaja.php?op=recepcionar",
						{
							id: data.id,
							usuarioEnvia: data.usuarioEnvia,
							cantidad: data.monto_apertura,
						},
						function (e) {
							swal(e, "Aperturado!", {
								icon: "success",
							});
							var tabla = $("#tbllistado").DataTable();
							tabla.ajax.reload();
						}
					);
				}
			});
		} else {
			swal("No hay niguna recepcion!", {
				icon: "warning",
			});
		}
	});
}

$("#b_200").keyup(function () {
	var cant = $(this).val() * 200;
	$("#tb_200").val(cant);

	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#b_100").keyup(function () {
	var cant = $(this).val() * 100;
	$("#tb_100").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#b_50").keyup(function () {
	var cant = $(this).val() * 50;
	$("#tb_50").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#b_20").keyup(function () {
	var cant = $(this).val() * 20;
	$("#tb_20").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#b_10").keyup(function () {
	var cant = $(this).val() * 10;
	$("#tb_10").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_5").keyup(function () {
	var cant = $(this).val() * 5;
	$("#tm_5").val(cant);

	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_2").keyup(function () {
	var cant = $(this).val() * 2;
	$("#tm_2").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_1").keyup(function () {
	var cant = $(this).val() * 1;
	$("#tm_1").val(cant);
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_050").keyup(function () {
	var cant = $(this).val() * 0.5;
	$("#tm_050").val(parseFloat(cant).toFixed(2));
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_020").keyup(function () {
	var cant = $(this).val() * 0.2;
	$("#tm_020").val(parseFloat(cant).toFixed(2));
	var total = $("#totalEnvio").val();

	calcularTotales();
});
$("#m_010").keyup(function () {
	var cant = $(this).val() * 0.1;
	$("#tm_010").val(parseFloat(cant).toFixed(2));
	var total = $("#totalEnvio").val();

	calcularTotales();
});

function calcularTotales() {
	var total = 0;
	var prev = document.getElementsByName("totald[]");

	for (var i = 0; i < prev.length; i++) {
		var inpP = prev[i];
		total += parseFloat(inpP.value);
		//console.log(total);
	}
	$("#totalEnvio").val(parseFloat(total).toFixed(2));
	//$("#totalEnvio").val(total);

	evaluar();
}

function evaluar() {
	var total = $("#totalEnvio").val();
	var totalSaldo = $("#totalDisponible").val();
	if (parseFloat(total) <= parseFloat(totalSaldo)) {
		if (total > 0) {
			$("#btnGuardar").show();
		} else {
			$("#btnGuardar").hide();
		}
	} else {
		swal("No tiene saldo que enviar!", {
			icon: "warning",
		});
		$("#btnGuardar").hide();
		//$("#totalEnvio").val("0");
	}
	//alert("para enviar:" + total + " saldo:" + totalSaldo);
	/*if (total >= totalSaldo) {
		if (total > 0) {
			$("#btnGuardar").show();
		} else {
			$("#btnGuardar").hide();
		}
	} else {
		swal("No tiene saldo que enviar!", {
			icon: "warning",
		});
		$("#btnGuardar").hide();
	}*/
}

init();
