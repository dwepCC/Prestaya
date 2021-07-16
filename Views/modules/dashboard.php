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

                <!--SALDO CAJA-->
<?php if($_SESSION['cargo'] =='Caja'){?> 
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="saldoCaja"></span>
                                    </h6>
                                    <span class="text-muted">Saldo Caja</span>
                                </div>
                            </div>
                        </div>
                        <a href="cuadrecaja">
                            <div class="l-bg-orange">
                                Caja
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

<?php 
}
if($_SESSION['cargo'] =='Administrador'){?>
                <!--SALDO BOVEDA-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="saldoBoveda"></span>
                                    </h6>
                                    <span class="text-muted">Saldo Boveda</span>
                                </div>
                            </div>
                        </div>
                        <a href="enrep">
                            <div class="l-bg-orange">
                                Boveda
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

                <!--COMPRAS-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tcomprahoy"></span>
                                    </h6>
                                    <span class="text-muted">Artículos</span>
                                </div>
                            </div>
                        </div>
                        <a href="product">
                            <div class="l-bg-orange">
                                Artículos
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!--VENTAS-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tventahoy"></span>
                                    </h6>
                                    <span class="text-muted">Total desembolso</span>
                                </div>
                            </div>
                        </div>
                        <a href="listsales">
                            <div class="l-bg-orange">
                                Creditos
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="totalCreditos"></span>
                                    </h6>
                                    <span class="text-muted">Total Créditos</span>
                                </div>
                            </div>
                        </div>
                        <a href="listsales">
                            <div class="l-bg-orange">
                                Total Créditos
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!--COMPRAS-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tahorro"></span>
                                    </h6>
                                    <span class="text-muted">Ahorro libre</span>
                                </div>
                            </div>
                        </div>
                        <a href="ahorro">
                            <div class="l-bg-orange">
                                Ahorros
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!--COMPRAS-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tplazofijo"></span>
                                    </h6>
                                    <span class="text-muted">Plazo fijo</span>
                                </div>
                            </div>
                        </div>
                        <a href="plazofijo">
                            <div class="l-bg-orange">
                                Plazo fijo
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>


                <!--CLIENTES-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tclientes"></span>
                                    </h6>
                                    <span class="text-muted">Clientes</span>
                                </div>
                            </div>
                        </div>
                        <a href="customer">
                            <div class="l-bg-orange">
                                Clientes
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <!--PROVEEDORES-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="small-box card card-statistic-1">
                        <div class="card-icon l-bg-orange">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="padding-20">
                                <div class="text-right">
                                    <h6 class="font-light mb-0">
                                        <i class="ti-arrow-up text-success"></i><span id="tproveedores"></span>
                                    </h6>
                                    <span class="text-muted">Proveedores</span>
                                </div>
                            </div>
                        </div>
                        <a href="supplier">
                            <div class="l-bg-orange">
                                Proveedores
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div> 
                </div>
                <!--CATEGORIAS-->
                <!--<div class="col-xl-6 col-lg-12">
                    <div class="card l-bg-orange">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-file-alt"></i></div>
                            <div class="card-content">
                                <h4 class="card-title"><span id="tcategorias"></span></h4>
                                <p class="mb-0 text-sm">
                                    <span class="text-nowrap">Categorias</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>-->

                <!--ALMACEN-->
                <!--<div class="col-xl-6 col-lg-12">
                    <div class="card l-bg-orange">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-grip-horizontal"></i></div>
                            <div class="card-content">
                                <h4 class="card-title"><span id="tarticulos"></span></h4>

                                <p class="mb-0 text-sm">
                                    <span class="text-nowrap">Artículos</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>-->

                <!--BARRAS COMPRAS 10 ULTIMOS DIAS-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Desembolso en los ultimos 10 dias</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="compra10dias"></canvas>
                        </div>
                    </div>
                </div>
                <!--BARRAS VENTAS 12 ULTIMOS MESES-->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Desembolso en los ultimos 12 meses</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="venta12meses"></canvas>
                        </div>
                    </div>
                </div>
      <!--GRAFICA VENTAS-->
    <div class="col-lg-12 col-md-12 col-xs-12">

         <div class="card card-primary">

               <div class="card-body">

                  <div id="cat_mas_vendidas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

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
<script src="Assets/bundles/highcharts/highcharts.js"></script>

<script src="Assets/bundles/chartjs/chart.min.js"></script>

<script src="Views/modules/scripts/dashboard.js"></script>

<?php
 }
  ob_end_flush();
  ?>