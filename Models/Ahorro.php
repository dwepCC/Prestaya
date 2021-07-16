<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Ahorro{

    private $tableName='ahorro';
    private $tableNameAsiento='asiento';
    private $tableNameCuenta='cuenta_persona';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();   
	}
  
	//metodo insertar regiustro
    public function ingresoAhorro($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$fecha_reg,$hora_reg,$idusuario,$idoficina){
        $glosa='Depósito de ahorro';
        $sw=true;
        $sql="INSERT INTO $this->tableName (idpersona,idcuenta,tipoahorro,cantidad,interes,plazo,total,fecha_reg,hora_reg,tipo_mov,idusuario,idoficina,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$cantidad,$fecha_reg,$hora_reg,'1',$idusuario,$idoficina,1);
        $this->conexion->setData($sql,$arrData) or $sw=false;

        $sql_asiento="INSERT INTO $this->tableNameAsiento (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$glosa,$idpersona,$cantidad,$fecha_reg,$hora_reg,$idusuario,'1','1','1');
        $this->conexion->setData($sql_asiento,$arrDatadet)or $sw=false;

        //ACTUALIZAR EL SALDO DEL AHORRO
        $sqlCuenta="UPDATE $this->tableNameCuenta SET cuentaSaldo=cuentaSaldo+'$cantidad' WHERE id=?"; 	
        $arrDataCuenta=array($idcuenta);
        $this->conexion->setData($sqlCuenta,$arrDataCuenta) or $sw=false;

        return $sw;
    }

	//metodo insertar regiustro
    public function retiroAhorro($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$fecha_reg,$hora_reg,$idusuario,$idoficina){
        $glosa='Retiro de ahorro';
        $sw=true;
        $sql="INSERT INTO $this->tableName (idpersona,idcuenta,tipoahorro,cantidad,interes,plazo,total,fecha_reg,hora_reg,tipo_mov,idusuario,idoficina,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$cantidad,$fecha_reg,$hora_reg,'2',$idusuario,$idoficina,1);
        $this->conexion->setData($sql,$arrData) or $sw=false;

        $sql_asiento="INSERT INTO $this->tableNameAsiento (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$glosa,$idpersona,$cantidad,$fecha_reg,$hora_reg,$idusuario,'2','1','1');
        $this->conexion->setData($sql_asiento,$arrDatadet)or $sw=false;

        //ACTUALIZAR EL SALDO DEL AHORRO
        $sqlCuenta="UPDATE $this->tableNameCuenta SET cuentaSaldo=cuentaSaldo-'$cantidad' WHERE id=?"; 	
        $arrDataCuenta=array($idcuenta);
        $this->conexion->setData($sqlCuenta,$arrDataCuenta) or $sw=false;

        return $sw;
    }
    /*public function editar($id,$idpersona,$tipoahorro){
        $sql="UPDATE $this->tableName SET idpersona=?,tipoahorro=? WHERE id=?";
        $arrData = array($idpersona,$tipoahorro,$id);
        return $this->conexion->setData($sql,$arrData);
    }*/

	public function anular($id){
		$sql="UPDATE $this->tableName SET estado='0' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}
    
	/*public function activar($id){
		$sql="UPDATE $this->tableName SET estado='1' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}*/

	//metodo para mostrar registros
	public function mostrar(string $id){
		$sql="SELECT * FROM $this->tableName WHERE id=?";
		$arrData = array($id);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar($idpersona,$idcuenta){
		$sql="SELECT * FROM $this->tableName WHERE idpersona='$idpersona' AND idcuenta='$idcuenta'";
		return  $this->conexion->getDataAll($sql); 
	}


}

