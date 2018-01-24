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
        paraTodos::arrayInserte("rut_rucodigo, rut_descripcion, rut_estado", "rubro_tipo", "'$rubro', '$descrip', $estado");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("rut_rucodigo='$rubro',rut_descripcion='$descrip',rut_estado='$estado'", "rubro_tipo", "rut_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "rubro_tipo", "rut_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[rut_descripcion];
            $codigo = $post[rut_codigo];
            $rubro = $post[rut_rucodigo];
            $estado = $post[rut_estado];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("rut_codigo=$codigo" ,"rubro_tipo");
        $eliminar="";
    }
    $consult_tiprub = paraTodos::arrayConsulta("*", "rubro_tipo rt, rubros r, tools_status s", "rt.rut_rucodigo=r.ru_codigo and s.st_codigo=rt.rut_estado");
}
?>

