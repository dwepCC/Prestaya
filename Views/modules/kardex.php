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
                            <h4><i class="fa fa-list"></i> Kardex de inventario</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Seleccione producto</label>
                                        <select name="idarticulo" id="idarticulo" class="form-control selectpicker"
                                            data-live-search="true" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Buscar</label>
                                        <br>
                                        <button class="btn btn-success" onclick="listar()">
                                            Mostrar</button>
                                    </div>
                                </div>
                                <div id="tbl"></div>
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
<script src="Assets/js/jquery.PrintArea.js"></script>
<script src="Views/modules/scripts/kardex.js"></script>
<?php
 }
  ob_end_flush();
  ?>