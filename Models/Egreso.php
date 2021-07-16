<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Egreso{

    private $tableName='dev_egreso';
    private $tableNameAsiento='asiento';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion(); 
	}

	//metodo insertar regiustro
    public function insertar($idcuenta,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad,$fecha_reg,$idoficina,$idusuario){
        $sql="INSERT INTO $this->tableName (idcuenta,tipo,idpersona,tipo_comprobante,serie_comprobante,num_comprobante,descripcion,cantidad,fecha_reg,idoficina,idusuario,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idcuenta,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad,$fecha_reg,$idoficina,$idusuario,'0');
        return $this->conexion->setData($sql,$arrData);
    }

    public function editar($id,$idcuenta,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad){
	$sql="UPDATE $this->tableName SET idcuenta=?, tipo=?,idpersona=?,tipo_comprobante=?, serie_comprobante=?, num_comprobante=?, descripcion=?, cantidad=? WHERE id=?";
        $arrData = array($idcuenta,$tipo,$idpersona,$tipo_comprobante,$serie_comprobante,$num_comprobante,$descripcion,$cantidad,$id);
        return $this->conexion->setData($sql,$arrData);
    }
    
	public function anular($id){
		$sql="UPDATE $this->tableName SET estado='0' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}

	public function hacerPago($id,$idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario){
        $sw=true;
		$sql="UPDATE $this->tableName SET es_pagado='1' WHERE id=?";
		$arrData = array($id);
		$this->conexion->setData($sql,$arrData) or $sw=false;

        $sql_crono="INSERT INTO $this->tableNameAsiento (idoficina,glosa,idpersona,cantidad,fecha_reg,hora,idusuario,tipo_mov,cod_operacion,condicion) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrDatadet = array($idoficina,$descripcion,$idpersona,$cantidad,$fecha_reg,$hora,$idusuario,'2','1','1');
        $this->conexion->setData($sql_crono,$arrDatadet)or $sw=false;

		return $sw;
	}

	//metodo para mostrar registros
	public function mostrar(string $id){
		$sql="SELECT * FROM $this->tableName WHERE id=?";
		$arrData = array($id);
		return  $this->conexion->getData($sql,$arrData); 
	}

	//listar registros
	public function listar(){
		$sql="SELECT e.*, CONCAT(p.nombre,' ',p.ap,' ',p.am) AS titular FROM $this->tableName e INNER JOIN persona p ON e.idpersona=p.idpersona";
		return  $this->conexion->getDataAll($sql); 
	}

}

