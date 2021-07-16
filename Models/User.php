<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class User{

    private $tableName='usuario';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	}

	//metodo insertar regiustro
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
		$sql="INSERT INTO $this->tableName (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		//return ejecutarConsulta($sql);
		$arrDataInsert = array($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,1);
		$idusuarionew = $this->conexion->getReturnId($sql,$arrDataInsert);
		//$idusuarionew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($permisos)) {

			$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES(?,?)";
			$arrDataPermiso = array($idusuarionew,$permisos[$num_elementos]);
			$this->conexion->setData($sql_detalle,$arrDataPermiso) or $sw=false;

			$num_elementos=$num_elementos+1;
		}
		return $sw;
	}

	public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$imagen,$permisos){
		$sw=true;
		$sql="UPDATE $this->tableName SET nombre=?,tipo_documento=?,num_documento=?,direccion=?,telefono=?,email=?,cargo=?,login=?,imagen=? 
		WHERE idusuario=?";
		$arrDataUpdate = array($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$imagen,$idusuario);	
		$this->conexion->setData($sql,$arrDataUpdate) or $sw=false;

		//eliminar permisos asignados 
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario=?";
		$arrDataDel = array($idusuario);
		$this->conexion->setData($sqldel,$arrDataDel) or $sw=false;

		$num_elementos=0; 
		while ($num_elementos < count($permisos)) {

			$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES(?,?)";
			$arrDataPermiso = array($idusuario,$permisos[$num_elementos]);
			$this->conexion->setData($sql_detalle,$arrDataPermiso) or $sw=false;

			$num_elementos=$num_elementos+1;
		}
		return $sw;
	}
	public function editar_clave($idusuario,$clave){
		$sql="UPDATE $this->tableName SET clave=? WHERE idusuario=?";
		$arrData = array($clave,$idusuario);
		return $this->conexion->setData($sql,$arrData);
	}
	public function mostrar_clave($idusuario){
		$sql="SELECT idusuario, clave FROM $this->tableName WHERE idusuario=?";
		$arrData = array($idusuario);
		return  $this->conexion->getData($sql,$arrData); 

	}
	public function desactivar($idusuario){
		$sql="UPDATE $this->tableName SET condicion='0' WHERE idusuario=?";
		$arrData = array($idusuario);
		return $this->conexion->setData($sql,$arrData);
	}
	public function activar($idusuario){
		$sql="UPDATE $this->tableName SET condicion='1' WHERE idusuario=?";
		$arrData = array($idusuario);
		return $this->conexion->setData($sql,$arrData);
	}

	//metodo para mostrar registros
	public function mostrar(string $idusuario){
		$sql="SELECT * FROM $this->tableName WHERE idusuario=?";
		$arrData = array($idusuario);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar(){
		$sql="SELECT * FROM $this->tableName";
		return  $this->conexion->getDataAll($sql); 
	}

	//metodo para listar permmisos marcados de un usuario especifico
	public function listarmarcados(string $idusuario){
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return  $this->conexion->getDataAll($sql);  
	}

//Función para verificar el acceso al sistema
	/*public function sasa(string $login, string $clave)
    {
    	$sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM $this->tableName WHERE login='$login' AND clave='$clave' AND condicion='1'"; 
    	return ejecutarConsulta($sql);  
    }*/

    public function verificar(string $login, string $clave){
		$sql="SELECT idusuario,idoficina,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,tipo,login FROM $this->tableName WHERE login=? AND clave=? AND condicion='1'";
		$arrData = array($login,$clave);
		return  $this->conexion->getData($sql,$arrData); 
	}

    public function select(){
        $sql="SELECT * FROM $this->tableName WHERE condicion=1 AND tipo=0";
        return  $this->conexion->getDataAll($sql); 
    }
}

 ?>
