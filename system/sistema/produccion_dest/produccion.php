<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Producciones cargadas</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tbconsul" class='stripe' cellspacing='0' width='100%'>
                    <div class='cabecera'>			
                        <thead >
                            <tr class="fila">
                                <th>Código</th>
                                <th>Mes</th>
                                <th>Municipio</th>
                                <th>Establecimiento</th>
                                <th>Propietario</th>
                                <th>Rubro</th>
                                <th>Cantidad</th>
                                <th>Agg. Destino</th>
                            </tr>
                        </thead>
                    </div>
                    <tbody class="body">
                        <?php
                        $consulprod = paraTodos::arrayConsulta("ru_codigo,pr_codigo,p.pr_mes, e.est_nombre,r.ru_descripcion, m.mun_descrip,e.est_propietario, sum(pd.prd_monto) AS prd_cantidad ", "rubros r, establecimiento e, municipio m, produccion p LEFT JOIN produccion_detalle pd on pd.prd_prcodigo=p.pr_codigo and pd.prd_estado='ACTIVO' ", " p.pr_rucodigo=r.ru_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and p.pr_estado='ACTIVO' GROUP BY p.pr_codigo");
                        foreach ($consulprod as $post) {
                            ?>
                            <tr>
                                <td><?php echo $post['pr_codigo']; ?></td>
                                <td><?php echo $post['pr_mes']; ?></td>
                                <td><?php echo $post['mun_descrip']; ?></td>
                                <td><?php echo $post['est_nombre']; ?></td>
                                <td><?php echo $post['est_propietario']; ?></td>
                                <td><?php echo $post['ru_descripcion']; ?></td>
                                <td><?php echo $post['prd_cantidad']; ?></td>
                                <td><a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu ?>&ver=1&selrubro=<?php echo $post['ru_codigo']; ?>&cantidad=<?php echo $post['prd_cantidad']; ?>&codigo=<?php echo $post['pr_codigo']; ?>', 'verContenido', '');">Agregar</a></td>
                            </tr>
                            <?php
                        };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
if ($selrubro != "") {
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Destino de la Producción </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-sm-3">
                        <label>Tipo de Rubro</label>
                        <input type="text" id="codprod" class="collapse">
                        <select id="seltiprubro" class="form-control">
                            <option value="">Seleccione una opción</option>                                
                            <?php
                            combos::CombosSelect("1", "$tiporub", "rut_codigo, rut_descripcion", "rubro_tipo", "rut_codigo", "rut_descripcion", "rut_rucodigo=$selrubro order by rut_descripcion");
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Total de Producción</label>
                        <input type="text" id="totprod" class="form-control" value="<?php echo $cantidad; ?>" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label>Entidad</label>
                        <input type="text" id="entidad" class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <label>Cantidad</label>
                        <input type="number" id="cantdestino" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-default" onclick="controler('dmn=<?php echo $idMenu ?>&ver=1&codigo=<?php echo $codigo; ?>&cantidad=<?php echo $cantidad; ?>&adddest=1&entidad=' + $('#entidad').val() + '&unidad=' + $('#cantdestino').val(), 'verContenido', '');">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Destinos cargados </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="tbdestinos" class='stripe' cellspacing='0' width='100%'>
                        <div class='cabecera'>			
                            <thead >
                                <tr class="fila">
                                    <th>Entidad</th>
                                    <th>Cantidad</th>
                                    <th>Eliminar</th>                                    
                                </tr>
                            </thead>
                        </div>
                        <tbody class="body">
                            <?php
                            $consulprod = paraTodos::arrayConsulta("*", "produccion_destino", "prdes_prcodigo=$codigo");
                            foreach ($consulprod as $post) {
                                ?>
                                <tr>
                                    <td><?php echo $post['prdes_entidad']; ?></td>
                                    <td><?php echo $post['prdes_unidad']; ?></td>
                                    <td><a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu ?>&ver=1&selrubro=<?php echo $selrubro; ?>&codigo=<?php echo $codigo; ?>&codigodet=<?php echo $post['prdes_codigo'];?>&eliminar=1', 'verContenido', '');">Eliminar</a></td>
                                </tr>
                                <?php
                            };
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
}