<?php

require_once dirname(__FILE__,2).'/Config/config.php';
//require_once "../Config/config.php";
class Conexion{
	private $conect = null;

	public function __construct(){
		$connectionString = "mysql:host=".HOST.";port=".PORT.";dbname=".DB_NAME.";charset=".CHARSET;
		try{
			$this->conect = new PDO($connectionString,DB_USER,DB_PASS);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e){
			$this->conect = 'Error de conexion';
			echo "Ocurrió un error en la conexion a la base de datos...!: ".$e->getMessage();
		}
	} 

	//INSERTAR, ACTUALIZAR Y ELIMINAR DATOS
	public	function setData($sql,$arrData){ 
		$query = $this->conect->prepare($sql);
		$restQuery = $query->execute($arrData);
		return $restQuery;

	}

	//RETORNAR EL ID DEL ULTIMO REGISTRO	
	public function getReturnId($sql,$arrData){
		$query = $this->conect->prepare($sql);
		$restQuery = $query->execute($arrData);
		$idInsert = $this->conect->lastinsertId();
		return $idInsert;
	}

	//LISTAR TODO LOS DATOS
	public function getDataAll($sql){
		$execute = $this->conect->query($sql);
		$request = $execute->fetchall(PDO::FETCH_ASSOC);
		return $request;
		}

	//LISTAR DATOS POR ID (BUSCAR)	
	public function getData($sql,$arrData){
		$query = $this->conect->prepare($sql);
		$query->execute($arrData);
		$restQuery = $query->fetch(PDO::FETCH_ASSOC);
		return $restQuery;
		}

}

$conexion = new Conexion();