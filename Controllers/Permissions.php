 <?php 
require_once "../Models/Permissions.php";

$permissions=new Permissions();


switch ($_GET["op"]) {
	
    case 'listar':
		$rspta=$permissions->listar();
		$data=Array();

		foreach ($rspta as $reg) {
			$data[]=array(
            
            "0"=>$reg['nombre']
            
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
}
 ?>