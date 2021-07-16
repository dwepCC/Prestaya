<?php
date_default_timezone_set('America/Lima');
require_once "../Models/Caja.php";
if (strlen(session_id())<1) 
	session_start();

$caja=new Caja();

$idoficina=$_SESSION["idoficina"]; 
$idusuario=$_SESSION["idusuario"];
$idusuarioRecibe=isset($_POST["usuarioRecibe"])? $_POST["usuarioRecibe"]:"";
$fecha_reg = date("Y-m-d");
$totalEnvio=isset($_POST["totalEnvio"])? $_POST["totalEnvio"]:"";
//$id=isset($_POST["idcaja"])? $_POST["idcaja"]:"";
$b_200=isset($_POST["b_200"])? $_POST["b_200"]:"";
$b_100=isset($_POST["b_100"])? $_POST["b_100"]:"";
$b_50=isset($_POST["b_50"])? $_POST["b_50"]:"";
$b_20=isset($_POST["b_20"])? $_POST["b_20"]:"";
$b_10=isset($_POST["b_10"])? $_POST["b_10"]:"";
$m_5=isset($_POST["m_5"])? $_POST["m_5"]:"";
$m_2=isset($_POST["m_2"])? $_POST["m_2"]:"";
$m_1=isset($_POST["m_1"])? $_POST["m_1"]:""; 
$m_050=isset($_POST["m_050"])? $_POST["m_050"]:"";
$m_020=isset($_POST["m_020"])? $_POST["m_020"]:"";
$m_010=isset($_POST["m_010"])? $_POST["m_010"]:"";

$idpersona="4";
$glosa="Envio a boveda";
$hora=date('H:i:s');

switch ($_GET["op"]) {
	case 'guardaryeditar':

		$rspta=$caja->insertar($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
    //echo $rspta;

		break;

	case 'envioCaja':

		$rspta=$caja->insertarEnvio($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010,$idpersona,$glosa,$hora);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
    //echo $rspta;

		break;	

	case 'desactivar':
    $id=$_REQUEST['id'];
		$rspta=$caja->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'recepcionar':
    $id=$_REQUEST['id'];
    $totalEnvio=$_REQUEST['total']; 
		$rspta=$caja->recepcionar($id,$idoficina,$idusuario,$fecha_reg,$totalEnvio);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;
	
	case 'mostrar':
		$rspta=$caja->mostrar($idusuario); 
		echo json_encode($rspta);
		break; 

	case 'abrirCaja':
		$rspta=$caja->abrirCaja($idusuario);
		echo json_encode($rspta);
		break;

    case 'listarc':
		$rspta=$caja->listar($idoficina); 
		$data=Array();
$item=0;
$boton='';
            foreach($rspta as $reg){ 
          if($reg['usuarioRecibe']==$_SESSION['nombre']){
            $boton=($reg['estado'])?'<div class="badge badge-success">Recibido</div>':'<button class="btn btn-warning btn-sm" onclick="aceptar('.$reg['id'].','.$reg['monto_apertura'].')"><i class="fas fa-check"></i> Aceptar</button>';

          }else{
            $boton=($reg['estado'])?'<div class="badge badge-success">Recibido</div>':'<button class="btn btn-warning btn-sm"> Pendiente</button>';            
          }
			$data[]=array(
            "0"=>$item+1,
            "1"=>$reg['usuarioEnvia'],
            "2"=>$reg['monto_apertura'],
            "3"=>$reg['fecha_reg'],
            "4"=>$reg['usuarioRecibe'],
            "5"=>$boton
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarh':
		$rspta=$caja->listarh();
		$data=Array();
$item=0;
            foreach($rspta as $reg){ 
			$data[]=array(
            "0"=>$item+1,
            "1"=>$reg['usuarioEnvia'],
            "2"=>$reg['monto_apertura'],
            "3"=>$reg['fecha_reg'],
            "4"=>$reg['usuarioRecibe'],
            "5"=>$reg['monto_cierre'],
            "6"=>$reg['fecha_reg'],
            "7"=>$reg['total'],
            "8"=>($reg['estado'])?'<div class="badge badge-success">Recibido</div>':'<div class="badge badge-danger">No recibido</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarAhorroSaldo':
		$rspta=$caja->listarAhorroSaldo();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cajaNombre'],
            "3"=>$reg['cajaNumero'],
            "4"=>$reg['total'],
            "5"=>$reg['fechaRegistro'].'-'.$reg['horaRegistro'],
            "6"=>($reg['estado'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarPlazoFijo':
		$rspta=$caja->listarPlazoFijo();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cajaNombre'],
            "3"=>$reg['cajaNumero'],
            "4"=>$reg['total'],
            "5"=>$reg['fechaRegistro'].'-'.$reg['horaRegistro'],
            "6"=>($reg['estado'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarAhorroPago':
		$rspta=$caja->listarAhorroPago();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>'<button class="btn btn-success btn-sm" onclick="mostrarIngreso('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\')"><i class="fas fa-plus-square"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="mostrarRetiro('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\')"><i class="fas fa-minus-square"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cajaNombre'],
            "3"=>$reg['cajaNumero'],
            "4"=>$reg['cajaSaldo'],
            "5"=>$reg['fechaRegistro'].'-'.$reg['horaRegistro'],
            "6"=>($reg['estado'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);     
		break;

    case 'listarPlazoPago':
		$rspta=$caja->listarPlazoPago();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>'<button class="btn btn-success btn-sm" onclick="mostrarIngreso('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\','.$reg['interes'].','.$reg['plazo'].')"><i class="fas fa-plus-square"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="mostrarRetiro('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\','.$reg['interes'].','.$reg['plazo'].')"><i class="fas fa-minus-square"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cajaNombre'],
            "3"=>$reg['cajaNumero'],
            "4"=>$reg['cajaSaldo'],
            "5"=>$reg['fechaRegistro'].'-'.$reg['horaRegistro'],
            "6"=>($reg['estado'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'buscarcaja':
	$idpersona=$_REQUEST['idpersona'];
		$rspta=$caja->buscarcaja($idpersona);
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['id'].'">'.$reg['cajaNombre'].'</option>';
		}
		break;
}
