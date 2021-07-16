<?php
//incluir la conexion de base de datos
require_once "Connect.php";
class Consult{


  private $tableName='categoria'; 
  private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();  
	}

  //listar registros
  /*public function comprasfecha($fecha_inicio,$fecha_fin){
    $sql="SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
      return  $this->conexion->getDataAll($sql); 
  }*/

  /*public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente){
    $sql="SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante,v.serie_comprobante, v.num_comprobante , v.total_venta, v.impuesto, v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
    return  $this->conexion->getDataAll($sql); 
  }*/

  public function totalArticulos(){
    $sql="SELECT COUNT(*) totala FROM articulo";
    return  $this->conexion->getDataAll($sql); 
  }

  public function cantidadCreditos(){
    $sql="SELECT COUNT(*) cantidad FROM venta WHERE es_desembolsado='1'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function totalcreditos(){
    $sql="SELECT IFNULL(SUM(capital),0) as total_credito FROM venta WHERE es_desembolsado='1'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function totalAhorro(){
    $sql="SELECT IFNULL(SUM(cuentaSaldo),0) as total_ahorro FROM cuenta_persona WHERE estado='1' AND tipoCuenta='1'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function totalPlazo(){
    $sql="SELECT IFNULL(SUM(cuentaSaldo),0) as total_plazo FROM cuenta_persona WHERE estado='1' AND tipoCuenta='2'";
    return  $this->conexion->getDataAll($sql); 
  }

 /* public function totalcreditos(){
    $sql="SELECT IFNULL(SUM(capital),0) as total_prestamo FROM venta WHERE  MONTH(fecha_desembolso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_desembolso) = YEAR(CURRENT_DATE())";
    return  $this->conexion->getDataAll($sql); 
  }*/

  public function saldoCaja($idusuario){ 
    $sql="SELECT IFNULL(SUM(saldo),0) as total_saldo FROM saldocaja WHERE idusuario='$idusuario'";
    return  $this->conexion->getDataAll($sql); 
  }

    public function saldoBoveda($idusuario){
    $sql="SELECT IFNULL(SUM(saldo),0) as total_saldo FROM saldocaja WHERE idusuario='$idusuario'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function comprasultimos_10dias(){
    $sql="SELECT CONCAT(DAY(fecha_reg),'-',MONTH(fecha_reg)) AS fecha, SUM(capital) AS total FROM venta WHERE es_desembolsado='1' GROUP BY fecha_reg ORDER BY fecha_reg DESC LIMIT 0,10";
    return  $this->conexion->getDataAll($sql); 
  }


  public function ventasultimos_12meses(){
    $sql="SELECT DATE_FORMAT(fecha_reg,'%M') AS fecha, SUM(capital) AS total FROM venta WHERE es_desembolsado='1' GROUP BY MONTH(fecha_reg) ORDER BY MONTH(fecha_reg) DESC LIMIT 0,12";
    return  $this->conexion->getDataAll($sql); 
  }

  /*public function ventasultimos_12meses_grafica(){

    $sql=" SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";

    return  $this->conexion->getDataAll($sql); 
}*/

  /*public function comparsultimos_12meses_grafica(){
    $sql="SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return  $this->conexion->getDataAll($sql); 
}*/

  /*public function ventas_grafica(){
    $sql="SELECT DATE(fecha_hora) AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return  $this->conexion->getDataAll($sql); 
}*/
  /*public function compras_grafica(){
    $sql="SELECT DATE(fecha_hora) AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return  $this->conexion->getDataAll($sql); 
  }*/

  public function cantidadclientes(){
    $sql="SELECT COUNT(*) totalc FROM persona WHERE tipo_persona='Cliente'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function cantidadproveedores(){
    $sql="SELECT COUNT(*) totalp FROM persona WHERE tipo_persona='Proveedor'";
    return  $this->conexion->getDataAll($sql); 
  }

  /*public function cantidadarticulos(){
    $sql="SELECT COUNT(*) totalar FROM articulo WHERE condicion=1";
    return  $this->conexion->getDataAll($sql); 
  }
  public function totalstock(){
    $sql="SELECT SUM(stock) AS totalstock FROM articulo";
    return  $this->conexion->getDataAll($sql); 
  }

  public function cantidadcategorias(){
    $sql="SELECT COUNT(*) totalca FROM categoria WHERE condicion=1";
    return  $this->conexion->getDataAll($sql); 
  }

  /*public function listaventasarticulos($fecha_inicio,$fecha_fin){
    $sql="SELECT a.nombre AS articulo, a.codigo, SUM(d.cantidad) AS cantidad, SUM(d.precio_venta)AS precio_venta, d.descuento, SUM(d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo INNER JOIN venta v ON v.idventa=d.idventa WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' GROUP BY a.codigo";
  return  $this->conexion->getDataAll($sql); 
  }*/

  /*public function listacomprasarticulos($fecha_inicio,$fecha_fin){
    $sql="SELECT a.nombre AS articulo, a.codigo, SUM(d.cantidad) AS cantidad, SUM(d.precio_compra)AS precio_compra, SUM(d.cantidad*d.precio_compra) AS subtotal FROM detalle_ingreso d INNER JOIN articulo a ON d.idarticulo=a.idarticulo INNER JOIN ingreso i ON i.idingreso=d.idingreso WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin' GROUP BY a.codigo";
  return  $this->conexion->getDataAll($sql); 
  }*/

  public function cateogriasMasVendidas(){
    $sql="SELECT COUNT(idventa) as cantidad,tipo_credito AS categoria FROM venta WHERE es_desembolsado='1'  GROUP BY tipo_credito";
    return  $this->conexion->getDataAll($sql);

  }
