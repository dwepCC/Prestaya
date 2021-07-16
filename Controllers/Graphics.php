<?php 
require_once "../Models/Consult.php";

$consult = new Consult();

switch ($_GET["op"]) {
    case 'compras_grafica':
        //COMPRAS DE LOS ULTIMOS 10 DIAS
        $compras_grafica = $consult->compras_grafica();
        $fechas=Array();
        $totales=Array();

        foreach ($compras_grafica as $regfechac) {
            array_push($fechas,$regfechac['fecha']);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);

        break;

    case 'ventas_grafica':
        //COMPRAS DE LOS ULTIMOS 10 DIAS
        $ventas_grafica = $consult->ventas_grafica();
        $fechas=Array();
        $totales=Array();
        foreach ($ventas_grafica as $regfechac) {
            array_push($fechas,$regfechac['fecha']);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);

        break;

    case 'resumen_compras':
        $datos_grafica= $consult->comparsultimos_12meses_grafica();
        $fechas=Array();
        $totales=Array();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        foreach ($datos_grafica as $regfechac) {
            array_push($fechas,$meses[date("n", strtotime($regfechac["fecha"]))-1]);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);
        break;

    case 'resumen_ventas':

        $datos_grafica= $consult->ventasultimos_12meses_grafica();
        $fechas=Array();
        $totales=Array();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        foreach ($datos_grafica as $regfechac) {
            array_push($fechas,$meses[date("n", strtotime($regfechac["fecha"]))-1]);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);
        break;
}