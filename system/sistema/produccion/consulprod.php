<?php
$codigo = $_POST[codigo];
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
                <th>Eliminar</th>
            </tr>
        </thead>
    </div>
    <tbody class='body'>
        <?php
        $consul_prod = paraTodos::arrayConsulta("*", "produccion", "pr_codigo=$codigo");
        foreach($consul_prod as $prod){
?>
        <tr>
            <td><?php echo $prod['pr_mes'];?></td>
            <td><?php echo $prod['pr_estcodigo'];?></td>
            <td><?php echo $prod['pr_rucodigo'];?></td>
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