<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Permiso{

    private $tableName='permiso';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

//listar registros
public function listar(){
	$sql="SELECT * FROM $this->tableName";
	return  $this->conexion->getDataAll($sql); 
}
}

 ?>
