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
//include_once(dirname(__FILE__,2) . '\Models\Company.php');
$test= __DIR__ . '/' . '\Models\Company.php';

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

$idcredito = $this->codigo;

$digito_num = 5;
$num_pagare = substr(str_repeat(0, $digito_num).$idcredito, - $digito_num);
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

$pdf->SetFont ("", "", 9 , "", "default", true );
$bloque1 = <<<EOF
<div style="text-align: center;"><u><b>PAGARE N: $num_pagare</b></u></div>
<div style="text-align: right;"><b>IMPORTE DEUDOR</b>:.....................................</div>
<div><b>IMPORTE ORIGINAL</b>:.....................................
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Vence el.................. de................................del 20...........</div><br><br>
EOF;

//$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->writeHTML($bloque1, true, 0, true, true);
$pdf->SetFont ("", "", 8 , "", "default", true );
$bloque2 = <<<EOF
<div style="text-align: justify;">
Yo (nosotros).........................................................................................................................................................................................................................
<br><br>
Reconozco (reconocemos) que adeudo (adeudamos) y pagaré (pagaremos) incondicionalmente  en la fecha del vencimiento consignado en el presente Pagaré,  a la orden del señor: Julio Cesar Tunquipa Mamani, Identificado con DNI: 70130725 denominada en adelante <b>EL ACREEDOR</b>, o a quien esta se lo hubiera cedido, en su domicilio o donde se presentara para su cobro; en importe de........................................................................................................(....................................), sin lugar a reclamo de clase alguna para cuyo fiel y exacto cumplimiento, me obligo con todos mis bienes presentes y futuros en la mejor forma de derecho, al efecto, asumo la obligación en las siguientes condiciones:<br>

<div style="text-align: center;"><u><b>CLAÚSULAS  ESPECIALES</b></u></div>
<u><b>PRIMERO:</b></u>   Este pagare será pagado en la misma moneda que expresa este título de valor por ser producto de un préstamo de dinero otorgado por <b>EL ACREEDOR</b>.<br>
<u><b>SEGUNDO:</b></u>   Quedan aceptadas todas las renovaciones y prorrogas del vencimiento de este Pagaré; que <b>EL ACREEDOR</b> pudiera otorgar, sin que sea necesaria intervención alguna del obligado principal ni de los avalistas solidarios.<br>
<u><b>TERCERO:</b></u>   El pago del importe del Pagaré, podrá ser pactado en una o más cuotas, según el/los importe(s) y vencimiento que indique el correspondiente cronograma de pagos que no requerirá de suscripción adicional al presente documento.<br>
<u><b>CUARTO:</b></u>  El importe de este pagaré y/o de las cuotas de crédito que representa, genera desde la fecha de emisión hasta la fecha de sus respectivo(s) vencimiento(s). un interés compensatorio que se pacta en la tasa efectiva de ...........% anual y una tasa de interés moratorio efectivo de ..........% anual.<br>
<u><b>QUINTO:</b></u>  En caso de incumplimiento en el pago de una o más cuotas pactada, al importe deudor se le aplicaran los intereses compensatorios e intereses moratorios conforme a las tasas máximas aprobadas por el acreedor desde la fecha de vencimiento hasta su total cancelación, sin que sea necesario efectuar el requerimiento previo de pago para constituir en mora al obligado principal ni a los avalistas solidarios incurriéndose en esta automáticamente, por el solo hecho del vencimiento. Siendo de aplicación en este caso lo dispuesto por el Art. 158.2 de la ley de títulos valores.<br>
<u><b>SEXTO:</b></u>  El cliente y su conyugue o conviviente obligados principales y los deudores solidarios aceptan igualmente que las tasas de interés compensatorio y/o moratorio pueden ser variados por <b><b>EL ACREEDOR</b></b> o su tenor, sin necesidad de aviso previo, de acuerdo a las tasas que este tenga vigentes de conformidad a lo establecido en el Art. 1243 del Código Civil.<br>
<u><b>SEPTIMO:</b></u> Las obligaciones principales y solidarios suscribientes del pagare, dejan constancia que este documento no está sujeto a protesto por falta de pago, salvo lo disponga en el artículo 81.2 de la ley 27287 y sus normas complementarias.<br>
<u><b>OCTAVO:</b></u>   Serán de cargo de los obligados principales y avalistas solidarios, el pago del integro de los tributos, y gastos que afecten a este pagare o a la obligación en el contenida, los mismos que serán calculados y determinados por <b>EL ACREEDOR</b>, o su tenor en la oportunidad en que ello se verifique.<br>
<u><b>NOVENO:</b></u> El o los obligado (s) principal (es) y los avalistas solidarios autorizan desde ya expresamente a <b>EL ACREEDOR</b> a cargar directamente en sus cuentas (sea en moneda nacional y/o extranjera) que mantengan en ella, el saldo deudor del crédito que presenta el pagare, así como a compensarlos con cualquier otro tipo de bien que pudiera tener en su poder, sin que ello obligue o signifique responsabilidad para <b>EL ACREEDOR</b>.<br>
<u><b>DECIMO:</b></u> El presente pagaré será ejecutado por el solo mérito de haberse dado por vencido su plazo, no estando sujeto a protesto, al haberse optado por la preclusión de los plazos de ser el caso, según lo pactado al amparo de lo establecido en el Art. 10 de la ley de Títulos de Valores.<br>
<u><b>DECIMO PRIMERO:</b></u> El presente pagaré será ejecutado por el solo mérito de haberse dado por vencido su plazo, no estando sujeto a protesto, al haberse optado por la preclusión de los plazos de ser el caso, según lo pactado al amparo de lo establecido en el Art. 10 de la ley de Títulos de Valores.<br>
<u><b>DECIMO SEGUNDO:</b></u> <b>EL ACREEDOR</b> o su tenor podrá entablar acción judicial para efectuar el cobro de este Pagaré, procedimiento previamente conforme los acuerdos adoptados, donde lo tuviera por conveniente, a cuyo efecto el obligado principal y los avalistas solidarios renuncian el fuero de su propio domicilio y a cuantos favorecerles en el proceso judicial o fuera de él, señalando como domicilio, para todo los efectos y consecuencias que pudieran derivarse de la emisión del presente pagaré, el indicado en este documento, lugar donde se envían los avisos y se harán llegar todas las comunicaciones y/o notificaciones judiciales que resulten necesarias, para lo cual se sometan expresamente a las leyes de la República del Perú y la competencia de los jueces y sala de distrito judicial de la ciudad donde se suscribe el presente Pagaré.<br>
..........................................................., .............de................................................del.................<br><br><br>
</div>
EOF;

