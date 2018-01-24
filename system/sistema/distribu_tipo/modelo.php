<?php
$opcion = $_POST[opcion];
$editar = $_POST[editar];
$eliminar = $_POST[eliminar];
$codigo = $_POST[codigo];
$descrip = $_POST[descrip];
$rubro = $_POST[rubro];
$estado = $_POST[estado];
if($opcion!=""){

} else{
    if($editar==1 and $codigo=="" and $descrip!=""){
        paraTodos::arrayInserte("tip_rutcodigo, tip_medida,tip_estado", "tipos_medidas", "'$rubro', '$descrip', $estado");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("tip_rutcodigo='$rubro',tip_medida='$descrip',tip_estado='$estado'", "tipos_medidas", "tip_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "tipos_medidas", "tip_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[tip_medida];
            $estado = $post[tip_estado];
            $rubro = $post[tip_rutcodigo];
            $codigo = $post[tip_codigo];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("tip_codigo=$codigo" ,"tipos_medidas");
        $eliminar="";
    }
    $consul_tipo = paraTodos::arrayConsulta("*", "tipos_medidas tm, rubro_tipo r, tools_status", "tm.tip_rutcodigo=r.rut_codigo and tip_estado=st_codigo");
}
?>

