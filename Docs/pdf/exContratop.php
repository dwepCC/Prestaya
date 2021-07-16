<?php
//ob_end_clean();
//flush();
//ob_start();
//header("Content-type: application/pdf"); 
//ini_set ('display_errors', 1);
//activamos almacenamiento en el buffer
//ob_start();
if (strlen(session_id())<1) 
session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para visualizar el reporte";
}else{

if ($_SESSION['prestamos']==1) {

//require_once "../../Models/Company.php";
require_once(dirname(__FILE__,3).'/Models/Sell.php');
require_once(dirname(__FILE__,3).'/Models/Person.php');
require_once(dirname(__FILE__,3).'/Models/Product.php');

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

$idcredito = $this->codigo;

$sell=new Sell();
$dcliente=new Person();
$articulo=new Product();

$rspta=$sell->mostrar($idcredito);
$idcliente= $rspta['idcliente'];
$cliente= $rspta['cliente'];
$fecha_reg= $rspta['fecha_reg'];

$fechaDesembolso= $rspta['fecha_desembolso'];

$cantidadCuotas= $rspta['cantidad_cuotas'];
$interes= $rspta['interes'];
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

$totalApagar=$totalCredito+$interes;
$con_letraTotal=strtoupper($letras->ValorEnLetras($totalApagar," $moneda"));
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


$datei = date_create($rspta['fecha_desembolso']);
$mes=date_format($datei,"n");
$inicio= date_format($datei,"d")." de ".$months[$mes]." del ".date_format($datei,"Y");

//calcular tiempo de credito
$fechaDes  = new DateTime($fechaDesembolso);
$fechaFin = new DateTime($fechaFin);
$intvl = $fechaDes->diff($fechaFin);

$tiempo='';
if($intvl->y==0 && $intvl->m==0){
$tiempo= $intvl->d." dias"; 
}elseif($intvl->y==0 && $intvl->m>0){
 $tiempo= $intvl->m." meses y".$intvl->d." dias"; 
}else{
  $tiempo= $intvl->y . " año, " . $intvl->m." meses y".$intvl->d." dias"; 
}

$rsptac=$dcliente->mostrar($idcliente);
$doc_cliente=$rsptac['num_documento'];
$direccion_cliente=$rsptac['direccion'];
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

// ---------------------------------------------------------
date_default_timezone_set('America/Lima');
//$fecha_hoy = date("Y-m-d");

$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
$year_now = date ("Y");  
$month_now = date ("n");  
$day_now = date ("j");  
$week_day_now = date ("w");  
$fecha_hoy = $day_now . " dias  del mes de " . $months[$month_now] . " de " . $year_now; 
$hora_hoy = date('h:i a'); 

$pdf->SetFont ("", "", 8 , "", "default", true );

// ---------------------------------------------------------
$bloque6 = <<<EOF
<div style="text-align: center;"><u><b>CONTRATO DE PRENDA</b></u></div>
<div style="text-align: justify;"><p>
Se celebra el presente contrato de prenda de bienes inmuebles en la ciudad de Espinar  departamento cusco  a los $fecha_hoy.<br>
El presente documento es celebrado entre el C. <b>Julio Cesar, Tunquipa Mamani</b>. Quien en adelante se denominará acreedor, con domicilio en Asoc. Pedregal sur virgen de chapi MZ E2 Lt. 10 – Majes, Caylloma departamento Arequipa y el Sr. $cliente. Quien en adelante se denominará deudor, con domicilio   $direccion_cliente Distrito Y Provincia Espinar Departamento cusco.<br><br>
Ambas partes se sujetarán a las declaraciones y clausulas contenidas en el presente documento.<br><br>
<b>DECLARACIONES</b><br><br>
<b>Ambas partes declaran:</b><br>
Reconocerse con capacidad jurídica para llevar a cabo el presente contrato con base a la ley Ley General de Títulos y Operaciones de Crédito y para lo cual se someten expresamente a las leyes de la República del Perú y la competencia de los jueces y sala del distrito judicial de la ciudad donde se suscribe el presente Contrato.<br><br>
Que este contrato está libre de mala fe, dolo, error u otro tipo de vicio de la voluntad.<br><br>
<b>El Deudor declara:</b><br><br>
Tener la capacidad jurídica para obligarse en términos de este contrato.<br>
Ser el único y absoluto propietario de los siguientes bienes:
</p></div>
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');
//LISTAR DETALLE DE BIENES
// ---------------------------------------------------------
$rsptDB=$sell->listarDetalle($idcredito);
foreach ($rsptDB as $key=>$item) {

$idarticulo= $item['idarticulo'];

$rspta=$articulo->mostrar($idarticulo);
//$idarticulo= $rspta['idcliente'];

$bloqueBienes = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">
  <tr>
  <th style="border: 1px solid #666; width:260px; text-align:center">Nombre</th>
  <th style="border: 1px solid #666; width:80px; text-align:center">Serie</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Marca</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Modelo</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Cantidad</th>
  </tr>
		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$rspta[nombre]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$rspta[codigo]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[marca]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[modelo]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[stock]
			</td>
		</tr>
	</table>
EOF;

$pdf->writeHTML($bloqueBienes, false, false, false, false, '');

}

$bloque10 = <<<EOF
</div><p>
Estar facultado legalmente sobre el bien, bajo los términos y condiciones aquí estipuladas.<br>
Que es su deseo otorgar el objeto en prenda.<br><br>
<b>El acreedor declara:</b><br><br>
Tener la capacidad jurídica y recursos suficientes para cumplir con las obligaciones que deriven a partir de la firma del presente contrato<br>
Que es su voluntad aceptar el bien mueble en prenda y encontrarse satisfecho con las condiciones del mismo.<br><br>
<b>CLÁUSULAS</b><br><br>
<b>PRIMERA</b>. - El Sr. <b>$cliente </b>  deudor prendario declaro que soy deudor del ACREEDOR reconoce que adeuda por la cantidad de <b>S/ $totalCredito ($con_letra)</b>, cantidad de dinero que me comprometo a devolverlos en el plazo de $tiempo, que se les contara a partir de la suscripción del presente contrato privado, reconociendo el interés generado.<br>
Prenda civil consiste en un bien:
</p></div>
EOF;
$pdf->writeHTML($bloque10, false, false, false, false, '');

//LISTAR DETALLE DE BIENES
// ---------------------------------------------------------
$rsptDB=$sell->listarDetalle($idcredito);
foreach ($rsptDB as $key=>$item) {

$idarticulo= $item['idarticulo'];

$rspta=$articulo->mostrar($idarticulo);
//$idarticulo= $rspta['idcliente'];

$bloqueBienes1 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">
  <tr>
  <th style="border: 1px solid #666; width:260px; text-align:center">Nombre</th>
  <th style="border: 1px solid #666; width:80px; text-align:center">Serie</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Marca</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Modelo</th>
  <th style="border: 1px solid #666; width:100px; text-align:center">Cantidad</th>
  </tr>
		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$rspta[nombre]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$rspta[codigo]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[marca]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[modelo]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$rspta[stock]
			</td>
		</tr>
	</table>
EOF;

$pdf->writeHTML($bloqueBienes1, false, false, false, false, '');

}

$bloque14 = <<<EOF
</div><p>
Evaluando se le otorga <b>S/ $totalCredito ($con_letra), el ACREEDOR declara tener recibos y/o declaración jurada del deudor con lo cual se perfecciona el presente contrato.</b><br>

Ambas partes reconocen que, al momento de la firma de este contrato, el deudor prendario entregara la cantidad de <b>S/.  $totalApagar ($con_letraTotal)</b> al acreedor prendario. Sumado interés y capital al final de contrato.<br><br>

<b>SEGUNDA</b>.- Ambas partes realizaron un análisis previo del objeto dejándolo constar en un escrito que ambas partes firmaron y que se añadirá a dicho documento en donde se detallara el valor calculado del bien y las condiciones en que se encuentra.<br>
El acreedor prendario declara estar satisfecho con las condiciones del bien mueble.<br><br>

<b>TERCERA</b>.- El tiempo que el objeto se dejará en prenda dará inicio a los <b>$inicio y terminará a los $fin</b>.<br>

Al término del plazo establecido y en caso de no haber vuelto por el bien mueble el acreedor prendario podrá disponer del bien como mejor le convenga, sin necesidad de aviso al deudor prendario.<br>

En caso de que el deudor prendario vuelva por el bien, este deberá ser entregado en el mismo estado en que fue recibido al momento de la celebración de este contrato. Por ende, el deudor prendario se compromete a devolver el monto total entregado, en caso contrario el propietario no estará obligado a hace la devolución.<br>

La entrega del bien se efectuará dentro del plazo que se establece en el presente contrato en cuanto se cubra la deuda.<br><br>

<b>CUARTA</b>. -  En caso de que el deudor prendario se retrase con el pago se comprometerá a pagar un 3 % extra por día.<br>
El acreedor prendario también podrá realizar procedimientos legales para el cobro del adeudo.<br>

El acreedor prendario queda facultado a cobrar los intereses, dividendos y rentas que devenguen del bien dado en prenda.<br><br>
<b>QUINTA</b>. - Una vez el deudor prendario cubra el pago de la deuda el bien mueble dado en prenda será devuelto al deudor prendario debidamente endosado y este contrato entonces quedará sin efecto.<br><br>

<b>SEXTA</b>. - Los derechos y obligaciones del acreedor prendario serán los siguientes.<br>
Derechos:
<ul><li>Tendrá el derecho de retener el bien dado en prenda mediante este Contrato hasta que todas y cada una de las deudas y obligaciones sean liquidadas.</li>
<li>El acreedor prendario puede pedir que la prenda se venda para cubrir la deuda.</li>
<li>Si el acreedor prendario necesita hace gastos que el bien requiera y no son su culpa estos pueden ser reembolsados por el deudor.</li>
</ul>
Obligaciones:
<ul>
<li>Deberá preservar y conservar como si fuera suyo el bien dado en prenda.</li>
<li>Responderá por los daños o deterioros que el bien sufra bajo su custodia por culpa o negligencia.</li>
</ul>
<b>SEPTIMA</b>. - Los derechos y obligaciones del deudor prendario serán los siguientes.<br>
Derechos:
<ul>
<li>Tiene derecho a que se le restituya el bien mueble.</li>
<li>Puede pedir reemplazo de la prenda en caso de pérdida.</li>
<li>Derecho a asistir a la subasta de la prenda o impedir el remate, pagando la deuda.</li>
</ul>

Obligaciones.
<ul>
<li>Cubrir el monto total de la deuda en el tiempo establecido.</li>
<li>Pagar los gastos que el bien mueble le pueda ocasionar al acreedor prendario.</li>
</ul>
<b>OCTAVA</b>.- Ambas partes declaran haber leído el presente contrato y reconocen sus derechos y obligaciones estipuladas en el mismo.<br><br><br><br><br><br><br><br><br><br>
</p></div>
<div><p>
__________________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;__________________________________________________________<br><br>


Nombre y apellido/Razón social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Razón social: ________________________________<br><br>

__________________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;__________________________________________________________<br><br>

DNI/RUC: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DNI/RUC: __________________________________________________<br><br>
Deudor prendario: ____________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Acreedor prendario: _________________________________________<br><br>

</p></div>
EOF;

$pdf->writeHTML($bloque14, false, false, false, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 


ob_end_clean();
$pdf->Output('contrato_prenda.pdf', 'I');

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