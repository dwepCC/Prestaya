<?php 
//incluir la conexion de base de datos
require_once "Connect.php";
class Cuenta{

    private $tableName='cuenta_persona';
    private $conexion;

	//implementamos nuestro constructor
	public function __construct(){
		$this->conexion = new Conexion();
	} 

	//metodo insertar regiustro
    public function insertar($idpersona,$cuentaSaldo,$cuentaNombre,$interes,$plazo,$total,$fecha_reg,$hora_reg,$tipoCuenta){

        //NUMERO DE CUENTA
        $sql_vNumero="SELECT cuentaNumero FROM cuenta_persona WHERE cuenta=? ORDER BY id DESC limit 1";
        $arrData = array(1);
		$vNumero= $this->conexion->getData($sql_vNumero,$arrData);
        $cuentaNum = isset($vNumero['cuentaNumero'])? $cuentaNum=$vNumero['cuentaNumero']:$cuentaNum=0;

        if($cuentaNum>0){
            $numero = $cuentaNum+1;
            $digito_num = 7;
            $cuentaNumero = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }else{
            $numero = 1;
            $digito_num = 7;
            $cuentaNumero = substr(str_repeat(0, $digito_num).$numero, - $digito_num);
        }

        //REGISTRO DE DATOS
        $sql="INSERT INTO $this->tableName (idPersona,cuentaNumero,cuentaSaldo,cuentaNombre,interes,plazo,total,fechaRegistro,horaRegistro,tipoCuenta,cuenta,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($idpersona,$cuentaNumero,$cuentaSaldo,$cuentaNombre,$interes,$plazo,$total,$fecha_reg,$hora_reg,$tipoCuenta,1,1);
       return $this->conexion->setData($sql,$arrData);
//return $cuentaNumero;
    }

	public function desactivar($id){
		$sql="UPDATE $this->tableName SET estado='0' WHERE id=?";
		$arrData = array($id);
		return $this->conexion->setData($sql,$arrData);
	}
    
	public function activar($id){
		$sql="UPDATE $this->tableName SET estado='1' WHERE id=?";
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
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarAhorroPago(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='1'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarPlazoPago(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='2'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarAhorroSaldo(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='1'";
		return  $this->conexion->getDataAll($sql); 
	}

	//listar registros
	public function listarPlazoFijo(){
		$sql="SELECT cp.*,CONCAT(p.ap,' ',p.am,' ',p.nombre) AS titular FROM $this->tableName cp INNER JOIN persona p ON cp.idPersona=p.idpersona WHERE cp.tipoCuenta='2'";
		return  $this->conexion->getDataAll($sql); 
	}

public function buscarCuenta($idpersona){

        $sql="SELECT * FROM $this->tableName WHERE idPersona='$idpersona'";
        return  $this->conexion->getDataAll($sql); 

}

}

