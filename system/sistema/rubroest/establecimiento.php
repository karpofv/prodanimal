<link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<div class="row right_col">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Establecimientos</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tbestablec" class='stripe' cellspacing='0' width='100%'>
                    <div class='cabecera'>
                        <thead>
                            <tr class="fila">
                                <th>Rif</th>
                                <th>Nombre</th>
                                <th>Propietario</th>
                                <th>Dirección</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                    </div>
                    <tbody class="body">
                <?php
                        $consul_establece = paraTodos::arrayConsulta("*", "establecimiento e, municipio m", "est_estado=1 and m.mun_codigo=e.est_muncodigo");
                        foreach($consul_establece as $post){
                ?>
                        <tr>
                            <td>
                                <?php echo $post['est_rif'];?>
                            </td>
                            <td>
                                <?php echo $post['est_nombre'];?>
                            </td>
                            <td>
                                <?php echo $post['est_propietario'];?>
                            </td>
                            <td>
                                <?php echo $post['est_direccion'];?>
                            </td>
                            <td>
                                <a href="#" onclick="addestablec(<?php echo $post['est_codigo']?>,'<?php echo $post['mun_descrip']?>','<?php echo $post['est_nombre']?>')"><i class="fa fa-check"></i></a>
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
<script>
$('#tbestablec').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});
</script>