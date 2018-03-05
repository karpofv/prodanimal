<?php
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
$tiporub = filter_input(INPUT_POST, tiporub);
$clasrub = filter_input(INPUT_POST, clasrub);
$catrub = filter_input(INPUT_POST, catrub);
$totaltiprub = filter_input(INPUT_POST, totaltiprub);
$adddet = filter_input(INPUT_POST, adddet);
$codigodet = filter_input(INPUT_POST, codigodet);
$selmed = filter_input(INPUT_POST, selmed);
$totaldist = filter_input(INPUT_POST, totaldist);
$adddistri = filter_input(INPUT_POST, adddistri);
$eliminardet = filter_input(INPUT_POST, eliminardet);
$tiprub = filter_input(INPUT_POST, tiprub);
$opcion = filter_input(INPUT_POST, actd);
if ($opcion != "") {
    if ($opcion == "1") {
        $consul_dist = paraTodos::arrayConsulta("*", "tipos_medidas", "tip_rutcodigo=$tiprub");
        ?>
        <option value="">Seleccione una opción</option>
        <?php
        foreach ($consul_dist as $rubros) {
            ?>
            <option value="<?php echo $rubros['tip_codigo']; ?>"><?php echo $rubros['tip_medida']; ?></option>
            <?php
        }
    }
} else {
    if ($editar == 1 and $codigo == "") {
        $insertar = paraTodos::arrayInserte("pr_estcodigo, pr_mes, pr_rucodigo, pr_fechaelab, pr_fechatrans, pr_perelab, pr_pertrans, pr_perencuest, pr_observacion, pr_estado", "produccion", "$codigoestab,$selmes,$selrubro,'$fechae','$fecha',$selelab,$seleen,$seleen,'$observ',1");
        if ($insertar) {
            $consulcodigo = paraTodos::arrayConsulta("max(pr_codigo) as pr_codigo", "produccion", "pr_estcodigo=$codigoestab");
            $codigo = $consulcodigo[0]['pr_codigo'];
        }
    }
    if ($editar == 1 and $codigo != "") {
        $consul_prod = paraTodos::arrayConsulta("*", "produccion", "pr_codigo=$codigo");
        $codigoest = $consul_prod[0]['pr_estcodigo'];
        $fecha = $consul_prod[0]['pr_fechatrans'];
        $selmes = $consul_prod[0]['pr_mes'];
        $codigoestab = $consul_prod[0]['codigoestab'];
        $selelab = $consul_prod[0]['pr_perelab'];
        $fechaelab = $consul_prod[0]['pr_fechaelab'];
        $seleen = $consul_prod[0]['pr_perencuest'];
        $selrubro = $consul_prod[0]['pr_rucodigo'];
        $observacion = $consul_prod[0]['pr_observacion'];
        $transcriptor = $consul_prod[0]['pr_perelab'];
        $mes = $consul_prod[0]['pr_mes'];
        $consulestable = paraTodos::arrayConsulta("est_nombre", "establecimiento", "est_codigo=$codigoest");
        $establecimiento = $consulestable[0][est_nombre];
    }
    if ($adddet == 1 and $codigo != "") {
        $insertardet = paraTodos::arrayInserte("prd_prcodigo, prd_rutcodigo, prd_ruccodigo, prd_rucatcodigo, prd_cantidad,prd_monto,prd_tipomen", "produccion_detalle", "$codigo, $tiporub,$clasrub,$catrub,$totaltiprub,'$totaldist',$selmed");
        $consulproddet = paraTodos::arrayConsulta("prd_codigo", "produccion_detalle", "prd_rutcodigo=$tiporub and prd_ruccodigo=$clasrub and prd_rucatcodigo=$catrub");
        $codigodet = $consulproddet[0][prd_codigo];
    }
    if ($eliminardet == 1 and $codigodet != "") {
        $deletedet = paraTodos::arrayDelete("prd_codigo=$codigodet", "produccion_detalle");
    }
}