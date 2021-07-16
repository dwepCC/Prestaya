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
                            <h4>Porveedores <button class="btn btn-success" onclick="mostrarform(true)"
                                    id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Numero</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Numero</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Nombre</label>
                                            <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                                            <input class="form-control" type="hidden" name="tipo_persona"
                                                id="tipo_persona" value="Proveedor">
                                            <input class="form-control" type="text" name="nombre" id="nombre"
                                                maxlength="100" placeholder="Nombre del proveedor" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Tipo Dcumento</label>
                                            <select class="form-control" name="tipo_documento" id="tipo_documento"
                                                required>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="CEDULA">CEDULA</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Número Documento</label>
                                            <input class="form-control" type="text" name="num_documento"
                                                id="num_documento" maxlength="20" placeholder="Número de Documento">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Direccion</label>
                                            <input class="form-control" type="text" name="direccion" id="direccion"
                                                maxlength="70" placeholder="Direccion">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Telefono</label>
                                            <input class="form-control" type="text" name="telefono" id="telefono"
                                                maxlength="20" placeholder="Número de Telefono">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="">Email</label>
                                            <input class="form-control" type="email" name="email" id="email"
                                                maxlength="50" placeholder="Email">
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
<script src="Views/modules/scripts/supplier.js"></script>
<?php
 }
  ob_end_flush();
  ?>