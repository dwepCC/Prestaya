<?php 
//incluir la conexion de base de datos
//incluir la conexion de base de datos
require_once "Connect.php";
class Cuadrecaja{

    private $tableName='asiento';
    private $tableNameCaja='caja';
    private $tableNameSaldoCaja='saldocaja';

    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	} 

    //listar registros
    public function listar($idoficina,$fechaCaja,$idusuario){
        $sql="SELECT a.*, CONCAT(p.ap, ' ', p.am,' ',p.nombre) As titular, u.login AS usuario FROM $this->tableName  a INNER JOIN persona p ON a.idpersona=p.idpersona INNER JOIN usuario u ON a.idusuario=u.idusuario INNER JOIN oficina of ON a.idoficina=of.id  WHERE a.condicion='1' AND a.idoficina='$idoficina' AND a.fecha_reg='$fechaCaja' AND a.idusuario='$idusuario'";
		return  $this->conexion->getDataAll($sql);  
    }

    //listar registros
    public function mostrar($idasiento){ 
        $sql="SELECT a.*, CONCAT(p.ap, ' ', p.am,' ',p.nombre) As titular, u.login AS usuario FROM $this->tableName  a INNER JOIN persona p ON a.idpersona=p.idpersona INNER JOIN usuario u ON a.idusuario=u.idusuario INNER JOIN oficina of ON a.idoficina=of.id  WHERE a.id=?";
		$arrData = array($idasiento);
		return  $this->conexion->getData($sql,$arrData);
    }

	public function recepcionar($id,$idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario){
        $sw=true; 
		$sql="UPDATE $this->tableNameCaja SET estado='1' WHERE id=?";
		$arrData = array($id);
		$this->conexion->setData($sql,$arrData)or $sw=false; 

        $sql_crono="INSERT INTO $this->tableName (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario,'1','1','1');
        $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

      //mostrar usuario para saldo de caja
      $sql="SELECT IFNULL(COUNT(idusuario),0) as saldoCaja FROM $this->tableNameSaldoCaja WHERE idusuario=?";
      $arrData = array($idusuario);
      $idsaldo= $this->conexion->getData($sql,$arrData);
      $saldo = $idsaldo['saldoCaja'];
      //actualizar saldos de caja
      if($saldo>0){
        //echo "editar saldo";
        $sqlsaldo="UPDATE $this->tableNameSaldoCaja SET saldo=saldo+'$cantidad' WHERE idusuario=?";
        $arrData = array($idusuario);
        $this->conexion->setData($sqlsaldo,$arrData)or $sw=false;;
      }else{
        //echo "nuevo saldo ";
        $sql="INSERT INTO $this->tableNameSaldoCaja (idoficina,idusuario,fechaRegistro,saldo,estado) VALUES (?,?,?,?,?)";
        $arrData = array($idoficina,$idusuario,$fecha_reg,$cantidad,1);
        $this->conexion-> getReturnId($sql,$arrData)or $sw=false;
      }

        return $sw;
	}

  public function totalIngreso($fecha_reg,$idusuario){
    $sql="SELECT IFNULL(SUM(cantidad),0) as totali FROM asiento WHERE fecha_reg='$fecha_reg' AND idusuario='$idusuario' AND tipo_mov='1'";
    return  $this->conexion->getDataAll($sql); 
  }

  public function totalEgreso($fecha_reg,$idusuario){
    $sql="SELECT IFNULL(SUM(cantidad),0) as totale FROM asiento WHERE fecha_reg='$fecha_reg' AND idusuario='$idusuario' AND tipo_mov='2'";
    return  $this->conexion->getDataAll($sql); 
  }

}

 ?>
