<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Category{

    private $tableName='categoria';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion(); 
	}

	//metodo insertar regiustro
    public function insertar($nombre,$descripcion){
        $sql="INSERT INTO $this->tableName (nombre,descripcion,condicion) VALUES (?,?,?)";
        $arrData = array($nombre,$descripcion,1);
        return $this->conexion->setData($sql,$arrData); 
    }

    public function editar($idcategoria,$nombre,$descripcion){
        $sql="UPDATE $this->tableName SET nombre=?,descripcion=? WHERE idcategoria=?";
        $arrData = array($nombre,$descripcion,$idcategoria);
        return $this->conexion->setData($sql,$arrData);
    }

	public function desactivar($idcategoria){
		$sql="UPDATE $this->tableName SET condicion='0' WHERE idcategoria=?";
		$arrData = array($idcategoria);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function activar($idcategoria){
		$sql="UPDATE $this->tableName SET condicion='1' WHERE idcategoria=?";
		$arrData = array($idcategoria);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $idcategoria){
		$sql="SELECT * FROM $this->tableName WHERE idcategoria=?";
		$arrData = array($idcategoria);
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

