<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['settings']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Datos generales</h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opcion</th>
                                        <th>logo</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>E-mail</th>
                                        <th>Pais/Ciudad</th>
                                        <th>Impuesto</th>
                                        <th>Moneda</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opcion</th>
                                        <th>logo</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>E-mail</th>
                                        <th>Pais/Ciudad</th>
                                        <th>Impuesto</th>
                                        <th>Moneda</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Logo(*):</label>
                                            <input class="form-control" type="file" name="logo" id="logo">
                                            <input type="hidden" name="logoactual" id="logoactual">
                                            <img src="" alt="" width="150px" height="120" id="logomuestra">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Nombre(*):</label>
                                            <input class="form-control" type="hidden" name="id_negocio" id="id_negocio">
                                            <input class="form-control" type="text" name="nombre" id="nombre"
                                                maxlength="100" placeholder="Nombre" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Nombre del documento:(*)</label>
                                            <input class="form-control" type="text" name="ndocumento" placeholder="RUC"
                                                id="ndocumento" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Documento:(*)</label>
                                            <input class="form-control" type="text" name="documento" id="documento"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="">Dirección(*):</label>
                                            <input class="form-control" type="text" name="direccion" id="direccion"
                                                maxlength="256" placeholder="Dirección" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Pais:</label>
                                            <input class="form-control" type="text" name="pais" id="pais">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Telefono(*):</label>
                                            <input class="form-control" type="text" name="telefono" id="telefono"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">E-mail:</label>
                                            <input class="form-control" type="email" name="email" id="email">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Ciudad:</label>
                                            <input class="form-control" type="text" name="ciudad" id="ciudad">
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="">Datos Financieros</label>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                            <label for="">Nombre Imp:</label>
                                            <input class="form-control" type="text" name="nombre_impuesto"
                                                id="nombre_impuesto" placeholder="IVA - IGV">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                            <label for="">Monto (%):</label>
                                            <input class="form-control" type="text" name="monto_impuesto"
                                                id="monto_impuesto">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                            <label for="">Moneda:</label>
                                            <input class="form-control" type="text" name="moneda" id="moneda"
                                                placeholder="SOLES - Dolares">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                            <label for="">Simbolo:</label>
                                            <input class="form-control" type="text" name="simbolo" id="simbolo"
                                                placeholder="s/ - $">
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
<script src="Views/modules/scripts/generalsetting.js"></script>
<?php
 }
  ob_end_flush();
  ?>