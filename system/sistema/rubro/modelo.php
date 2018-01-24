<?php
$opcion = $_POST[opcion];
$editar = $_POST[editar];
$eliminar = $_POST[eliminar];
$codigo = $_POST[codigo];
$descrip = $_POST[descrip];
$estado = $_POST[estado];
if($opcion!=""){

} else{
    if($editar==1 and $codigo=="" and $descrip!=""){
        paraTodos::arrayInserte("ru_descripcion, ru_estado", "rubros", "'$descrip', $estado");
        $descrip = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("ru_descripcion='$descrip',ru_estado='$estado'", "rubros", "ru_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "rubros", "ru_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[ru_descripcion];
            $estado = $post[ru_estado];
            $codigo = $post[ru_codigo];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("ru_codigo=$codigo" ,"rubros");
        $eliminar="";
    }
    $consul_rubros = paraTodos::arrayConsulta("*", "rubros, tools_status s", "ru_estado=st_codigo");
}
?>

