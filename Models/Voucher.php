<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Voucher{

    private $tableName='tipo_credito';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar regiustro
    public function insertar($nombre){
        $sql="INSERT INTO $this->tableName (nombre,condicion) VALUES (?)";
        $arrData = array($nombre,1);
        return $this->conexion->setData($sql,$arrData);
    }

    public function editar($id,$nombre){
        $sql="UPDATE $this->tableName SET nombre=? WHERE id=?";
        $arrData = array($nombre,$id);
        return $this->conexion->setData($sql,$arrData);
    }

	public function desactivar($id){
		$sql="UPDATE $this->tableName SET condicion='0' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function activar($id){
		$sql="UPDATE $this->tableName SET condicion='1' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $id){
		$sql="SELECT * FROM $this->tableName WHERE id=?";
		$arrData = array($id);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar(){
		$sql="SELECT * FROM $this->tableName";
		return  $this->conexion->getDataAll($sql); 
	}
    //listar y mostrar en selct
    public function select(){
        $sql="SELECT * FROM $this->tableName WHERE condicion=1";
        return  $this->conexion->getDataAll($sql); 
    }


}

