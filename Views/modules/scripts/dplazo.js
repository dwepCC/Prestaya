"use strict";
var tabla;

//funcion que se ejecuta al inicio
function init() {
	listar();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
}

//funcion limpiar
function limpiar() {
	$("#total").val("");

	$("#modalAhorro").modal("hide");
	$("#tituloAhorro").html("");
}

//cancelar form
function cancelarform() {
	limpiar();
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
					title: "Reporte de Categorias",
					sheetName: "Categorias",
					exportOptions: {
						columns: [1, 2, 3],
					},
				},
				{
					extend: "pdfHtml5",
					text: '<i class="fa fa-file-pdf-o"></i> PDF',
					titleAttr: "Exportar a PDF",
					title: "Reporte de Categorias",
					//messageTop: "Reporte de usuarios",
					pageSize: "A4",
					//orientation: 'landscape',
					exportOptions: {
						columns: [1, 2, 3],
					},
				},
			],
			ajax: {
				url: "Controllers/Cuenta.php?op=listarPlazoPago",
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				},
			},
			bDestroy: true,
			iDisplayLength: 5, //paginacion
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
		url: "Controllers/Ahorro.php?op=guardaryeditar",
		type: "POST", 
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			console.log(datos);
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

function mostrarIngreso(id, idPersona, titular,interes,plazo) {
	$("#modalAhorro").modal("show");
	$("#tituloAhorro").html("Depósito de ahorro");
	$("#tipo_mov").val("1");
	$("#clienteNombre").val(titular);
	$("#idpersona").val(idPersona);
    $("#idcuenta").val(id);
    $("#interes").val(interes);
	$("#plazo").val(plazo); 
	//cargamos los items al celect categoria
}

function mostrarRetiro(id, idPersona, titular,interes,plazo) {
	$("#modalAhorro").modal("show");
	$("#tituloAhorro").html("Retiro de ahorro");
	$("#tipo_mov").val("2");
	$("#clienteNombre").val(titular);
	$("#idpersona").val(idPersona);
    $("#idcuenta").val(id);
    $("#interes").val(interes);
	$("#plazo").val(plazo);
	//cargamos los items al celect categoria
}
init();
