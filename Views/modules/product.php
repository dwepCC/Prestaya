<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['almacen']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Artículos <!--<button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
                                        class="fa fa-plus-circle"></i> Agregar</button>--></h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Codigo</th>
                                        <th>Stock</th>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>P. Compra</th>
                                        <th>P. Venta</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody> 
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th>Codigo</th>
                                        <th>Stock</th>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>P. Compra</th>
                                        <th>P. Venta</th>
                                        <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Nombre(*):</label>
                                            <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
                                            <input class="form-control" type="text" name="nombreArticulo" id="nombreArticulo"
                                                maxlength="100" placeholder="Nombre" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Categoria(*):</label>
                                            <select name="idcategoria" id="idcategoria" class="form-control"
                                                required></select>
                                        </div>
                                       <!-- <div class=" form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Stock</label>
                                            <input class="form-control" type="number" name="stock" id="stock">
                                        </div>-->
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Descripcion</label>
                                            <input class="form-control" type="text" name="observacionArticulo" id="observacionArticulo"
                                                maxlength="256" placeholder="Descripcion">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Imagen:</label>
                                            <input class="form-control filestyle" type="file" name="imagen" id="imagen"
                                                data-buttonText="Buscar..." data-buttonName="btn-success"
                                                data-iconName="fa fa-folder-open"
                                                data-placeholder="Selecciona un imagen">
                                            <input type="hidden" name="imagenactual" id="imagenactual">
                                            <img src="" alt="" width="150px" height="120" id="imagenmuestra">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Codigo:</label>
                                            <input class="form-control" type="text" name="serieArticulo" id="serieArticulo"
                                                placeholder="codigo del prodcuto" required>
                                            <button class="btn btn-success" type="button"
                                                onclick="generarbarcode()">Generar</button>
                                            <button class="btn btn-info" type="button"
                                                onclick="imprimir()">Imprimir</button>
                                            <div id="print">
                                                <svg id="barcode"></svg>
                                            </div>
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
<script src="Assets/js/JsBarcode.all.min.js"></script>
<script src="Assets/js/jquery.PrintArea.js"></script>
<script src="Views/modules/scripts/product.js"></script>
<?php
 }
  ob_end_flush();
  ?>