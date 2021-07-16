<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Company{

    private $tableName='datos_negocio';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}


    public function editar($id_negocio,$nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo){
        $sql="UPDATE $this->tableName SET nombre=?,ndocumento=?, documento=?, direccion=?, telefono=?, email=?, logo=?, pais=?, ciudad=?, nombre_impuesto=?, monto_impuesto=?, moneda=?, simbolo=? WHERE id_negocio=?";
        $arrData = array($nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo,$id_negocio);
        return $this->conexion->setData($sql,$arrData);
    }

	//metodo para mostrar registros
	public function mostrar(string $id_negocio){
		$sql="SELECT * FROM $this->tableName WHERE id_negocio=?";
		$arrData = array($id_negocio); 
		return  $this->conexion->getData($sql,$arrData); 
	}

	public function mostrar_impuesto(){
		$sql="SELECT monto_impuesto FROM datos_negocio";
			return  $this->conexion->getDataAll($sql); 
	}

	public function mostrar_simbolo(){
		$sql="SELECT simbolo FROM datos_negocio";
		return  $this->conexion->getDataAll($sql); 
	}

	public function nombre_impuesto(){
		$sql="SELECT nombre_impuesto FROM datos_negocio";
		return  $this->conexion->getDataAll($sql); 
	}
	//listar registros
	public function listar(){
		$sql="SELECT * FROM $this->tableName";
		return  $this->conexion->getDataAll($sql); 
	}


}

