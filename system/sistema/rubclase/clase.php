<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Clase de rubro</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&codigo='+$('#codigo').val()+'&descrip='+$('#descrip').val()+'&municipio='+$('#selmun').val()+'&estado='+$('#selestado').val()+'&editar=1&ver=1', 'verContenido'); return false;">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Rubro</label>
                            <select class="form-control" id="selrubro">
                                <option value="">Seleccione una opción</option>
                                <?php
                                combos::CombosSelect("1", "$rubro", "ru_codigo, ru_descripcion", "rubros", "ru_codigo", "ru_descripcion", "1=1");
                                ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="control-label">Descripcion</label>
                            <input type="text" class="form-control" id="descrip" required>
                            <input type="number" class="collapse" id="codigo"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Estado</label>
                            <select class="form-control" id="selestado">
                                <option value="">Seleccione una opción</option>
                                <?php
                                combos::CombosSelect("1", "$estado", "st_codigo, st_descripcion", "tools_status", "st_codigo", "st_descripcion", "1=1");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-default" id="btnsave">GUARDAR</button>
                            <button type="button" class="btn btn-danger" id="btncancel">CANCELAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Clase de rubro</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="tables">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <h4>Clases Registradas</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rubro</th>
                                    <th>Clase</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query=mysql_query("select * from rubro_calse rc, rubros r where rc.ruc_rucodigo=r.ru_codigo");
                                    foreach($consul_clase as $post){
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $post['ru_descripcion'];?>
                                        </th>
                                        <td>
                                            <?php echo $post['ruc_descripcion'];?>
                                        </td>
                                        <td>
                                            <?php echo $post['ruc_estado'];?>
                                        </td>
                                        <td>
                                            <a href="#" onclick="editar(<?php echo $post['ruc_codigo'];?>,<?php echo $post['ru_codigo'];?>,'<?php echo $post['ruc_descripcion'];?>','<?php echo $post['ruc_estado'];?>')"><img src="images/edit.png" width="30px"></a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="eliminar(<?php echo $post['ruc_codigo'];?>)"><img src="images/delete.png" width="30px"></a>
                                        </td>
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
    </div>
</div>
