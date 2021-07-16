<?php
date_default_timezone_set('America/Lima');

require_once "../Models/Buy.php";
if (strlen(session_id())<1) 
	session_start();

$buy=new Buy(); 

$fecha_reg=date('Y-m-d');
$idingreso=isset($_POST["idingreso"])? $_POST["idingreso"]:"";
$idproveedor=isset($_POST["idproveedor"])? $_POST["idproveedor"]:"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? $_POST["tipo_comprobante"]:"";
$serie_comprobante=isset($_POST["serie_comprobante"])? $_POST["serie_comprobante"]:"";
$num_comprobante=isset($_POST["num_comprobante"])? $_POST["num_comprobante"]:"";
$fecha_hora=isset($_POST["fecha_hora"])? $_POST["fecha_hora"]:"";
$impuesto=isset($_POST["impuesto"])? $_POST["impuesto"]:"";
$total_compra=isset($_POST["total_compra"])? $_POST["total_compra"]:"";


switch ($_GET["op"]) {
	case 'guardaryeditar':
        if (empty($idingreso)) {
            $rspta=$buy->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		}else{
			$rspta=$buy->editar($idingreso,$idproveedor,$tipo_comprobante,$serie_comprobante,$num_comprobante,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["nuevostock"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		}
		break;
	
	case 'anular':
		$rspta=$buy->anular($idingreso);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el buy";
		break; 
	
	case 'mostrar':
		$rspta=$buy->mostrar($idingreso);
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		require_once "../Models/Company.php";
        $company = new Company();
        $rsptan = $company->listar();
        //$regn=$rsptan->fetch_object();
        if (empty($rsptan)) {
            $smoneda='Simbolo de moneda';
        }else{
            $smoneda=$rsptan[0]['simbolo'];
            $nom_imp=$rsptan[0]['nombre_impuesto'];
        };
		//recibimos el idingreso
		$id=$_GET['id'];

		$rspta=$buy->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Precio Venta Unitario</th>
        <th>Importe</th>
       </thead>';
		foreach ($rspta as $reg) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg['nombre'].'</td>
			<td>'.$reg['cantidad'].'</td>
			<td>'.$reg['precio_compra'].'</td>
			<td>'.$reg['precio_venta'].'</td>
			<td>'.$reg['precio_compra']*$reg['cantidad'].'</td>
			</tr>';
			//$total=$total+($reg['precio_compra']*$reg['cantidad']);
			$t_compra=$reg['total_compra'];
			$subtotal=round(($t_compra/1.18),1,PHP_ROUND_HALF_UP);
			//$imp=$reg['impuesto'];
			$igv=$t_compra-$subtotal;
			//$most_igv=$t_compra-$total;
		}
		echo '<tfoot>
        <th><span>SubTotal</span><br><span id="valor_impuestoc">'.$nom_imp.' '.$imp.' %</span><br><span>TOTAL</span></th>
         <th></th>
         <th></th>
         <th></th> 
         <th></th>
         <th>
		 <span class="pull-right" id="total">'.$smoneda.' '.number_format((float)$subtotal,2,'.','').'</span><br>
		 <span class="pull-right" id="most_imp">'.$smoneda.' '.number_format((float)$igv,2,'.','').'</span><br>
		 <span class="pull-right" id="most_total" maxlength="4">'.$smoneda.' '.$t_compra.'</span>
		 </th>
       </tfoot>';
		break;

	case 'listarDetalle_editar':
		require_once "../Models/Company.php";
		  $cnegocio = new Company();
		  $rsptan = $cnegocio->listar();
		  $regn=$rsptan[0];
		  if (empty($regn)) {
		    $smoneda='Simbolo de moneda';
		  }else{
		    $smoneda=$regn['simbolo'];
		    $nom_imp=$regn['nombre_impuesto'];
		  };
		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$buy->listarDetalle($id);
		$total=0;
		$data=Array();

		foreach ($rspta as $reg) {
			$data[]=array(
			"Idarticulo"=>$reg['idarticulo'],
            "Articulo"=>$reg['nombre'],
            "Pcompra"=>$reg['precio_compra'],
			"Pventa"=>$reg['precio_venta'],
			"Cantidad"=>$reg['cantidad'],
			"Stock"=>$reg['stock'],
			"Total"=>$reg['total_compra']
              );
		}
		$results=array(
    		"Datos"=>$data);
		echo json_encode($data);
		break;

    case 'listar':
		$rspta=$buy->listar();
		$data=Array();

		foreach ($rspta as $reg) {
			$data[]=array(
            "0"=>($reg['estado']=='Aceptado')?'<button class="btn btn-info btn-sm" onclick="mostrar('.$reg['idingreso'].')"><i class="fas fa-eye"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="anular('.$reg['idingreso'].')"><i class="fas fa-times"></i></button>':'<button class="btn btn-info btn-sm" onclick="mostrar('.$reg['idingreso'].')"><i class="fas fa-eye"></i></button>',
            "1"=>$reg['fecha'],
            "2"=>$reg['proveedor'], 
            "3"=>$reg['usuario'],
            "4"=>$reg['tipo_comprobante'],
            "5"=>$reg['serie_comprobante']. '-' .$reg['num_comprobante'],
            "6"=>$reg['total_compra'],
            "7"=>($reg['estado']=='Aceptado')?'<div class="badge badge-success">Aceptado</div>':'<div class="badge badge-danger">Anulado</div>'
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
			require_once "../Models/Person.php";
			$person = new Person();

			$rspta = $person->listarp();
			echo '<option value="0">seleccione...</option>';

			foreach ($rspta as $reg) {
				echo '<option value='.$reg['idpersona'].'>'.$reg['nombre'].'</option>';
			}
			break;

			case 'listarArticulos':
			require_once "../Models/Product.php";
			$product=new Product();

				$rspta=$product->listarActivos();
		$data=Array();

		foreach ($rspta as $reg) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" id="addetalle" name="'.$reg['idarticulo'].'" onclick="agregarDetalle('.$reg['idarticulo'].',\''.$reg['nombre'].'\')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg['nombre'],
            "2"=>$reg['categoria'],
            "3"=>$reg['codigo'],
            "4"=>$reg['stock'],
            "5"=>"<img src='Assets/img/products/".$reg['imagen']."' height='50px' width='50px'>"
          
              );
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