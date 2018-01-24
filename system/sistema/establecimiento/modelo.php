<?php
$opcion = $_POST[opcion];
$editar = $_POST[editar];
$eliminar = $_POST[eliminar];
$codigo = $_POST[codigo];
$rif = $_POST[rif];
$nombre = $_POST[nombre];
$propietario = $_POST[propietario];
$direccion = $_POST[direccion];
$municipio = $_POST[municipio];
$parroquia = $_POST[parroquia];
$tipo = $_POST[tipo];
$estado = $_POST[estado];
if($opcion!=""){
    
} else{
    if($editar==1 and $codigo=="" and $nombre!=""){
        paraTodos::arrayInserte("est_nombre, est_rif, est_propietario, est_tipo, est_muncodigo, est_parcodigo, est_direccion, est_estado", "establecimiento", "'$nombre', '$rif', '$propietario', '$tipo', '$municipio', '$parroquia', '$direccion', $estado");
        $rif = "";
        $nombre = "";
        $propietario = "";
        $direccion = "";
        $municipio = "";
        $parroquia = "";
        $tipo = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $nombre!=""){
        paraTodos::arrayUpdate("est_nombre='$nombre',est_rif='$rif',est_propietario='$propietario',est_tipo='$tipo',est_muncodigo='$municipio',est_parcodigo='$parroquia',est_direccion='$direccion',est_estado='$estado'", "establecimiento", "est_codigo=$codigo");
        $rif = "";
        $nombre = "";
        $propietario = "";
        $direccion = "";
        $municipio = "";
        $parroquia = "";
        $tipo = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $nombre==""){
        $consulta = paraTodos::arrayConsulta("*", "establecimiento", "est_codigo=$codigo");
        foreach($consulta as $post){
            $rif = $post[est_rif];
            $nombre = $post[est_nombre];
            $propietario = $post[est_propietario];
            $direccion = $post[est_direccion];
            $municipio = $post[est_muncodigo];
            $parroquia = $post[est_parcodigo];
            $tipo = $post[est_tipo];
            $estado = $post[est_estado];
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("est_codigo=$codigo" ,"personal");
        $eliminar="";
    }
    $consul_establecimiento = paraTodos::arrayConsulta("*", "establecimiento e,municipio m, parroquia p, tools_status", "e.est_muncodigo=m.mun_codigo and e.est_parcodigo=p.par_codigo and est_estado=st_codigo");
}
?>