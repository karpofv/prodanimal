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
        paraTodos::arrayInserte("rucat_rucodigo, rucat_descripcion,rucat_estado", "rubro_categoria", "'$rubro', '$descrip', $estado");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("rucat_rucodigo='$rubro',rucat_descripcion='$descrip',rucat_estado='$estado'", "rubro_categoria", "rucat_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $rubro = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "rubro_categoria", "rucat_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[rucat_descripcion];
            $estado = $post[rucat_estado];
            $rubro = $post[rucat_rucodigo];
            $codigo = $post[rucat_estado];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("rucat_codigo=$codigo" ,"rubro_categoria");
        $eliminar="";
    }
    $consul_catego = paraTodos::arrayConsulta("*", "rubro_categoria rc, rubros r, tools_status s", "rc.rucat_rucodigo=r.ru_codigo and rc.rucat_estado=st_codigo");
}
?>