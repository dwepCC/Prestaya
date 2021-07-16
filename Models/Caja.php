<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Caja{

    private $tableName='caja';
    private $tableNameSaldoCaja='saldocaja';
    private $tableBilletaje='billetaje';
    private $tableAsiento='asiento';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar registro
    public function insertar($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010){ 

        $sw=true;
        //REGISTRO DE DATOS
        $sql="INSERT INTO $this->tableName (idoficina,usuarioEnvia,usuarioRecibe,fecha_reg,monto_apertura,estado) VALUES (?,?,?,?,?,?)";
        $arrData = array($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,0); 
        $idcajanew= $this->conexion-> getReturnId($sql,$arrData)or $sw=false;

        $sqlb="INSERT INTO $this->tableBilletaje (idCaja,b_200,b_100,b_50,b_20,b_10,m_5,m_2,m_1,m_050,m_020,m_010,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrDatab = array($idcajanew,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010,0);
        $this->conexion-> setData($sqlb,$arrDatab) or $sw=false;
        //return $cuentaNumero;


		//mostrar usuario para saldo de caja
		$sql="SELECT IFNULL(COUNT(idusuario),0) as saldoCaja FROM $this->tableNameSaldoCaja WHERE idusuario=?";
		$arrData = array($idusuario);
		$idsaldo= $this->conexion->getData($sql,$arrData);
		$saldo = $idsaldo['saldoCaja'];
		//actualizar saldos de caja
		if($saldo>0){
			//echo "editar saldo";
			$sqlsaldo="UPDATE $this->tableNameSaldoCaja SET saldo=saldo-'$totalEnvio' WHERE idusuario=?";
			$arrData = array($idusuario);
			$this->conexion->setData($sqlsaldo,$arrData)or $sw=false;;
		}else{
			$nuevoSaldo=0-$totalEnvio;
			//echo "nuevo saldo ";
			$sql="INSERT INTO $this->tableNameSaldoCaja (idoficina,idusuario,fechaRegistro,saldo,estado) VALUES (?,?,?,?,?)";
			$arrData = array($idoficina,$idusuario,$fecha_reg,$nuevoSaldo,1);
			$this->conexion-> getReturnId($sql,$arrData)or $sw=false;
		}
		        return $idcajanew;
	//	return $this->conexion->getData($sql,$arrData); 
    }

    public function insertarEnvio($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010,$idpersona,$glosa,$hora){ 

        $sw=true;
        //REGISTRO DE DATOS
        $sql="INSERT INTO $this->tableName (idoficina,usuarioEnvia,usuarioRecibe,fecha_reg,monto_apertura,estado) VALUES (?,?,?,?,?,?)";
        $arrData = array($idoficina,$idusuario,$idusuarioRecibe,$fecha_reg,$totalEnvio,0);
        $idcajanew= $this->conexion-> getReturnId($sql,$arrData)or $sw=false;

        $sqlb="INSERT INTO $this->tableBilletaje (idCaja,b_200,b_100,b_50,b_20,b_10,m_5,m_2,m_1,m_050,m_020,m_010,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrDatab = array($idcajanew,$b_200,$b_100,$b_50,$b_20,$b_10,$m_5,$m_2,$m_1,$m_050,$m_020,$m_010,0);
        $this->conexion-> setData($sqlb,$arrDatab) or $sw=false;
        //return $cuentaNumero;

        $sql_crono="INSERT INTO $this->tableAsiento (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$glosa,$idpersona,$totalEnvio,$fecha_reg,$hora,$idusuario,'2','1','1');
        $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

		//mostrar usuario para saldo de caja
		$sql="SELECT IFNULL(COUNT(idusuario),0) as saldoCaja FROM $this->tableNameSaldoCaja WHERE idusuario=?";
		$arrData = array($idusuario);
		$idsaldo= $this->conexion->getData($sql,$arrData);
		$saldo = $idsaldo['saldoCaja'];
		//actualizar saldos de caja
		if($saldo>0){
			//echo "editar saldo";
			$sqlsaldo="UPDATE $this->tableNameSaldoCaja SET saldo=saldo-'$totalEnvio' WHERE idusuario=?";
			$arrData = array($idusuario);
			$this->conexion->setData($sqlsaldo,$arrData)or $sw=false;;
		}else{
			//echo "nuevo saldo ";
			$nuevoSaldo=0-$totalEnvio;
			//echo "nuevo saldo ";
			$sql="INSERT INTO $this->tableNameSaldoCaja (idoficina,idusuario,fechaRegistro,saldo,estado) VALUES (?,?,?,?,?)";
			$arrData = array($idoficina,$idusuario,$fecha_reg,$nuevoSaldo,1);
			$this->conexion-> getReturnId($sql,$arrData)or $sw=false;
		}

        return $idcajanew;
    }



	public function desactivar($id){
		$sql="UPDATE $this->tableName SET estado='0' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function recepcionar($id,$idoficina,$idusuario,$fecha_reg,$totalEnvio){
		$sw=true;
		$sql="UPDATE $this->tableName SET estado='1' WHERE id=?";
		$arrData = array($id);
		$this->conexion->setData($sql,$arrData) or $sw=false;

		//mostrar usuario para saldo de caja
		$sql="SELECT IFNULL(COUNT(idusuario),0) as saldoCaja FROM $this->tableNameSaldoCaja WHERE idusuario=?";
		$arrData = array($idusuario);
		$idsaldo= $this->conexion->getData($sql,$arrData);
		$saldo = $idsaldo['saldoCaja'];
		//actualizar saldos de caja
		if($saldo>0){
			//echo "editar saldo";
			$sqlsaldo="UPDATE $this->tableNameSaldoCaja SET saldo=saldo+'$totalEnvio' WHERE idusuario=?";
			$arrData = array($idusuario);
			$this->conexion->setData($sqlsaldo,$arrData)or $sw=false;;
		}else{
			//echo "nuevo saldo ";
			$nuevoSaldo=0-$totalEnvio;
			//echo "nuevo saldo ";
			$sql="INSERT INTO $this->tableNameSaldoCaja (idoficina,idusuario,fechaRegistro,saldo,estado) VALUES (?,?,?,?,?)";
			$arrData = array($idoficina,$idusuario,$fecha_reg,$nuevoSaldo,1);
			$this->conexion-> getReturnId($sql,$arrData)or $sw=false; 
		}

		return $sw; 
	}

	//metodo para mostrar registros
	public function mostrar(string $idusuario){
		$sql="SELECT * FROM $this->tableName WHERE usuarioRecibe=? AND usuarioEnvia!='$idusuario' AND estado='0' ORDER BY id DESC LIMIT 1";
		$arrData = array($idusuario);
		return  $this->conexion->getData($sql,$arrData);  
	}

	//metodo para mostrar registros
	public function abrirCaja(string $idusuario){
		$sql="SELECT * FROM $this->tableName WHERE usuarioRecibe=? AND usuarioEnvia='$idusuario' AND estado='0' ORDER BY id DESC LIMIT 1";
		$arrData = array($idusuario);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar($idoficina){ 
		/*$sql="SELECT c.*,u.nombre As usuarioEnvia, ur.nombre AS usuarioRecibe FROM $this->tableName c INNER JOIN usuario u ON c.usuarioEnvia=u.idusuario INNER JOIN usuario ur ON c.usuarioRecibe=ur.idusuario WHERE c.usuarioRecibe='$idusuario'";
		return  $this->conexion->getDataAll($sql);*/

		$sql="SELECT c.*,u.nombre As usuarioEnvia, ur.nombre AS usuarioRecibe FROM $this->tableName c INNER JOIN usuario u ON c.usuarioEnvia=u.idusuario INNER JOIN usuario ur ON c.usuarioRecibe=ur.idusuario WHERE ur.idoficina='$idoficina'";
		return  $this->conexion->getDataAll($sql); 		 
	}

	//listar registros
	public function listarh(){   
		$sql="SELECT c.*,u.nombre As usuarioEnvia, ur.nombre AS usuarioRecibe FROM $this->tableName c INNER JOIN usuario u ON c.usuarioEnvia=u.idusuario INNER JOIN usuario ur ON c.usuarioRecibe=ur.idusuario";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarAhorroPago(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='1'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarPlazoPago(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='2'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarAhorroSaldo(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='1'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarPlazoFijo(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='2'";
		return  $this->conexion->getDataAll($sql); 
	}

public function buscarCuenta($idpersona){

        $sql="SELECT * FROM $this->tableName WHERE idPersona='$idpersona'";
        return  $this->conexion->getDataAll($sql); 

}

}

