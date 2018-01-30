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
                <div class="form-title">
                    <a href="javascript:void(0)" onclick="controler('dmn=<?php echo $idMenu;?>&act=2&ver=1', 'VentanaVer');"><img src="<?php echo $ruta_base;?>/assets/images/search.png" id="btnbusc" class="btntb"></a>
                </div>
                <div class="form-body">						
                    <label>Establecimiento</label>
                    <input type="text" id="establec" class="form-control" readonly>
                    <input type="text" id="codigoestab" class="collapse">
                </div>
            </div>
            <div class="inline-form widget-shadow">
                <div class="form-title">
                    <h4>Seleccione Rubro</h4>
                </div>
                <div class="form-body">						
                    <table id="tbrubros" class='stripe' cellspacing='0' width='100%'>
                        <div class='cabecera'>			
                            <thead >
                                <tr class="fila">
                                    <th>Rubro</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                        </div>
                        <tbody class="body">
<?php
                            foreach($consul_rubros as $post){
?>
                            <tr>
                                <td><?php echo $post['ru_descripcion'];?></td>
                                <td><a href="javascript:void(0)" onclick="controler('dmn=<?php echo $idMenu;?>&ver=1&act=3&codigo=<?php echo $post[ru_codigo];?>&estable='+$('#codigoestab').val()+'&editar=1','rubrosasig');"><i class="fa fa-plus"></i></a></td>
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
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Rubros asignados</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="inline-form widget-shadow" id="rubrosasig"></div>                
            </div>
        </div>
    </div>
</div>
<script>
$('#tbrubros').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});    
</script>