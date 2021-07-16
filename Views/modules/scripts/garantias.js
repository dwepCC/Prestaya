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
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
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
				url: "Controllers/Product.php?op=listarGarantia",
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

function devolver(idarticulo) {
	swal({
		//title: "Activar?",
		text: "Esá seguro de devolver?",
		icon: "warning",
		buttons: {
			cancel: "No, cancelar",
			confirm: "Si, devolver",
		},
		//buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.post(
				"Controllers/Product.php?op=devolver",
				{ idarticulo: idarticulo },
				function (e) {
					swal(e, {
						icon: "success",
					});
					var tabla = $("#tbllistado").DataTable();
					tabla.ajax.reload();
				}
			);
		}
	});
}

function generarbarcode() {
	codigo = $("#codigo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

function imprimir() {
	$("#print").printArea();
}

init();
