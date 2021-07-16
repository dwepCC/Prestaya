<?php 
session_start();
require_once "../Models/User.php";

$user=new User();

$idusuarioc=isset($_POST["idusuarioc"])? $idusuarioc=$_POST["idusuarioc"]:"";
$clavec=isset($_POST["clavec"])? $clavec=$_POST["clavec"]:"";
$idusuario=isset($_POST["idusuario"])? $idusuario=$_POST["idusuario"]:"";
$nombre=isset($_POST["nombre"])? $nombre=$_POST["nombre"]:"";
$tipo_documento=isset($_POST["tipo_documento"])? $tipo_documento=$_POST["tipo_documento"]:"";
$num_documento=isset($_POST["num_documento"])? $num_documento=$_POST["num_documento"]:"";
$direccion=isset($_POST["direccion"])? $direccion=$_POST["direccion"]:"";
$telefono=isset($_POST["telefono"])? $telefono=$_POST["telefono"]:"";
$email=isset($_POST["email"])? $email=$_POST["email"]:"";
$cargo=isset($_POST["cargo"])? $cargo=$_POST["cargo"]:"";
$login=isset($_POST["login"])? $login=$_POST["login"]:"";
$clave=isset($_POST["clave"])? $clave=$_POST["clave"]:"";
$imagen=isset($_POST["imagen"])? $imagen=$_POST["imagen"]:"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
		{
			$imagen=$_POST["imagenactual"];
		}else
		{

			$ext=explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			 {

			   $imagen = round(microtime(true)).'.'. end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../Assets/img/users/" . $imagen);
		 	}
		}

		//Hash SHA256 para la contraseña
		$clavehash=hash("SHA256", $clave);

		if (empty($idusuario)) {
			$rspta=$user->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del user";
		}
		else {
			$rspta=$user->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$imagen,$_POST['permiso']);  
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
	break;
	

	case 'desactivar':
		$rspta=$user->desactivar($idusuario);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
	break;

	case 'activar':
		$rspta=$user->activar($idusuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
	break;
	
	case 'mostrar':
		$rspta=$user->mostrar($idusuario);
		echo json_encode($rspta);
	break;

	case 'editar_clave':
		$clavehash=hash("SHA256", $clavec);

		$rspta=$user->editar_clave($idusuarioc,$clavehash);
		echo $rspta ? "Password actualizado correctamente" : "No se pudo actualizar el password";
	break;

	case 'mostrar_clave':
		$rspta=$user->mostrar_clave($idusuario);
		echo json_encode($rspta);
	break;
	
	case 'listar':
		$rspta=$user->listar();
		//declaramos un array
		$data=Array();

			foreach ($rspta as $reg) {

			$data[]=array(
				"0"=>($reg['condicion'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idusuario'].')"><i class="fas fa-user-edit"></i></button>'.' '.'<button class="btn btn-info btn-sm" onclick="mostrar_clave('.$reg['idusuario'].')"><i class="fas fa-key"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg['idusuario'].')"><i class="fas fa-user-times"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['idusuario'].')"><i class="fas fa-user-edit"></i></button>'.' '.'<button class="btn btn-info btn-sm" onclick="mostrar_clave('.$reg['idusuario'].')"><i class="fas fa-key"></i></button>'.' '.'<button class="btn btn-success btn-sm" onclick="activar('.$reg['idusuario'].')"><i class="fas fa-user-check"></i></button>',
				"1"=>$reg['nombre'],
				"2"=>$reg['tipo_documento'],
				"3"=>$reg['num_documento'],
				"4"=>$reg['telefono'],
				"5"=>$reg['email'],
				"6"=>$reg['login'],
				"7"=>"<img alt='image' src='Assets/img/users/".$reg['imagen']."' height='50px' width='50px'>",
				"8"=>($reg['condicion'])?'<div class="badge badge-success">Activo</div>':'<div class="badge badge-danger">Inactivo</div>'
				);
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

	break;

	case 'permisos':
		//obtenemos toodos los permisos de la tabla permisos
		require_once "../Models/Permiso.php";
		$permiso=new Permiso();
		$rspta=$permiso->listar();

		//obtener permisos asigandos
		$id=$_GET['id'];
		$marcados=$user->listarmarcados($id);
		//declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//almacenar permisos asigandos
					$valores=array();
			foreach ($marcados as $per) {
				array_push($valores,$per['idpermiso']);
			}
		//mostramos la lista de permisos
		foreach ($rspta as $reg) {
			$sw=in_array($reg['idpermiso'],$valores)?'checked':'';
			echo '<li><input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg['idpermiso'].'">'.$reg['nombre'].'</li>';
		}

	break;

	case 'verificar':

		$logina=isset($_POST["nombre"])? $clave=$_POST["nombre"]:"";
		$clavea=isset($_POST["clave"])? $clave=$_POST["clave"]:"";

		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256", $clavea); 
	
		$rspta=$user->verificar($logina, $clavehash);
$result=$rspta;
if($rspta==false){
	$result=0;
}else{
	$result=1;
		if ($rspta) 
		{
			# Declaramos la variables de sesion
			$_SESSION['idusuario']=$rspta['idusuario'];
			$_SESSION['nombre']=$rspta['nombre'];
			$_SESSION['imagen']=$rspta['imagen'];
			$_SESSION['login']=$rspta['login'];
			$_SESSION['cargo']=$rspta['cargo'];
			$_SESSION['idoficina']=$rspta['idoficina'];
			$_SESSION['tipo']=$rspta['tipo'];

			//obtenemos los permisos
			$marcados = $user->listarmarcados($rspta['idusuario']);

			//declaramos el array para almacenar todos los permisos
			$valores=array();
			foreach ($marcados as $per) {
				array_push($valores,$per['idpermiso']);
			}


			//almacenamos los permisos marcados en al array
			//determinamos lo accesos al user
			in_array(1, $valores)?$_SESSION['dashboard']=1:$_SESSION['dashboard']=0;
			in_array(2, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
			in_array(3, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(4, $valores)?$_SESSION['prestamos']=1:$_SESSION['prestamos']=0;
			in_array(5, $valores)?$_SESSION['users']=1:$_SESSION['users']=0;
			in_array(6, $valores)?$_SESSION['datebuy']=1:$_SESSION['datebuy']=0;
			in_array(7, $valores)?$_SESSION['clientdatesales']=1:$_SESSION['clientdatesales']=0;
			in_array(8, $valores)?$_SESSION['settings']=1:$_SESSION['settings']=0;
			in_array(9, $valores)?$_SESSION['generaSolicitudCredito']=1:$_SESSION['generaSolicitudCredito']=0; 
			in_array(10, $valores)?$_SESSION['autorizaCredito']=1:$_SESSION['autorizaCredito']=0; 
			in_array(11, $valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
			in_array(12, $valores)?$_SESSION['desembolsaCredito']=1:$_SESSION['desembolsaCredito']=0; 
			in_array(13, $valores)?$_SESSION['clientes']=1:$_SESSION['clientes']=0;  
			in_array(14, $valores)?$_SESSION['cuentas']=1:$_SESSION['cuentas']=0;  
			in_array(15, $valores)?$_SESSION['ahorros']=1:$_SESSION['ahorros']=0;
			in_array(16, $valores)?$_SESSION['sistema']=1:$_SESSION['sistema']=0;

		} 
}
		echo $result; 
		
		require_once "../Models/Company.php";
		$company=new Company();
		  $rsptan = $company->listar();
	$regn=$rsptan[0];
	$_SESSION['nombreEmrpesa']=$regn['nombre'];
		$_SESSION['logoEmrpesa']=$regn['logo'];



	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;

	case 'selectUsuario': 
		$rspta=$user->select();
		echo '<option value="">Seleccione...</option>';
		foreach($rspta as $reg){
		//while ($reg=$rspta->fetch_object()) {
			echo '<option value="'. $reg['idusuario'].'">'.$reg['nombre'].'</option>';
		}
		break;
}
?>