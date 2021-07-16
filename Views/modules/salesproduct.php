<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['almacen']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Consulta de Venta de artículos por Fecha</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <label>Fecha Inicio</label>
                                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio"
                                            value="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <label>Fecha Fin</label>
                                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin"
                                            value="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                </div>
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/salesproduct.js"></script>
<?php
 }
  ob_end_flush();
  ?>