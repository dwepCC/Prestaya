var tabla;

//funcion que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//cargamos los items al celect categoria
	$.post("Controllers/Category.php?op=selectCategoria", function (r) {
		$("#idcategoria").html(r);
		//$("#idcategoria").selectpicker("refresh");
	});
	$("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar() {
	$("#serieArticulo").val("");
	$("#nombreArticulo").val("");
	$("#observacionArticulo").val("");
	$("#stock").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
		$("#btnreporte").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnreporte").show();
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
					text: '<i class="fa fa-file-excel-o"></i> Excel',
					titleAttr: "Exportar a Excel",
					title: "Reporte de Articulos",
					sheetName: "Artículos",
					exportOptions: {
						columns: [1, 2, 3, 4, 6, 7],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Articulos",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3, 4, 6, 7],
					},
				},
			],
			ajax: {
				url: "Controllers/Product.php?op=listar",
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
		url: "Controllers/Product.php?op=guardaryeditar",
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

function mostrar(idarticulo) {
	$.post(
		"Controllers/Product.php?op=mostrar",
		{ idarticulo: idarticulo },
		function (data, status) {
			data = JSON.parse(data);
			mostrarform(true);

			$("#idcategoria").val(data.idcategoria);
			//$("#idcategoria").selectpicker("refresh");
			$("#serieArticulo").val(data.codigo);
			$("#nombreArticulo").val(data.nombre);
			$("#observacionArticulo").val(data.descripcion);
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src", "Assets/img/products/" + data.imagen);
			$("#imagenactual").val(data.imagen);
			$("#idarticulo").val(data.idarticulo);
			generarbarcode();
		}
	);
}

//funcion para desactivar
//funcion para desactivar
function desactivar(idarticulo) {
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
				"Controllers/Product.php?op=desactivar",
				{ idarticulo: idarticulo },
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

function activar(idarticulo) {
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
				"Controllers/Product.php?op=activar",
				{ idarticulo: idarticulo },
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

function agregarPrecioVenta(idarticulo) {
	swal({
		title: "Precio de venta",
		content: {
			element: "input",
			attributes: {
				placeholder: "0.00",
				type: "number",
			},
		},
	}).then((data) => {
		//swal("Hello, " + data + "!");
		$.post(
			"Controllers/Product.php?op=agregarPrecioVenta",
			{ idarticulo: idarticulo, precio_venta: data },
			function (e) {
				swal(e, "Registrado!", {
					icon: "success",
				});
				var tabla = $("#tbllistado").DataTable();
				tabla.ajax.reload();
			}
		);
	});

	/*	swal({
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
//AQUI VA EL CODIGO DE LA ACCION
		}
	});*/
}

function generarbarcode() {
	codigo = $("#serieArticulo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

function imprimir() {
	$("#print").printArea();
}

init();
