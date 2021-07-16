<?php

ob_start();
session_start();
 if(!isset($_SESSION['nombre'])){
header("location: login");
 }else{
     //echo $_SESSION['nombre'];
    require "header.php";
    require "sidebar.php";

    if($_SESSION['sistema']==1){
    ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Envio/ Recepcion <button class="btn btn-warning" onclick="mostrarform(true)"
                                    id="btnagregar"><i class="fa fa-plus-circle"></i> Envíar a caja</button>
                            </h4>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body"> 
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>#</th>
                                        <th>Nombre emisor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Nombre receptor</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>#</th>
                                        <th>Nombre emisor</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Nombre receptor</th>
                                        <th>Estado</th>
                                    </tfoot> 
                                </table>
                            </div>
                            <!--TABLA DE LISTADO DE REGISTROS FIN-->

                            <!--FORMULARIO PARA DE REGISTRO-->
                            <div id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Traslado de efectivo</label>
                                            <table id="tblefectivo" class="" style="width:100%;">
                                                <thead>
                                                    <th>Denominacion</th>
                                                    <th>Valor</th>
                                                    <th>Unidades</th>
                                                    <th>Totales</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Billetes</th>
                                                        <td>200</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="b_200" id="b_200">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tb_200" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Billetes</th>
                                                        <td>100</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="b_100" id="b_100">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tb_100" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Billetes</th>
                                                        <td>50</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="b_50" id="b_50">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tb_50" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Billetes</th>
                                                        <td>20</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="b_20" id="b_20">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tb_20" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Billetes</th>
                                                        <td>10</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="b_10" id="b_10">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tb_10" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>5</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_5" id="m_5">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_5" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>2</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_2" id="m_2">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_2" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>1</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_1" id="m_1">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_1" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>0.50</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_050" id="m_050">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_050" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>0.20</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_020" id="m_020">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_020" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monedas</th>
                                                        <td>0.10</td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="m_010" id="m_010">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number"
                                                                name="totald[]" id="tm_010" readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                            <label for="">Total(*)</label>
                                            <input class="form-control" type="text" name="totalEnvio" id="totalEnvio" maxlength="100"
                                                required>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                            <label for="">Usuario(*)</label>
                                            <select class="form-control" name="usuarioRecibe" id="usuarioRecibe"
                                                required>
                                            </select>
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


<!--modal para agregar nuevo cliente-->
<div class="modal fade" id="modalAhorro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloAhorro"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <div class="modal-body">
                <form action="" name="formulario" id="formulario" method="POST">
                    <div class="row">

                        <div class="form-group col-lg-8 col-md-8 col-xs-12">
                            <label for="">Cliente(*):</label>
                            <input class="form-control" type="hidden" name="idcuenta" id="idcuenta">
                            <input class="form-control" type="hidden" name="interes" id="interes" value="0">
                            <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                            <input class="form-control" type="hidden" name="plazo" id="plazo" value="0">
                            <input class="form-control" type="hidden" name="tipo_mov" id="tipo_mov">
                            <input class="form-control" type="hidden" name="tipoCuenta" id="tipoCuenta" value="1">
                            <input class="form-control form-control-sm" type="text" name="clienteNombre"
                                id="clienteNombre" readonly>

                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-xs-12">
                            <label for="">Cantidad(*):</label>
                            <input class="form-control" type="number" name="total" id="total" step="0.01" required>
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
            <div class="form-group col-lg-12 col-md-12 col-xs-12">

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        require "access.php";
    }     
require "footer.php";
?>
<script src="Views/modules/scripts/enrep.js"></script>
<?php
 }
  ob_end_flush();
  ?>