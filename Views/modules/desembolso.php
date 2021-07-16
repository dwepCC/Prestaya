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

    if($_SESSION['desembolsaCredito']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="box-title">Créditos para desembolsar</h4>

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


<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/desembolso.js"></script>
<?php
 }
  ob_end_flush();
  ?>