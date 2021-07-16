<?php 
require_once "../Models/Paymentstype.php";

$paymentstype=new Paymentstype();

$idtipopago=isset($_POST["idtipopago"])? $_POST["idtipopago"]:"";
$nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";
$descripcion=isset($_POST["descripcion"])? $_POST["descripcion"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idtipopago)) {
		$rspta=$paymentstype->insertar($nombre,$descripcion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$paymentstype->editar($idtipopago,$nombre,$descripcion);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$paymentstype->desactivar($idtipopago);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$paymentstype->activar($idtipopago);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$paymentstype->mostrar($idtipopago);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$paymentstype->listar();
		$data=Array();


            foreach($rspta as $reg){
			$data[]=array(
            "0"=>($reg['estado'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idtipopago'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idtipopago'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idtipopago'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['idtipopago'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['nombre'],
            "2"=>$reg['descripcion'],
            "3"=>($reg['estado'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectTipopago':
		$rspta=$paymentstype->select();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['idtipopago'].'">'.$reg['nombre'].'</option>';
		}
		break;
}
