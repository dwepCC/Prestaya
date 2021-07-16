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
require_once "../Models/Sell.php"; 

$venta = new Venta();

//en el objeto $rspta obtenemos los valores devueltos del metodo ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);

$reg=$rspta->fetch_object();

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

include('../fpdf182/fpdf.php');
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
$pdf->Cell(76,$textypos, utf8_decode($ndocumento.": ".$documento) ,0,0,'C');
$pdf->setY(10); 
$pdf->setX(2);
$pdf->Cell(76,$textypos,utf8_decode("Direc: ".$direccion),0,0,'C');
$pdf->setY(13); 
$pdf->setX(2);
$pdf->Cell(76,$textypos,utf8_decode("Telf: ".$telefono),0,0,'C');
$pdf->setY(17); 
$pdf->setX(2);
$pdf->Cell(76,$textypos,utf8_decode($ciudad),0,0,'C');
$pdf->setY(22); 
$pdf->setX(2);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(76,$textypos, utf8_decode("Fecha: ".$reg['fecha']));
$pdf->setY(25); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode("Cliente: ".$reg['cliente']));
$pdf->setY(28); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode("Atendió: ".$_SESSION['nombre']));
$pdf->setY(34); 
$pdf->setX(2);
$pdf->Cell(76,$textypos, utf8_decode(strtoupper($reg['tipo_comprobante'])." N°: ".$reg['serie_comprobante']." - ".$reg['num_comprobante']));

$pdf->Ln(5);
//SI ESTA ANULADO LA VENTA
$text=$reg->estado;
if($text=='Anulado'){
$pdf->SetFont('Helvetica','B',30);
$pdf->SetTextColor(245, 183, 177);
$pdf->setX(12);
$pdf->Cell(80,20,strtoupper($text));
$pdf->SetTextColor(0,0,0);
}

//COLUMNAS
$pdf->SetFont('Helvetica', 'b', 7);
$pdf->setX(2);
$pdf->Cell(40, 4, 'ARTICULO', 0);
$pdf->setX(43);
$pdf->Cell(6, 4, 'UND',0,0,'R');
$pdf->setX(50);
$pdf->Cell(12, 4, 'PRECIO',0,0,'R');
$pdf->setX(63);
$pdf->Cell(14, 4, 'TOTAL',0,0,'C');
$pdf->Ln(5);
$pdf->setX(2);
$pdf->Cell(76,0,'','T');
$pdf->Ln(2);

$total =0;
$rsptad = $venta->ventadetalles($_GET["id"]);
$cantidad=0;
foreach ($rsptad as $regd) {
      // PRODUCTOS
      $pdf->SetFont('Helvetica', '', 7);
      $pdf->setX(2); 
      $pdf->MultiCell(40,4,$regd['articulo'],0,'L');
      $pdf->setX(42);  
      $pdf->Cell(6, -5, $regd['cantidad'],0,0,'R');
      $pdf->setX(50); 
      $pdf->Cell(10, -5, number_format(round($regd['precio_venta'],2), 2, '.', ' ,'),0,0,'R');
      $pdf->setX(63); 
      $pdf->Cell(15, -5, number_format(round($regd['subtotal'],2), 2, '.', ' ,'),0,0,'R');
     // $pdf->setX(2);
     // $pdf->Cell(76,0,'','T');  
      $cantidad+=$regd['cantidad'];
}


// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$ivgimp=$reg['impuesto']+100;
$igv_total=$ivgimp/100;
$subtotal=$reg['total_venta']/$igv_total;
$igv=$reg['total_venta']-$subtotal;
$totalv=$igv+$subtotal;

$pdf->setX(2);
$pdf->Cell(76,0,'','T');  
$pdf->Ln(0);
$pdf->setX(2);    
$pdf->Cell(25, 10, 'TOTAL SIN '.$nombre_impuesto, 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->setX(63);
$pdf->Cell(15, 10, number_format($subtotal, 2, '.', ' ,').' '.$new_simbolo,0,0,'R');
$pdf->Ln(3);
$pdf->setX(2);    
$pdf->Cell(25, 10,$nombre_impuesto.' '.round($monto_impuesto,0).' %', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->setX(63);
$pdf->Cell(15, 10, number_format($igv, 2, '.', ' ,').' '.$new_simbolo,0,0,'R');
$pdf->Ln(3);
$pdf->setX(2);    
$pdf->Cell(25, 10, 'TOTAL', 0);
$pdf->Cell(20, 10, '', 0);
$pdf->setX(63);
$pdf->Cell(15, 10, number_format($totalv, 2, '.', ' ,').' '.$new_simbolo,0,0,'R');


//PIE DE PAGINA     
$pdf->setX(2);
$pdf->Cell(76,$textypos+10, utf8_decode('CANT. ARTICULOS: '.$cantidad));
$pdf->setX(2);
$pdf->Cell(76,$textypos+25, utf8_decode('GRACIAS POR SU COMPRA '),0,0,'C');

//SALIDA DEL ARCHIVO
$pdf->Output($reg['tipo_comprobante'].'_'.$reg['serie_comprobante'].'_'.$reg['num_comprobante'].'.pdf' ,'i');



  }else{
echo "No tiene permiso para visualizar el reporte";
}

}


ob_end_flush();
  ?>
