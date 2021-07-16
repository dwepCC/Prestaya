var tabla;

//funcion que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//cargamos los items al celect categoria
	$.post("Controllers/User.php?op=selectUsuario", function (r) {
		$("#usuarioRecibe").html(r);
		//$("#idcategoria").selectpicker("refresh");
	});

	$("#totalEnvio").val("0");
	$("#btnGuardar").hide();
}

//funcion limpiar
function limpiar() {
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
					text: '<i class="fa fa-file-excel-o bg-green"></i> Excel',
					titleAttr: "Exportar a Excel",
					title: "Reporte de Clientes",
					sheetName: "Clientes",
					exportOptions: {
						columns: [1, 2, 3, 4, 5],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o bg-red"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Clientes",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 5],
					},
				},
			],
			ajax: {
				url: "Controllers/Caja.php?op=listarc",
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
		url: "Controllers/Caja.php?op=guardaryeditar",
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

function aceptar(id, total) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de recepcionar?",
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
				"Controllers/Caja.php?op=recepcionar",
				{ id: id, total: total },
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

	evaluar();
}

function evaluar() {
	var total = $("#totalEnvio").val();
	if (total > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
	}
}

init();
