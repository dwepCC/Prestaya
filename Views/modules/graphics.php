<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['dashboard']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <!-- add content here -->
            <div class="row">

                <!--GRAFICO DE COMPRAS-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafico de compras</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="compras_grafica"></canvas>
                        </div>
                    </div>
                </div>

                <!--GRAFICO DE VENTAS-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafico de ventas</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="ventas_grafica"></canvas>
                        </div>
                    </div>
                </div>

                <!--RESUMEN DE COMPRAS DEL AÑO-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resumen de compras del año <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="resumen_compras"></canvas>
                        </div>
                    </div>
                </div>
                <!--RESUMEN DE VENTAS DEL AÑO-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resumen de ventas del año <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="resumen_ventas"></canvas>
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
<!-- JS Libraies -->
<script src="Assets/bundles/chartjs/chart.min.js"></script>
<script src="Views/modules/scripts/graphics.js"></script>



<?php
 }
  ob_end_flush();
  ?>