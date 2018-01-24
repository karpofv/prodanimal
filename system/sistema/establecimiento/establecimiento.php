<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Establecimiento</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&codigo='+$('#codigo').val()+'&rif='+$('#rif').val()+'&nombre='+$('#nombre').val()+'&propietario='+$('#propietario').val()+'&direccion='+$('#direccion').val()+'&tipo='+$('#tipo').val()+'&municipio='+$('#municipio').val()+'&parroquia='+$('#parroquia').val()+'&estado='+$('#selestado').val()+'&editar=1&ver=1', 'verContenido'); return false;">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">RIF</label>
                            <input type="text" class="form-control" placeholder="00000000" value="<?php echo $rif;?>" id="rif" required>
                            <input type="number" class="collapse" id="codigo" value="<?php echo $codigo;?>">
                        </div>
                        <div class="col-md-8">
                            <label class="control-label">Nombre o Razon Social</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo $nombre;?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="control-label">Propietario</label>
                            <input type="text" class="form-control" id="propietario" value="<?php echo $propietario;?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Tipo</label>
                            <input type="text" class="form-control" id="tipo" value="<?php echo $tipo;?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Municipio</label>
                            <select class="form-control" id="municipio">
                                <option value="">Seleccione una opción</option>
                                <?php
                                combos::CombosSelect("1", "$municipio", "mun_codigo, mun_descrip", "municipio", "mun_codigo", "mun_descrip", "1=1");
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Parroquia</label>                            
                            <select class="form-control" id="parroquia">
                                <option value="">Seleccione una opción</option>                                
                                <?php
                                combos::CombosSelect("1", "$parroquia", "par_codigo, par_descrip", "parroquia", "par_codigo", "par_descrip", "1=1");
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-2 control-label">Estado</label>
                            <select class="form-control" id="selestado">
                                <option value="">Seleccione una opción</option>                                
                                    <?php
                                    combos::CombosSelect("1", "$estado", "st_codigo, st_descripcion", "tools_status", "st_codigo", "st_descripcion", "1=1");
                                    ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Dirección</label>
                            <input type="text" class="form-control" id="direc" value="<?php echo $direccion;?>" required>
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
                <h2>Usuarios registrados</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover" id="establecimiento">
                    <thead>
                        <tr>
                            <th>RIF</th>
                            <th>Establecimiento</th>
                            <th>Propietario</th>
                            <th>Tipo</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($consul_establecimiento as $post){
                            ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $post['est_rif'];?>
                                </th>
                                <td>
                                    <?php echo $post['est_nombre'];?>
                                </td>
                                <td>
                                    <?php echo $post['est_propietario'];?>
                                </td>
                                <td>
                                    <?php echo $post['est_tipo'];?>
                                </td>
                                <td>
                                    <?php echo $post['mun_descrip'];?>
                                </td>
                                <td>
                                    <?php echo $post['par_descrip'];?>
                                </td>
                                <td>
                                    <?php echo $post['est_direccion'];?>
                                </td>
                                <td>
                                    <?php echo $post['st_descrip'];?>
                                </td>
                                <td>
                                    <a href="#" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post['est_codigo'];?>&editar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-check bg-green"></i></a>
                                </td>
                                <td>
                                    <a href="#" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post['est_codigo'];?>&eliminar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-remove bg-red"></i></a>
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