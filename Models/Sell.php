<?php 
//incluir la conexion de base de datos
//incluir la conexion de base de datos
require_once "Connect.php";
class Sell{

    private $tableName='venta';
    private $tableNameDetalle='detalle_venta';
    private $tableNameCrono='credito_cronograma';
    private $tableNamePagoCredito='pago_credito';
    private $tableNameAsiento='asiento';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	} 

    //metodo insertar registro
    public function insertar($idoficina,$idcliente,$idusuario,$tipo_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,$cantidad_cuotas,$tipo_venta,$anio_credito,$idarticulo,$precio_venta,$prestamo,$numItem,$fechaPagoOriginal,$intCrono,$amortizacion,$cuotaPagar,$restoCapital){

        //NUMERO DE COMPROBANTE
        $sql_vNumero="SELECT num_credito FROM venta WHERE credito=? ORDER BY idventa DESC limit 1";
        $arrData = array(1);
		$vNumero= $this->conexion->getData($sql_vNumero,$arrData);
        $numeroCredito = isset($vNumero['num_credito'])? $numeroCredito=$vNumero['num_credito']:null;

        if(!empty($numeroCredito)){
            $numero = $numeroCredito+1;
            $digito_num = 7;
            $num_credito = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }else{
            $numero = 1;
            $digito_num = 7;
            $num_credito = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }

     //   echo $num_credito;
       $sql="INSERT INTO $this->tableName (idoficina,idcliente,idusuario,tipo_credito,anio_credito,num_credito,fecha_reg,impuesto,total_avaluo,capital,total_prestamo,tasa_interes,interes,tipo_pago,num_transac,credito,cantidad_cuotas,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idoficina,$idcliente,$idusuario,$tipo_credito,$anio_credito,$num_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,'1',$cantidad_cuotas,'Aceptado');
        $idventanew= $this->conexion-> getReturnId($sql,$arrData);
        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($idarticulo)) {
            //REGISTRO DE DATOS EN EL DETALLE DE VENTAS
            $sql_detalle="INSERT INTO $this->tableNameDetalle (idventa,idarticulo,avaluo,prestamo,estado) VALUES(?,?,?,?,?)";
            $arrDatadet = array($idventanew,$idarticulo[$num_elementos],$precio_venta[$num_elementos],$prestamo[$num_elementos],'1');
            $this->conexion->setData($sql_detalle,$arrDatadet)or $sw=false;

            $num_elementos=$num_elementos+1;
        }

        //GUARDAR DATOS DEL CRONOGRAMA
        $numElementos=0;
        $sw=true;
        while ($numElementos < count($numItem)) {
            //REGISTRO DE DATOS EN EL DETALLE DE VENTAS
            $sql_crono="INSERT INTO $this->tableNameCrono (idcliente,idcredito,num_credito,num_cuota,interes,capital,fecha_pago_original,total_pago,saldo_capital,estado) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $arrDatadet = array($idcliente,$idventanew,$num_credito,$numItem[$numElementos],$intCrono[$numElementos],$amortizacion[$numElementos],$fechaPagoOriginal[$numElementos],$cuotaPagar[$numElementos],$restoCapital[$numElementos],'1');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

            $numElementos=$numElementos+1;
        }

        //GUARDAR DATOS EN PAGO CREDITO
        $numElementos=0;
        $sw=true;
        while ($numElementos < count($numItem)) {
            //REGISTRO DE DATOS EN creditoi_cronograma   tableNamePagoCredito
            $sql_crono="INSERT INTO $this->tableNamePagoCredito (idcliente,idcredito,num_credito,num_cuota,interes,interes_original,capital,capital_original,fecha_pago_original,total_pago,total_pago_original,saldo_capital,saldo_capital_original,estado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $arrDatadet = array($idcliente,$idventanew,$num_credito,$numItem[$numElementos],$intCrono[$numElementos],$intCrono[$numElementos],$amortizacion[$numElementos],$amortizacion[$numElementos],$fechaPagoOriginal[$numElementos],$cuotaPagar[$numElementos],$cuotaPagar[$numElementos],$restoCapital[$numElementos],$restoCapital[$numElementos],'0');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

            $numElementos=$numElementos+1;
        }
        //ACTUALIZAR STOCK DESPUES DE REALIZAR UNA VENTA
       /* $sql_stock="SELECT idarticulo, cantidad FROM $this->tableNameDetalle WHERE idventa='$idventanew'";
        $res= $this->conexion->getDataAll($sql_stock);
        $idart=0;
        foreach($res as $reg){
            $cantidad[$idart] = isset($reg['cantidad'])? $cantidad[$idart]=$reg['cantidad']:null;
            $idarticulo[$idart] = isset($reg['idarticulo'])? $idarticulo[$idart]=$reg['idarticulo']:null;
            $sql_detalle="UPDATE articulo SET stock= stock-'$cantidad[$idart]' WHERE idarticulo=?";
            //ejecutarConsulta($sql_detalle) or $sw=false;
            $arrData=array($idarticulo[$idart]);
            $this->conexion-> setData($sql_detalle,$arrData) or $sw=false;
            $idart= $idart+1;

        }*/

        return $sw;
    }


    public function insertarCredito($idoficina,$idcliente,$idusuario,$tipo_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,$cantidad_cuotas,$tipo_venta,$anio_credito,$numItem,$fechaPagoOriginal,$intCrono,$amortizacion,$cuotaPagar,$restoCapital){
        //NUMERO DE COMPROBANTE
        $sql_vNumero="SELECT num_credito FROM venta WHERE credito=? ORDER BY idventa DESC limit 1";
        $arrData = array(1);
		$vNumero= $this->conexion->getData($sql_vNumero,$arrData);
        //$vNumero=$this->conexion->getDataAll($sql_vNumero);
        $numeroCredito = isset($vNumero['num_credito'])? $numeroCredito=$vNumero['num_credito']:null;


        if(!empty($numeroCredito)){
            $numero = $numeroCredito+1;
            $digito_num = 7;
            $num_credito = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }else{
            $numero = 1;
            $digito_num = 7;
            $num_credito = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }


     //   echo $num_credito;
       $sql="INSERT INTO $this->tableName (idoficina,idcliente,idusuario,tipo_credito,anio_credito,num_credito,fecha_reg,impuesto,total_avaluo,capital,total_prestamo,tasa_interes,interes,tipo_pago,num_transac,credito,cantidad_cuotas,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idoficina,$idcliente,$idusuario,$tipo_credito,$anio_credito,$num_credito,$fecha_reg,$impuesto,$total_avaluo,$capital,$total_prestamo,$tasa_interes,$interes,$tipo_pago,$num_transac,'2',$cantidad_cuotas,'Aceptado');
        $idventanew= $this->conexion-> getReturnId($sql,$arrData);

        //GUARDAR DATOS DEL CRONOGRAMA
        $numElementos=0;
        $sw=true;
        while ($numElementos < count($numItem)) {
            //REGISTRO DE DATOS EN creditoi_cronograma   tableNamePagoCredito
            $sql_crono="INSERT INTO $this->tableNamePagoCredito (idcliente,idcredito,num_credito,num_cuota,interes,interes_original,capital,capital_original,fecha_pago_original,total_pago,total_pago_original,saldo_capital,saldo_capital_original,estado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $arrDatadet = array($idcliente,$idventanew,$num_credito,$numItem[$numElementos],$intCrono[$numElementos],$intCrono[$numElementos],$amortizacion[$numElementos],$amortizacion[$numElementos],$fechaPagoOriginal[$numElementos],$cuotaPagar[$numElementos],$cuotaPagar[$numElementos],$restoCapital[$numElementos],$restoCapital[$numElementos],'0');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

            $numElementos=$numElementos+1;
        }

        $numCronograma=0;
        while ($numCronograma < count($numItem)) {
            //GUARDANDO DATOS EN pago_credito
            $sql_crono="INSERT INTO $this->tableNameCrono (idcliente,idcredito,num_credito,num_cuota,interes,capital,fecha_pago_original,total_pago,saldo_capital,estado) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $arrDatadet = array($idcliente,$idventanew,$num_credito,$numItem[$numCronograma],$intCrono[$numCronograma],$amortizacion[$numCronograma],$fechaPagoOriginal[$numCronograma],$cuotaPagar[$numCronograma],$restoCapital[$numCronograma],'0');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

            $numCronograma=$numCronograma+1;
        }
        return $sw;
    }

    public function anular($idventa){
        $sw=true; 
        $sql="UPDATE $this->tableName SET estado='Anulado' WHERE idventa=?";
        $arrData=array($idventa);
        $this->conexion->setData($sql,$arrData);
        $sql_detalle="UPDATE $this->tableNameDetalle SET estado='0' WHERE idventa=?"; 	
        $arrDataDetalle=array($idventa);
        $this->conexion->setData($sql_detalle,$arrDataDetalle) or $sw=false;

        //ACTUALIZAR STOCK DESPUES DE ANULAR UNA VENTA
        $sql_stock="SELECT idarticulo, cantidad FROM $this->tableNameDetalle WHERE idventa='$idventa'";
        $res= $this->conexion->getDataAll($sql_stock);
        $idart=0;
        foreach($res as $reg){
            $cantidad[$idart] = isset($reg['cantidad'])? $cantidad[$idart]=$reg['cantidad']:null;
            $idarticulo[$idart] = isset($reg['idarticulo'])? $idarticulo[$idart]=$reg['idarticulo']:null;
            $sql_detalle="UPDATE articulo SET stock= stock+'$cantidad[$idart]' WHERE idarticulo=?";
            //ejecutarConsulta($sql_detalle) or $sw=false;
            $arrData=array($idarticulo[$idart]);
            $this->conexion-> setData($sql_detalle,$arrData) or $sw=false;
            $idart= $idart+1;

        }

        //ACTUALIZAR KARDEX
        $sql_k="SELECT * FROM kardex WHERE iddetalle='$idventa' AND tipo='Salida'";
        $resk= $this->conexion->getDataAll($sql_k);
        $idart=0;
        foreach($resk as $reg){
            //ACTUALIZAR KARDEX
            $sql_kardex="UPDATE kardex SET estado= 'Anulado' WHERE iddetalle=? AND idarticulo=? AND tipo=?";
            //ejecutarConsulta($sql_kardex) or $sw=false;
            $arrDataKardex=array($idventa,$idarticulo[$idart],'Salida');
            $this->conexion-> setData($sql_kardex,$arrDataKardex) or $sw=false;
            //echo $idarticulo[$idart];
            $idart= $idart+1;

        }        
        return $sw;
    }

    //implementar un metodopara mostrar los datos de unregistro a modificar
    public function mostrar($idventa){
       $sql="SELECT DATE(v.fecha_reg) as fecha,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS cliente,u.idusuario,u.nombre as usuario, v.* FROM $this->tableName v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa=?";
		$arrData = array($idventa);
		return  $this->conexion->getData($sql,$arrData);  

    }

    //implementar un metodopara mostrar los datos de unregistro a modificar
    public function mostrarCredito($idventa){
       $sql="SELECT * FROM credito_cronograma  WHERE idcredito=? ORDER BY id DESC LIMIT 1";
		$arrData = array($idventa);
		return  $this->conexion->getData($sql,$arrData);  

    }

    public function mostrarCreditoin($idventa){
       $sql="SELECT * FROM credito_cronograma  WHERE idcredito=? ORDER BY id ASC LIMIT 1";
		$arrData = array($idventa);
		return  $this->conexion->getData($sql,$arrData);  

    }

    public function listarDetalle($idventa){
        $sql="SELECT dv.*, v.total_venta, v.impuesto FROM detalle_venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo INNER JOIN venta v ON v.idventa=dv.idventa WHERE dv.idventa='$idventa'"; 
		return  $this->conexion->getDataAll($sql);  
    }

    //listar registros
    public function listar($idoficina,$estadoCredito){
        $sql="SELECT DATE(v.fecha_reg) as fecha,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS cliente,p.num_documento,p.telefono,u.idusuario,u.nombre as usuario, v.* FROM $this->tableName v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idoficina='$idoficina' AND v.estado='$estadoCredito' ORDER BY v.idventa DESC";
		return  $this->conexion->getDataAll($sql); 
    }

    public function listarDesembolso($idoficina){
        $sql="SELECT DATE(v.fecha_reg) as fecha,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS cliente,u.idusuario,u.nombre as usuario, v.* FROM $this->tableName v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idoficina='$idoficina' AND v.es_aprobado='1' AND v.es_desembolsado='0'  ORDER BY v.idventa DESC";
		return  $this->conexion->getDataAll($sql); 
    }

    public function listarSolicitud($idoficina){
        $sql="SELECT DATE(v.fecha_reg) as fecha,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS cliente,u.idusuario,u.nombre as usuario, v.* FROM $this->tableName v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idoficina='$idoficina' AND v.es_solicitud='1' AND v.es_desembolsado='0'  ORDER BY v.idventa DESC";
		return  $this->conexion->getDataAll($sql); 
    }

    public function ventacabecera($idventa){
        $sql= "SELECT v.estado, v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_credito, v.anio_credito, v.num_credito, DATE(v.fecha_reg) AS fecha, v.impuesto, v.total_venta FROM $this->tableName v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return  $this->conexion->getDataAll($sql); 
    }

    public function ventadetalles($idventa){
        $sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM $this->tableNameDetalle d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		return  $this->conexion->getDataAll($sql); 
    }

    public function mostrarCronograma($idventa){
        $sql="SELECT pc.*,pc.estado AS credito_estado,c.es_aprobado FROM $this->tableNameCrono pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE c.idventa='$idventa'";
		return  $this->conexion->getDataAll($sql);  
    }

    public function mostrarCronogramaEstado($idventa){
        $sql="SELECT pc.*,pc.estado AS credito_estado,c.es_aprobado FROM $this->tableNamePagoCredito pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE c.idventa='$idventa'";
		return  $this->conexion->getDataAll($sql);  
    }

    public function mostrarMovimiento($idventa){
        $sql="SELECT pc.*,pc.estado AS credito_estado,c.es_aprobado FROM $this->tableNamePagoCredito pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE c.idventa='$idventa' AND pc.estado='1'";
		return  $this->conexion->getDataAll($sql);  
    }

	public function desaprobar($idventa){
		$sql="UPDATE $this->tableName SET es_desaprobado='1', es_solicitud='0',estado='Desaprovado' WHERE idventa=?";
		$arrData = array($idventa);
		return $this->conexion->setData($sql,$arrData);
	}
	public function autorizar($idventa){
		$sql="UPDATE $this->tableName SET es_aprobado='1', es_solicitud='0', estado='Aprobado' WHERE idventa=?";
		$arrData = array($idventa);
		return $this->conexion->setData($sql,$arrData);
	}



//DESEMBOLSO DE CREDITO
	public function desembolsar($idventa,$idoficina,$glosa,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario){
        $sw=true;
		$sql="UPDATE $this->tableName SET es_desembolsado='1',fecha_desembolso='$fecha_reg' WHERE idventa=?";
		$arrData = array($idventa);
	    $this->conexion->setData($sql,$arrData) or $sw=false;

        $sql_crono="INSERT INTO $this->tableNameAsiento (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$glosa,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario,'2','1','1');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

         return $sw;   
	}

}

 ?>
