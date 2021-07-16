var tabla;

//funcion que se ejecuta al inicio
function init() {
	mostrarform(false);
	mostrarform_clave(false);
	listar();
	$("#formularioc").on("submit", function (c) {
		editar_clave(c);
	});
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	$("#imagenmuestra").hide();
	//mostramos los permisos
	$.post("Controllers/User.php?op=permisos&id=", function (r) {
		$("#permisos").html(r);
	});
}

//funcion limpiar
function limpiar() {
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#idusuario").val("");
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
function mostrarform_clave(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formulario_clave").show();
		$("#btnGuardar_clave").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formulario_clave").hide();
		$("#btnagregar").show();
	}
}
//cancelar form
function cancelarform() {
	$("#claves").show();
	limpiar();
	mostrarform(false);
}
function cancelarform_clave() {
	limpiar();
	mostrarform_clave(false);
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
					title: "Reporte de Usuarios",
					sheetName: "Usuarios",
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 8],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Usuarios",
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
				url: "Controllers/User.php?op=listar",
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
		url: "Controllers/User.php?op=guardaryeditar",
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
	$("#claves").show();
	limpiar();
}

function editar_clave(c) {
	c.preventDefault(); //no se activara la accion predeterminada
	$("#btnGuardar_clave").prop("disabled", true);
	var formData = new FormData($("#formularioc")[0]);

	$.ajax({
		url: "Controllers/User.php?op=editar_clave",
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
				mostrarform_clave(false);
			tabla.ajax.reload();
			bootbox.alert(datos);
		},
	});

	limpiar();
}
function mostrar(idusuario) {
	$.post(
		"Controllers/User.php?op=mostrar",
		{ idusuario: idusuario },
		function (data, status) {
			data = JSON.parse(data);
			mostrarform(true);
			console.log($("#idusuario").val(data.idusuario).length);
			if ($("#idusuario").val(data.idusuario).length === 0) {
				$("#claves").show();
			} else {
				$("#claves").hide();
			}
			$("#nombre").val(data.nombre);
			$("#tipo_documento").val(data.tipo_documento);
			//$("#tipo_documento").select2();
			//$("#tipo_documento").empty();
			//$("#tipo_documento").select2({
			//data: data.slots,
			//});
			$("#num_documento").val(data.num_documento);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#cargo").val(data.cargo);
			$("#login").val(data.login);

			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src", "Assets/img/users/" + data.imagen);
			$("#imagenactual").val(data.imagen);
			$("#idusuario").val(data.idusuario);
		}
	);
	$.post("Controllers/User.php?op=permisos&id=" + idusuario, function (r) {
		$("#permisos").html(r);
	});
}

function mostrar_clave(idusuario) {
	$.post(
		"Controllers/User.php?op=mostrar_clave",
		{ idusuario: idusuario },
		function (data, status) {
			data = JSON.parse(data);
			mostrarform_clave(true);
			$("#clavec").val("");
			$("#idusuarioc").val(data.idusuario);
		}
	);
}

//funcion para desactivar
function desactivar(idusuario) {
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
			$.post(
				"Controllers/User.php?op=desactivar",
				{ idusuario: idusuario },
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

function activar(idusuario) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de activar?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, activar",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/User.php?op=activar",
				{ idusuario: idusuario },
				function (e) {
					swal(e, "Activado!", {
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
