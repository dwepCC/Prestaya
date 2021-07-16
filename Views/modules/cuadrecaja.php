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
                            <div class="form-inline col-lg-9 col-md-9 col-xs-12">
                                <h4>Cuadre caja <button class="btn btn-warning" onclick="mostrarEnvio()" id="btnEnvio"><i
                                            class="fa fa-plus-circle"></i> Envío/Cierre</button>
                                    <button class="btn btn-success" onclick="mostrarRecepcion()" id="btnRecibo"><i
                                            class="fa fa-plus-circle"></i> Recepción/Boveda</button>

                                    <button class="btn btn-primary" onclick="abrirCaja()" id="btnAbrir"><i
                                            class="fa fa-plus-circle"></i> Apertura/Caja</button>
                                       
                                </h4> 
                            </div>
                            <div class="form-inline col-lg-3 col-md-3 col-xs-12">
                                <label for="">Fecha:</label>
                                <input class="form-control" type="date" name="fechaCaja" id="fechaCaja">
                            </div>
                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-hover text-nowrap"
                                    style="width:100%;">
                                    <thead>
                                        <th>#</th>
                                        <th>Opción</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>N° Operación</th>
                                        <th>Descripción</th>
                                        <th>Titular</th>
                                        <th>Ingreso</th>
                                        <th>Egreso</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>#</th>
                                        <th>Opción</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>N° Operación</th>
                                        <th>Descripción</th>
                                        <th>Titular</th>
                                        <th>Ingreso</th>
                                        <th>Egreso</th>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="">
                                <div class="row">
                                    <div class="form-inline col-lg-2 col-md-2 col-xs-12">
                                        <label>Ingreso <span class="btn btn-warning" id="tIngreso">0.00</span>
                                        </label>
                                    </div>
                                    <div class="form-inline col-lg-2 col-md-2 col-xs-12">
                                        <label>Egreso
                                            <span class="btn btn-danger" id="tEgreso">0.00</span>
                                        </label>
                                    </div>
                                    <div class="form-inline col-lg-2 col-md-2 col-xs-12">

                                        <label>Saldo
                                            <span class="btn btn-info" id="tSaldo">0.00</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!--TABLA DE LISTADO DE REGISTROS FIN-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!--modal para agregar nuevo cliente-->
<div class="modal fade" id="modalAhorro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 65% !important;">
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
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
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
                                            <input class="form-control form-control-sm" type="number" name="b_200"
                                                id="b_200">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tb_200" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Billetes</th>
                                        <td>100</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="b_100"
                                                id="b_100">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tb_100" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Billetes</th>
                                        <td>50</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="b_50"
                                                id="b_50">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tb_50" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Billetes</th>
                                        <td>20</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="b_20"
                                                id="b_20">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tb_20" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Billetes</th>
                                        <td>10</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="b_10"
                                                id="b_10">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tb_10" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th>
                                        <td>5</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_5"
                                                id="m_5">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_5" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th>
                                        <td>2</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_2"
                                                id="m_2">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_2" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th>
                                        <td>1</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_1"
                                                id="m_1">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_1" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th>
                                        <td>0.50</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_050"
                                                id="m_050">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_050" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th> 
                                        <td>0.20</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_020"
                                                id="m_020">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_020" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Monedas</th> 
                                        <td>0.10</td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="m_010"
                                                id="m_010" step="0.01">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="totald[]"
                                                id="tm_010" step="0.01" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label for="">Total(*)</label>
                            <input class="form-control" type="text" name="totalEnvio" id="totalEnvio" required>
                            <label for="">Saldo(*)</label>
                            <input class="form-control" type="text" name="totalDisponible" id="totalDisponible"
                                readonly>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label for="">Usuario(*)</label>
                            <select class="form-control" name="usuarioRecibe" id="usuarioRecibe" required>
                            </select>
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
<script src="Views/modules/scripts/cuadrecaja.js"></script>
<?php
 }
  ob_end_flush();
  ?>