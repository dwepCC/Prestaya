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
            <form action="" name="formulario" id="formulario" method="POST">
                <div class="row">

                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h4>Buscar cliente</h4>
                            </div>
                            <div class="card-body">
                                <!--FORMULARIO PARA DE REGISTRO-->
                                <div id="formularioregistros">

                                    <div class="row">
                                        <div class="form-group col-lg-8 col-md-8 col-xs-12">
                                            <label for="">Ingrese numero de documento(*):</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="text"
                                                    name="numDocumento" id="numDocumento" autofocus>
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
                                            <input type="hidden" name="idventa" id="idventa">
                                            <input type="hidden" name="idcliente" id="idcliente">
                                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                                id="clienteNombre" readonly>
                                            <input type="hidden" value="Amortizacion de crédito" name="glosa"
                                                id="glosa">
                                            <input type="hidden" name="tipo_mov" id="tipo_mov" value="1">

                                        </div>




                                        <div class="form-group  col-lg-12 col-md-12 col-xs-12">
                                            <!--centro-->
                                            <div id="divMostrarCreditos"></div>
                                            <table id="tblCronograma"
                                                class="table table-responsive table-striped table-bordered table-condensed table-hover text-nowrap">
                                                <thead>
                                                    <th>N°</th>
                                                    <th>Num Cuota</th>
                                                    <th>Fecha de pago</th>
                                                    <th>Interes</th>
                                                    <th>Capital</th>
                                                    <th>Cuota</th>
                                                    <th>Saldo Capital</th>
                                                </thead>
                                                <tbody id="crono">



                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--FORMULARIO PARA DE REGISTRO FIN-->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-xs-12">

                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h4>Operaciones de credito</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Tipos de pago</label>
                                            <ul>
                                                <li>
                                                    <label for=""></label>
                                                    <input type="radio" name="tipoPagoCredito" id="tipoPagoCredito1"
                                                        value="1">
                                                    Normal
                                                </li>
                                                <!--<li>
                                                <label for=""></label>
                                                <input type="radio" name="tipoPagoCredito" id="tipoPagoCredito2"
                                                    value="2">
                                                Parcial
                                            </li>-->
                                                <li>
                                                    <label for=""></label>
                                                    <input type="radio" name="tipoPagoCredito" id="tipoPagoCredito3"
                                                        value="3">
                                                    N° cuotas adelanto
                                                </li>
                                                <li>
                                                    <label for=""> </label>
                                                    <input type="radio" name="tipoPagoCredito" id="tipoPagoCredito4"
                                                        value="4">
                                                    Cancelación

                                                </li>
                                            </ul>

                                        </div>

                                        <div class="form-group col-lg-5 col-md-5 col-xs-12">
                                            <label for="">Total a cobrar(*): </label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="number"
                                                    name="totalPagoCredito" id="totalPagoCredito" required readonly>
                                                <div class="input-group-prepend">

                                                    <button class="btn btn-info btn-sm" type="button"
                                                        id="btnTotalPagar"><i class="fas fa-calculator"></i> Mostrar
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="divParcial">
                                                <label for="">Monto(*):</label>
                                                <input class="form-control form-control-sm" type="number"
                                                    name="pagoParcial" id="pagoParcial">
                                            </div>
                                            <div id="divNumCuotas">
                                                <label for="">N° cuotas(*)</label>:
                                                <input class="form-control form-control-sm" type="number"
                                                    name="pagoNumCuotas" id="pagoNumCuotas">
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-success" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>
                                            <a href="cuadrecaja"><button class="btn btn-danger" type="button"
                                                    id="btnCancelar"><i class="fa fa-arrow-circle-left"></i>
                                                    Cancelar</button></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h4>Opciones de credito</h4>
                                </div>
                                <div class="card-body">

                                    <div class="row" id="divMostrarOpciones">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </section>

</div>
<?php
    }else{
        require "access.php";
    }
require "footer.php";
?>
<script src="Views/modules/scripts/pagocredito.js"></script>
<?php
 }
  ob_end_flush();
  ?>