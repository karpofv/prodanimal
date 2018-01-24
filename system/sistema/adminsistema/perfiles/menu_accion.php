<?php
    $codigo = $_POST[codigo];
    $acc = $_POST[acc];
    $permiso = strtoupper($_POST[perm]);
    $submen = $_POST[submen];
    $menu = $_POST[menu];
    $perf = $_POST[perf];
    if($acc==1){
        $acc=0;
        $color = "red";
        $icon = "remove";
    } else {
        $acc=1;
        $color = "green";
        $icon = "check";        
    }
    /*Se verifica ya se hallan establecidos permisos antes para este submenu para el perfil seleccionado*/
    $verifica = paraTodos::arrayConsultanum("*", "perfiles_det", "perdet_perfcodigo=$perf and perdet_submcodigo=$submen");
    if($verifica>0){
        /*Se actualiza el valor de la accion por la opcion contraria a la recibida*/
        paraTodos::arrayUpdate("perdet_$permiso=$acc", "perfiles_det", "perdet_perfcodigo=$perf and perdet_submcodigo=$submen");
    } else {
        paraTodos::arrayInserte("perdet_perfcodigo, perdet_menucodigo, perdet_submcodigo, perdet_$permiso", "perfiles_det", "$perf, $menu, $submen, $acc");
    }
?>
    <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $codigo?>&acc=<?php echo $acc;?>&perm=<?php echo $permiso;?>&submen=<?php echo $submen;?>&perf=<?php echo $perf;?>&menu=<?php echo $menu;?>','td_<?php echo $codigo?>_<?php echo $permiso;?>','')">
        <i class="glyphicon glyphicon-<?php echo $icon;?>" style="color:<?php echo $color;?>"></i>    
    </a>