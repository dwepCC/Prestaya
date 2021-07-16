<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['compras']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Compras <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
                                        class="fa fa-plus-circle"></i> Agregar</button></h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Usuario</th>
                                        <th>Documento</th>
                                        <th>Número</th>
                                        <th>Total Compra</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Usuario</th>
                                        <th>Documento</th>
                                        <th>Número</th>
                                        <th>Total Compra</th>
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
                                            <label>Proveedor(*):</label>
                                            <input class="form-control" type="hidden" name="idingreso" id="idingreso">
                                            <select name="idproveedor" id="idproveedor" class="form-control"
                                                data-live-search="true" required>

                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Fecha(*): </label>
                                            <input class="form-control" type="date" name="fecha_hora" id="fecha_hora"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-6">
                                            <label for="">Tipo Comprobante(*): </label>
                                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control"
                                                required>
                                                <option value="Boleta">Boleta</option>
                                                <option value="Factura">Factura</option>
                                                <option value="Ticket">Ticket</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-6">
                                            <label for="">Serie: </label>
                                            <input class="form-control" type="text" name="serie_comprobante"
                                                id="serie_comprobante" maxlength="7" placeholder="Serie">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-6">
                                            <label for="">Número: </label>
                                            <input class="form-control" type="text" name="num_comprobante"
                                                id="num_comprobante" maxlength="10" placeholder="Número" required>
                                        </div>
                                        <!-- <div class="form-group col-lg-4 col-md-4 col-xs-6">
                                            <label for="">Aplicar Impuesto: </label>
                                            <input class="form-control" onchange="modificarSubtotales();" type="hidden"
                                                name="impuesto" id="impuesto">
                                           
                                        </div>--> 
                                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <a data-toggle="modal" href="#myModal">
                                                <button id="btnAgregarArt" type="button" class="btn btn-primary"><span
                                                        class="fa fa-plus"></span>Agregar
                                                    Articulos</button>
                                            </a>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <table id="detalles"
                                                class="table table-striped table-bordered table-condensed table-hover">
                                                <thead class="bg-aqua">
                                                    <th>Opciones</th>
                                                    <th>Articulo</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Compra Total</th>
                                                    <th>Precio Venta Unitario</th>
                                                    <th>Subtotal</th>
                                                </thead>
                                                <tfoot style="background-color:#A9D0F5">
                                                    <th>
                                                        <span>SubTotal</span><br>
                                                        <span id="valor_impuesto">
                                                            <span id="tipo_impuesto"></span>
                                                            0.00
                                                        </span><br>
                                                        <span>TOTAL</span>
                                                    </th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th> 
                                                    <th></th>
                                                    <th>
                                                        <i id="smoneda_total"></i>
                                                        <span class="pull-right" id="total">0.00</span><br>
                                                        <i id="smoneda_most_imp"></i>
                                                        <span class="pull-right" id="most_imp"
                                                            maxlength="4">0.00</span><br>
                                                        <i id="smoneda_most_total"></i>
                                                        <span class="pull-right" id="most_total">0.00</span>
                                                        <input type="hidden" step="0.01" name="total_compra"
                                                            id="total_compra">
                                                    </th>
                                                </tfoot>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"
                                                id="btnCancelar"><i class="fa fa-arrow-circle-left"></i>
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
    </section>
</div>



<!--MODALES-->
<!--MODAL PARA LISTAR PRODUCTOS-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccione un articulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive col-lg-12 col-md-12 col-xs-12">
                        <table id="tblarticulos" width="100%" class="table table-striped table-hover text-nowrap">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Código</th>
                                <th>Stock</th>
                                <th>Imagen</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Código</th>
                                <th>Stock</th>
                                <th>Imagen</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL PARA LISTAR PRODUCTOS-->
<!--MODAL PARA VER EL INGRESO-->

<div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Vista de ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-8 col-md-8 col-xs-12">
                        <label for="">Proveedor(*):</label>
                        <input class="form-control" type="hidden" name="idingreso" id="idingreso">
                        <input class="form-control" type="text" name="idproveedorm" id="idproveedorm" readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-xs-6">
                        <label>Fecha: </label>
                        <div class="input-group">
                            <input class="form-control pull-right" type="text" name="fecha_horam" id="fecha_horam"
                                readonly>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-xs-6">
                        <label for="">Tipo Comprobante(*): </label>
                        <input class="form-control" type="text" name="tipo_comprobantem" id="tipo_comprobantem"
                            readonly>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-xs-6">
                        <label for="">Serie: </label>
                        <input class="form-control" type="text" name="serie_comprobantem" id="serie_comprobantem"
                            maxlength="7" readonly>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-xs-6">
                        <label for="">Número: </label>
                        <input class="form-control" type="text" name="num_comprobantem" id="num_comprobantem"
                            maxlength="10" readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-xs-6">
                        <label>Impuesto: </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="impuestom" id="impuestom" value="18" readonly> 
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                        <table id="detallesm" class="table table-striped table-bordered table-condensed table-hover">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL PARA VER EL INGRESO-->
<!--FIN MODALES-->
<?php
    }else{
        require "access.php";
    }    
require "footer.php";
?>
<script src="Views/modules/scripts/buy.js"></script>
<script src="Views/modules/scripts/generaldata.js"></script>
<?php
 }
  ob_end_flush();
  ?>