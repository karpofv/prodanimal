<?php
$opcion = $_POST[actd];
if($opcion!=""){
    if($opcion==1){
        
    }
} else {
    $consul_rubros = paraTodos::arrayConsulta("*", "rubros", "ru_estado=1");
}
?>