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
  $tiempo= $intvl->y . " a??o, " . $intvl->m." meses y".$intvl->d." dias"; 
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
<div style="text-align: center;"><b>CONTRATO DE PR??STAMO ENTRE PARTICULARES</b></div>
<div style="text-align: left;">En Espinar, a $hora_hoy. $fecha_hoy</div>
<div style="text-align: center;"><b>REUNIDOS</b></div>
<div style="text-align: justify;"><p>
De una parte, como <b>PRESTAMISTA</b>, Sr. Julio Cesar, Tunquipa Mamani , mayor de edad, de Nacionalidad Peruano, con domicilio en la calle sicuani, s/n n??mero , de la localidad de Espinar - Cusco, y con Documento Nacional de Identidad n??mero 70130725.<br>

Y de otra, como <b>PRESTATARIO</b>, mayor de edad, $cliente.  De nacionalidad peruana, identificado con DNI N?? $doc_cliente. Domiciliado en la Av. San Martin Del distrito y provincia de espinar departamento de Cusco.<br>

Interviene, asimismo, en el presente contrato, en su propio nombre y derecho. Ambas partes se reconocen la capacidad legal necesaria para formalizar el presente CONTRATO CIVIL DE PR??STAMO CON INTERESES en el concepto en el que intervienen en el mismo, y de conformidad con las siguientes:<br><br>

CL??USULAS<br><br>
PRIMERA.- PR??STAMO. El <b>PRESTAMISTA</b> presta al <b>PRESTATARIO</b> la cantidad de S/.$totalCredito ($con_letra), que se hace efectiva en este acto, mediante conteo en efectivo, sirviendo la firma de este documento como formal carta de pago y recibo de la citada cantidad.<br><br>

SEGUNDA.- DEVOLUCI??N DEL CAPITAL E INTER??S. El <b>PRESTATARIO</b> se obliga frente al <b>PRESTAMISTA</b> a la devoluci??n del capital prestado con un inter??s, pactado por las partes, que ser??n devueltos de forma diario capital e inter??s (seg??n plan de pagos), siendo pagadero dicho inter??s por periodos vencidos. (De forma pago diario con especifica en el plan de pago).<br> 
Asimismo, la falta de pago del importe del capital o de los intereses pactados a su vencimiento, devengar?? un inter??s de demora del tres por ciento (3 %) por d??a; sin que sea necesario para ello el requerimiento previo por parte del <b>PRESTAMISTA</b>.<br><br>

TERCERA.- PLAZO DE DEVOLUCI??N. El capital prestado deber?? devolverse como m??ximo en el plazo de $tiempo, en modalidad de $cantidadCuotas cuotas de forma pago, $tipoCredito de S/. $cuota ($con_letraCuota)  a contar desde el d??a de la firma del presente contrato, es decir, para los pagos de cada cuota es como m??ximo durante todo el d??a. En $cantidadCuotas cuotas, (pago, $tipoCredito). Empezando a pagar a partir del $inicio, La ??ltima cuota vence el $fin.<br><br>

CUARTA.- DEVOLUCI??N ANTICIPADA DEL PR??STAMO. El <b>PRESTATARIO</b> podr?? devolver de forma anticipada, total o parcialmente (puede pactarse tambi??n que las cantidades entregadas de forma anticipada no sean inferiores a determinada cantidad o a determinado porcentaje del capital prestado), el principal prestado m??s los intereses respectivos calculados hasta la fecha en que se realice la entrega anticipada, document??ndose por medio de plan de pago (kardex) al presente documento las cantidades objeto de entrega anticipada y las cantidades que queden pendientes en concepto de principal y de intereses exigibles hasta la fecha de vencimiento pactada.<br><br>

QUINTO.- GASTOS. Todos los gastos e impuestos que se deriven de la formalizaci??n del presente contrato, ser??n a cargo del <b>PRESTATARIO</b>, con entera indemnidad para el <b>PRESTAMISTA</b>.<br><br>

SEXTA.- INCUMPLIMIENTO Y RESOLUCI??N DEL CONTRATO. El incumplimiento por parte del <b>PRESTATARIO</b> de cualquiera de las obligaciones contra??das en virtud del presente contrato facultar?? al <b>PRESTAMISTA</b> para resolver el contrato antes del plazo de vencimiento pactado, siempre que medie requerimiento previo al <b>PRESTATARIO</b> del cumplimiento de sus obligaciones.<br><br>

S??PTIMA.- DOMICILIO DE NOTIFICACIONES. A los efectos de recibir cualquier notificaci??n relacionada con los derechos y obligaciones derivados de este contrato, las partes designan como domicilios los que figuran al encabezamiento de este documento.<br><br>
OCTAVO.- LEGISLACI??N APLICABLE. La interpretaci??n de las cl??usulas del presente contrato se realizar?? de conformidad con la legislaci??n peruana. 
En consecuencia, el presente contrato se rige supletoriamente, y en lo no pactado expresamente en ??l, por lo dispuesto en el C??digo Civil.<br><br>
NOVENO.- FUERO. Las partes, con expresa renuncia al fuero propio que pudiera corresponderles, deciden someter cuantas divergencias pudieran surgir por motivo de la interpretaci??n y cumplimiento de este contrato, a la Jurisdicci??n de los Jueces y Tribunales del estado peruano (domicilio del prestatario, del lugar de cumplimiento de la obligaci??n, del pr??stamo)<br>
Y en prueba de conformidad, firman ambas partes el presente contrato, por duplicado ejemplar, en todas sus hojas y a un solo efecto, en el lugar y fecha indicados al principio de este documento.<br><br><br><br><br>
</p></div>
<div><p>
__________________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;__________________________________________________________<br>


Nombre y apellido/Raz??n social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Raz??n social: ________________________________<br><br>

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