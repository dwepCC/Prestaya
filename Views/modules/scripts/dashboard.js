"use strict";
function init() {
	cuadros1();
	cuadros2();
	compra10dias();
	venta12meses();
	cat_vendidas();
}

//var valor = 10000.34;
//console.log(addCommas(valor));
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

function cuadros1() {
	$.post("Controllers/Dashboard.php?op=cuadros1", function (data, status) {
		data = JSON.parse(data);
		//console.log(data);
		//SALDO CAJA
		$("#saldoCaja").html(addCommas(data.saldoCaja));
		//SALDO BOVEDA
		$("#saldoBoveda").html(addCommas(data.saldoBoveda));
		//SALDO DE CREDITO
		$("#tcomprahoy").html(addCommas(data.totalArticulos));
		//TOTAL CREDITOS
		$("#totalCreditos").html(addCommas(data.cantidadCreditos));
		//TOTAL AHORRO
		$("#tahorro").html(addCommas(data.totalAhorro));
		//TOTAL PLAZOFIJO
		$("#tplazofijo").html(addCommas(data.totalPlazo));
		//TOTAL CRDITO
		$("#tventahoy").html(addCommas(data.totalcreditos));
		//CLIENTES
		$("#tclientes").html(addCommas(data.cantidadclientes));
		//PROVEEDORES
		$("#tproveedores").html(addCommas(data.cantidadproveedores));
	});
}
function cuadros2() {
	$.post("Controllers/Dashboard.php?op=cuadros2", function (data, status) {
		data = JSON.parse(data);
		//console.log(data.totalcomprahoy);
		//CATEGORIAS
		$("#tcategorias").html(data.cantidadcategorias);
		//ALAMACEN
		$("#tarticulos").html(data.cantidadarticulos);
	});
}
//COMPRA DE LOS ULTIMOS 10 DIAS
function compra10dias() {
	$.post("Controllers/Dashboard.php?op=compras10dias", function (data, status) {
		data = JSON.parse(data);
		var ctx = document.getElementById("compra10dias").getContext("2d");
		var myChart = new Chart(ctx, {
			type: "bar",
			data: {
				labels: data.fechas,
				datasets: [
					{
						label: "Creditos",
						data: data.totales,
						//borderWidth: 2,
						backgroundColor: [
							"#fc544b",
							"#F4D03F",
							"#63ed7a",
							"#1262F7",
							"#ffa426",
							"#6777ef",
							"#fc544b",
							"#F4D03F",
							"#63ed7a",
							"#1262F7",
							"#ffa426",
							"#6777ef",
						],
						//borderColor: "#6777ef",
						//borderWidth: 2.5,
						//pointBackgroundColor: "#ffffff",
						//pointRadius: 4,
					},
				],
			},
			options: {
				legend: {
					display: true,
				},
				scales: {
					yAxes: [
						{
							gridLines: {
								drawBorder: true,
								color: "#f2f2f2",
							},
							ticks: {
								beginAtZero: true,
								stepSize: 1500,
								fontColor: "#9aa0ac", // Font Color
							},
						},
					],
					xAxes: [
						{
							ticks: {
								display: true,
							},
							gridLines: {
								display: true,
							},
						},
					],
				},
			},
		});
	});
}

//VENTAS DE LOS ULTIMOS 12 MESES
function venta12meses() {
	$.post("Controllers/Dashboard.php?op=ventas12meses", function (data, status) {
		data = JSON.parse(data);
		var ctx = document.getElementById("venta12meses").getContext("2d");
		var myChart = new Chart(ctx, {
			type: "bar",
			data: {
				labels: data.fechas,
				datasets: [
					{
						label: "Creditos",
						data: data.totales,
						//borderWidth: 2,
						backgroundColor: [
							"#fc544b",
							"#F4D03F",
							"#63ed7a",
							"#1262F7",
							"#ffa426",
							"#6777ef",
							"#fc544b",
							"#F4D03F",
							"#63ed7a",
							"#1262F7",
							"#ffa426",
							"#6777ef",
						],
						//borderColor: "#6777ef",
						//borderWidth: 2.5,
						//pointBackgroundColor: "#ffffff",
						//pointRadius: 4,
					},
				],
			},
			options: {
				legend: {
					display: true,
				},
				scales: {
					yAxes: [
						{
							gridLines: {
								drawBorder: true,
								color: "#f2f2f2",
							},
							ticks: {
								beginAtZero: true,
								stepSize: 1500,
								fontColor: "#9aa0ac", // Font Color
							},
						},
					],
					xAxes: [
						{
							ticks: {
								display: true,
							},
							gridLines: {
								display: true,
							},
						},
					],
				},
			},
		});
	});
}

function cat_vendidas() {
	$.post(
		"Controllers/Dashboard.php?op=cateogriasMasVendidas",
		function (data, status) {
			data = JSON.parse(data);
			//console.log(data);
			var cant,
				cat,
				datos = [];
			for (var i = 0; i < data.length; i++) {
				datos.push(
					(cat = {
						name: data[i].categoria,
						y: parseFloat(data[i].cantidad),
					})
				);
			}
			// Build the chart
			Highcharts.chart("cat_mas_vendidas", {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: "pie",
				},
				title: {
					text: "Créditos mas desembolsados",
				},
				tooltip: {
					pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
				},
				accessibility: {
					point: {
						valueSuffix: "%",
					},
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: "pointer",
						dataLabels: {
							enabled: false,
						},
						showInLegend: true,
					},
				},
				series: [
					{
						name: "Crédito",
						colorByPoint: true,
						data: datos,
					},
				],
			});
		}
	);
}
init();
