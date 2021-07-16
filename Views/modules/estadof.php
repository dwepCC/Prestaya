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
                            <div class="form-inline col-lg-6 col-md-6 col-xs-12">
                                <h4>Estados financieros <!--<button class="btn btn-success" onclick="mostrarEnvio()"
                                        id="btnEnvio"><i class="fa fa-plus-circle"></i> Excel</button>-->
                                    <button class="btn btn-danger" onclick="mostrarRecepcion()" id="btnRecibo"><i
                                            class="fa fa-file-pdf"></i> PDF</button>
                                </h4>
                            </div>
                            <div class="form-inline col-lg-3 col-md-3 col-xs-12">
                                <label for="">buscar:</label>
                                <select class="form-control" name="" id="tipo">
                                <option value="1">Todos</option>
                                <option value="2">Mensual</option>
                                </select>
                            </div>
                            <div class="form-inline col-lg-3 col-md-3 col-xs-12">
                                <label for="">Fecha:</label>
                                <input class="form-control" type="date" name="fechaEstado" id="fechaEstado">
                            </div>

                        </div>
                        <!--TABLA DE LISTADO DE REGISTROS-->
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-8 col-md-8 col-xs-12">
                                    <table id="tblestadof" class="table table-striped table-hover table-sm"
                                        style="width:100%;">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><b>INGRESOS FINACIEROS</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        id="ifinanciero" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INTERESES POR CARTERA</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        id="icartera" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><b>GASTOS FINANCIEROS</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INTERESES POR AHORROS</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><b>MARGEN FINANCIERO</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INGRESOS DIVERSOS</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><b>MARGEN OPERACIONAL</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><b>GASTOS ADMINISTRATIVOS</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GATOS DE PERSONAL </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GATOS DE RECIBO OR HONORARIOS</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><b>MARGEN OPERATIVO NETO</b></th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>RESULTADO NETO DEL EJERCICIO </th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="totald[]" id="ingresof" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!--<div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label for="">Oficina(*)</label>
                                        <select class="form-control" name="usuarioRecibe" id="usuarioRecibe" required>
                                        </select>
                                    </div>-->

                            </div>


                            <!-- <div class="form-inline col-lg-2 col-md-2 col-xs-12">
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
                            </div>-->


                            <!--TABLA DE LISTADO DE REGISTROS FIN-->
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
<script src="Views/modules/scripts/estadof.js"></script>
<?php
 }
  ob_end_flush();
  ?>