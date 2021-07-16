<?php
date_default_timezone_set('America/Lima');
require_once "../Models/Ahorro.php";
if (strlen(session_id())<1) 
	session_start();

$ahorro=new Ahorro();   

$idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$idcuenta=isset($_POST["idcuenta"])? $_POST["idcuenta"]:"";
$cantidad=isset($_POST["total"])? $_POST["total"]:"";
$interes=isset($_POST["interes"])? $_POST["interes"]:"";
$plazo=isset($_POST["plazo"])? $_POST["plazo"]:"";
$fecha_reg = date("Y-m-d");
$hora_reg=date("H:i:s");
$idusuario=$_SESSION["idusuario"];  
$idoficina=$_SESSION["idoficina"];
$tipo_mov=isset($_POST["tipo_mov"])? $_POST["tipo_mov"]:"";

$tipoahorro=isset($_POST["tipoCuenta"])? $_POST["tipoCuenta"]:"";

switch ($_GET["op"]) { 
	case 'guardaryeditar':
        if($tipo_mov=='1'){
                $rspta=$ahorro->ingresoAhorro($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$fecha_reg,$hora_reg,$idusuario,$idoficina); 
                echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
            //echo $rspta;
        }elseif($tipo_mov=='2'){
                $rspta=$ahorro->retiroAhorro($idpersona,$idcuenta,$tipoahorro,$cantidad,$interes,$plazo,$fecha_reg,$hora_reg,$idusuario,$idoficina);
                echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";    
        }
		break;
	

}
