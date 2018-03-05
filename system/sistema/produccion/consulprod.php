<?php
$codestab = $_POST['codigoestab'];
$selrubro = $_POST['selrubro'];
/*Se busca la ultima produccion cargada y se muestran los datos*/
    $consulprcodigo = paraTodos::arrayConsulta("max(pr_codigo) as pr_codigo", "produccion", "pr_estcodigo=$codigoestab and pr_rucodigo=$selrubro");
    $cod_prod = $consulprcodigo[0]['pr_codigo'];
?>
<table id='tbconsul' class='stripe' cellspacing='0' width='100%'>
    <div class='cabecera'>
        <thead>
            <tr class='fila'>
                <th>Mes</th>
                <th>Establecimiento</th>
                <th>Rubro</th>
                <th>Tipo de Rubro</th>
                <th id='thtotal'>Total Producción</th>
                <th>Clase</th>
                <th>Categoría</th>
                <th id='thdistri'>Distribucion</th>
                <th>Cantidad</th>
                <th>Eliminar<?php echo $codigo;?></th>
            </tr>
        </thead>
    </div>
    <tbody class='body'>
        <?php
        $consul_prod = paraTodos::arrayConsulta("m.mes_descripcion, e.est_nombre, r.ru_descripcion", "produccion pr, tools_mes m, establecimiento e, rubros r", "pr_codigo=$cod_prod and pr.pr_mes=m.mes_codigo and pr.pr_estcodigo=e.est_codigo and pr.pr_rucodigo=r.ru_codigo");
        foreach($consul_prod as $prod){
?>
        <tr>
            <td><?php echo $prod['mes_descripcion'];?></td>
            <td><?php echo $prod['est_nombre'];?></td>
            <td><?php echo $prod['ru_descripcion'];?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="javascript:void(0);"><i class="fa fa-eraser"></i></a></td>
        </tr>
<?php
        }
        ?>
    </tbody>
</table>
<script>
$('#tbconsul').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});    
</script>