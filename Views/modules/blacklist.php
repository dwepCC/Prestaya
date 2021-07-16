<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['clientes']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lista negra de clientes</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>F. Registro</th>
                                        <th>Nombre</th>
                                        <th>Doc.</th>
                                        <th>Numero</th>
                                        <th>F. Nacimiento</th>
                                        <th>Sexo</th>
                                        <th>Telefono</th>
                                        <th>Dirección</th>
                                        <th>Email</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>F. Registro</th>
                                        <th>Nombre</th>
                                        <th>Doc.</th>
                                        <th>Numero</th>
                                        <th>F. Nacimiento</th>
                                        <th>Sexo</th>
                                        <th>Telefono</th>
                                        <th>Dirección</th>
                                        <th>Email</th>
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
<script src="Views/modules/scripts/blacklist.js"></script>
<?php
 }
  ob_end_flush();
  ?>