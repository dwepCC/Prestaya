<?php 
require_once "../Models/Product.php";

$product=new Product();

$idarticulo=isset($_POST["idarticulo"])? $_POST["idarticulo"]:"";
$idcategoria=isset($_POST["idcategoria"])? $_POST["idcategoria"]:"";
$tipo_articulo=isset($_POST["tipo_articulo"])? $_POST["tipo_articulo"]:"";
$nombre=isset($_POST["nombreArticulo"])? $_POST["nombreArticulo"]:"";
$codigo=isset($_POST["serieArticulo"])? $_POST["serieArticulo"]:"";
$marca=isset($_POST["marcaArticulo"])? $_POST["marcaArticulo"]:"";
$modelo=isset($_POST["modeloArticulo"])? $_POST["modeloArticulo"]:"";
$metal=isset($_POST["metalArticulo"])? $_POST["metalArticulo"]:"";
$peso=isset($_POST["pesoArticulo"])? $_POST["pesoArticulo"]:"";
$pureza=isset($_POST["purezArticulo"])? $_POST["purezArticulo"]:"";
$kilometraje=isset($_POST["kmArticulo"])? $_POST["kmArticulo"]:"";
$stock=isset($_POST["stock"])? $_POST["stock"]:"";
$descripcion=isset($_POST["observacionArticulo"])? $_POST["observacionArticulo"]:"";
$evaluo=isset($_POST["evaluoArticulo"])? $_POST["evaluoArticulo"]:"";
$valor_prestamo=isset($_POST["valorArticulo"])? $_POST["valorArticulo"]:"";
$precio_venta=isset($_POST["precioVenta"])? $_POST["precioVenta"]:"";
$imagen=isset($_POST["imagen"])? $_POST["imagen"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':


			if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])){ 
			(empty($_POST["imagenactual"]))?$imagen='default.png':$imagen=$_POST["imagenactual"];
			}else{
				if(!empty($_POST["imagenactual"]) && $_POST["imagenactual"] != 'default.png'){
					unlink("../Assets/img/products/".$_POST["imagenactual"]);
				}
				$ext=explode(".", $_FILES["imagen"]["name"]);
				if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
					$imagen=round(microtime(true)).'.'. end($ext);
					move_uploaded_file($_FILES["imagen"]["tmp_name"], "../Assets/img/products/".$imagen);
				}
			}
			if (empty($idarticulo)) {
					$rspta=$product->insertar($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen);
					echo $rspta ? "Articulo agregado correctamente" : "No se puedo agregar el articulo";

			}else{
				$rspta=$product->editar($idcategoria,$codigo,$nombre,$descripcion,$imagen,$idarticulo);
				echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
			}

		break;

	case 'agregarArticulo':
			if (empty($idarticulo)) {
					$rspta=$product->agregarArticulo($idcategoria,$tipo_articulo,$codigo,$nombre,$marca,$modelo,$stock,$metal,$peso,$pureza,$kilometraje,$descripcion,$evaluo,$valor_prestamo,$precio_venta,$imagen);
					//echo $rspta ? "Articulo agregado correctamente" : "No se puedo agregar el articulo";
					echo $rspta;
			}
		break;


	case 'desactivar':
		$rspta=$product->desactivar($idarticulo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$product->activar($idarticulo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	

	case 'agregarPrecioVenta':
	$precio_venta=$_REQUEST["precio_venta"];
		$rspta=$product->agregarPrecioVenta($idarticulo,$precio_venta);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'devolver':
		$rspta=$product->devolver($idarticulo);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;

	case 'mostrar':
		$rspta=$product->mostrar($idarticulo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$product->listar();
		$data=Array();

            foreach($rspta as $reg){

			$data[]=array(
            "0"=>($reg['condicion'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idarticulo'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idarticulo'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idarticulo'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['idarticulo'].')"><i class="fas fa-check"></i></button>',
            "1"=>$reg['nombre'],
            "2"=>$reg['categoria'],
            "3"=>$reg['codigo'],
            "4"=>'<button class="btn btn-success btn-sm">'.$reg['stock'].'</button>',
            "5"=>"<img src='Assets/img/products/".$reg['imagen']."' height='50px' width='50px'>",
            "6"=>$reg['descripcion'],
			"7"=>$reg['valor_prestamo'],
			"8"=>($reg['precio_venta']>0)?$reg['precio_venta']:'<button class="btn btn-warning btn-sm" onclick="agregarPrecioVenta('.$reg['idarticulo'].')"><i class="fas fa-plus"></i></button>',
            "9"=>($reg['condicion'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listarParaVenta':
		$rspta=$product->listarParaVenta();
		$data=Array();

            foreach($rspta as $reg){
$boton=($reg['condicion'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idarticulo'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idarticulo'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idarticulo'].')"><i class="fas fa-pencil-alt"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg['idarticulo'].')"><i class="fas fa-check"></i></button>';
			$data[]=array(
            "0"=>'',
            "1"=>$reg['nombre'],
            "2"=>$reg['categoria'],
            "3"=>$reg['codigo'],
            "4"=>'<button class="btn btn-success btn-sm">'.$reg['stock'].'</button>',
            "5"=>"<img src='Assets/img/products/".$reg['imagen']."' height='50px' width='50px'>",
            "6"=>$reg['descripcion'],
			"7"=>$reg['valor_prestamo'],
			"8"=>($reg['precio_venta']>0)?$reg['precio_venta']:'<button class="btn btn-warning btn-sm" onclick="agregarPrecioVenta('.$reg['idarticulo'].')"><i class="fas fa-plus"></i></button>',
            "9"=>($reg['condicion'])?'<div class="badge badge-success">Activado</div>':'<div class="badge badge-danger">Desactivado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;


    case 'listarGarantia':
		$rspta=$product->listarGarantia();
		$data=Array();

            foreach($rspta as $reg){

			$data[]=array(
            "0"=>($reg['estado_credito'])?'<button class="btn btn-warning btn-sm" onclick="devolver('.$reg['idarticulo'].')"><i class="fas fa-check"></i></button>':' ',
            "1"=>$reg['nombre'],
            "2"=>$reg['categoria'],
            "3"=>$reg['codigo'],
            "4"=>"<img src='Assets/img/products/".$reg['imagen']."' height='50px' width='50px'>",
            "5"=>$reg['descripcion'],
			"6"=>$reg['evaluo'],
			"7"=>$reg['valor_prestamo'],
            "8"=>($reg['estado_credito'])?'<div class="badge badge-success">Pagado</div>':'<div class="badge badge-warning">Pendiente</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;



	case 'selectArticulo':
		$rspta=$product->select();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
			echo '<option value="'. $reg['idarticulo'].'">'.$reg['nombre'].'</option>';
		}
		break;
}
