<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Usuarios</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="controler('dmn=<?php echo $idMenu;?>&codigo='+$('#codigo').val()+'&cedula='+$('#cedula').val()+'&nombre='+$('#nombre').val()+'&apellido='+$('#apellido').val()+'&usuario='+$('#usuario').val()+'&pass='+$('#clave').val()+'&tipo='+$('#seltipo').val()+'&editar=1&ver=1', 'verContenido'); return false;">
                    <div class="row">
                        <div class="col-sm-2" style="display: block;">
                            <label class="control-label" for="cedula">Cédula</label>
                            <input class="form-control" id="cedula" type="number" value="<?php echo $cedula; ?>" required>
                            <input class="form-control" id="codigo" type="hidden" value="<?php echo $codigo; ?>"> </div>
                        <div class="col-sm-5" style="display: block;">
                            <label class="control-label" for="nombre">Nombres</label>
                            <input class="form-control" id="nombre" type="text" value="<?php echo $nombre;?>" required> </div>
                        <div class="col-sm-5" style="display: block;">
                            <label class="control-label" for="apellido">Apellidos</label>
                            <input class="form-control" id="apellido" type="text" value="<?php echo $apellido;?>" required> </div>
                        <div class="col-sm-4" style="display: block;">
                            <label class="control-label" for="usuario">Usuario</label>
                            <input class="form-control" id="usuario" type="text" value="<?php echo $usuario;?>" required> </div>
                        <div class="col-sm-4" style="display: block;">
                            <label class="control-label" for="clave">clave</label>
                            <input class="form-control" id="clave" type="password"> </div>
                        <div class="col-sm-4" style="display: block;">
                            <label class="control-label" for="seltipo">Tipo de usuario</label>
                            <select class="form-control" id="seltipo" required>
                                <option value="">Seleccione una opción</option>
                                <?php
                                    combos::CombosSelect("1", "$tipo", "perf_codigo, perf_descripcion", "perfiles", "perf_codigo", "perf_descripcion", "perf_codigo<>1");
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <br>
                            <input id="enviar" type="submit" value="Guardar" class="btn btn-primary col-md-offset-5"> </div>
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
                            <td class="text-center"><strong>Cédula</strong></td>
                            <td class="text-center"><strong>Nombres</strong></td>
                            <td class="text-center"><strong>Apellidos</strong></td>
                            <td class="text-center"><strong>Usuario</strong></td>
                            <td class="text-center"><strong>Tipo de usuario</strong></td>
                            <td class="text-center"><strong>Editar</strong></td>
                            <td class="text-center"><strong>Eliminar</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($consulta as $row){
                        ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $row[per_cedula];?>
                                </td>
                                <td class="text-center">
                                    <?php echo utf8_decode($row[per_nombres]);?>
                                </td>
                                <td class="text-center">
                                    <?php echo utf8_decode($row[per_apellidos]);?>
                                </td>
                                <td class="text-center">
                                    <?php echo utf8_decode($row[Usuario]);?>
                                </td>
                                <td class="text-center">
                                    <?php echo utf8_decode($row[perf_descripcion]);?>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $row[id];?>&editar=1&ver=1', 'verContenido');"> <i class="fa fa-edit"></i> </a>
                                </td>
                                <td class="text-center"> <a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&codigo=<?php echo $row[id];?>&eliminar=1&ver=1', 'verContenido');"><i class="fa fa-eraser"></i>
                                    </a> </td>
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