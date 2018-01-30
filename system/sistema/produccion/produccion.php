<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Producción</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&fecha='+$('#fecha').val()+'&selmes='+$('#selmes').val()+'&codigoestab='+$('#codigoestab').val()+'&selelab='+$('#selelab').val()+'&fechae='+$('#fechae').val()+'&seleen='+$('#seleen').val()+'&selrubro='+$('#selrubro').val()+'&observ='+$('#observ').val()+'&editar=1&act=20&actd=3&ver=1', 'codigo'); controler('dmn=<?php echo $idMenu;?>&ver=1&act=3&codigo='$('#codigo').html(),'paneltbconsul') return false;">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Fecha de Transcripción</label>
                            <input type="date" id="fecha" class="form-control" required>
                            <label id="codigo" class="collapse"></label>
                        </div>
                        <div class="col-sm-3">
                            <label>Mes</label>
                            <select id="selmes" class="form-control">
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    combos::CombosSelect("1", "$mes", "mes_codigo, mes_descripcion", "tools_mes", "mes_codigo", "mes_descripcion", "1=1 order by mes_codigo");
                                    ?>
								</select>
                        </div>
                        <div class="col-sm-6">
                            <label class='control-label' id="mun"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Establecimiento</label>
                            <input type="text" id="establec" class="form-control col-sm-12" readonly required>
                            <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&ver=1&act=2', 'VentanaVer');"><i class="fa fa-search"></i></a>
                            <input type="text" id="codigoestab" class="collapse">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Informante</label>
                            <select id="selelab" class="form-control">
									<option value="0">Seleccione un Transcriptor</option>
                                    <?php
                                    combos::CombosSelect("1", "$transcriptor", "per_codigo, concat(per_apellidos,' ',per_nombres) as nombre", "personal", "per_codigo", "nombre", "per_tipo=3 and per_estado=1");
                                    ?>
								</select>
                        </div>
                        <div class="col-sm-6">
                            <label>Fecha de Elaboración</label>
                            <input type="date" id="fechae" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Encuestador</label>
                            <select id="seleen" class="form-control">
									<option value="0">Seleccione al Elaborador</option>                                
                                    <?php
                                    combos::CombosSelect("1", "$transcriptor", "per_codigo, concat(per_apellidos,' ',per_nombres) as nombre", "personal", "per_codigo", "nombre", "per_tipo=4 and per_estado=1");
                                    ?>
							  </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Rubro</label>
                            <select id="selrubro" class="form-control">
								</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Observación</label>
                            <textarea id="observ" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label id="lblsavedg">Guardar Y Agregar Tipos de Rubro</label>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" id="btnsavedg" class="btn btn-default">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default" id="paneltip">
            <div class="panel-heading">
                <h4>Tipo de Rubro</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-warning alert-dismissable collapse" id="alertdet">
                    <strong>¡Cuidado!</strong> Ya este rubro esta registrado bajo estas características en la producción.<br>Ingrese la Distribución
                </div>
                <form class="form-horizontal" id="frmproddet">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Tipo de Rubro</label>
                            <input type="text" id="codprod" class="collapse" value="<?php echo $_GET['id']; ?>">
                            <select id="seltiprubro" class="form-control">
								</select>
                        </div>
                        <div class="col-sm-3">
                            <label>Clase de Rubro</label>
                            <select id="selclasrubro" class="form-control">
								</select>
                        </div>
                        <div class="col-sm-3">
                            <label>Categoría de Rubro</label>
                            <select id="selcatrubro" class="form-control">
								</select>
                        </div>
                        <div class="col-sm-2">
                            <label id="lbltotaltip">Total</label>
                            <input type="number" id="totaltiprub" class="form-control" required>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" id="btndetalle" class="btn btn-default">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default" id="panelmov">
            <div class="panel-heading">
                <h4>Detalles de Producción</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-warning alert-dismissable collapse" id="alertmov">
                    <strong>¡Cuidado!</strong> Ya se asignó la distribución de este Tipo de Rubro.
                </div>
                <div class="alert alert-warning alert-dismissable collapse" id="alertcant">
                    <strong>¡Cuidado!</strong> La Distribución no puede Exceder la Totalidad de la Producción del Rubro.
                </div>
                <form class="form-horizontal" id="frmprodmov">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label id="tipdistri">Tipo de Distribución</label>
                            <input type="text" id="codigodet" class="collapse">
                            <select id="seldistrubro" class="form-control">
								</select>
                        </div>
                        <div class="col-sm-3">
                            <label id="totdistri">Total por Distribución</label>
                            <input type="number" id="totaldistrib" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-default" id="btnagreg">AGREGAR</button>
                        <button type="button" class="btn btn-default" id="btncancel">CANCELAR</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default" id="panelconsul">
            <div class="panel-heading">
                <h4>Detalles Cargados</h4>
            </div>
            <div class="panel-body" id="paneltbconsul">
                <table id='tbconsul' class='stripe' cellspacing='0' width='100%'>
                    <div class='cabecera'>
                        <thead>
                            <tr class='fila'>
                                <th>Mes</th>
                                <th>Establecimiento</th>
                                <th>Rubro</th>
                                <th>Tipo de Rubro</th>
                                <th id='thtotal'>Total Producción</th>
                                <th>Clase</th>
                                <th>Categoría</th>
                                <th id='thdistri'>Distribucion</th>
                                <th>Cantidad</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                    </div>
                    <tbody class='body'>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$('#tbconsul').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});    
</script>