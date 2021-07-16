<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['ahorros']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ahorros plazo fijo <button class="btn btn-success" onclick="mostrarform(true)"
                                    id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>#</th>
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
                                        <th>#</th>
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

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="row">

                                        <div class="form-group col-lg-8 col-md-8 col-xs-12">
                                            <label for="">Ingrese numero de documento(*):</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="text" name="numDocumento"
                                                    id="numDocumento">
                                                <div class="input-group-prepend">
                                                    <!--<div class="input-group-text">-->
                                                    <button class="btn btn-success btn-sm" type="button"
                                                        onclick="buscarCliente()"><i class="fas fa-search"></i>
                                                        Buscar...</button>
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-6">
                                            <label for="">N° Documento(*):</label>
                                            <input class="form-control form-control-sm" type="text" name="clienteDocumento"
                                                id="clienteDocumento" readonly>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Cliente(*):</label>
                                            <input class="form-control" type="hidden" name="idcuenta" id="idcuenta">
                                            <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                                            <input class="form-control" type="hidden" name="tipoCuenta" id="tipoCuenta" value="2">
                                            <input class="form-control" type="hidden" name="total" id="total">
                                            <input class="form-control" type="hidden" name="cuentaSaldo" id="cuentaSaldo">
                                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                                id="clienteNombre" readonly>

                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Cuenta(*):</label>
                                            <select name="cuentaNombre" id="cuentaNombre" class="form-control" required>
                                            <!--<option value="CUENTA LIBRE">Cuenta libre</option>-->
                                            <option value="CUENTA PLAZO FIJO">Plazo fijo</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Interes(*):</label>
                                            <input class="form-control" type="number" step="0.01" name="interes" id="interes" required>
                                        </div>   

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                        <label for="">Plazo(*):</label>
                                            <select name="plazo" id="plazo" class="form-control" required>
                                            <!--<option value="CUENTA LIBRE">Cuenta libre</option>-->
                                            <option value="360">1 AÑO</option>
                                            <option value="78">6 MESES</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Cantidad:</label>
                                            <input class="form-control" type="number" name="cantidad" id="cantidad">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Cantidad final:</label>
                                            <input class="form-control" type="text" name="cantidadFinal" id="cantidadFinal" readonly>
                                        </div>
                                        
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>

                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fa fa-arrow-circle-left"></i>
                                                Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--FORMULARIO PARA DE REGISTRO FIN-->
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
<script src="Views/modules/scripts/plazofijo.js"></script>
<?php
 }
  ob_end_flush();
  ?>