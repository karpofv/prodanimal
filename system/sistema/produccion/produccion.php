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
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu; ?>&fecha=' + $('#fecha').val() + '&selmes=' + $('#selmes').val() + '&codigoestab=' + $('#codigoestab').val() + '&selelab=' + $('#selelab').val() + '&fechae=' + $('#fechae').val() + '&seleen=' + $('#seleen').val() + '&selrubro=' + $('#selrubro').val() + '&observ=' + $('#observ').val() + '&codigo=' + $('#codigo').val() + '&ver=1&editar=1', 'verContenido', '');
                        return false;">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Fecha de Transcripción</label>
                            <input type="date" id="fecha" class="form-control" value="<?php echo $fecha; ?>" required>
                            <input id="codigo" value="<?php echo $codigo; ?>" hidden="">
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
                            <input type="text" id="establec" class="form-control col-sm-12" value="<?php echo $establecimiento; ?>" readonly required>
                            <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu; ?>&ver=1&act=2', 'VentanaVer');"><i class="fa fa-search"></i></a>
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
                            <input type="date" id="fechae" class="form-control" value="<?php echo $fechaelab; ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Encuestador</label>
                            <select id="seleen" class="form-control">
                                <option value="0">Seleccione al Elaborador</option>                                
                                <?php
                                combos::CombosSelect("1", "$seleen", "per_codigo, concat(per_apellidos,' ',per_nombres) as nombre", "personal", "per_codigo", "nombre", "per_tipo=4 and per_estado=1");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Rubro</label>
                            <select id="selrubro" class="form-control">
                                <?php
                                combos::CombosSelect($permiso, "$rubro", "ru_codigo,ru_descripcion", "rubros r, rubro_estableci re", "ru_codigo", "ru_descripcion", "re.rue_rucodigo=ru_codigo and rue_estcodigo=$codigoest");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Observación</label>
                            <textarea id="observ" class="form-control"><?php echo $observacion; ?></textarea>
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
            <?php
            if ($codigo != "") {
                ?>
                <div class="panel-heading">
                    <h4>Tipo de Rubro</h4>
                </div>
                <div class="panel-body">
                    <div class="alert alert-warning alert-dismissable collapse" id="alertdet">
                        <strong>¡Cuidado!</strong> Ya este rubro esta registrado bajo estas características en la producción.<br>Ingrese la Distribución
                    </div>
                    <input type="number" id="codigo_prod" class="collapse" value="<?php echo $consulprcodigo[0][pr_codigo]; ?>">    
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Tipo de Rubro</label>
                            <select id="seltiprubro" class="form-control" onchange="controler('dmn=<?php echo $idMenu;?>&ver=1&actd=1&act=20&tiprub='+$('#seltiprubro').val(),'seldistrubro');">
                                <option value="">Seleccione una opción</option>                                
                                <?php
                                combos::CombosSelect("1", "$tiporub", "rut_codigo, rut_descripcion", "rubro_tipo", "rut_codigo", "rut_descripcion", "rut_rucodigo=$selrubro order by rut_descripcion");
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Clase de Rubro</label>
                            <select id="selclasrubro" class="form-control">
                                <option value="">Seleccione una opción</option>                                
                                <?php
                                combos::CombosSelect("1", "$clasrub", "ruc_codigo, ruc_descripcion", "rubro_calse", "ruc_codigo", "ruc_descripcion", "ruc_rucodigo=$selrubro order by ruc_descripcion");
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Categoría de Rubro</label>
                            <select id="selcatrubro" class="form-control">
                                <option value="">Seleccione una opción</option>                                
                                <?php
                                combos::CombosSelect("1", "$catrub", "rucat_codigo, rucat_descripcion", "rubro_categoria", "rucat_codigo", "rucat_descripcion", "rucat_rucodigo=$selrubro order by rucat_descripcion");
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label id="lbltotaltip">Total</label>
                            <input type="number" id="totaltiprub" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label id="tipdistri">Tipo de Distribución</label>
                            <input type="text" id="codigodet" class="collapse" value="<?php echo $codigodet; ?>">                                
                            <select id="seldistrubro" class="form-control">
                                <option value="">Seleccione una opción</option>
                                <?php
                                combos::CombosSelect($permiso, "$distribucion", "tip_codigo,tip_medida", "tipos_medidas", "tip_codigo", "tip_medida", "tip_rutcodigo=$tiporub");
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="totaldistrib">Total por Distribución</label>
                            <input type="number" id="totaldistrib" class="form-control" required>
                        </div>                        
                        <div class="col-sm-1">
                            <br>
                            <button type="button"class="btn btn-default" onclick="controler('dmn=<?php echo $idMenu ?>&codigo=<?php echo $codigo; ?>&tiporub=' + $('#seltiprubro').val() + '&clasrub=' + $('#selclasrubro').val() + '&catrub=' + $('#selcatrubro').val() + '&totaltiprub=' + $('#totaltiprub').val() + '&totaldist=' + $('#totaldistrib').val() + '&selmed=' + $('#seldistrubro').val() + '&adddet=1&ver=1&editar=1', 'verContenido');">Agregar</button>
                        </div>                        
                    </div>
                </div>
                <?php
            }
            ?>
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
                                <th>Distribucion</th>                                
                                <th>Cantidad</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                    </div>
                    <tbody class='body'>
                        <?php
                        $consul_prod = paraTodos::arrayConsulta("prd_codigo,prd_monto,tip_medida,mes_descripcion,est_nombre,ru_descripcion,pr.*,rt.rut_descripcion, rc.ruc_descripcion, rct.rucat_descripcion, pd.prd_cantidad", "tools_mes m, establecimiento e, rubros r,produccion pr
inner join produccion_detalle pd on pd.prd_prcodigo=pr.pr_codigo
left join rubro_tipo rt on rt.rut_codigo=pd.prd_rutcodigo
left join rubro_calse rc on rc.ruc_codigo=pd.prd_ruccodigo
left join tipos_medidas tm on tip_codigo=prd_tipomen
left join rubro_categoria rct on rct.rucat_codigo=pd.prd_rucatcodigo", "pr_codigo=$codigo and pr.pr_mes=m.mes_codigo and pr.pr_estcodigo=e.est_codigo and pr.pr_rucodigo=r.ru_codigo");
                        foreach ($consul_prod as $prod) {
                            ?>
                            <tr>
                                <td><?php echo $prod['mes_descripcion']; ?></td>
                                <td><?php echo $prod['est_nombre']; ?></td>
                                <td><?php echo $prod['ru_descripcion']; ?></td>
                                <td><?php echo $prod['rut_descripcion']; ?></td>
                                <td><?php echo $prod['prd_cantidad']; ?></td>                                
                                <td><?php echo $prod['ruc_descripcion']; ?></td>
                                <td><?php echo $prod['rucat_descripcion']; ?></td>
                                <td><?php echo $prod['tip_medida']; ?></td>
                                <td><?php echo $prod['prd_monto']; ?></td>
                                <td><a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu?>&ver=1&editar=1&codigo=<?php echo $codigo;?>&codigodet=<?php echo $prod['prd_codigo']; ?>&eliminardet=1','verContenido','');"><i class="fa fa-eraser"></i></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#tbconsul').DataTable({
        "language": {
            "url": "<?php echo $ruta_base; ?>/assets/js/Spanish.json"
        }
    });
</script>