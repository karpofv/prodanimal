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
                <table id='tbconsul' class='stripe' cellspacing='0' width='100%'>
                    <div class='cabecera'>
                        <thead>
                            <tr class='fila'>
                                <th>Mes</th>
                                <th>Establecimiento</th>
                                <th>Rubro</th>
                                <th>Imprimir</th>
                                <th>Editar</th>                                
                                <th>Eliminar</th>                                
                            </tr>
                        </thead>
                    </div>
                    <tbody class='body'>
                        <?php
                        foreach ($consul_prod as $prod) {
                            ?>
                            <tr>
                                <td><?php echo $prod['mes_descripcion']; ?></td>
                                <td><?php echo $prod['est_nombre']; ?></td>
                                <td><?php echo $prod['ru_descripcion']; ?></td>
                                <?php
                                if($prod['ru_descripcion']=="APICOLA"){
                                    $reporte = "resumena";
                                }
                                if($prod['ru_descripcion']=="VEGETAL"){
                                    $reporte = "resumenv";
                                }
                                if($prod['ru_descripcion']!="VEGETAL" and $prod['ru_descripcion']!="APICOLA"){
                                    $reporte = "resumen";
                                }                                
                                ?>
                                <td><a href="<?php echo $ruta_base;?>/system/sistema/reportes/<?php echo $prod['ru_descripcion'];?>.php?id=<?php echo $prod['pr_codigo'];?>" target="_blank"><i class="fa fa-print"></i></a></td>
                                <td><a href="javascript:void(0);" onclick="controler('dmn=12&editar=1&ver=1&codigo=<?php echo $prod['pr_codigo'] ?>', 'verContenido', '');"><i class="fa fa-edit"></i></a></td>                                
                                <td><a href="javascript:void(0);" onclick="controler('dmn=<?php echo $idMenu;?>&eliminar=1&ver=1&codigo=<?php echo $prod['pr_codigo'] ?>', 'verContenido', '');"><i class="fa fa-eraser"></i></a></td>
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