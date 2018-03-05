<?php
$codigo = filter_input(INPUT_POST, codigo);
$selrubro = filter_input(INPUT_POST, selrubro);
$cantidad = filter_input(INPUT_POST, cantidad);
$adddest = filter_input(INPUT_POST, adddest);
$opcion = filter_input(INPUT_POST, opcion);
$entidad = filter_input(INPUT_POST, entidad);
$unidad = filter_input(INPUT_POST, unidad);
$codigodet = filter_input(INPUT_POST, codigodet);
$eliminar = filter_input(INPUT_POST, eliminar);
if($opcion!=""){
    
} else {
    if($adddest==1 and $codigo!=""){
        paraTodos::arrayInserte("prdes_prcodigo,prdes_entidad, prdes_unidad", "produccion_destino ", "$codigo, '$entidad', $unidad");
    }
    if($eliminar==1 and $codigo!=""){
        $delete = paraTodos::arrayDelete("prdes_codigo=$codigodet", "produccion_destino");
        $codigodet = "";
        $codigo = "";
    }
}