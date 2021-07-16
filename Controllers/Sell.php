<?php 
date_default_timezone_set('America/Lima');
require_once "../Models/Sell.php";
if (strlen(session_id())<1) 
	session_start();

$sell = new Sell();

$anio_credito = date("Y");
$fecha_reg = date("Y-m-d");
$hora=date("H:i:s");
$idoficina=$_SESSION["idoficina"];
$idventa=isset($_POST["idventa"])? $_POST["idventa"]:"";
$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
$idusuario=$_SESSION["idusuario"];
$tipo_credito=isset($_POST["tipo_credito"])? $_POST["tipo_credito"]:"";
$capital=isset($_POST["capital"])? $_POST["capital"]:"";
$tasa_interes=isset($_POST["tasa_interes"])? $_POST["tasa_interes"]:"";
$interes=isset($_POST["interes"])? $_POST["interes"]:"";
$impuesto=isset($_POST["impuesto"])? $_POST["impuesto"]:"";
$total_avaluo=isset($_POST["total_avaluo"])? $_POST["total_avaluo"]:"";
$total_prestamo=isset($_POST["total_prestamo"])? $_POST["total_prestamo"]:"";
$tipo_pago=isset($_POST["tipo_pago"])? $_POST["tipo_pago"]:"";
$num_transac=isset($_POST["num_transac"])? $_POST["num_transac"]:"";
$cantidad_cuotas=isset($_POST["cantidad_cuotas"])? $_POST["cantidad_cuotas"]:"";
$tipo_venta=isset($_POST["tipo_venta"])? $_POST["tipo_venta"]:"";



