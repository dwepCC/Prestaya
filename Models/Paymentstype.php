<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Paymentstype{

    private $tableName='tipo_pago';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar regiustro
    public function insertar($nombre,$descripcion){
        $sql="INSERT INTO $this->tableName (nombre,descripcion,estado) VALUES (?,?,?)";
        $arrData = array($nombre,$descripcion,1);
        return $this->conexion->setData($sql,$arrData);
    }

    public function editar($idtipopago,$nombre,$descripcion){
        $sql="UPDATE $this->tableName SET nombre=?,descripcion=? WHERE idtipopago=?";
        $arrData = array($nombre,$descripcion,$idtipopago);
        return $this->conexion->setData($sql,$arrData);
    }

	public function desactivar($idtipopago){
		$sql="UPDATE $this->tableName SET estado='0' WHERE idtipopago=?";
		$arrData = array($idtipopago);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function activar($idtipopago){
		$sql="UPDATE $this->tableName SET estado='1' WHERE idtipopago=?";
		$arrData = array($idtipopago);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $idtipopago){
		$sql="SELECT * FROM $this->tableName WHERE idtipopago=?";
		$arrData = array($idtipopago);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar(){
		$sql="SELECT * FROM $this->tableName";
		return  $this->conexion->getDataAll($sql); 
	}
    //listar y mostrar en selct
    public function select(){
        $sql="SELECT * FROM $this->tableName WHERE estado=1";
        return  $this->conexion->getDataAll($sql); 
    }


}

