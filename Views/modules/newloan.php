<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['generaSolicitudCredito']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <form action="" name="formulario" id="formulario" method="POST">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h4>Registro de préstamo</h4>
                            </div>
                            <div class="card-body">
                                <!--FORMULARIO PARA DE REGISTRO-->
                                <div id="formularioregistros">

                                    <div class="row">
                                        <div class="form-group col-lg-8 col-md-8 col-xs-12">
                                            <label for="">Ingrese numero de documento(*):</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="text"
                                                    name="numDocumento" id="numDocumento">
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
                                            <input class="form-control form-control-sm" type="text"
                                                name="clienteDocumento" id="clienteDocumento" readonly>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="">Cliente(*):</label>
                                            <input class="form-control" type="hidden" name="idventa" id="idventa">
                                            <input class="form-control" type="hidden" name="idcliente" id="idcliente">
                                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                                id="clienteNombre" readonly>
                                            <input class="form-control" type="hidden" name="tipo_venta" id="tipo_venta"
                                                value="1">

                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Forma de pago(*):</label>
                                            <select name="tipo_credito" id="tipo_credito"
                                                class="form-control form-control-sm" required>
                                                <option value="">Seleccione...</option>
                                                <option value="DIARIO">Diario</option>
                                                <option value="MENSUAL">Mensual</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Inicio pago(*): </label>
                                            <input class="form-control" type="date" name="fechaInicioPago"
                                                id="fechaInicioPago">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Monto(*): </label>
                                            <input class="form-control" type="number" name="capital" step="0.01" id="capital"
                                                required>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Plazo(*): </label>
                                            <input class="form-control" type="number" name="cantidad_cuotas"
                                                id="cantidad_cuotas" required>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label>Interes(*)</label>
                                            <div class="input-group">
                                                <input class="form-control" type="number" step="0.001"
                                                    name="tasa_interes" id="tasa_interes" required value="0">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-percent"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label>Cronograma</label><br>
                                            <button class="btn btn-info" type="button" id="btnCalcular"
                                                onclick="generarCronograma();"><i class="fas fa-calculator"></i> Generar
                                            </button>
                                        </div>

                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-success" type="submit" id="btnGuardar"><i
                                                class="fa fa-save"></i> Guardar</button>
                                        <a href="listsales"><button class="btn btn-danger" type="button"
                                                id="btnCancelar"><i class="fa fa-arrow-circle-left"></i>
                                                Cancelar</button></a>
                                    </div>
                                </div>

                            </div>
                            <!--FORMULARIO PARA DE REGISTRO FIN-->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h4>Cronograma</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group  col-lg-12 col-md-12 col-xs-12">
                                        <!--centro-->
                                        <table id="tblCronograma"
                                            class="table table-striped table-bordered table-condensed table-hover">
                                            <thead class="bg-aqua">
                                                <th>N°</th>
                                                <th>Vencimiento</th>
                                                <th>Interes</th>
                                                <th>Capital</th>
                                                <th>Cuota</th>
                                                <th>Saldo Capital</th>
                                            </thead>
                                            <tfoot style="background-color:#A9D0F5">

                                            </tfoot>
                                            <tbody id="crono">



                                            </tbody>
                                        </table>


                                    </div>
                                </div>

                                <!--FORMULARIO PARA DE REGISTRO-->

                                <!--FORMULARIO PARA DE REGISTRO FIN-->

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</div>
<?php
    }else{
        require "access.php";
    }
require "footer.php";
?>
<script src="Views/modules/scripts/newloan.js"></script>
<?php
 }
  ob_end_flush();
  ?>