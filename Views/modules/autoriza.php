<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['autorizaCredito']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="box-title">Créditos para ser autorizados</h4>

                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>N° credito</th>
                                        <th>Tipo credito</th>
                                        <th>Cuotas</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Monto credito</th>
                                        <th>Interés</th>
                                        <th>Total credito</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>N° credito</th>
                                        <th>Tipo credito</th>
                                        <th>Cuotas</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Monto credito</th>
                                        <th>Interés</th>
                                        <th>Total credito</th>
                                        <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<!--MODALES-->
<!--MODAL PARA VER EL INGRESO-->

<div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Elija el tipo de credito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <a href="newsale"> <button class="btn btn-info"><i class="fas fa-money-check-alt"></i>
                                Empeño</button></a>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">

                        <a href="newloan"> <button class="btn btn-success"><i class="fas fa-money-check-alt"></i>
                                Normal</button></a>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL PARA VER EL INGRESO-->
<!--FIN MODALES-->
<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/autoriza.js"></script>
<?php
 }
  ob_end_flush();
  ?>