/*public function kardex_ingreso($idarticulo){
$sql="SELECT DATE_FORMAT(fecha, '%Y %m %d') AS fecha,m.detalle,IF(tipo=0,m.cantidad,0) AS cantidadi,IF(tipo=0,m.preciou,0) AS costoui,IF(tipo=0,m.total,0) AS totali ,IF(tipo=1,m.cantidad,0) AS cantidads,IF(tipo=1,m.preciou,0) AS costous ,IF(tipo=1,m.total,0) AS totals, IF(tipo=0,m.cantidad,0) AS cantidadex ,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS costouex ,((SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) )* a.stock AS totalex  FROM

(SELECT 0 As tipo,CONCAT(i.tipo_comprobante,' ',i.serie_comprobante,'-',i.num_comprobante) AS detalle, di.idarticulo, di.cantidad AS cantidad, di.precio_compra AS preciou, i.fecha_hora AS fecha,i.total_compra AS total,i.f_registro AS f_registro FROM ingreso i INNER JOIN detalle_ingreso di ON i.idingreso=di.idingreso WHERE i.estado='Aceptado'
 UNION ALL
  SELECT 1 As tipo,CONCAT(v.tipo_comprobante,' ',v.serie_comprobante,'-',v.num_comprobante) AS detalle, dv.idarticulo, dv.cantidad AS cantidad, dv.precio_venta AS preciou, v.fecha_hora AS fecha, v.total_venta AS total,v.f_registro AS f_registro FROM venta v INNER JOIN detalle_venta dv ON v.idventa=dv.idventa WHERE v.estado='Aceptado' )
 AS m INNER JOIN articulo a ON m.idarticulo = a.idarticulo WHERE m.idarticulo='$idarticulo' ORDER BY f_registro ASC";
    return  $this->conexion->getDataAll($sql); 
}*/


/*public function kardex_ingreso($idarticulo){
$sql="SELECT * FROM kardex WHERE idarticulo='$idarticulo' AND estado='Activo' ORDER BY fecha DESC";
    return  $this->conexion->getDataAll($sql);
}*/





//ESTADOS FIANCIEROS
	//metodo para mostrar registros
	public function interesCartera($tipo,string $fecha){
    if($tipo=='1'){
		$sql="SELECT IFNULL(SUM(interes_original),0) AS icartera FROM pago_credito WHERE estado='1' AND fecha_pago<=?";
		$arrData = array($fecha);
		return  $this->conexion->getData($sql,$arrData); 

    }elseif($tipo=='2'){
      $sql="SELECT IFNULL(SUM(interes_original),0) AS icartera FROM pago_credito WHERE estado=? AND dayofmonth(fecha_pago) >= 1 AND fecha_pago <= '$fecha'";
		$arrData = array(1);
		return  $this->conexion->getData($sql,$arrData); 
  }
	}

}

 ?>
