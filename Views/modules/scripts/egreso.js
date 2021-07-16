var tabla;

//funcion que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
}

function buscarCliente() {
	var documento = $("#numDocumento").val();
	$.post(
		"Controllers/Person.php?op=buscarCliente",
		{ documento: documento },
		function (data, status) {
			data = JSON.parse(data);
			$("#idpersona").val(data.idpersona);
			$("#clienteNombre").val(data.nombre + " " + data.ap + " " + data.am);
			$("#numDocumento").val("");
		}
	);
}

//funcion limpiar
function limpiar() {
	$("#numDocumento").val("");
	$("#clienteNombre").val("");
	$("#idpersona").val("");
	$("#tipo_comprobante").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#descripcion").val("");
	$("#cantidad").val("");
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
			language: {
				search: "Buscar:",
				zeroRecords: "No se encontró nada, lo siento",
				info: "mostrando de _START_ a _END_ de _TOTAL_ elementos",
				infoEmpty: "No hay registros disponibles",
				paginate: {
					previous: "Anterior",
					next: "Siguiente",
				},
			},
			aProcessing: true, //activamos el procedimiento del datatable
			aServerSide: true, //paginacion y filrado realizados por el server
			dom: "Bfrtip", //definimos los elementos del control de la tabla
			buttons: [
				{
					extend: "excelHtml5",
					text: "Excel",
					titleAttr: "Exportar a Excel",
					title: "Reporte de Egresos",
					sheetName: "Egresos",
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 8],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Egresos",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					download: "open",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 8],
					},
				},
			],
			ajax: {
				url: "Controllers/Egreso.php?op=listar",
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
		url: "Controllers/Egreso.php?op=guardaryeditar",
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

function mostrar(id) {
	$.post(
		"Controllers/Egreso.php?op=mostrar",
		{ id: id },
		function (data, status) {
			data = JSON.parse(data);
			mostrarform(true);

			$("#id").val(data.id);
			$("#idpersona").val(data.idpersona);
			$("#tipo_comprobante").val(data.tipo_comprobante);
			$("#serie_comprobante").val(data.serie_comprobante);
			$("#num_comprobante").val(data.num_comprobante);
			$("#descripcion").val(data.descripcion);
			$("#cantidad").val(data.cantidad);
		}
	);
}

//funcion para desactivar
function anular(id) {
	swal({
		title: "Desactivar?",
		text: "Esá seguro de desactivar?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, desactivar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post("Controllers/Egreso.php?op=anular", { id: id }, function (e) {
				swal(e, "Anulado!", {
					icon: "success",
				});
				var tabla = $("#tbllistado").DataTable();
				tabla.ajax.reload();
			});
		}
	});
}

function hacerPago(id, descripcion, idpersona, cantidad) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de pagar?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, pagar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/Egreso.php?op=hacerPago",
				{
					id: id,
					descripcion: descripcion,
					idpersona: idpersona,
					cantidad: cantidad,
				},
				function (e) {
					swal(e, "Pagado!", {
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
