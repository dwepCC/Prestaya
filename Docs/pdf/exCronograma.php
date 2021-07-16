<?php

require_once(dirname(__FILE__,3).'/Models/Sell.php');

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$idcredito = $this->codigo;

require_once(dirname(__FILE__,3).'/Models/Sell.php');

$sell=new Sell();
$rspta=$sell->mostrarCronograma($idcredito);
$rsptc=$sell->mostrar($idcredito);
$cliente=$rsptc['cliente'];
$fecha=$rsptc['fecha_desembolso'];
$num_credito=$rsptc['num_credito'];
$tipo_credito=$rsptc['tipo_credito'];
$fecha_reg=$rsptc['fecha_reg'];
//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set default header data
$PDF_HEADER_LOGO = "logo.jpg";//any image file. check correct path.
$PDF_HEADER_LOGO_WIDTH = "10";
$PDF_HEADER_TITLE = "PRESTACENTER";
$PDF_HEADER_STRING = 'Telfono:   Dirección: Av. San Martin - Espinar - Cusco';
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

//$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'marks', 'header string');

$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// margenes titulo y pie de pagina
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->setFontSubsetting(true);


$pdf->startPageGroup();

$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
$pdf->setPrintFooter(true); //no imprime el pie ni la linea
$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="text-align:center">CRONOGRAMA DE PAGOS</td>
</tr>
<tr>
			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:left; line-height:15px;">
					
					<br>
					Fecha registro: $fecha_reg
				</div>

			</td>

			<td style="background-color:white; width:100px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					Tipo de credito: $tipo_credito

				</div>
				
			</td>

			<td style="background-color:white; width:260px; text-align:right; color:red"><br><br>CREDITO N: $num_credito</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table> 
		
		<tr>
			
			<td style="width:540px"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:310px">

				Cliente: $cliente

			</td>

			<td style="border: 1px solid #666; background-color:white; width:200px; text-align:left">
			
				Fecha desembolso: $fecha

			</td>

		</tr>


		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:440px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:35px; text-align:center">N°</td>
		<td style="border: 1px solid #666; background-color:white; width:85px; text-align:center">Vencimiento</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Interes</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Capital</td>
		<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">Cuota</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Saldo capital</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($rspta as $key) {
$num_cuota=$key['num_cuota'];
$fecha_pago=$key['fecha_pago_original'];
$interes=$key['interes'];
$capital=$key['capital'];
$total_pago=$key['total_pago'];
$saldo_capital=$key['saldo_capital'];

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:0px 0px;">

		<tr style="height:10px;">
			<td style="border: 1px solid #666; color:#333; background-color:white; width:35px; text-align:center">
				$num_cuota
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:85px; text-align:center">
				$fecha_pago
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
			$interes
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
      $capital
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:90px; text-align:center">
      $total_pago
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
      $saldo_capital
			</td>

		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$interesCredito=$rsptc['interes'];
$capitalCredito=$rsptc['capital'];
$totalCredito=$rsptc['total_prestamo'];
$bloque5 = <<<EOF

	<table style="font-size:10px; padding:0px 0px;">
		
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">TOTALES</td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				$interesCredito
			</td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
			$capitalCredito
			</td>

			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">
				$totalCredito
			</td>

		</tr>
	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
ob_end_clean();
$pdf->Output('factura.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["id"];
$factura -> traerImpresionFactura();

?>