<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para vosualizar el reporte";
}else{

if ($_SESSION['caja']==1) {

// incluimos la clase venta
require_once "../Models/Cuadrecaja.php"; 

$venta = new Cuadrecaja();

//en el objeto $rspta obtenemos los valores devueltos del metodo ventacabecera del modelo
$rspta = $venta->mostrar($_GET["id"]);

$reg=$rspta['id']; 

//datos de la empresa
require_once "../Models/Company.php";
$cnegocio = new Company();
$rsptan = $cnegocio->listar();
$regn=$rsptan[0];
$empresa = $regn['nombre'];
$ndocumento = $regn['ndocumento'];
$documento = $regn['documento'];
$direccion = $regn['direccion']; 
$telefono = $regn['telefono'];
$email = $regn['email'];
$pais = $regn['pais'];
$ciudad = $regn['ciudad'];
$nombre_impuesto = $regn['nombre_impuesto'];
$monto_impuesto = $regn['monto_impuesto'];
$moneda = $regn['moneda'];
$simbolo = $regn['simbolo'];
$new_simbolo='';
$sim_euro='€';
$sim_yen='¥';
$sim_libra='£';
if ($simbolo==$sim_euro) {
  $new_simbolo=EURO;
}elseif($simbolo==$sim_yen){
  $new_simbolo=JPY;
}elseif ($simbolo==$sim_libra) {
  $new_simbolo=GBP;
}else{
  $new_simbolo=$simbolo;
}

include('../Libraries/fpdf182/fpdf.php');
$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',12);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(2); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode($empresa) ,0,0,'C');
$pdf->SetFont('Helvetica','',10);
$pdf->setY(7); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode('Direc:'.$direccion) ,0,0,'C');
$pdf->setY(13); 
$pdf->setX(2);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(76,$textypos,utf8_decode("Comprobante de control interno"),0,0,'C');
/*$pdf->setY(13); 
$pdf->setX(2);
$pdf->Cell(76,$textypos,utf8_decode("Telf: ".$telefono),0,0,'C');*/
/*$pdf->setY(17); 
$pdf->setX(2);
$pdf->Cell(76,$textypos,utf8_decode($ciudad),0,0,'C');*/
$pdf->setY(22); 
$pdf->setX(2);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(76,$textypos, utf8_decode("Fecha: ".$rspta['fecha_reg']));
$pdf->setY(25); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode("Cliente: ".$rspta['titular']));
$pdf->setY(28); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode("Atendió: ".$_SESSION['nombre']));
$pdf->setY(34); 
$pdf->setX(2);
            $num_credito = substr(str_repeat(0, 7).$rspta['id'], - 7);
$pdf->Cell(76,$textypos, utf8_decode("Operación N°: ".$num_credito));

$pdf->Ln(5);
//SI ESTA ANULADO LA VENTA
$text=$rspta['condicion'];
if($text=='0'){
$pdf->SetFont('Helvetica','B',30);
$pdf->SetTextColor(245, 183, 177);
$pdf->setX(12);
$pdf->Cell(80,20,strtoupper($text));
$pdf->SetTextColor(0,0,0);
}

//COLUMNAS
$pdf->SetFont('Helvetica', 'b', 7);
$pdf->setX(2);
$pdf->Cell(40, 4, utf8_decode('DESCRIPCIÓN'), 0);
$pdf->setX(63);
$pdf->Cell(14, 4, 'TOTAL',0,0,'C');
$pdf->Ln(5);
$pdf->setX(2);
$pdf->Cell(76,0,'','T');
$pdf->Ln(2);

$total =0;
//$rsptad = $venta->ventadetalles($_GET["id"]);
$cantidad=0;
      // PRODUCTOS
      $pdf->SetFont('Helvetica', '', 8);
      $pdf->setX(2); 
      $pdf->MultiCell(40,4,utf8_decode($rspta['glosa']),0,'L');
      $pdf->setX(63); 
      $pdf->Cell(15, -5, number_format(round($rspta['cantidad'],2), 2, '.', ' ,'),0,0,'R');
     // $pdf->setX(2);
     // $pdf->Cell(76,0,'','T');  


// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$total_venta=$rspta['cantidad'];
$subtotal=round(($total_venta/1.18),1,PHP_ROUND_HALF_UP);
$igv=$total_venta-$subtotal;


$pdf->Ln(3);
$pdf->setX(2);    
$pdf->Cell(25, 10, 'TOTAL', 0);
$pdf->Cell(20, 10, '', 0);
$pdf->setX(63);
$pdf->Cell(15, 10, number_format($total_venta, 2, '.', ' ,'),0,0,'R');


//PIE DE PAGINA  
$pdf->Ln(20);   
$pdf->setX(2);
$pdf->Cell(76,$textypos+25, utf8_decode('______________________________________'),0,0,'C');
$pdf->Ln(3);  
$pdf->setX(2);
$pdf->Cell(76,$textypos+25, utf8_decode('Firma'),0,0,'C');

//SALIDA DEL ARCHIVO
$pdf->Output('Comprobante.pdf' ,'i');



  }else{
echo "No tiene permiso para visualizar el reporte";
}

}


ob_end_flush();
  ?>
