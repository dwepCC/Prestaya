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
                            <h4>Consulta de Ventas por Fecha</h4>
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
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Cliente</label>
                                        <select name="idcliente" id="idcliente" class="form-control selectpicker"
                                            data-live-search="true" required>
                                        </select>
                                        <br>
                                        <button class="btn btn-success" onclick="listar()">
                                            Mostrar</button>
                                    </div>
                                </div>
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Comprobante</th>
                                        <th>Número</th>
                                        <th>Total Ventas</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Proveedor</th>
                                        <th>Comprobante</th>
                                        <th>Número</th>
                                        <th>Total Compra</th>
                                        <th>Impuesto</th>
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
</div>
</section>
</div>
<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/clientdatesales.js"></script>
<?php
 }
  ob_end_flush();
  ?>