<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Personal</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&codigo='+$('#codigo').val()+'&cedula='+$('#cedula').val()+'&nombre='+$('#nombre').val()+'&apellido='+$('#apellido').val()+'&cargo='+$('#cargo').val()+'&direccion='+$('#direccion').val()+'&telefono='+$('#telefono').val()+'&tipo='+$('#seltipo').val()+'&estado='+$('#selestado').val()+'&editar=1&ver=1', 'verContenido'); return false;">
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="control-label">Cédula</label>                            
                                <input type="number" class="form-control" placeholder="00000000" id="cedula" value="<?php echo $cedula;?>">
                                <input type="number" class="collapse" id="codigo" value="<?php echo $codigo;?>">
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Nombres</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo $nombre;?>" required>
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" value="<?php echo $apellido?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="control-label">Cargo</label>                            
                            <input type="text" class="form-control" id="cargo" value="<?php echo $cargo?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Tipo</label>                                
                            <select class="form-control" id="seltipo">
                                <option value="">Seleccione una opción</option>
<?php
    combos::CombosSelect("1", "$tipo", "tip_codigo, tip_descripcion", "tools_tipoemp", "tip_codigo", "tip_descripcion", "1=1");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Dirección</label>                            
                            <input type="text" class="form-control" id="direccion" value="<?php echo $direccion?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5">
                            <label class="control-label">Teléfono</label>                                
                            <input type="tel" class="form-control" id="telef" value="<?php echo $telefono?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Estado</label>
                            <select class="form-control" id="selestado" required>
                                <option value="">Selecciona una opción</option>
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
                <h2>Usuarios registrados</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover" id="usuarios">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombres y Apellidos</th>
                            <th>Cargo</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                foreach($consul_personal as $post){
                            ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $post['per_cedula'];?>
                                </th>
                                <td>
                                    <?php echo $post['per_nombres']." ".$post['per_apellidos'];?>
                                </td>
                                <td>
                                    <?php echo $post['per_cargo'];?>
                                </td>
                                <td>
                                    <?php echo $post['per_direccion'];?>
                                </td>
                                <td>
                                    <?php echo $post['per_telefono'];?>
                                </td>
                                <td>
                                    <?php echo $post['tip_descripcion'];?>
                                </td>
                                <td>
                                    <?php echo $post['st_descripcion'];?>
                                </td>
                                <td>
                                    <a href="#" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post['per_codigo'];?>&editar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-check bg-green"></i></a>
                                </td>
                                <td>
                                    <a href="#" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $post['per_codigo'];?>&eliminar=1&ver=1', 'verContenido');"><i class="glyphicon glyphicon-remove bg-red"></i></a>
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