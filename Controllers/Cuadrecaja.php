<?php 
date_default_timezone_set('America/Lima');
require_once "../Models/Cuadrecaja.php";
if (strlen(session_id())<1) 
	session_start();

$cuadrecaja = new Cuadrecaja();

$fecha = date("Y-m-d");
$idoficina=$_SESSION["idoficina"];
$id=isset($_POST["id"])? $_POST["id"]:"";
$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
$idusuario=$_SESSION["idusuario"];

//recepcion
$idoficina=$_SESSION["idoficina"];
$descripcion="Recepcion de boveda"; 
$fecha_reg=date('Y-m-d');
$hora=date('H:i:s');
//$idusuario=$_SESSION["idusuario"];


switch ($_GET["op"]) {
	case 'desaprobar':
		$rspta=$cuadrecaja->desaprobar($id);
		echo $rspta ? "Credito desaprobado correctamente" : "No se pudo desaprobar el crédito";
		break;

	case 'autorizar':
		$rspta=$cuadrecaja->autorizar($id);
		echo $rspta ? "Credito autorizado correctamente" : "No se pudo autorizar el crédito";
		break;	

    case 'sumarTotales': 
		$fecha_reg=$_REQUEST["fechaCaja"];
        $rsptac = $cuadrecaja->totalIngreso($fecha_reg,$idusuario);
        $regc=$rsptac[0];
        $totali=$regc['totali'];

        $rsptav = $cuadrecaja->totalEgreso($fecha_reg,$idusuario);
        $regv=$rsptav[0];
        $totale=$regv['totale']; 


        $data=[
            "totalIngreso" => $totali,
            "totalEgreso" => $totale
        ];
        echo json_encode($data);
        break;


	case 'recepcionar':
	$id=$_REQUEST["id"];
	//$idpersona=$_REQUEST["usuarioEnvia"];
	$idpersona="4";
	$cantidad=$_REQUEST["cantidad"];
	$rspta=$cuadrecaja->recepcionar($id,$idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario);
	echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		//echo $rspta;
		break;

	case 'mostrar':
		$rspta=$cuadrecaja->mostrar($id);
		echo json_encode($rspta);
		//echo $rspta;
		break;

    case 'listar':
		$fechaCaja=$_REQUEST["fechaCaja"];
		$rspta=$cuadrecaja->listar($idoficina,$fechaCaja,$idusuario);
		$data=Array();  
		$item=1;
		$anular='';
		foreach ($rspta as $reg) {
			//	$estado='';
			$urlt='Reports/ticket.php?id=';
			if($reg['fecha_reg']==$fecha){   
/*$anular='<button class="btn btn-danger btn-sm" onclick="anular('.$reg['id'].')"><i class="fas fa-trash-alt"></i></button>';*/
			}

			$data[]=array(
                "0"=>$item,
				"1"=>$anular.' '.'<a target="_blank" href="'.$urlt.$reg['id'].'"> <button class="btn btn-info btn-sm"><i class="fas fa-print"></i></button></a>',
				"2"=>$reg['fecha_reg'],
                "3"=>$reg['hora'],
				"4"=>$reg['id'],
				"5"=>$reg['glosa'],
				"6"=>$reg['titular'],
				"7"=>($reg['tipo_mov']=='1')?$reg['cantidad']:'',
				"8"=>($reg['tipo_mov']=='2')?$reg['cantidad']:''
              );
              $item+=1;
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;




}
 ?>