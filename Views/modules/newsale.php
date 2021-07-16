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
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4>Registro de préstamo</h4>
                        </div>
                        <div class="card-body">
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

                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="">Cliente(*):</label>
                                            <input class="form-control" type="hidden" name="idventa" id="idventa">
                                            <input class="form-control" type="hidden" name="sotck" id="sotck" value="1">
                                            <input class="form-control" type="hidden" name="idcliente" id="idcliente">
                                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                                id="clienteNombre" readonly>
                                            <input class="form-control" type="hidden" name="tipo_venta" id="tipo_venta"
                                                value="1">

                                        </div>
                                        <div class="form-group  col-lg-12 col-md-12 col-xs-12">
                                                                                   
                                            <span>ARTICULOS EMPEÑADOS</span>
                                            <div class="table-responsive">
                                                <table id="detalles"
                                                    class="table text-center">
                                                    <thead>
                                                        <th>Articulo</th>
                                                        <th>Valor prestamos</th>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div
                                                style="background-color:#A9D0F5; height: 31px; border: #ffff 1px solid;">
                                                <label> MONTO PRESTAMO</label>
                                                <input type="hidden" step="0.001" name="total_avaluo" id="total_avaluo">
                                                <input type="hidden" step="0.001" name="capital" id="capital">
                                                <span id="most_total" class="pull-right badge badge-success">
                                                    0.00 </span>
                                            </div>

                                        </div> 

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Forma de pago(*):</label>
                                            <select name="tipo_credito" id="tipo_credito" class="form-control form-control-sm" required>
                                                <option value="">Seleccione...</option>
                                                <option value="DIARIO">Diario</option>
                                                <option value="MENSUAL">Mensual</option>
                                                <option value="PRENDARIO">Prendario</option>
                                            </select>
                                            
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Inicio pago: </label>
                                            <input class="form-control" type="date" name="fechaInicioPago"
                                                id="fechaInicioPago">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12" id="divFechaFinPago">
                                            <label for="">Fecha fin plazo: </label>
                                            <input class="form-control" type="date" name="fechaFinPago"
                                                id="fechaFinPago">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12" id="divPlazo">
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

                                        <div class="form-group  col-lg-12 col-md-12 col-xs-12">
                                            <hr>
                                            <span>CRONOGRAMA</span>
                                            <!--centro-->
                                            <table id="tblCronograma"
                                                class="table table-striped table-bordered table-condensed table-hover table-responsive">
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

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-success" type="submit" id="btnGuardar"><i
                                                class="fa fa-save"></i> Guardar</button>
                                        <a href="listsales"><button class="btn btn-danger" type="button"
                                                id="btnCancelar"><i class="fa fa-arrow-circle-left"></i>
                                                Cancelar</button></a>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <!--FORMULARIO PARA DE REGISTRO FIN-->
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4>Agrega un articulo</h4>
                        </div>
                        <div class="card-body">

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros_articulo">
                                <form action="" name="formularioArticulo" id="formularioArticulo" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Tipo de prenda(*):</label>
                                            <select name="tipo_articulo" id="tipo_articulo" class="form-control"
                                                required>
                                                <option value="">Seleccione...</option>
                                                <option value="1">Articulo</option>
                                                <option value="2">Joyas</option>
                                                <OPtion value="3">Vehículo</OPtion>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Categoria(*):</label>
                                            <select name="idcategoria" id="idcategoria" class="form-control"
                                                required></select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Nombre(*):</label>
                                            <input class="form-control" type="text" name="nombreArticulo"
                                                id="nombreArticulo" maxlength="100" placeholder="Articulo" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Serie</label>
                                            <input class="form-control" type="text" name="serieArticulo"
                                                id="serieArticulo" placeholder="Serie">
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Marca(*)</label>
                                            <input class="form-control" type="text" name="marcaArticulo"
                                                id="marcaArticulo" placeholder="Marca" required>
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Modelo</label>
                                            <input class="form-control" type="text" name="modeloArticulo"
                                                id="modeloArticulo" placeholder="Modelo">
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12" id="divMetal">
                                            <label for="">Metal(*)</label>
                                            <select name="metalArticulo" id="metalArticulo" class="form-control">
                                                <option value="">Seleccione...</option>
                                                <option value="ORO">Oro</option>
                                                <option value="COBRE">Cobre</option>
                                                <OPtion value="PLATA">Plata</OPtion>
                                            </select>
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12" id="divPeso">
                                            <label for="">Peso(km,oz)</label>
                                            <input class="form-control" type="number" step="0.01" name="pesoArticulo"
                                                id="pesoArticulo" placeholder="1 kg">
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12" id="divPureza">
                                            <label for="">Pureza</label>
                                            <input class="form-control" type="text" name="purezArticulo"
                                                id="purezArticulo" placeholder="Kilates">
                                        </div>

                                        <div class=" form-group col-lg-6 col-md-6 col-xs-12" id="divKm">
                                            <label for="">Kilometraje</label>
                                            <input class="form-control" type="number" name="kmArticulo" id="kmArticulo">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Observacion</label>
                                            <input class="form-control" type="text" name="observacionArticulo"
                                                id="observacionArticulo" maxlength="256" placeholder="Observacion">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Evalúo(*)</label>
                                            <input class="form-control" type="number" step="0.01" name="evaluoArticulo"
                                                id="evaluoArticulo" placeholder="0.00" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Préstamo(*)</label>
                                            <input class="form-control" type="number" step="0.01" name="valorArticulo"
                                                id="valorArticulo" placeholder="0.00" required>
                                        </div>


                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-success" type="submit" id="btnGuardarArticulo"><i
                                                    class="fas fa-check"></i> Agregar</button>

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
    </section>

</div>
<?php
    }else{
        require "access.php";
    }
require "footer.php";
?>
<script src="Views/modules/scripts/generaldata.js"></script>
<script src="Views/modules/scripts/newsale.js"></script>
<?php
 }
  ob_end_flush();
  ?>