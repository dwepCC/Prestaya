<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['sistema']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Historial de envio/ Recepcion de dinero
                            </h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>#</th>
                                        <th>Nombre emisor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Nombre receptor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>#</th>
                                        <th>Nombre emisor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Nombre receptor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
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
<script src="Views/modules/scripts/henrep.js"></script>
<?php
 }
  ob_end_flush();
  ?>