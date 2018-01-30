<?php
    $codigo = $_POST[codigo];
    $estable = $_POST[estable];
    $rubroes = $_POST[rubroes];
    $eliminar = $_POST[eliminar];
    $editar = $_POST[editar];
    if($editar==1){
        paraTodos::arrayInserte("rue_rucodigo, rue_estcodigo", "rubro_estableci", "$codigo, $estable");
    }
    if($eliminar==1){
        paraTodos::arrayDelete("rubro_estableci", "rue_codigo=$rubroes");
    }
?>
    <link href="<?php echo $ruta_base; ?>/assets/css/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="<?php echo $ruta_base; ?>/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <table id='tbrubrosasig' class='stripe' cellspacing='0' width='100%'>
        <div class='cabecera'>
            <thead>
                <tr class='fila'>
                    <th>Rubro</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
        </div>
        <tbody class='body'>
            <?php
                        $consulrub = paraTodos::arrayConsulta("*","rubro_estableci re, rubros r","re.rue_rucodigo=r.ru_codigo and rue_estcodigo=$estable");
                        foreach($consulrub as $post){
?>
                <tr>
                    <td>
                        <?php echo $post['ru_descripcion'];?>
                    </td>
                    <td>
                        <a href='javascript:void(0);' onclick='controler("dmn=<?php echo $idMenu;?>&ver=1&act=3&$rubroe=<?php echo $post[rue_codigo];?>&eliminar=1", "rubrosasig")'><i class="fa fa-eraser"></i></a>
                    </td>
                </tr>
                <?php
                                                   }
                        ?>
        </tbody>
    </table>
    <script>
        $('#tbrubrosasig').DataTable({
            "language": {
                "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
            }
        });
    </script>