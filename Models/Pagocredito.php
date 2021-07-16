<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Pagocredito{

    private $tableName='asiento';
    private $tableNamePagoCredito='pago_credito';
    private $tableNameCrono='credito_cronograma';
    private $tableNameAsiento='asiento';
    private $tableNameCredito='venta';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar regiustro
    public function insertar($idoficina,$glosa,$idcliente,$cantidad,$fecha_reg,$hora,$idusuario,$tipo_mov,$idcredito,$num_credito,$idCronograma,$numItem,$fechaPagoOriginal,$intCrono,$amortizacion,$cuotaPagar,$restoCapital){
		$sw=true;
        $sql="INSERT INTO $this->tableName (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idoficina,$glosa,$idcliente,$cantidad,$fecha_reg,$hora,$idusuario,$tipo_mov,'1','1');
        $this->conexion->setData($sql,$arrData) or $sw=false;

        //ACTUALIZAR PAGO DE CREDITO
        $idart=0;
        while ($idart < count($numItem)) {
            $sql_detalle="UPDATE $this->tableNamePagoCredito SET interes= interes-'$intCrono[$idart]',capital= capital-'$amortizacion[$idart]',total_pago= total_pago-'$cuotaPagar[$idart]',saldo_capital= saldo_capital-'$restoCapital[$idart]',fecha_pago='$fecha_reg',estado='1' WHERE id=?";

            $arrData=array($idCronograma[$idart]);
            $this->conexion-> setData($sql_detalle,$arrData) or $sw=false;
            $idart= $idart+1;
        }

        //MARCAR CRONOGRAMA COMO PAGADO
        $idart=0;
        while ($idart < count($numItem)) {

            $sql_detalle="UPDATE $this->tableNameCrono SET fecha_pago='$fecha_reg',estado= '1' WHERE id=?";

            $arrData=array($idCronograma[$idart]);
            $this->conexion-> setData($sql_detalle,$arrData) or $sw=false;
            $idart= $idart+1;

        }		
        /*$num_elementos=0;
        while ($num_elementos < count($numItem)) {
            //REGISTRO DE DATOS EN EL DETALLE DE VENTAS
        	$sql_crono="INSERT INTO $this->tableNamePagoCredito (idcliente,idcredito,num_credito,num_cuota,interes,capital,fecha_pago_original,total_pago,saldo_capital,fecha_pago,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $arrDatadet = array($idcliente,$idcredito,$num_credito,$numItem[$num_elementos],$intCrono[$num_elementos],$amortizacion[$num_elementos],$fechaPagoOriginal[$num_elementos],$cuotaPagar[$num_elementos],$restoCapital[$num_elementos],$fecha_reg,'1');
            $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

            $num_elementos=$num_elementos+1;
        }*/
	return $sw;

    }

	public function anular($idpersona){
		$sql="UPDATE $this->tableName SET lista_negra='1' WHERE idpersona=?";
		$arrData = array($idpersona);
		return $this->conexion->setData($sql,$arrData);
	}

	public function mostrarCreditos($idpersona){
		$sql="SELECT c.* FROM $this->tableNameCredito c WHERE c.es_aprobado=1 AND c.es_desembolsado=1 AND c.estado='Aprobado' AND idcliente='$idpersona'";
		return  $this->conexion->getDataAll($sql);
	}

	public function mostrarOpciones($idcredito){
		$sql="SELECT * FROM $this->tableNameCredito WHERE idventa=?";
		$arrData = array($idcredito);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listarCronograma($idcredito,$tipoPago,$fecha,$numCuota){
        if($tipoPago=='0'){
		$sql="SELECT pc.*,c.es_aprobado FROM $this->tableNamePagoCredito pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE pc.idcredito=$idcredito AND c.es_aprobado=1 AND c.es_desembolsado=1 AND pc.estado=0";
		return  $this->conexion->getDataAll($sql);
        }elseif($tipoPago=='1'){
		$sql="SELECT pc.*,c.es_aprobado FROM $this->tableNamePagoCredito pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE pc.idcredito=$idcredito AND c.es_aprobado=1 AND c.es_desembolsado=1 AND pc.estado=0 AND fecha_pago_original<='$fecha'";
		return  $this->conexion->getDataAll($sql);
        }elseif($tipoPago=='3'){
		$sql="SELECT pc.*,c.es_aprobado FROM $this->tableNamePagoCredito pc INNER JOIN venta c ON pc.idcredito=c.idventa WHERE pc.idcredito=$idcredito AND c.es_aprobado=1 AND c.es_desembolsado=1 AND pc.estado=0 ORDER BY pc.num_cuota ASC LIMIT $numCuota";
		return  $this->conexion->getDataAll($sql);
        } 
	}


}

