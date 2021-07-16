            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html"> <img alt="image" src="Assets/img/logo.png" class="header-logo" /> <span
                                class="logo-name">Crediges</span>
                        </a>
                    </div>
                    <!--<div class="sidebar-user">
                        <div class="sidebar-user-picture">
                            <img alt="image" src="Assets/img/users/<?php //echo $_SESSION['imagen']; ?>" class="mr-3 user-img-radious-style user-list-img">
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name"><?php //echo $_SESSION['nombre']; ?></div>
                            <div class="user-role"><?php //echo $_SESSION['cargo'];?></div>
                        </div>
                    </div>-->
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menú</li>
                            <?php if($_SESSION['dashboard']==1) {
                                $cd='';
                              ($_GET['url']=='dashboard')?$cd='active':' ';?>
                                <li class="<?php echo $cd;?>"><a class="nav-link" href="dashboard"><i data-feather="monitor"></i><span>Escritorio</span></a></li>
                            <?php }
                            if($_SESSION['caja']==1){ ?>  
                        <li class="dropdown ">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="dollar-sign"></i><span>Caja</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="cuadrecaja">Cuadre de caja</a></li>
                                <li><a class="nav-link" href="pagocredito">Pago de creditos</a></li>      
                                <li><a class="nav-link" href="desembolso">Desembolso de credito</a></li>
                                <li><a class="nav-link" href="dpahorro">Ahorro libre</a></li>
                                <li><a class="nav-link" href="dplazo">Plazo fijo</a></li>
                                <li><a class="nav-link" href="ingreso">Ingreso</a></li>
                                <li><a class="nav-link" href="egreso">Egreso</a></li>
                            </ul>
                        </li>
                        <?php }
                        if($_SESSION['prestamos']==1){
                            ?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="shopping-cart"></i><span>Créditos</span></a>
                            <ul class="dropdown-menu">
                            <?php 
                            if($_SESSION['autorizaCredito']==1){
                                ?>
                                <li><a class="nav-link" href="autoriza">Autorizar creditos</a></li>
                            <?php
                            }
                             ?>
                                <li><a class="nav-link" href="listsales">Créditos</a></li>
                                <li><a class="nav-link" href="garantias">Garantías</a></li>
                            </ul>
                        </li>
                        <?php }
                        if($_SESSION['ahorros']==1){
                            ?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="file-plus"></i><span>Ahorros</span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a class="nav-link" href="cuenta">Cuenta de ahorros</a></li>-->
                                <li><a class="nav-link" href="ahorro">Ahorro libre</a></li>
                                <li><a class="nav-link" href="plazofijo">Ahorro plazo fijo</a></li>
                            </ul>
                        </li>
                        <?php }
                        if($_SESSION['clientes']==1){
?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="users"></i><span>Personas</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="customer">Clientes</a></li>
                                <li><a class="nav-link" href="supplier">Proveedores</a></li>
                                <li><a class="nav-link" href="blacklist">Lista negra</a></li>
                            </ul>
                        </li>
                        <?php }
                         if($_SESSION['compras']==1){
                          ?>
                       <!-- <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i
                                    data-feather="shopping-bag"></i><span>Compras</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="buy">Ingresos</a></li>
                                 <li><a class="nav-link" href="supplier">Proveedores</a></li>
                            </ul>
                        </li>-->
                        <?php }
                        if($_SESSION['almacen']==1){
                           ?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i
                                    data-feather="layers"></i><span>Almacen</span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a class="nav-link" href="agarantia">Empeñados</a></li>-->
                                <li><a class="nav-link" href="product">Artículos</a></li>
                                <li><a class="nav-link" href="aventa">En venta</a></li>
                                <li><a class="nav-link" href="category">Categorías</a></li>
                                <!--<li><a class="nav-link" href="kardex">Kardex</a></li>-->
                            </ul>
                        </li>
                        <?php }
                        if($_SESSION['sistema']==1){  
?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="users"></i><span>Sistema</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="enrep">Envio/Recepcion Caja</a></li>
                                <li><a class="nav-link" href="henrep">Historial</a></li>
                                <li><a class="nav-link" href="estadof">EEFF</a></li>
                            </ul>
                        </li>
                        <?php }
                         if($_SESSION['users']==1){
                           ?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="users"></i><span>Usuarios</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="users">Usuarios</a></li>
                                <li><a class="nav-link" href="permissions">Permisos</a></li>
                            </ul>
                        </li>
                        <?php }
                        if($_SESSION['settings']==1){
                          ?>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i data-feather="settings"></i><span>Configuración</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="generalsetting">Datos generales</a></li>
                                <li><a class="nav-link" href="vouchersetting">Tipo de créditos</a></li>
                                <li><a class="nav-link" href="paymentstype">Tipos de pago</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li class="menu-header">Reportes</li>
                        <?php ($_GET['url']=='graphics')?$cg='active':'';?>
                        <li class="<?php echo $cg;?>"><a class="nav-link" href="#"><i data-feather="grid"></i><span>Gráficos</span></a></li>
                        <?php if($_SESSION['datebuy']==1){
                            $cdb=''; 
                              ($_GET['url']=='datebuy' ||$_GET['url']=='purchaseproduct')?$cdb='active':'';?>
                        <li class="dropdown <?php echo $cdb;?>">
                            <a href="#" class="nav-link has-dropdown"><i
                                    data-feather="shopping-bag"></i><span>Consulta de creditos</span></a>
                            <ul class="dropdown-menu">
                               <!-- <li><a class="nav-link" href="datebuy">Compras por fechas</a></li>
                                <li><a class="nav-link" href="purchaseproduct">Compras articulos</a></li>-->
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if($_SESSION['clientdatesales']==1){
                            $ccds=''; 
                              ($_GET['url']=='clientdatesales' ||$_GET['url']=='salesproduct')?$ccds='active':'';?>
                        <li class="dropdown <?php echo $ccds; ?>">
                            <a href="#" class="nav-link has-dropdown"><i
                                    data-feather="layout"></i><span>Consulta de articulos</span></a>
                            <ul class="dropdown-menu">
                               <!-- <li><a class="nav-link" href="clientdatesales">Consulta Ventas</a></li>
                                <li><a class="nav-link" href="salesproduct">Ventas articulo</a></li>-->
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a class="nav-link" href="#"><i data-feather="grid"></i><span>Ayuda</span></a></li>
                    </ul>
                </aside>
            </div>