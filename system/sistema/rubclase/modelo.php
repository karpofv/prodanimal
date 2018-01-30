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
        paraTodos::arrayInserte("ruc_rucodigo, ruc_descripcion,ruc_estado", "rubro_calse", "'$rubro', '$descrip', $estado");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("ruc_rucodigo='$rubro',ruc_descripcion='$descrip',ruc_estado='$estado'", "rubro_calse", "ruc_estado=$codigo");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "rubro_calse", "ruc_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[ruc_descripcion];
            $estado = $post[ruc_estado];
            $rubro = $post[ruc_rucodigo];
            $codigo = $post[ruc_estado];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("ruc_codigo=$codigo" ,"rubro_calse");
        $eliminar="";
    }
    $consul_clase = paraTodos::arrayConsulta("*", "rubro_calse rc, rubros r, tools_status s", "rc.ruc_rucodigo=r.ru_codigo and rc.ruc_estado=st_codigo");
}
?>

