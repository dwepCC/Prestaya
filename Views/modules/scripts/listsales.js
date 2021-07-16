//funcion que se ejecuta al inicio
function init() {
	listar("Aprobado");
}

//$("#concretar_oferta").on("click", myFuncion());
$("#btnagregar").on("click", function () {
	$("#getCodeModal").modal("show");
});

$("input[name=estadoCredito]").click(function () {
	var estadoCredito = $(this).val();
	listar(estadoCredito);
});

//funcion listar
function listar(estadoCredito) {
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
					title: "Reporte de Creditos",
					sheetName: "Creditos",
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o bg-red"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Creditos",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
			],
			ajax: {
				url: "Controllers/Sell.php?op=listar",
				data: { estadoCredito: estadoCredito },
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

function mostrar(idventa) {
	$("#getCodeModal").modal("show");
	$.post(
		"Controllers/Sell.php?op=mostrar",
		{ idventa: idventa },
		function (data, status) {
			data = JSON.parse(data);
			//mostrarform(true);
			console.log(data);
			$("#cliente").val(data.cliente);
			$("#tipo_comprobantem").val(data.tipo_comprobante);
			$("#serie_comprobantem").val(data.serie_comprobante);
			$("#num_comprobantem").val(data.num_comprobante);
			$("#fecha_horam").val(data.fecha);
			$("#impuestom").val("18");
			$("#idventam").val(data.idventa);

			//ocultar y mostrar los botones
		}
	);
	$.post("Controllers/Sell.php?op=listarDetalle&id=" + idventa, function (r) {
		$("#detallesm").html(r);
	});
}

function desaprobar(idventa) {
	swal({
		title: "Denegar?",
		text: "Esá seguro de desaprobar el crédito?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, desaprobar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/Sell.php?op=desaprobar",
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

function autorizar(idventa) {
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
init();
