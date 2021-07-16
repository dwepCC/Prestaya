<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['caja']==1){ 
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Depósito de plazo fijo</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Titular</th>
                                        <th>Nombre</th>
                                        <th>Número</th>
                                        <th>Saldo</th>
                                        <th>Registro</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Titular</th>
                                        <th>Nombre</th>
                                        <th>Número</th>
                                        <th>Saldo</th>
                                        <th>Registro</th>
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
    </section>
</div>

 
<!--modal para agregar nuevo cliente-->
<div class="modal fade" id="modalAhorro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloAhorro"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <div class="modal-body">
                <form action="" name="formulario" id="formulario" method="POST">
                    <div class="row">

                        <div class="form-group col-lg-8 col-md-8 col-xs-12">
                            <label for="">Cliente(*):</label>
                            <input class="form-control" type="hidden" name="idcuenta" id="idcuenta">
                            <input class="form-control" type="hidden" name="interes" id="interes">
                            <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                            <input class="form-control" type="hidden" name="plazo" id="plazo" >
                            <input class="form-control" type="hidden" name="tipo_mov" id="tipo_mov">
                            <input class="form-control" type="hidden" name="tipoCuenta" id="tipoCuenta" value="2">
                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                id="clienteNombre" readonly>

                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                            <label for="">Cantidad(*):</label>
                            <input class="form-control" type="number" name="total" id="total" step="0.01" required>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                    class="fa fa-arrow-circle-left"></i>
                                Cancelar</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/dplazo.js"></script>
<?php
 }
  ob_end_flush();
  ?>