<?php
$codigo = $_POST[codigo];
$cedula = $_POST[cedula];
$nombre = utf8_encode($_POST[nombre]);
$apellido = utf8_encode($_POST[apellido]);
$usuario = utf8_encode($_POST[usuario]);
$pass = md5($_POST[pass]);
$tipo = $_POST[tipo];
$eliminar = $_POST[eliminar];
$editar = $_POST[editar];
/*GUARDAR*/
if ($editar=='1' and $codigo==""){
    $consulu = paraTodos::arrayConsultanum("*", "usuarios", "Cedula='$cedula'");
    if ($consulu>0){
        paraTodos::showMsg("Esta persona ya se encuentra registrada", "alert-danger");
    } else{
        paraTodos::arrayInserte("Cedula, Usuario, Nivel, contrasena, Tipo", "usuarios", "$cedula, '$usuario', '$tipo', '$pass', 'Empleado'");
        paraTodos::arrayInserte("per_cedula, per_nombres, per_apellidos", "persona", "$cedula, '$nombre', '$apellido'");
    }
    $cedula ="";
    $nombre ="";
    $apellido ="";
    $usuario ="";
    $tipo ="";
    $pass ="";
}
/*UPDATE*/
if($editar == 1 and $nombre !="" and $codigo!=""){
    if($pass!=""){
        $updatepass = ", contrasena='$pass'";
    }
    paraTodos::arrayUpdate("Cedula='$cedula', Usuario='$usuario', Nivel='$tipo'$updatepass", "usuarios", "id=$codigo");
    paraTodos::arrayUpdate("per_cedula='$cedula', per_nombres='$nombre', per_apellidos='$apellido'", "persona", "per_cedula=$cedula");
    $codigo="";
    $cedula ="";
    $nombre ="";
    $apellido ="";
    $usuario ="";
    $tipo ="";
    $pass ="";
}
/*ELIMINAR*/
if ($eliminar !=''){
    paraTodos::arrayDelete("id=$codigo", "usuarios");
    $codigo="";
}
/*MOSTRAR*/
if($editar == 1 and $codigo !="" and $nombre==""){

    $consulta = paraTodos::arrayConsulta("p.per_cedula, p.per_nombres, p.per_apellidos, pf.perf_codigo, u.Usuario", "usuarios u, persona p, perfiles pf", "u.Cedula=p.per_cedula and u.Nivel=pf.perf_codigo and u.id=$codigo");
    foreach($consulta as $row){
        $cedula =$row[per_cedula];
        $nombre =$row[per_nombres];
        $apellido =$row[per_apellidos];
        $usuario =$row[Usuario];
        $tipo =$row[perf_codigo];
    }
}
$consulta = paraTodos::arrayConsulta("p.per_cedula, p.per_nombres, p.per_apellidos, pf.perf_descripcion, u.Usuario, u.id", "usuarios u, persona p, perfiles pf", "u.Cedula=p.per_cedula and u.Nivel=pf.perf_codigo and u.Nivel<>1");
?>
