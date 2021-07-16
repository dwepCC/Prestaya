<?php
require_once "../Models/Consult.php";
if (strlen(session_id())<1) 
	session_start();

$consult = new Consult();

switch ($_GET["op"]) {

	
	case 'interesCartera':
    $tipo=$_REQUEST['tipo'];
    $fecha=$_REQUEST['fecha'];
		$rspta=$consult->interesCartera($tipo,$fecha);
		echo json_encode($rspta);
		break;
}