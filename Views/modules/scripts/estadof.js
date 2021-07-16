//funcion que se ejecuta al inicio
function init() {
	//obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + month + "-" + day;
	$("#fechaEstado").val(today);

	mostrar(1, today);
}

function addCommas(nStr) {
	nStr += "";
	let x = nStr.split(".");
	let x1 = x[0];
	let x2 = x.length > 1 ? "." + x[1] : "";
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, "$1" + "," + "$2");
	}
	return x1 + x2;
}

$("#tipo").change(function () {
	let tipo = $(this).val();
	let fecha = $("#fechaEstado").val();
	mostrar(tipo, fecha);
});

$("#fechaEstado").change(function () {
	let fecha = $(this).val();
	let tipo = $("#tipo").val();
	//console.log(tipo);
	mostrar(tipo, fecha);
});

function mostrar(tipo, fecha) {
	//INGRESOS FINANCIEROS
	$.post(
		"Controllers/Estadof.php?op=interesCartera",
		{ tipo: tipo, fecha: fecha },
		function (data, status) {
			//console.log(data);
			data = JSON.parse(data);
			var icartera = parseFloat(addCommas(data.icartera));
			$("#icartera").val(icartera);
			$("#ifinanciero").val(icartera);
		}
	);
}
init();