//$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->writeHTML($bloque2, true, 0, true, true);
//"<div style='text-align: justify;'".$bloque2."</div>"
// ---------------------------------------------------------

$bloque3 = <<<EOF
<div><p>
FIRMA:____________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIRMA:____________________________________________________<br>
Deudor / Representante Legal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Cónyuge / Codeudor<br><br>

Nombre y apellido/Razón social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Razón social: ________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
DNI/RUC: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DNI/RUC: __________________________________________________<br><br>
Dirección: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Dirección: __________________________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
</p></div>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------


$bloque4 = <<<EOF
<div style="text-align: justify;">
AVAL: Los que suscribimos al final nos constituimos en avalistas SOLIDARIOS con los deudores y entre nosotros mismos, renunciando expresamente al beneficio de excusión, por todas las obligaciones que se contraen por el presente pagaré comprometiéndose a responder por la cantidad adeudada, los intereses compensatorios y monetarios de ser el caso y comisión pactada que se devengas4e según lo estipulado, así como los tributos, gastos notariales, costas y costos procesales a que hubiera lugar. Así mismo expresamos nuestra aceptación a las condiciones especiales de giro de este título valor. Dejamos constancia que esta FIANZA SOLIDARIA la constituimos por plazo indeterminado hasta que sea íntegramente cancelada la obligación a la que se sirve de garantía, renunciando en forma expresa al plazo de requerimiento al que se refiere el art. 1899 del C.C ACEPTANDO DESDE AHORA TODAS LAS PRORROGAS Y RENOVACIONES que se conceda a los deudores para los cuales prestamos nuestro consentimiento expreso sin que sean necesarias nuevamente nuestras firmas en las anotaciones que sobre el particular se hagan en este mismo documento todo ello con arreglo a las disposiciones del Art. 1901 del C.C nos sometemos a jurisdicción señalada por el girador y señalamos como nuestros domicilios para todos los fines de actos notariales y/o procesales, los señalados en el presente documento.<br><br>
........................................, ................. De......................................del 20..........
</div>
<div><p>
FIRMA:____________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIRMA:____________________________________________________<br>
Avalista &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Avalista Cónyugue o Conviviente<br><br>

Nombre y apellido/Razón social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Razón social: ________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
DNI/RUC: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DNI/RUC: __________________________________________________<br><br>
Dirección: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Dirección: __________________________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
</p></div>
<div><p>
FIRMA:____________________________________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIRMA:____________________________________________________<br>
Avalista &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Avalista Cónyugue o Conviviente<br><br>

Nombre y apellido/Razón social: ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nombre y apellido/Razón social: ________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
DNI/RUC: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DNI/RUC: __________________________________________________<br><br>
Dirección: __________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Dirección: __________________________________________________<br><br>

__________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
__________________________________________________________<br><br>
</p></div>
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');


$bloque5 = <<<EOF
<div><p>
RENOVADO POR:.....................................................................................&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
RENOVADO POR:.....................................................................................<br><br>

VENCIMIENTO AL ....................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
VENCIMIENTO AL ....................................................................................<br><br>

DE CONFORMIDAD A LOS TERMINOS DE ESTE DOCUMENTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DE CONFORMIDAD A LOS TERMINOS DE ESTE DOCUMENTO<br><br>
FECHA:......................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
FECHA:......................................................................<br><br><br><br><br><br><br><br>

</p><br><br></div>

<div><p>
<b>_____________________________________________________</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<b>_____________________________________________________</b><br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>GERENTE</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>GERENTE</b> <br><br>

</p></div>
EOF;
//$pdf->SetXY(0, 250);
$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 


ob_end_clean();
$pdf->Output('pagare.pdf', 'I');

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