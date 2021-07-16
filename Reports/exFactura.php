<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para visualizar el reporte";
}else{

if ($_SESSION['ventas']==1) { 

//incluimos el archivo factura
require('Factura.php');

//datos de la empresa
require_once "../Models/Company.php";
$cnegocio = new Company();
$rsptan = $cnegocio->listar();
//$regn=$rsptan->fetch_object();
$empresa = $rsptan[0]['nombre'];
$ndocumento = $rsptan[0]['ndocumento'];
$documento = $rsptan[0]['documento'];
$direccion = $rsptan[0]['direccion'];
$telefono = $rsptan[0]['telefono'];  
$email = $rsptan[0]['email'];
$pais = $rsptan[0]['pais'];
$ciudad = $rsptan[0]['ciudad'];
$nombre_impuesto = $rsptan[0]['nombre_impuesto'];
$monto_impuesto = $rsptan[0]['monto_impuesto'];
$moneda = $rsptan[0]['moneda'];
$simbolo = $rsptan[0]['simbolo'];
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


$logoe="../Assets/img/company/".$rsptan[0]['logo']."";
$ext_logo="png";

//obtenemos los datos de la cabecera de la venta actual
require_once "../Models/Sell.php";
$venta= new Sell();
$rsptav=$venta->ventacabecera($_GET["id"]);

//recorremos todos los valores que obtengamos
$regv=$rsptav[0];

//configuracion de la factura
$pdf = new PDF_Invoice('p','mm','A4');
$pdf->AddPage();

//enviamos datos de la empresa al metodo addSociete de la clase factura
$pdf->addSociete(utf8_decode($empresa),
                 $ndocumento. ": "  .$documento."\n".
                 utf8_decode("Direccion: "). utf8_decode($direccion)."\n".
                 utf8_decode("Telefono: ").$telefono."\n".
                 "Email: ".$email,$logoe,$ext_logo);

$pdf->fact_dev($regv['tipo_comprobante'] ,$regv['serie_comprobante'].'-'. $regv['num_comprobante']);
$pdf->temporaire( "" );
$pdf->addDate($regv['fecha']);

//enviamos los datos del cliente al metodo addClientAddresse de la clase factura
$pdf->addClientAdresse(utf8_decode($regv['cliente']),
                       "Domicilio: ".utf8_decode($regv['direccion']), 
                       $regv['tipo_documento'].": ".$regv['num_documento'], 
                       "Email: ".$regv['email'], 
                       "Telefono: ".$regv['telefono']);

//establecemos las columnas que va tener la seccion donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
	         "DESCRIPCION"=>78,
	         "CANTIDAD"=>22,
	         "P.U."=>25,
	         "DSCTO"=>20,
	         "IMPORTE"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             "P.U."=>"R",
             "DSCTO"=>"R",
             "IMPORTE"=>"C" );
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols); 

//actualizamos el valor de la coordenada "y" quie sera la ubicacion desde donde empecemos a mostrar los datos 
$y=85;

//obtenemos todos los detalles del a venta actual
$rsptad=$venta->ventadetalles($_GET["id"]);

foreach($rsptad as $regd){
  $line = array( "CODIGO"=>$regd['codigo'],
                 "DESCRIPCION"=>utf8_decode($regd['articulo']),
                 "CANTIDAD"=>$regd['cantidad'],
                 "P.U."=>$regd['precio_venta'],
                 "DSCTO"=>$regd['descuento'],
                 "IMPORTE"=>$regd['subtotal']);
  $size = $pdf->addLine( $y, $line );
  $y += $size +2;

}


/*aqui falta codigo de letras*/
require_once "Letras.php";
$V = new EnLetras();

$total=$regv['total_venta'];  
$V=new EnLetras(); 
$V->substituir_un_mil_por_mil = true;

 $con_letra=strtoupper($V->ValorEnLetras($total," $moneda")); 
$pdf->addCadreTVAs("SON ".$con_letra,55);

//mostramos el impuesto
$pdf->addTVAs( $regv['impuesto'], $regv['total_venta'], $new_simbolo);
$pdf->addCadreEurosFrancs($nombre_impuesto. " 18 %");
$pdf->Output('Reporte de Venta' ,'I');

	}else{
echo "No tiene permiso para visualizar el reporte";
}

}

ob_end_flush();
  ?>