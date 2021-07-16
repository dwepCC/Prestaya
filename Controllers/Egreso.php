<?php 
date_default_timezone_set('America/Lima');
require_once "../Models/Egreso.php";
if (strlen(session_id())<1) 
	session_start();

$egreso=new Egreso();

$id=isset($_POST["id"])? $_POST["id"]:"";
$tipo=isset($_POST["tipo"])? $_POST["tipo"]:"";
$idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? $_POST["tipo_comprobante"]:"";
$serie_comprobante=isset($_POST["serie_comprobante"])? $_POST["serie_comprobante"]:"";
$num_comprobante=isset($_POST["num_comprobante"])? $_POST["num_comprobante"]:"";
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
		$rspta=$egreso->insertar($idcuenta,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad,$fecha_reg,$idoficina,$idusuario);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$egreso->editar($idcuenta,$id,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'anular':
		$rspta=$egreso->anular($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'hacerPago':
    $descripcion=$_REQUEST['descripcion'];
    $idpersona=$_REQUEST['idpersona'];
    $cantidad=$_REQUEST['cantidad'];
		$rspta=$egreso->hacerPago($id,$idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$egreso->mostrar($id);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$egreso->listar();
		$data=Array();

            foreach($rspta as $reg){

        if($reg['tipo_comprobante']=='1'){
            $comprobante='FACTURA';
        }elseif ($reg['tipo_comprobante']=='2') {
            $comprobante='RECIBO POR HONORARIOS';
        }elseif ($reg['tipo_comprobante']=='3') {
            $comprobante='BOLETA DE VENTA';
        }elseif ($reg['tipo_comprobante']=='12') {
            $comprobante='TICKET';
        }elseif ($reg['tipo_comprobante']=='14') {
            $comprobante='RECIBO';
        }

			$data[]=array(
            "0"=>($reg['es_pagado'])?'<div class="badge badge-success">Pagado</div>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-warning btn-sm" onclick="hacerPago('.$reg['id'].',\''.$reg['descripcion'].'\','.$reg['idpersona'].','.$reg['cantidad'].')"><i class="fas fa-money-bill-alt"></i></button>',
            "1"=>$reg['titular'],
            "2"=>$comprobante,
            "3"=>$reg['serie_comprobante'].'-'.$reg['num_comprobante'],
            "4"=>$reg['descripcion'],
            "5"=>$reg['cantidad'],
            "6"=>$reg['fecha_reg']
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectCategoria':
		$rspta=$egreso->select();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['id'].'">'.$reg['tipo'].'</option>';
		}
		break;
}
