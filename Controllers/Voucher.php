<?php 
require_once "../Models/Voucher.php";

$voucher=new Voucher();

$id=isset($_POST["id"])? $_POST["id"]:"";
$nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($id)) {
		$rspta=$voucher->insertar($nombre);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$voucher->editar($id,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	
	case 'desactivar':
		$rspta=$voucher->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$voucher->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$voucher->mostrar($id);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$voucher->listar();
		$data=Array();

        foreach($rspta as $reg){
        $data[]=array(
            "0"=>($reg['condicion'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['id'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['id'].')"><i class="fa fa-check"></i></button>',
            "1"=>$reg['nombre'],
            "2"=>($reg['condicion'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectComprobante':
		$rspta=$voucher->select();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
			echo '<option value="'. $reg['id'].'">'.$reg['nombre'].'</option>';
		}
		break;
}
