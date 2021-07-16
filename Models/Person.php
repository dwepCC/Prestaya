<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Person{

    private $tableName='persona';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar regiustro
    public function insertar($tipo_persona,$fecha_reg,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email){
        $sql="INSERT INTO $this->tableName (tipo_persona,fecha_reg,ap,am,nombre,tipo_documento,num_documento,fecha_nac,sexo,direccion,telefono,email) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($tipo_persona,$fecha_reg,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email);
        return $this->conexion->setData($sql,$arrData);
    }

    public function editar($idpersona,$tipo_persona,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email){
	$sql="UPDATE $this->tableName SET tipo_persona=?,ap=?, am=?, nombre=?, tipo_documento=?, num_documento=?,fecha_nac=?,sexo=?, direccion=?, telefono=?, email=? WHERE idpersona=?";
        $arrData = array($tipo_persona,$ap,$am,$nombre,$tipo_documento,$num_documento,$fecha_nac,$sexo,$direccion,$telefono,$email,$idpersona);
        return $this->conexion->setData($sql,$arrData);
    }
    
	public function desactivar($idpersona){
		$sql="UPDATE $this->tableName SET lista_negra='1' WHERE idpersona=?";
		$arrData = array($idpersona);
		return $this->conexion->setData($sql,$arrData); 
	}
	public function activar($idpersona){
		$sql="UPDATE $this->tableName SET lista_negra='0' WHERE idpersona=?";
		$arrData = array($idpersona);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $idpersona){
		$sql="SELECT * FROM $this->tableName WHERE idpersona=?";
		$arrData = array($idpersona);
		return  $this->conexion->getData($sql,$arrData); 
	}

	public function buscarCliente(string $documento){
		$sql="SELECT * FROM $this->tableName WHERE num_documento=?";
		$arrData = array($documento);
		return  $this->conexion->getData($sql,$arrData); 
	}
	//listar registros
	public function listarp(){
		$sql="SELECT * FROM $this->tableName WHERE tipo_persona='Proveedor'";
		return  $this->conexion->getDataAll($sql); 
	}
	public function listarc(){
		$sql="SELECT * FROM $this->tableName WHERE tipo_persona='Cliente' AND lista_negra='0'";
		return  $this->conexion->getDataAll($sql); 
	}

	public function lista_negra(){
		$sql="SELECT * FROM $this->tableName WHERE tipo_persona='Cliente' AND lista_negra='1'";
		return  $this->conexion->getDataAll($sql); 
	}

    //listar y mostrar en selct
    public function selectp(){
        $sql="SELECT * FROM $this->tableName WHERE tipo_persona='Proveedor'";
        return  $this->conexion->getDataAll($sql); 
    }

    //listar y mostrar en selct
    public function selectc(){
        $sql="SELECT * FROM $this->tableName WHERE tipo_persona='Cliente'";
        return  $this->conexion->getDataAll($sql); 
    }

}

