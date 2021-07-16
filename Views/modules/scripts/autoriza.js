//funcion que se ejecuta al inicio
function init() {
	listar();
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
					title: "Reporte de Ventas",
					sheetName: "Ventas",
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o bg-red"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Ventas",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7],
					},
				},
			],
			ajax: {
				url: "Controllers/Sell.php?op=listarSolicitud",
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
