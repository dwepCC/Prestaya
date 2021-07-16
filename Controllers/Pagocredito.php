<?php 
date_default_timezone_set('America/Lima');

require_once "../Models/Pagocredito.php";

if (strlen(session_id())<1) 
	session_start();
$pagocredito=new Pagocredito();

$fecha=date('Y-m-d');

$idoficina=$_SESSION["idoficina"];
$glosa=isset($_POST["glosa"])? $_POST["glosa"]:"";
$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
$cantidad=isset($_POST["totalPagoCredito"])? $_POST["totalPagoCredito"]:"";
$fecha_reg=date('Y-m-d');
$hora=date('H:i:s');
$idusuario=$_SESSION["idusuario"];
$tipo_mov=isset($_POST["tipo_mov"])? $_POST["tipo_mov"]:"";

$idcredito=isset($_POST["idcredito"])? $_POST["idcredito"]:"";
$num_credito=isset($_POST["num_credito"])? $_POST["num_credito"]:"";


switch ($_GET["op"]) {
	case 'guardaryeditar':
		$rspta=$pagocredito->insertar($idoficina,$glosa,$idcliente,$cantidad,$fecha_reg,$hora,$idusuario,$tipo_mov,$idcredito,$num_credito,$_POST["idCronograma"],$_POST["numItem"],$_POST["fechaPagoOriginal"],$_POST["intCrono"],$_POST["amortizacion"],$_POST["cuotaPagar"],$_POST["restoCapital"]);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";

		break;

	case 'anular':
		$rspta=$pagocredito->desactivar($idpersona);
		echo $rspta ? "Agregado a la lista negra correctamente" : "No se pudo enviar a la lista negra";
	break;



    case 'listarCronograma':

$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
$tipoPago=isset($_POST["tipoPago"])? $_POST["tipoPago"]:"";
$numCuota=isset($_POST["numCuota"])? $_POST["numCuota"]:"";
$idcredito=$_REQUEST['idcredito'];

        if(!empty($idcredito)){

        //$idcliente=$_REQUEST["idcliente"];
        //$tipoPago=$_REQUEST["tipoPago"];
        //$numCuota=$_REQUEST["numCuota"];
		$rspta=$pagocredito->listarCronograma($idcredito,$tipoPago,$fecha,$numCuota);
		$data=Array();

        $item=1;
        $totalInteres=0;
        $totalCap=0;
        $totalCapital=0;
        $totalInteres=0;
        $totalPagado=0;
        $idcredito='';
        $num_credito='';            
//print_r($rspta);
        if(!empty($rspta)){
            foreach ( $rspta as $reg ) {

            echo '<tr>
            <td>'.$item.'</td>
                    <td>'.$reg['num_cuota'].'<input type="hidden" step="0.01" name="numItem[]" id="numItem[]" value="'.$reg['num_cuota'].'"><input type="hidden" name="idCronograma[]" id="idCronograma[]" value="'.$reg['id'].'"></td>
                    <td>'.$reg['fecha_pago_original'].'<input type="hidden" step="0.01" name="fechaPagoOriginal[]" id="fechaPagoOriginal[]" value="'.$reg['fecha_pago_original'].'"></td>
                    <td>'.round($reg['interes'],2).'<input type="hidden" step="0.01" name="intCrono[]" id="intCrono[]" value="'.round($reg['interes'],2).'"></td>
                    <td>'.round($reg['capital'],2).'<input type="hidden" step="0.01" name="amortizacion[]" id="amortizacion[]" value="'.round($reg['capital'],2).'"></td>
                    <td>'.round($reg['total_pago'],2).'<input type="hidden" step="0.01" name="cuotaPagar[]" id="cuotaPagar[]" value="'.$reg['total_pago'].'"></td>
                    <td>'.$reg['saldo_capital'].'<input type="hidden" step="0.01" name="restoCapital[]" id="restoCapital[]" value="'.$reg['saldo_capital'].'"></td>';
                
            $totalPagado+=round(((float)$reg['capital']+(float)$reg['interes']),2);
            $totalCapital+=round($reg['capital'],1,PHP_ROUND_HALF_UP);
            $totalCap+=round($reg['capital'],1,PHP_ROUND_HALF_DOWN);  
            $totalInteres+=$reg['interes'];
            $item+=1;
            $idcredito=$reg['num_credito'];
            $num_credito=$reg['num_credito'];
            }
            echo '<input type="hidden" name="idcredito" id="idcredito" value="'.$idcredito.'">';
            echo '<input type="hidden" name="num_credito" id="num_credito" value="'.$num_credito.'">';
        }else{
            echo 'false';
        }

        /* $tinteres=number_format($totalInteres,2,',','.');
            $tcapital=number_format($totalCap,2,',','.');
            $pago=$totalInteres+$totalCap;
            echo'<tr><th colspan="3" class="text-center"><label>TOTALES</label></th>
            <th><label>'.number_format($totalInteres,2,',','.').'</label></th>
            <th><label>'.number_format($totalCapital,2,',','.').'</label></th>
            <th><label>'.round($pago,2).'</label></th> 
            <th><input type="hidden" step="0.01" name="total_prestamo" id="total_prestamo" value="'.round($totalPagado,2).'"><input type="hidden" step="0.01" name="interes" id="interes" value="'.round($totalInteres,2).'"></th></tr>';*/
        }else{
            echo'no hay datos';
        }
		break;

	case 'mostrarCreditos':
        $idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
		$rspta=$pagocredito->mostrarCreditos($idcliente);
        echo '<b>CRÉDITOS VIGENTES: </b> ';
        foreach ( $rspta as $reg ) {
            echo '<label class="btn btn-info btn-sm"> 
                   <input type="radio" name="mostrarCreditos" onclick="mostrarCronograma('.$reg['idventa'].',0,0)" value="'.$reg['idventa'].' "> <b> '.' '.$reg['num_credito'].' </b></label>';
        }
		//echo $rspta;
	break;

	case 'mostrarOpciones':
		$urlCronograma='Docs/pdf/estadoCronograma.php?id=';
        $movCredito='Docs/pdf/movCredito.php?id=';
        //$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
        $idcredito=$_REQUEST['idcredito'];
		$rspta=$pagocredito->mostrarOpciones($idcredito);
        echo '<div class="form-group col-lg-12 col-md-12 col-xs-12">
                <a target="_blank" href="'.$movCredito.$rspta['idventa'].'"> <label class="btn btn-warning btn-sm"><i class="fas fa-list-ol"></i> Movimientos</label></a>
                <a target="_blank" href="'.$urlCronograma.$rspta['idventa'].'"> <label class="btn btn-primary btn-sm"><i class="fas fa-file"></i> Cronograma</label></a>
             </div>';
		//echo $rspta['idventa'];
	break;
}
