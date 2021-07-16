<?php 
require_once "../Models/Consult.php";

if (strlen(session_id())<1) 
	session_start();

$consult = new Consult();

$idusuario=$_SESSION['idusuario'];


switch ($_GET["op"]) {
    case 'compras10dias':
        //COMPRAS DE LOS ULTIMOS 10 DIAS
        $compras10 = $consult->comprasultimos_10dias();
        $fechas=Array();
        $totales=Array();

        /*$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");*/

        foreach ($compras10 as $regfechac) {
            array_push($fechas,$regfechac["fecha"]);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);

        break;

    case 'ventas12meses':
        //COMPRAS DE LOS ULTIMOS 10 DIAS
        $compras10 = $consult->ventasultimos_12meses();
        $fechas=Array();
        $totales=Array();

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        foreach ($compras10 as $regfechac) {
            array_push($fechas,$meses[date("n", strtotime($regfechac["fecha"]))-1]);
            array_push($totales,$regfechac['total']);
        }
        $respuesta=[
            "fechas" => $fechas,
            "totales" => $totales,
        ];
        echo json_encode($respuesta);

        break;

    case 'cuadros1':
        $rsptac = $consult->totalArticulos();
        $regc=$rsptac[0];
        $totalc=$regc['totala'];

        $rsptav = $consult->totalcreditos();
        $regv=$rsptav[0];
        $totalv=$regv['total_credito'];

        $rsptav = $consult->cantidadclientes();
        $regv=$rsptav[0];
        $totalclientes=$regv['totalc'];

        $rsptav = $consult->cantidadCreditos();
        $regv=$rsptav[0];
        $cantidadCreditos=$regv['cantidad'];

        $rsptav = $consult->cantidadproveedores();
        $regv=$rsptav[0];
        $totalproveedores=$regv['totalp'];

        $rsptav = $consult->saldoCaja($idusuario);
        $regv=$rsptav[0];
        $saldoCaja=$regv['total_saldo'];

        $rsptav = $consult->saldoBoveda($idusuario);
        $regv=$rsptav[0];
        $saldoBoveda=$regv['total_saldo'];

        $rsptav = $consult->totalAhorro();
        $regv=$rsptav[0];
        $totalAhorro=$regv['total_ahorro'];

        $rsptav = $consult->totalPlazo(); 
        $regv=$rsptav[0];
        $totalPlazo=$regv['total_plazo'];

        $data=[
            
            "cantidadCreditos" => $cantidadCreditos,
            "totalArticulos" => $totalc,
            "totalcreditos" => $totalv,
            "cantidadclientes" => $totalclientes,
            "cantidadproveedores" => $totalproveedores,
            "saldoCaja" => $saldoCaja,
            "saldoBoveda" => $saldoBoveda,
            "totalAhorro" => $totalAhorro,
            "totalPlazo" => $totalPlazo,
        ];
        echo json_encode($data);
        break;

    case 'cuadros2':
        $rsptav = $consult->cantidadarticulos();
        $regv=$rsptav[0];
        $totalarticulos=$regv['totalar'];

        $rsptav = $consult->totalstock();
        $regv=$rsptav[0];
        $totalstock=$regv['totalstock'];
        $cap_almacen=3000;

        $rsptav = $consult->cantidadcategorias();
        $regv=$rsptav[0];
        $totalcategorias=$regv['totalca'];

        $data=[
            "cantidadarticulos" => $totalarticulos,
            "totalstock" => $totalstock,
            "cantidadcategorias" => $totalcategorias,
        ];
        echo json_encode($data);
        break;

    case 'cateogriasMasVendidas':
        $cateogriasMasVendidas = $consult->cateogriasMasVendidas();

        echo json_encode($cateogriasMasVendidas);

        break;
}