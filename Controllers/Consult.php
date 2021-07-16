<?php
require_once "../Models/Consult.php";
if (strlen(session_id())<1) 
	session_start();

$consult = new Consult();

switch ($_GET["op"]) {


    case 'comprasfecha':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $idusuario=$_SESSION['idusuario'];  

		$rspta=$consult->comprasfecha($fecha_inicio,$fecha_fin);
		$data=Array();

		foreach($rspta as $reg){
			$data[]=array(
            "0"=>$reg['fecha'],
            "1"=>$reg['usuario'],
            "2"=>$reg['proveedor'],
            "3"=>$reg['tipo_comprobante'],
            "4"=>$reg['serie_comprobante'].' '.$reg['num_comprobante'],
            "5"=>$reg['total_compra'],
            "6"=>$reg['impuesto'],
            "7"=>($reg['estado']=='Aceptado')?'<div class="badge badge-success">Aceptado</div>':'<div class="badge badge-danger">Anulado</div>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
		break;

     case 'ventasfechacliente':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $idcliente=$_REQUEST["idcliente"];

        $rspta=$consult->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
        $data=Array();

        foreach($rspta as $reg){
            $data[]=array(
            "0"=>$reg['fecha'],
            "1"=>$reg['usuario'],
            "2"=>$reg['cliente'],
            "3"=>$reg['tipo_comprobante'],
            "4"=>$reg['serie_comprobante'].' '.$reg['num_comprobante'],
            "5"=>$reg['total_venta'],
            "6"=>$reg['impuesto'],
            "7"=>($reg['estado']=='Aceptado')?'<div class="badge badge-success">Aceptado</div>':'<div class="badge badge-danger">Anulado</div>'
              );
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
        echo json_encode($results);
        break;

        case 'listaventasarticulos':
          $fecha_inicio=$_REQUEST["fecha_inicio"];
          $fecha_fin=$_REQUEST["fecha_fin"];
          $rspta=$consult->listaventasarticulos($fecha_inicio,$fecha_fin);
          $data=Array();
              $item=1;
          foreach ($rspta as $reg) {

            $data[]=array(
            "0"=>$item++,
            "1"=>$reg['codigo'],
            "2"=>$reg['articulo'],
            "3"=>$reg['cantidad'],
            "4"=>$reg['subtotal']
              );
          }
          $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
          echo json_encode($results);
          break;

        case 'listacomprasarticulos':
          $fecha_inicio=$_REQUEST["fecha_inicio"];
          $fecha_fin=$_REQUEST["fecha_fin"];
          $rspta=$consult->listacomprasarticulos($fecha_inicio,$fecha_fin);
          $data=Array();
              $item=1;
          foreach ($rspta as $reg) {

            $data[]=array(
            "0"=>$item++,
            "1"=>$reg['codigo'],
            "2"=>$reg['articulo'],
            "3"=>$reg['cantidad'],
            "4"=>$reg['subtotal']
              );
          }
          $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
          echo json_encode($results);
          break;

     case 'kardex':
        $idarticulo=$_REQUEST["idarticulo"];

        $rspta=$consult->kardex_ingreso($idarticulo);
        if(empty($rspta)){
          $sotck=0;
        }else{
         // $sotck=$rspta[0]['cantidad'];
        }
?>
        <table border="1" id="tbllistado" class="table table-striped table-hover text-nowrap text-center"
            style="width:100%;">
            <thead>
                <tr>
                    <th colspan="2">Existencia actual: <?php  //echo $sotck;?></th>
                    <th style="background:#F3F781;" colspan="3">Entrada</th>
                    <th style="background:#F3E2A9;" colspan="3">Salida</th>
                    <th style="background:#D0F5A9;" colspan="3">Existente</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th style="background:#F2F5A9;">Cantidad</th>
                    <th style="background:#F2F5A9;">Costo Unitario</th>
                    <th style="background:#F2F5A9;">Total</th>
                    <th style="background:#F5ECCE;">Cantidad</th>
                    <th style="background:#F5ECCE;">Costo Unitario</th>
                    <th style="background:#F5ECCE;">Total</th>
                    <th style="background:#ECF6CE;">Cantidad</th>
                    <th style="background:#ECF6CE;">Costo Unitario</th>
                    <th style="background:#ECF6CE;">Total</th>
                </tr>
            </thead>
            <tbody>

              <?php
              foreach($rspta as $reg){
                //$sotck=$reg['cantidad'];
                //number_format($número, 2, ',', ' ');
                ?>
                <tr>
                  <td><?php echo $reg['fecha'];?></td>
                  <td><?php echo $reg['detalle'];?></td>
                  <td style="background:#F2F5A9;"><?php echo ($reg['cantidadi']>0)?$reg['cantidadi']:' ';?></td>
                  <td style="background:#F2F5A9;"><?php echo ($reg['costoui']>0)?$reg['costoui']:'';?></td>
                  <td style="background:#F2F5A9;"><?php echo ($reg['totali']>0)?$reg['totali']:'';?></td>
                  <td style="background:#F5ECCE;"><?php echo ($reg['cantidads']>0)?$reg['cantidads']:'';?></td>
                  <td style="background:#F5ECCE;"><?php echo ($reg['costous']>0)?$reg['costous']:'';?></td>
                  <td style="background:#F5ECCE;"><?php echo ($reg['totals']>0)?$reg['totals']:'';?></td>
                  <td style="background:#ECF6CE;"><?php echo $reg['cantidadex'];//($reg['cantidadex']>0)?$reg['cantidadex']:'';?></td>
                  <td style="background:#ECF6CE;"><?php echo $reg['costouex'];//($reg['costouex']>0)?$reg['costouex']:'';?></td>
                  <td style="background:#ECF6CE;"><?php echo $reg['totalex'];//($reg['totalex']>0)?number_format($reg['totalex'],2,'.',','):'';?></td>
                </tr>
                <?php
              }
              ?>

            </tbody>
        </table>

                <script type="text/javascript">
            tabla=$('#tbllistado').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                  {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: "Exportar a Excel",
                    title: "kardex de inventario",
                    sheetName: "kardex"
                  },
                  {
                    extend: "pdfHtml5",
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: "Exportar a PDF",
                    title: "kardex de inventario",
                    //messageTop: "kardex de inventario",
                    pageSize: "A4",
                    orientation: 'landscape',
                  }
                    ],
              bDestroy: true,
      iDisplayLength: 20, //paginacion
      order: [[0, "desc"]], //ordenar (columna, orden)
                } );
        </script>
<?php

       /* $data=Array();

        foreach($rspta as $reg){
            $data[]=array(
            "0"=>$reg['idarticulo'],
            "1"=>date($reg['fecha_ingreso']),
            "2"=>$reg['comp_ingreso'],
            "3"=>$reg['cantidad_ingreso'],
            "4"=>$reg['costou_ingreso'],
            "5"=>$reg['total_compra'],
            "6"=>$reg['total_compra'],
            "7"=>$reg['total_compra']
              );
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
        echo json_encode($results);*/
        break;

}
 ?>