<?php 
date_default_timezone_set('America/Lima');

require_once "../Models/Person.php";

$person=new Person();

$idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$fecha_reg=date('Y-m-d');
$tipo_persona=isset($_POST["tipo_persona"])? $_POST["tipo_persona"]:"";
$ap=isset($_POST["ap"])? $_POST["ap"]:"";
$am=isset($_POST["am"])? $_POST["am"]:"";
$nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";
$tipo_documento=isset($_POST["tipo_documento"])? $_POST["tipo_documento"]:"";
$num_documento=isset($_POST["num_documento"])? $_POST["num_documento"]:"";
$fecha_nac=isset($_POST["fecha_nac"])? $_POST["fecha_nac"]:"";
$sexo=isset($_POST["sexo"])? $_POST["sexo"]:"";
$direccion=isset($_POST["direccion"])? $_POST["direccion"]:"";
$telefono=isset($_POST["telefono"])? $_POST["telefono"]:"";
$email=isset($_POST["email"])? $_POST["email"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idpersona)) {
		$rspta=$person->insertar($tipo_persona,$fecha_reg,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$person->editar($idpersona,$tipo_persona,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;

	case 'desactivar':
		$rspta=$person->desactivar($idpersona);
		echo $rspta ? "Agregado a la lista negra correctamente" : "No se pudo enviar a la lista negra";
	break;

	case 'activar':
		$rspta=$person->activar($idpersona);
		echo $rspta ? "Quitado de la lista negra correctamente" : "No se pudo quitar de la lista negra";
	break;
	
	case 'mostrar':
		$rspta=$person->mostrar($idpersona);
		echo json_encode($rspta);
		break;

	case 'buscarCliente':
	$documento=$_REQUEST["documento"];
		$rspta=$person->buscarCliente($documento);
		echo json_encode($rspta);
		/*if(!empty($rspta)){
		echo json_encode($rspta);
		}else{
			echo 'no hay datos';
		}*/
		break;

    case 'listarp':
		$rspta=$person->listarp();
		$data=Array();

		foreach($rspta as $reg){
		$data[]=array(
		"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idpersona'].')"><i class="fas fa-pencil-alt"></i></button>',
		"1"=>$reg['nombre'],
		"2"=>$reg['tipo_documento'],
		"3"=>$reg['num_documento'],
		"4"=>$reg['telefono'],
		"5"=>$reg['email']
			);
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarc':
		$rspta=$person->listarc();
		$data=Array();

		foreach($rspta as $reg){
		$data[]=array(
		"0"=>($reg['lista_negra'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idpersona'].')"><i class="fas fa-user-edit"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idpersona'].')"><i class="fas fa-user-edit"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idpersona'].')"><i class="fas fa-user-times"></i></button>',
		"1"=>$reg['fecha_reg'],
		"2"=>$reg['ap'].' '.$reg['am'].', '.$reg['nombre'],
		"3"=>$reg['tipo_documento'],
		"4"=>$reg['num_documento'],
		"5"=>$reg['fecha_nac'],
		"6"=>$reg['sexo'],
		"7"=>$reg['telefono'],
		"8"=>$reg['direccion'],
		"9"=>$reg['email']
			);
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'lista_negra':
		$rspta=$person->lista_negra();
		$data=Array();

		foreach($rspta as $reg){
		$data[]=array(
		"0"=>($reg['lista_negra'])?'<button class="btn btn-success btn-sm" onclick="activar('.$reg['idpersona'].')"><i class="fas fa-user-check"></i></button>':'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idpersona'].')"><i class="fas fa-user-times"></i></button>',
		"1"=>$reg['fecha_reg'],
		"2"=>$reg['ap'].' '.$reg['am'].', '.$reg['nombre'],
		"3"=>$reg['tipo_documento'],
		"4"=>$reg['num_documento'],
		"5"=>$reg['fecha_nac'],
		"6"=>$reg['sexo'],
		"7"=>$reg['telefono'],
		"8"=>$reg['direccion'],
		"9"=>$reg['email']
			);
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectProveedor':
		$rspta=$person->selectp();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
			echo '<option value="'. $reg['idpersona'].'">'.$reg['nombre'].'</option>';
		}
		break;

	case 'selectCliente':
		$rspta=$person->selectc();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
			echo '<option value="'. $reg['idpersona'].'">'.$reg['nombre'].'</option>';
		}
		break;
}
