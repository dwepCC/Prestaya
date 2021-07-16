<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['users']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Usuarios <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
                    class="fa fa-plus-circle"></i>Agregar</button></h4>
            </div>
            <!--TABLA DE LISTADO DE REGISTROS-->
            <div class="card-body">
              <div class="table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-hover text-nowrap" style="width:100%;">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Numero Documento</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Login</th>
                    <th>Foto</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Numero Documento</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Login</th>
                    <th>Foto</th>
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
                      <input class="form-control" type="hidden" name="idusuario" id="idusuario">
                      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                        placeholder="Nombre" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Tipo Documento(*):</label>
                      <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                        <option value=" DNI">DNI</option>
                        <option value="RUC">RUC</option>
                        <option value="CEDULA">CEDULA</option>
                      </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Numero de Documento(*):</label>
                      <input type="text" class="form-control" name="num_documento" id="num_documento"
                        placeholder="Documento" maxlength="20">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Direccion</label>
                      <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Telefono</label>
                      <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20"
                        placeholder="Número de telefono">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Email: </label>
                      <input class="form-control" type="email" name="email" id="email" maxlength="70"
                        placeholder="email">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Cargo</label>
                      <input class="form-control" type="text" name="cargo" id="cargo" maxlength="20"
                        placeholder="Cargo">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Login(*):</label>
                      <input class="form-control" type="text" name="login" id="login" maxlength="20"
                        placeholder="nombre de usuario" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12" id="claves">
                      <label for="">Clave(*):</label>
                      <input class="form-control" type="password" name="clave" id="clave" maxlength="64"
                        placeholder="Clave">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label>Permisos</label>
                      <ul id="permisos" style="list-style: none;">

                      </ul>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Imagen:</label>
                      <input class="form-control filestyle" type="file" name="imagen" id="imagen"
                        data-buttonText="Buscar..." data-buttonName="btn-success" data-iconName="fa fa-folder-open"
                        data-placeholder="Selecciona un imagen">
                      <input type="hidden" name="imagenactual" id="imagenactual">
                      <img src="" alt="" width="150px" height="120" id="imagenmuestra">
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

              <!--FORMULARIO CMABIO DE CLAVE-->
              <div id="formulario_clave">
                <form action="" name="formularioc" id="formularioc" method="POST">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nueva clave:</label>
                    <input class="form-control" type="hidden" name="idusuarioc" id="idusuarioc">
                    <input class="form-control" type="password" name="clavec" id="clavec" maxlength="64"
                      placeholder="Clave">
                  </div>
                  <button class="btn btn-primary" type="submit" id="btnGuardar_clave"><i class="fa fa-save"></i>
                    Guardar</button>
                  <button class="btn btn-danger" onclick="cancelarform_clave()" type="button"><i
                      class="fa fa-arrow-circle-left"></i> Cancelar</button>
                </form>
              </div>
              <!--FORMULARIO CMABIO DE CLAVE FIN-->
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
<script src="Views/modules/scripts/user.js"></script>
<?php
 }
  ob_end_flush();
  ?>