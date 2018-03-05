<?php
    $rubro = $consul_prod[0]['pr_rucodigo'];
    $opcion = $_POST[actd];
    $codigoest = $_POST[codigoest];
    $editar = $_POST[editar];
    $fecha = $_POST[fecha];
    $selmes = $_POST[selmes];
    $codigoestab = $_POST[codigoestab];
    $selelab = $_POST[selelab];
    $fechae = $_POST[fechae];
    $seleen = $_POST[seleen];
    $selrubro = $_POST[selrubro];
    $observ = $_POST[observ];
    $codigo = $_POST[codigo];
    if($editar==1 and $codigo==""){
        paraTodos::arrayInserte("pr_estcodigo, pr_mes, pr_rucodigo, pr_fechaelab, pr_fechatrans, pr_perelab, pr_pertrans, pr_perencuest, pr_observacion, pr_estado", "produccion","$codigoestab,$selmes,$selrubro,'$fechae','$fecha',$selelab,$seleen,$seleen,'$observ',1");
        $consulprcodigo = paraTodos::arrayConsulta("max(pr_codigo) as pr_codigo", "produccion", "pr_estcodigo=$codigoestab");
    }
    $consul_prod = paraTodos::arrayConsulta("pr_rucodigo", "produccion", "pr_codigo=$codigo");
?>
<div class="panel-heading">
    <h4>Tipo de Rubro</h4>
</div>
<div class="panel-body">
    <div class="alert alert-warning alert-dismissable collapse" id="alertdet">
        <strong>¡Cuidado!</strong> Ya este rubro esta registrado bajo estas características en la producción.<br>Ingrese la Distribución
    </div>
        <input type="number" id="codigo_prod" class="collapse" value="<?php echo $consulprcodigo[0][pr_codigo];?>">    
        <div class="form-group">
            <div class="col-sm-3">
                <label>Tipo de Rubro</label>
                <select id="seltiprubro" class="form-control">
                    <?php
                    combos::CombosSelect("1", "$tiporub", "rut_codigo, rut_descripcion", "rubro_tipo", "rut_codigo", "rut_descripcion", "rut_rucodigo=$selrubro order by rut_descripcion");
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label>Clase de Rubro</label>
                <select id="selclasrubro" class="form-control">
                    <?php
                    combos::CombosSelect("1", "$clasrub", "ruc_codigo, ruc_descripcion", "rubro_calse", "ruc_codigo", "ruc_descripcion", "ruc_rucodigo=$selrubro order by ruc_descripcion");
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label>Categoría de Rubro</label>
                <select id="selcatrubro" class="form-control">
                    <?php
                    combos::CombosSelect("1", "$catrub", "rucat_codigo, rucat_descripcion", "rubro_categoria", "rucat_codigo", "rucat_descripcion", "rucat_rucodigo=$selrubro order by rucat_descripcion");
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label id="lbltotaltip">Total</label>
                <input type="number" id="totaltiprub" class="form-control" required>
            </div>
            <div class="col-sm-1">
                <button type="button" id="btndetalle" class="btn btn-default" onclick="controler('dmn=<?php echo $idMenu?>&act=4&codigo=<?php echo $codigo;?>&tiporub='+$('#seltiprubro').val()+'&clasrub='+$('#selclasrubro').val()+'&catrub='+$('#selcatrubro').val(),'');
                                                                                       controler('dmn=<?php echo $idMenu;?>&ver=1&act=3&codigo=<?php echo $codigo;?>','paneltbconsul');">Agregar</button>
            </div>
        </div>
</div>