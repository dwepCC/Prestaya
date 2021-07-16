<?php 
date_default_timezone_set('America/Lima');
require_once "../Models/Ingreso.php";
if (strlen(session_id())<1) 
	session_start();

$ingreso=new Ingreso();

$id=isset($_POST["id"])? $_POST["id"]:"";
$idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$descripcion=isset($_POST["descripcion"])? $_POST["descripcion"]:"";
$cantidad=isset($_POST["cantidad"])? $_POST["cantidad"]:"";
$fecha_reg=date('Y-m-d');
$idoficina=$_SESSION['idoficina'];
$idusuario=$_SESSION['idusuario'];
$idcuenta=isset($_POST["idcuenta"])? $_POST["idcuenta"]:"";

$hora=date('H:i:s'); 

switch ($_GET["op"]) {
	case 'guardaryeditar': 
	if (empty($id)) {
		$rspta=$ingreso->insertar($idpersona,$idcuenta,$descripcion,$cantidad,$fecha_reg,$idoficina,$idusuario);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$ingreso->editar($id,$idpersona,$idcuenta,$descripcion,$cantidad);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'anular':
		$rspta=$ingreso->anular($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'hacerPago':
    $descripcion=$_REQUEST['descripcion'];
    $idpersona=$_REQUEST['idpersona'];
    $cantidad=$_REQUEST['cantidad'];
		$rspta=$ingreso->hacerPago($id,$idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$ingreso->mostrar($id);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$ingreso->listar();
		$data=Array();

            foreach($rspta as $reg){

			$data[]=array(
            "0"=>($reg['es_pagado'])?'<div class="badge badge-success">Ingresado</div>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-warning btn-sm" onclick="hacerPago('.$reg['id'].',\''.$reg['descripcion'].'\','.$reg['idpersona'].','.$reg['cantidad'].')"><i class="fas fa-money-bill-alt"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$reg['descripcion'],
            "3"=>$reg['cantidad'],
            "4"=>$reg['fecha_reg']
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectCuenta':
		$rspta=$ingreso->selectCuenta();
				//echo json_encode($rspta); 
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['idcuenta'].'">'.$reg['idcuenta'].' - '.$reg['nombre'].'</option>';
		}
		break;
}
