<?php
$opcion = $_POST[opcion];
$editar = $_POST[editar];
$eliminar = $_POST[eliminar];
$codigo = $_POST[codigo];
$cedula = $_POST[cedula];
$nombre = $_POST[nombre];
$apellido = $_POST[apellido];
$cargo = $_POST[cargo];
$direccion = $_POST[direccion];
$telefono = $_POST[telefono];
$tipo = $_POST[tipo];
$estado = $_POST[estado];
if($opcion!=""){
    
} else{
    if($editar==1 and $codigo=="" and $nombre!=""){
        paraTodos::arrayInserte("per_cedula, per_nombres, per_apellidos, per_cargo, per_direccion, per_telefono, per_tipo, per_estado", "personal", "$cedula, '$nombre', '$apellido', '$cargo', '$direccion', '$telefono', $tipo, $estado");
        $cedula = "";
        $nombre = "";
        $apellido = "";
        $cargo = "";
        $direccion = "";
        $telefono = "";
        $tipo = "";
        $estado = "";
        $codigo = "";
    }
    if($editar==1 and $codigo!="" and $nombre!=""){
        paraTodos::arrayUpdate("per_cedula=$cedula,per_nombres='$nombre',per_apellidos='$apellido',per_cargo='$cargo',per_direccion='$direccion',per_telefono='$telefono',per_tipo=$tipo,per_estado=$estado", "personal", "per_codigo=$codigo");
            $cedula = "";
            $nombre = "";
            $apellido = "";
            $cargo = "";
            $direccion = "";
            $telefono = "";
            $tipo = "";
            $estado = "";
            $codigo = "";
    }
    if($editar==1 and $codigo!="" and $nombre==""){
        $consulta = paraTodos::arrayConsulta("*", "personal", "per_codigo=$codigo");
        foreach($consulta as $post){
            $cedula = $post[per_cedula];
            $nombre = $post[per_nombres];
            $apellido = $post[per_apellidos];
            $cargo = $post[per_cargo];
            $direccion = $post[per_direccion];
            $telefono = $post[per_telefono];
            $tipo = $post[per_tipo];
            $estado = $post[per_estado];           
        }
    }
    if($eliminar==1){
        paraTodos::arrayDelete("per_codigo=$codigo" ,"personal");
        $eliminar="";
    }
    $consul_personal = paraTodos::arrayConsulta("*", "personal p, tools_status s, tools_tipoemp t", "per_estado=st_codigo and per_tipo=tip_codigo");
}
?>