switch ($_GET["op"]) {
	case 'guardaryeditar':
        if (empty($idventa)) {
            $rspta=$sell->insertar($idoficina,$idcliente,$idusuario,$tipo_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,$cantidad_cuotas,$tipo_venta,$anio_credito,$_POST["idarticulo"],$_POST["precio_venta"],$_POST["prestamo"],$_POST["numItem"],$_POST["fechaPagoOriginal"],$_POST["intCrono"],$_POST["amortizacion"],$_POST["cuotaPagar"],$_POST["restoCapital"]);
		   echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}/*else{
        $rspta=$sell->editar($idventa,$idcliente,$tipo_credito,$anio_credito,$num_credito,$impuesto,$total_venta,$tipo_pago,$num_transac,$_POST["idarticulo"],$_POST["nuevostock"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"],$_POST["descuento"]);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}*/
		break;

	case 'guardarCredito':

            $rspta=$sell->insertarCredito($idoficina,$idcliente,$idusuario,$tipo_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,$cantidad_cuotas,$tipo_venta,$anio_credito,$_POST["numItem"],$_POST["fechaPagoOriginal"],$_POST["intCrono"],$_POST["amortizacion"],$_POST["cuotaPagar"],$_POST["restoCapital"]);
		   echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";

		break;

	case 'desaprobar':
		$rspta=$sell->desaprobar($idventa);
		echo $rspta ? "Credito desaprobado correctamente" : "No se pudo desaprobar el crédito";
		break;

	case 'autorizar':
		$rspta=$sell->autorizar($idventa);
		echo $rspta ? "Credito autorizado correctamente" : "No se pudo autorizar el crédito";
		break;	

	case 'desembolsar':
	$glosa='Desembolso de crédito';
	$idpersona=$_REQUEST['idcliente'];
	$cantidad=$_REQUEST['capital'];
		$rspta=$sell->desembolsar($idventa,$idoficina,$glosa,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario);
		echo $rspta ? "Credito desembolsado correctamente" : "No se pudo desembolsar el crédito";
		break;	

	case 'mostrar':
		$rspta=$sell->mostrar($idventa);
		echo json_encode($rspta);
		//echo $rspta;
		break;

	case 'listarDetalle':
		require_once "../Models/Company.php";
		  $cnegocio = new Company();
		  $rsptan = $cnegocio->listar();
		  //$regn=$rsptan->fetch_object();
		  if (empty($rsptan)) {
		    $smoneda='Simbolo de moneda';
		  }else{
		    $smoneda=$rsptan[0]['simbolo'];
		    $nom_imp=$rsptan[0]['nombre_impuesto'];
		  };
		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$sell->listarDetalle($id);
		$total=0;
		
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Venta</th>
        <th>Descuento</th>
        <th>Subtotal</th>
       </thead>';
		foreach ($rspta as $reg) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg['nombre'].'</td>
			<td>'.$reg['cantidad'].'</td> 
			<td>'.$reg['precio_venta'].'</td>
			<td>'.$reg['descuento'].'</td>
			<td>'.$reg['subtotal'].'</td></tr>';
			//$total=$total+($reg['precio_venta']*$reg['cantidad']-$reg['descuento']);
			$t_venta=$reg['total_venta'];
			$subtotal=round(($t_venta/1.18),1,PHP_ROUND_HALF_UP);
			$igv=$t_venta-$subtotal;
			//$imp=$reg['impuesto'];
			//$most_igv=$t_venta-$total;
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
		 <span class="pull-right" id="most_total" maxlength="4">'.$smoneda.' '.$t_venta.'</span></th>
       </tfoot>';
		break;


    case 'listarSolicitud':
		$rspta=$sell->listarSolicitud($idoficina);
		$data=Array();

		foreach ($rspta as $reg) {
			//	$estado='';
			$urlt='Reports/ticket.php?id=';
			$url='Reports/exFactura.php?id=';

			if($reg['es_solicitud']=='1'){
				$estado='<div class="badge badge-warning">Pendiente</div>';
			}else{
				if($reg['es_aprobado']=='1'){
					$estado='<div class="badge badge-success">Aprobado</div>';
				}elseif($reg['es_desaprobado']=='1'){
					$estado='<div class="badge badge-danger">Desaprobado</div>';	
				}
			}

			$data[]=array(
				"0"=>'<a target="_blank" href="'.$url.$reg['idventa'].'"> <button class="btn btn-primary btn-sm"><i class="far fa-file-pdf"></i></button></a>'.' '.'<a target="_blank" href="'.$urlt.$reg['idventa'].'"> <button class="btn btn-warning btn-sm"><i class="fas fa-hands-helping"></i></button></a>'.' '.'<a target="_blank" href="'.$urlt.$reg['idventa'].'"> <button class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i></button></a>'.' '.'<button class="btn btn-success btn-sm" onclick="autorizar('.$reg['idventa'].')"><i class="fas fa-check"></i></button>' .' '.'<button class="btn btn-danger btn-sm" onclick="desaprobar('.$reg['idventa'].')"><i class="fas fa-times"></i></button>',
				"1"=>$reg['num_credito'],
				"2"=>$reg['tipo_credito'],
				"3"=>$reg['cantidad_cuotas'],
				"4"=>$reg['fecha'],
				"5"=>$reg['cliente'],
				"6"=>$reg['capital'],
				"7"=>$reg['interes'],
				"8"=>$reg['total_prestamo'],
				"9"=>$estado
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

    case 'listar':
	$estadoCredito=$_REQUEST['estadoCredito'];
		$rspta=$sell->listar($idoficina,$estadoCredito);
		$data=Array();

		foreach ($rspta as $reg) {
			//	$estado='';
			$urlPagare='Docs/pdf/exPagare.php?id=';
			$urlContratop='Docs/pdf/exContratop.php?id=';
			$urlContratoc='Docs/pdf/exContratoc.php?id=';
			$urlCronograma='Docs/pdf/exCronograma.php?id=';
			if($reg['es_solicitud']=='1'){
				$estado='<div class="badge badge-warning">Pendiente</div>';
			}else{ 
				if($reg['es_aprobado']=='1'){
					$estado='<div class="badge badge-success">Vigente</div>';
				}elseif($reg['es_desaprobado']=='1'){
					$estado='<div class="badge badge-danger">Desaprobado</div>';	
				}
			}
			if($reg['credito']=='1'){ 
				$contrato='<a target="_blank" href="'.$urlContratoc.$reg['idventa'].'"> <button class="btn btn-warning btn-sm"><i class="fas fa-hands-helping"></i></button></a>';
			}elseif($reg['credito']=='2'){
				$contrato='<a target="_blank" href="'.$urlContratop.$reg['idventa'].'"> <button class="btn btn-warning btn-sm"><i class="fas fa-hands-helping"></i></button></a>';				
			}

			$data[]=array(
				"0"=>'<a target="_blank" href="'.$urlPagare.$reg['idventa'].'"> <button class="btn btn-primary btn-sm"><i class="far fa-file-pdf"></i></button></a>'.' '.$contrato.' '.'<a target="_blank" href="'.$urlCronograma.$reg['idventa'].'"> <button class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i></button></a>',
				"1"=>$reg['fecha'],
				"2"=>$reg['cliente'],
				"3"=>$reg['num_documento'],
				"4"=>$reg['telefono'],
				"5"=>$reg['num_credito'],
				"6"=>$reg['tipo_credito'],
				"7"=>$reg['cantidad_cuotas'],
				"8"=>$reg['capital'],
				"9"=>$reg['interes'],
				"10"=>$reg['total_prestamo'],
				"11"=>$estado
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;


    case 'listarDesembolso':
		$rspta=$sell->listarDesembolso($idoficina);
		$data=Array();

		foreach ($rspta as $reg) {

			$data[]=array(
				"0"=>'<button class="btn btn-success btn-sm" onclick="desembolsar('.$reg['idventa'].','.$reg['idcliente'].','.$reg['capital'].')"><i class="fas fa-money-bill-wave"></i> Desembolsar</button>',
				"1"=>$reg['num_credito'],
				"2"=>$reg['tipo_credito'],
				"3"=>$reg['cantidad_cuotas'],
				"4"=>$reg['fecha'],
				"5"=>$reg['cliente'],
				"6"=>$reg['capital'],
				"7"=>$reg['interes'],
				"8"=>$reg['total_prestamo']
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;


		case 'selectCliente':
			require_once "../Models/Person.php";
			$persona = new Person();

			$rspta = $persona->listarc();
			echo '<option value="">seleccione...</option>';
			foreach ($rspta as $reg) {
			
				echo '<option value='.$reg['idpersona'].'>'.$reg['nombre'].'</option>';
			}
			break;

	case 'cantidad_articulos':
			require_once "../Models/Product.php";
			$articulo=new Product();
		  $rsptav = $articulo->cantidadarticulos();

		  echo json_encode($rsptav);
		break;

		case 'listarArticulos':
			require_once "../Models/Product.php";
			$articulo=new Product();

			$rspta=$articulo->listarActivosVenta();
			$data=Array();
			$op=1;
			foreach ($rspta as $reg) { 
		        $btncolor='';
		        if ($reg['stock']<=10) {
		        	$btncolor='<button class="btn btn-danger btn-sm">'.$reg['stock'].'</button>';
		        }elseif ($reg['stock']>10 && $reg['stock']<30 ) {
		        	$btncolor='<button class="btn btn-warning btn-sm">'.$reg['stock'].'</button>';
		        }elseif ($reg['stock']>=30) {
		        	$btncolor='<button class="btn btn-success btn-sm">'.$reg['stock'].'</button>';
		        }
				$data[]=array(
	            "0"=>'<button class="btn btn-success btn-sm" id="addetalle" name="'.$reg['idarticulo'].'" onclick="agregarDetalle('.$reg['idarticulo'].',\''.$reg['nombre'].'\','.$reg['precio_compra'].','.$reg['precio_venta'].','.$reg['stock'].','.$op.')"><span class="fa fa-plus"></span> Añadir</button>',
	            "1"=>$reg['nombre'], 
	            "2"=>$reg['codigo'],
	            "3"=>$btncolor,
	            "4"=>"<img src='Assets/img/products/".$reg['imagen']."' height='40px' width='40px'>"
	          
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
			require_once "../Models/Voucher.php";
			$comprobantes=new Voucher();

			$rspta=$comprobantes->select();
			echo '<option value="">Seleccione...</option>'; 
			foreach ($rspta as $reg) {
				echo '<option value="' . $reg['nombre'].'">'.$reg['nombre'].'</option>';
			}
			break;

		case 'selectTipopago':
			require_once "../Models/Paymentstype.php";
			$tipopago=new Paymentstype();

			$rspta=$tipopago->select();
			foreach ($rspta as $reg) {
				echo '<option value="' . $reg['nombre'].'">'.$reg['nombre'].'</option>';
			}
			break;


}
 ?>