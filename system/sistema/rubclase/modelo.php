<?php
$opcion = $_POST[opcion];
$editar = $_POST[editar];
$eliminar = $_POST[eliminar];
$codigo = $_POST[codigo];
$descrip = $_POST[descrip];
$municipio = $_POST[municipio];
$estado = $_POST[estado];
if($opcion!=""){

} else{
    if($editar==1 and $codigo=="" and $descrip!=""){
        paraTodos::arrayInserte("par_descrip, par_muncodigo,par_estado", "parroquia", "'$descrip', '$municipio', $estado");
        $descrip = "";
        $estado = "";
        $municipio = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip!=""){
        paraTodos::arrayUpdate("par_descrip='$descrip',par_muncodigo='$municipio',par_estado='$estado'", "parroquia", "par_codigo=$codigo");
        $descrip = "";
        $estado = "";
        $municipio = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $descrip==""){
        $consulta = paraTodos::arrayConsulta("*", "parroquia", "par_codigo=$codigo");
        foreach($consulta as $post){
            $descrip = $post[par_descrip];
            $estado = $post[par_estado];
            $municipio = $post[par_muncodigo];
            $codigo = $post[par_codigo];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("par_codigo=$codigo" ,"parroquia");
        $eliminar="";
    }
    $consulpar = paraTodos::arrayConsulta("*", "rubro_calse rc, rubros r", "rc.ruc_rucodigo=r.ru_codigo");
}
?>

