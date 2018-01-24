<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Parroquia</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&codigo='+$('#codigo').val()+'&descrip='+$('#descrip').val()+'&municipio='+$('#selmun').val()+'&estado='+$('#selestado').val()+'&editar=1&ver=1', 'verContenido'); return false;">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Descripcion</label>
                            <input type="text" class="form-control" id="descrip" value="<?php echo $descrip?>" required>
                            <input type="text" class="collapse" id="codigo" value="<?php echo $codigo; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="control-label">Municipio</label>
                            <select class="form-control" id="selmun">
                                <option value="">Seleccione una opción</option>
                                <?php
                                combos::CombosSelect("1", "$municipio", "mun_codigo, mun_descrip", "municipio", "mun_codigo", "mun_descrip", "1=1");
                                ?>
                            </select>
                        </div>
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
                <h2>Parroquias registradas</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover" id="municipio">
                    <thead>
                        <tr>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($consulpar as $post){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $post['mun_descrip'];?></th>
                            <th><?php echo $post['par_descrip'];?></th>
                            <td><?php echo $post['st_descripcion'];?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post[par_codigo]?>&editar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-check bg-green"></i></a>
                            </td>
                            <td>
                                <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post[par_codigo]?>&eliminar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-remove bg-red"></i></a>
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
