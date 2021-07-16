<?php
//ob_end_clean();
//flush();
//ob_start();
//header("Content-type: application/pdf"); 
//ini_set ('display_errors', 1);
//activamos almacenamiento en el buffer
//ob_start();
setlocale(LC_TIME, 'es_ES');

if (strlen(session_id())<1) 
session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para visualizar el reporte";
}else{

if ($_SESSION['prestamos']==1) {

//require_once "../../Models/Company.php";
//require_once "../../Models/Company.php";
require_once(dirname(__FILE__,3).'/Models/Sell.php');
require_once(dirname(__FILE__,3).'/Models/Person.php');

//$test= __DIR__ . '/' . '\Models\Sell.php';

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

$idcredito = $this->codigo;

$sell=new Sell();
$dcliente=new Person(); 
 
$rspta=$sell->mostrar($idcredito);
$idcliente= $rspta['idcliente'];
$cliente= $rspta['cliente'];
$fecha_reg= $rspta['fecha_reg'];

$fechaDesembolso= $rspta['fecha_desembolso'];

$cantidadCuotas= $rspta['cantidad_cuotas'];
$tipoCredito= $rspta['tipo_credito'];
/*if($tipoCredito=='ONEPAY'){
  $tipoCredito='un solo pago';
}*/


//aqui falta codigo de letras
require_once "Letras.php";
$letras = new EnLetras();

$totalCredito=$rspta['capital']; 
$letras->substituir_un_mil_por_mil = true;

$moneda="SOLES";
$con_letra=strtoupper($letras->ValorEnLetras($totalCredito," $moneda"));

//MOSTRAR LOS DETALLES DEL CREDITO
//cuota y ultimo dia de pago
$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$rsptDC=$sell->mostrarCredito($idcredito);
$cuota= $rsptDC['total_pago'];
$con_letraCuota=strtoupper($letras->ValorEnLetras($cuota," $moneda"));
$fechaFin= $rsptDC['fecha_pago_original'];
$datef = date_create($rsptDC['fecha_pago_original']);
$mes=date_format($datef,"n");
$fin= date_format($datef,"d")." de ".$months[$mes]." del ".date_format($datef,"Y");

//primer dia de pago
$rsptDi=$sell->mostrarCreditoin($idcredito);
$fechaInicio= $rsptDi['fecha_pago_original'];


$datei = date_create($rsptDi['fecha_pago_original']);
$mes=date_format($datei,"n");
$inicio= date_format($datei,"d")." de ".$months[$mes]." del ".date_format($datei,"Y");

//calcular tiempo de credito
$fechaInicio  = new DateTime($fechaInicio);
$fechaFin = new DateTime($fechaFin);
$intvl = $fechaInicio->diff($fechaFin);

$tiempo='';
if($intvl->y==0 && $intvl->m==0){
$tiempo= $intvl->d." dias"; 
}elseif($intvl->y==0 && $intvl->m>0){
 $tiempo= $intvl->m." meses y".$intvl->d." dias"; 
}else{
  $tiempo= $intvl->y . " año, " . $intvl->m." meses y".$intvl->d." dias"; 
}
//echo "\n";
// Total amount of days
//echo $intvl->days . " days ";



$rsptac=$dcliente->mostrar($idcliente);
$doc_cliente=$rsptac['num_documento'];
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

// create new PDF document
$pageLayout = array(210,297); //  or array($height, $width) 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
/*$PDF_HEADER_LOGO = "logo.jpg";//any image file. check correct path.
$PDF_HEADER_LOGO_WIDTH = "50";
$PDF_HEADER_TITLE = "www.lamarperu.com";
$PDF_HEADER_STRING = 'Telf:   Direc: ';
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);*/

$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'marks', 'header string');

$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->setFontSubsetting(true);


$pdf->startPageGroup();

$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
$pdf->setPrintFooter(true); //no imprime el pie ni la linea

$pdf->AddPage();


date_default_timezone_set('America/Lima');
//$fecha_hoy = date("Y-m-d");

$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
$year_now = date ("Y");  
$month_now = date ("n");  
$day_now = date ("j");  
$week_day_now = date ("w");  
$fecha_hoy = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now; 
$hora_hoy = date('h:i a'); 
// ---------------------------------------------------------
//$test=dirname(__FILE__,3) . '\Models\Company.php';
$pdf->SetFont ("", "", 8 , "", "default", true );

$bloque7 = <<<EOF
<div style="text-align: center;"><b>CONTRATO DE PRÉSTAMO ENTRE PARTICULARES</b></div>
<div style="text-align: left;">En Espinar, a $hora_hoy. $fecha_hoy</div>
<div style="text-align: center;"><b>REUNIDOS</b></div>
<div style="text-align: justify;"><p>
De una parte, como <b>PRESTAMISTA</b>, Sr. Julio Cesar, Tunquipa Mamani , mayor de edad, de Nacionalidad Peruano, con domicilio en la calle sicuani, s/n número , de la localidad de Espinar - Cusco, y con Documento Nacional de Identidad número 70130725.<br>

Y de otra, como <b>PRESTATARIO</b>, mayor de edad, $cliente.  De nacionalidad peruana, identificado con DNI N° $doc_cliente. Domiciliado en la Av. San Martin Del distrito y provincia de espinar departamento de Cusco.<br>

Interviene, asimismo, en el presente contrato, en su propio nombre y derecho. Ambas partes se reconocen la capacidad legal necesaria para formalizar el presente CONTRATO CIVIL DE PRÉSTAMO CON INTERESES en el concepto en el que intervienen en el mismo, y de conformidad con las siguientes:<br><br>

CLÁUSULAS<br><br>
PRIMERA.- PRÉSTAMO. El <b>PRESTAMISTA</b> presta al <b>PRESTATARIO</b> la cantidad de S/.$totalCredito ($con_letra), que se hace efectiva en este acto, mediante conteo en efectivo, sirviendo la firma de este documento como formal carta de pago y recibo de la citada cantidad.<br><br>

SEGUNDA.- DEVOLUCIÓN DEL CAPITAL E INTERÉS. El <b>PRESTATARIO</b> se obliga frente al <b>PRESTAMISTA</b> a la devolución del capital prestado con un interés, pactado por las partes, que serán devueltos de forma diario capital e interés (según plan de pagos), siendo pagadero dicho interés por periodos vencidos. (De forma pago diario con especifica en el plan de pago).<br> 
Asimismo, la falta de pago del importe del capital o de los intereses pactados a su vencimiento, devengará un interés de demora del tres por ciento (3 %) por día; sin que sea necesario para ello el requerimiento previo por parte del <b>PRESTAMISTA</b>.<br><br>

TERCERA.- PLAZO DE DEVOLUCIÓN. El capital prestado deberá devolverse como máximo en el plazo de $tiempo, en modalidad de $cantidadCuotas cuotas de forma pago, $tipoCredito de S/. $cuota ($con_letraCuota)  a contar desde el día de la firma del presente contrato, es decir, para los pagos de cada cuota es como máximo durante todo el día. En $cantidadCuotas cuotas, (pago, $tipoCredito). Empezando a pagar a partir del $inicio, La última cuota vence el $fin.<br><br>

CUARTA.- DEVOLUCIÓN ANTICIPADA DEL PRÉSTAMO. El <b>PRESTATARIO</b> podrá devolver de forma anticipada, total o parcialmente (puede pactarse también que las cantidades entregadas de forma anticipada no sean inferiores a determinada cantidad o a determinado porcentaje del capital prestado), el principal prestado más los intereses respectivos calculados hasta la fecha en que se realice la entrega anticipada, documentándose por medio de plan de pago (kardex) al presente documento las cantidades objeto de entrega anticipada y las cantidades que queden pendientes en concepto de principal y de intereses exigibles hasta la fecha de vencimiento pactada.<br><br>

QUINTO.- GASTOS. Todos los gastos e impuestos que se deriven de la formalización del presente contrato, serán a cargo del <b>PRESTATARIO</b>, con entera indemnidad para el <b>PRESTAMISTA</b>.<br><br>

SEXTA.- INCUMPLIMIENTO Y RESOLUCIÓN DEL CONTRATO. El incumplimiento por parte del <b>PRESTATARIO</b> de cualquiera de las obligaciones contraídas en virtud del presente contrato facultará al <b>PRESTAMISTA</b> para resolver el contrato antes del plazo de vencimiento pactado, siempre que medie requerimiento previo al <b>PRESTATARIO</b> del cumplimiento de sus obligaciones.<br><br>

SÉPTIMA.- DOMICILIO DE NOTIFICACIONES. A los efectos de recibir cualquier notificación relacionada con los derechos y obligaciones derivados de este contrato, las partes designan como domicilios los que figuran al encabezamiento de este documento.<br><br>
OCTAVO.- LEGISLACIÓN APLICABLE. La interpretación de las cláusulas del presente contrato se realizará de conformidad con la legislación peruana. 
En consecuencia, el presente contrato se rige supletoriamente, y en lo no pactado expresamente en él, por lo dispuesto en el Código Civil.<br><br>
NOVENO.- FUERO. Las partes, con expresa renuncia al fuero propio que pudiera corresponderles, deciden someter cuantas divergencias pudieran surgir por motivo de la interpretación y cumplimiento de este contrato, a la Jurisdicción de los Jueces y Tribunales del estado peruano (domicilio del prestatario, del lugar de cumplimiento de la obligación, del préstamo)<br>
Y en prueba de conformidad, firman ambas partes el presente contrato, por duplicado ejemplar, en todas sus hojas y a un solo efecto, en el lugar y fecha indicados al principio de este documento.<br><br><br><br><br>
</p></div>
<div><p>
__________________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;__________________________________________________________<br>


Nombre y apellido/Razón social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Razón social: ________________________________<br><br>

DNI/RUC: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DNI/RUC: __________________________________________________<br><br>
Prestamista:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Prestatario:<br><br>
</p></div>
EOF;
$pdf->writeHTML($bloque7, false, false, false, false, '');




// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 


ob_end_clean();
$pdf->Output('contrato_prestamo.pdf', 'I');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["id"];
$factura -> traerImpresionFactura();

}else{
echo "No tiene permiso para visualizar el reporte";
}

}

ob_end_flush();
?>