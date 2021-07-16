<?php
 date_default_timezone_set('America/Lima');

switch ($_GET["op"]) {


    case 'generarCronograma':
//$fDesembolso='12-06-2021';
//$fInicioPago='20-04-2021';
$fechasPago=$_REQUEST['fechaInicioPago'];
$fechafinPago=$_REQUEST['fechaFinPago'];
$fDesembolso= date($fechasPago);
$montoCredito=$_REQUEST['montoCredito'];
$nCuotas=$_REQUEST['numCuotas'];
$frecuenciaPago=$_REQUEST['frecuenciaPago'];
//TEA
$tea=$_REQUEST['tea'];
//TEM
$tem=$_REQUEST['tem'];

//FUNCION PARA OBTENER DIASD HABILES PARA EL CRONOGRAMA
function getDiasHabiles($fecha, $dias,$tipo) {
    $workingDays = [1, 2, 3, 4, 5,6]; # date format = N (1 = Monday, ...)
    $holidayDays = ['*-12-25', '*-01-01', '2013-12-24', '2013-12-25']; # variable and fixed holidays

    $fecha = new DateTime($fecha);
    $dates = [];
   // $dates[] = $fecha->format('Y-m-d');
    while ($dias) {
        if($tipo=='DIARIO'){
        $fecha->modify('+1 day');
        if (!in_array($fecha->format('N'), $workingDays)) continue;
        if (in_array($fecha->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($fecha->format('*-m-d'), $holidayDays)) continue;

        $dates[] = $fecha->format('d-m-Y');
        }elseif ($tipo='MENSUAL') {
        $fecha->modify('+1 month');
        //if (!in_array($fecha->format('N'), $workingDays)) continue;
        //if (in_array($fecha->format('Y-m-d'), $holidayDays)) continue;
        //if (in_array($fecha->format('*-m-d'), $holidayDays)) continue;

        $dates[] = $fecha->format('d-m-Y');
        }

        $dias--;
    }
    return $dates;
}


 function pasTEM($interes){
        $teaPoarcent=$interes/100;
$TEM=(pow((1+$teaPoarcent),1/12)-1)*100;
return $TEM;
}

 function pasTEA($interes){
    $temPorcent=$interes/100;
    $TEA=(pow((1+$temPorcent),12)-1)*100;
return $TEA;
}

function pasTED($interes){
    $tedPorcent=$interes/100;
    $iTED=(pow(1+($tedPorcent),1/30)-1)*100;
    return $iTED;
}

//FORMULAS
if(!empty($tem)){
    //CALCULO DE LA TASA DE INTERES ANUAL(TEA)
    $temPorcent=$tem/100;
    $cTEA=pasTEA($tem);
    $cTEM=$tem;
    //CALCULO DE LA TASA DE INTERES DIARIA
    $tedPorcent=$tem/100;
    $iTED=pasTED($tem);
    $cTED=$iTED;
    
    /*echo 'TEA= '.round($cTEA,2).' ';
    echo 'TEM= '.round($cTEM,2).' ';
    echo 'TED= '.$cTED.'</br>';*/

}else{
    //CALCULO DE LA TASA DE INTERES MENSUAL(TEM)
    $teaPoarcent=$tea/100;
    $cTEM=pasTEM($tea);
    $cTEA=$tea;
    //CALCULO DE LA TASA DE INTERES DIARIA
    //$tedPorcent=$cTEM/100;
    $iTED=pasTED($cTEM);
    $cTED=$iTED;
  /*  echo 'TEA ='.round($tea,2).' ';
    echo 'TEM ='.round($cTEM,2).' ';
    echo 'TED = '.$cTED.'</br>';*/

}



function calculaCuotaDiaria($cInteres,$nCuotas,$montoCredito){
    $porcentTEM=$cInteres/100;
    $cFijaMensual=$montoCredito*($porcentTEM*((pow((1+$porcentTEM),$nCuotas))/(pow((1+$porcentTEM),$nCuotas)-1)));
return $cFijaMensual;
}

function calculaCuotaSemanal($cInteres,$nCuotas,$montoCredito){
    $porcentTEM=$cInteres/100;
    $cFijaMensual=$montoCredito*($porcentTEM*((pow((1+$porcentTEM),$nCuotas))/(pow((1+$porcentTEM),$nCuotas)-1)));
return $cFijaMensual;
}

function calculaCuotaMensual($cInteres,$nCuotas,$montoCredito){
    $porcentTEM=$cInteres/100;
    $cFijaMensual=$montoCredito*($porcentTEM*((pow((1+$porcentTEM),$nCuotas))/(pow((1+$porcentTEM),$nCuotas)-1)));
return $cFijaMensual;
}

if($frecuenciaPago=='DIARIO'){
    $int=$cTED;
    $cFijaMensual=calculaCuotaMensual($cTED,$nCuotas,$montoCredito);

$capital=$montoCredito;
$totalInteres=0;
$totalCapital=0;
$totalCuota=0;
$totalPagado=0;


$dates = getDiasHabiles($fDesembolso, $nCuotas,$frecuenciaPago);

$item=1;
foreach ( $dates as $date ) {

$iCuota=$capital*((1+$int/100)-1);
//CALCULO DE AMORTIZACION DEL PRIMER MES
$amortizacion=$cFijaMensual-$iCuota;

$cuotaPagar=$amortizacion+$iCuota;
$restoCaptal=(float)$capital-(float)$amortizacion;
    $date = new DateTime($date);
echo '<tr>
        <td>'.$item.'<input type="hidden" step="0.01" name="numItem[]" id="numItem[]" value="'.$item.'"></td>
        <td>'.$date->format('d-m-Y').'<input type="hidden" step="0.01" name="fechaPagoOriginal[]" id="fechaPagoOriginal[]" value="'.$date->format('Y-m-d').'"></td>
        <td>'.round($iCuota,2).'<input type="hidden" step="0.01" name="intCrono[]" id="intCrono[]" value="'.round($iCuota,2).'"></td>
        <td>'.round($amortizacion,2).'<input type="hidden" step="0.01" name="amortizacion[]" id="amortizacion[]" value="'.round($amortizacion,2).'"></td>
        <td>'.round($cuotaPagar,2).'<input type="hidden" step="0.01" name="cuotaPagar[]" id="cuotaPagar[]" value="'.round($cuotaPagar,2).'"></td>
        <td>'.round(abs($restoCaptal),2).'<input type="hidden" step="0.01" name="restoCapital[]" id="restoCapital[]" value="'.round(abs($restoCaptal),2).'"></td>';
      
  $capital=$capital-$amortizacion;
    $totalPagado+=$amortizacion+$iCuota;
  $totalCapital+=$amortizacion;
  $totalInteres+=$iCuota;
  $item+=1;  
}
echo'<tr><th colspan="2" class="text-center"><label>TOTALES</label></th>
<th><label>'.number_format($totalInteres,2,',','.').'</label></th>
<th><label>'.number_format($totalCapital,2,',','.').'</label></th>
<th><label>'.round($totalPagado,2).'</label></th> 
<th><input type="hidden" step="0.01" name="total_prestamo" id="total_prestamo" value="'.round($totalPagado,2).'"><input type="hidden" step="0.01" name="interes" id="interes" value="'.round($totalInteres,2).'"></th></tr>';

}elseif ($frecuenciaPago=='MENSUAL') { 
        $int=$cTEM;
        $cFijaMensual=calculaCuotaMensual($cTEM,$nCuotas,$montoCredito);

$capital=$montoCredito;
$totalInteres=0;
$totalCapital=0;
$totalCuota=0;
$totalPagado=0;


$dates = getDiasHabiles($fDesembolso, $nCuotas,$frecuenciaPago);

$item=1;
foreach ( $dates as $date ) {

$iCuota=$capital*((1+$int/100)-1);
//CALCULO DE AMORTIZACION DEL PRIMER MES
$amortizacion=$cFijaMensual-$iCuota;

$cuotaPagar=$amortizacion+$iCuota;
$restoCaptal=(float)$capital-(float)$amortizacion;
    $date = new DateTime($date);
echo '<tr>
        <td>'.$item.'<input type="hidden" step="0.01" name="numItem[]" id="numItem[]" value="'.$item.'"></td>
        <td>'.$date->format('d-m-Y').'<input type="hidden" step="0.01" name="fechaPagoOriginal[]" id="fechaPagoOriginal[]" value="'.$date->format('Y-m-d').'"></td>
        <td>'.round($iCuota,2).'<input type="hidden" step="0.01" name="intCrono[]" id="intCrono[]" value="'.round($iCuota,2).'"></td>
        <td>'.round($amortizacion,2).'<input type="hidden" step="0.01" name="amortizacion[]" id="amortizacion[]" value="'.round($amortizacion,2).'"></td>
        <td>'.round($cuotaPagar,2).'<input type="hidden" step="0.01" name="cuotaPagar[]" id="cuotaPagar[]" value="'.round($cuotaPagar,2).'"></td>
        <td>'.round(abs($restoCaptal),2).'<input type="hidden" step="0.01" name="restoCapital[]" id="restoCapital[]" value="'.round(abs($restoCaptal),2).'"></td>';
      
  $capital=$capital-$amortizacion;
    $totalPagado+=$amortizacion+$iCuota;
  $totalCapital+=$amortizacion;
  $totalInteres+=$iCuota;
  $item+=1;  
}
echo'<tr><th colspan="2" class="text-center"><label>TOTALES</label></th>
<th><label>'.number_format($totalInteres,2,',','.').'</label></th>
<th><label>'.number_format($totalCapital,2,',','.').'</label></th>
<th><label>'.round($totalPagado,2).'</label></th> 
<th><input type="hidden" step="0.01" name="total_prestamo" id="total_prestamo" value="'.round($totalPagado,2).'"><input type="hidden" step="0.01" name="interes" id="interes" value="'.round($totalInteres,2).'"></th></tr>';

}elseif($frecuenciaPago=='PRENDARIO'){
    $int=$cTEM;

//$cInteres,$nCuotas,$montoCredito
    //$cFijaMensual=calculaCuotaDiaria($cTED,$nCuotas,$montoCredito);
       $cFijaMensual=calculaCuotaMensual($cTEM,$nCuotas,$montoCredito);

$capital=$montoCredito;
$totalInteres=0;
$totalCapital=0;
$totalCuota=0;
$totalPagado=0;


/*for ($i = 1; $i <= 10; $i++) {
    echo $i;
}*/


$item=1;
for ($i=1; $i<=$nCuotas;$i++ ) {

$iCuota=$capital*((1+$int/100)-1);
//CALCULO DE AMORTIZACION DEL PRIMER MES
$amortizacion=$cFijaMensual-$iCuota;

$cuotaPagar=$amortizacion+$iCuota;
$restoCaptal=(float)$capital-(float)$amortizacion;
    $date = new DateTime($fechafinPago);
echo '<tr>
        <td>'.$item.'<input type="hidden" step="0.01" name="numItem[]" id="numItem[]" value="'.$item.'"></td>
        <td>'.$date->format('d-m-Y').'<input type="hidden" step="0.01" name="fechaPagoOriginal[]" id="fechaPagoOriginal[]" value="'.$date->format('Y-m-d').'"></td>
        <td>'.round($iCuota,2).'<input type="hidden" step="0.01" name="intCrono[]" id="intCrono[]" value="'.round($iCuota,2).'"></td>
        <td>'.round($amortizacion,2).'<input type="hidden" step="0.01" name="amortizacion[]" id="amortizacion[]" value="'.round($amortizacion,2).'"></td>
        <td>'.round($cuotaPagar,2).'<input type="hidden" step="0.01" name="cuotaPagar[]" id="cuotaPagar[]" value="'.round($cuotaPagar,2).'"></td>
        <td>'.round(abs($restoCaptal),2).'<input type="hidden" step="0.01" name="restoCapital[]" id="restoCapital[]" value="'.round(abs($restoCaptal),2).'"></td>';
      
  $capital=$capital-$amortizacion;
    $totalPagado+=$amortizacion+$iCuota;
  $totalCapital+=$amortizacion;
  $totalInteres+=$iCuota;
  $item+=1;  
}
echo'<tr><th colspan="2" class="text-center"><label>TOTALES</label></th>
<th><label>'.number_format($totalInteres,2,',','.').'</label></th>
<th><label>'.number_format($totalCapital,2,',','.').'</label></th>
<th><label>'.round($totalPagado,2).'</label></th> 
<th><input type="hidden" step="0.01" name="total_prestamo" id="total_prestamo" value="'.round($totalPagado,2).'"><input type="hidden" step="0.01" name="interes" id="interes" value="'.round($totalInteres,2).'"></th></tr>';

}



//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos
	/*$fechaInicial = date("Y-m-d"); //obtenemos la fecha de hoy, solo para usar como referencia al usuario

	$MaxDias = 6; //Cantidad de dias maximo para el prestamo, este sera util para crear el for
$Segundos=0;
	
         //Creamos un for desde 0 hasta 3
         for ($i=0; $i<$MaxDias; $i++)
	{
                  //Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for
		$Segundos = $Segundos + 86400;
	
                  //Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias, segun la vuelta en la que estemos
		$caduca = date("D",time()+$Segundos);
		
                           //Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...
			if ($caduca == "Sat")
			{
				$i--;
			}
			else if ($caduca == "Sun")
			{
				$i--;
			}
			else
			{
                $fPago=date("d-m-Y",strtotime($fechaInicial."+ ".$i." day"));
                $tpago=date("d-m-Y",strtotime($fPago."+ ".$i." day"));	
                echo $tpago.'<br>';
                                    //Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha
			//	echo $FechaFinal = date("Y-m-d",time()+$Segundos).'<br>';
			}
	}*/

    break;
}






 ?>