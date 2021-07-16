<?php
date_default_timezone_set('America/Lima');
require_once "../Models/Cuenta.php";

$cuenta=new Cuenta(); 

$id=isset($_POST["idcuenta"])? $_POST["idcuenta"]:"";
$idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$cuentaSaldo=isset($_POST["cuentaSaldo"])? $_POST["cuentaSaldo"]:"";
$cuentaNombre=isset($_POST["cuentaNombre"])? $_POST["cuentaNombre"]:"";
$interes=isset($_POST["interes"])? $_POST["interes"]:"";
$plazo=isset($_POST["plazo"])? $_POST["plazo"]:"";
$total=isset($_POST["total"])? $_POST["total"]:"";
$fecha_reg = date("Y-m-d");
$hora_reg=date("H:i:s");
$tipoCuenta=isset($_POST["tipoCuenta"])? $_POST["tipoCuenta"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

		$rspta=$cuenta->insertar($idpersona,$cuentaSaldo,$cuentaNombre,$interes,$plazo,$total,$fecha_reg,$hora_reg,$tipoCuenta);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
    //echo $rspta;

		break;
	
	case 'desactivar':
    $id=$_REQUEST['id'];
		$rspta=$cuenta->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar':
    $id=$_REQUEST['id'];
		$rspta=$cuenta->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$cuenta->mostrar($id);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$cuenta->listar();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cuentaNombre'],
            "3"=>$reg['cuentaNumero'],
            "4"=>$reg['cuentaSaldo'],
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

    case 'listarAhorroSaldo':
		$rspta=$cuenta->listarAhorroSaldo();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cuentaNombre'],
            "3"=>$reg['cuentaNumero'],
            "4"=>$reg['cuentaSaldo'],
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
		$rspta=$cuenta->listarPlazoFijo();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cuentaNombre'],
            "3"=>$reg['cuentaNumero'],
            "4"=>$reg['cuentaSaldo'],
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
		$rspta=$cuenta->listarAhorroPago();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>'<button class="btn btn-success btn-sm" onclick="mostrarIngreso('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\')"><i class="fas fa-plus-square"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="mostrarRetiro('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\')"><i class="fas fa-minus-square"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cuentaNombre'],
            "3"=>$reg['cuentaNumero'],
            "4"=>$reg['cuentaSaldo'],
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
		$rspta=$cuenta->listarPlazoPago();
		$data=Array();

            foreach($rspta as $reg){
			$data[]=array(
            "0"=>'<button class="btn btn-success btn-sm" onclick="mostrarIngreso('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\','.$reg['interes'].','.$reg['plazo'].')"><i class="fas fa-plus-square"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="mostrarRetiro('.$reg['id'].','.$reg['idPersona'].',\''.$reg['titular'].'\','.$reg['interes'].','.$reg['plazo'].')"><i class="fas fa-minus-square"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['cuentaNombre'],
            "3"=>$reg['cuentaNumero'],
            "4"=>$reg['cuentaSaldo'],
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

	case 'buscarCuenta':
	$idpersona=$_REQUEST['idpersona'];
		$rspta=$cuenta->buscarCuenta($idpersona);
		echo '<option value="">Seleccione...</option>'; 
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['id'].'">'.$reg['cuentaNombre'].'</option>';
		}
		break;
}
