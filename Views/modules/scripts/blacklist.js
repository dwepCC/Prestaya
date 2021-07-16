var tabla;

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
				url: "Controllers/Person.php?op=lista_negra",
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



function activar(idpersona) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de sacar de la lista negra?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, sacar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/Person.php?op=activar",
				{ idpersona: idpersona },
				function (e) {
					swal(e, "Quitado!", {
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
