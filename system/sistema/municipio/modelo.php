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
        paraTodos::arrayInserte("mun_descrip, mun_estado", "municipio", "'$descrip', $estado");
        $descrip = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("mun_descrip='$descrip', mun_estado='$estado'", "municipio", "mun_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "municipio", "mun_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[mun_descrip];
            $estado = $post[mun_estado];
            $codigo = $post[mun_codigo];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("mun_codigo=$codigo" ,"municipio");
        $eliminar="";
    }
    $consulmun = paraTodos::arrayConsulta("*", "municipio m, tools_status", "mun_estado=st_codigo");
}
?>

