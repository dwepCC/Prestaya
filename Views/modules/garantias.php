<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['prestamos']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Artículos en garantía</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Devolución</th>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Codigo</th>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>Avaluo</th>
                                        <th>Prestamo</th>
                                        <th>Crédito</th>
                                    </thead>
                                    <tbody> 
                                    </tbody>
                                    <tfoot>
                                        <th>Devolución</th>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Codigo</th>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>Avaluo</th>
                                        <th>Prestamo</th>
                                        <th>Crédito</th>
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
<script src="Views/modules/scripts/garantias.js"></script>
<?php
 }
  ob_end_flush();
  ?>