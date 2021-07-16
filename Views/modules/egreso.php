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
              <h4>Registro de egresos <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
                    class="fa fa-plus-circle"></i>Agregar</button></h4>
            </div>
            <!--TABLA DE LISTADO DE REGISTROS-->
            <div class="card-body">
              <div class="table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-hover text-nowrap" style="width:100%;">
                  <thead>
                    <th>Opciones</th>
                    <th>Titular</th>
                    <th>Documento</th>
                    <th>Numero Documento</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Titular</th>
                    <th>Documento</th>
                    <th>Numero Documento</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tfoot>
                </table>
              </div>
              <!--TABLA DE LISTADO DE REGISTROS FIN-->

              <!--FORMULARIO PARA DE REGISTRO-->
              <div id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="row">

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Ingrese numero de documento(*):</label>
                      <div class="input-group">
                        <input class="form-control form-control-sm" type="text" name="numDocumento" id="numDocumento">
                        <div class="input-group-prepend">
                          <!--<div class="input-group-text">-->
                          <button class="btn btn-success btn-sm" type="button" onclick="buscarCliente()"><i
                              class="fas fa-search"></i>
                            Buscar...</button>
                          <!--</div>-->
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Titular:</label>
                      <input class="form-control form-control-sm" type="text" name="clienteNombre" id="clienteNombre"
                        readonly>
                      <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                      <input class="form-control" type="hidden" name="id" id="id">
                      <input class="form-control" type="hidden" name="tipo" id="tipo">
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Tipo Comprobante(*):</label>
                      <select name="tipo_comprobante" id="tipo_comprobante" class="selectpicker form-control form-control-sm" data-container="body" data-live-search="true"
                    title="Seleccione..." required>
                        <option value="1">Factura</option>
                        <option value="2">Recibo por honorarios</option>
                        <option value="3">Boleta de venta</option>
                        <option value="12">Ticket</option>
                        <option value="14">Recibo</option>
                      </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-12">
                      <label for="">Serie(*):</label>
                      <input type="text" class="form-control form-control-sm" name="serie_comprobante" id="serie_comprobante"
                        placeholder="Serie" maxlength="20" required>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-12">
                      <label for="">Numero(*):</label>
                      <input type="text" class="form-control form-control-sm" name="num_comprobante" id="num_comprobante"
                        placeholder="Numero" maxlength="20">
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Concepto(*)</label>
                      <?php 
                    require_once(dirname(__FILE__,3).'/Models/Ingreso.php');
                    $ingreso=new Ingreso(); 
                       ?>
                  <select class="selectpicker form-control form-control-sm" id="idcuenta" name="idcuenta" data-container="body" data-live-search="true"
                    title="Seleccione..." data-hide-disabled="true">
                                <?php
                                    $rspta=$ingreso->selectCuenta(1);
                                    foreach($rspta as $reg){
                                      echo '<option value="'. $reg['idcuenta'].'">'.$reg['idcuenta'].' - '.$reg['nombre'].'</option>';
                                    }
                                ?>
                    </select>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Descripción</label>
                      <input class="form-control form-control-sm" type="text" name="descripcion" id="descripcion" maxlength="70">
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Monto(*)</label>
                      <input class="form-control form-control-sm" type="number" step="0.01" name="cantidad" id="cantidad" required>
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
<script src="Views/modules/scripts/egreso.js"></script>
<?php
 }
  ob_end_flush();
  ?>