<?php
    ini_set('display_errors', false);
    ini_set('display_startup_errors', false);
    $campos    = "perf_descripcion";
    $tablas    = "perfiles";
    $consultas = "perf_codigo =$_POST[idperfil]";
    $dmn = $_POST['dmn'];
    $res_car =paraTodos::arrayConsulta($campos,$tablas,$consultas);
    foreach ($res_car as $row ) {
        $nombre_pefil=$row['perf_descripcion'];
    }
?>
    <div class="contenedor-formulario">
        <div class="wrap">
            <h5>
                <i class="icon-reorder"></i> Configuración del Perfil <b> (<?php echo $nombre_pefil; ?>)</b>
            </h5>
            <a style="float:right;margin-right: 15px;margin-top: -10px;" onclick="var msg = confirm('Esta seguro que desea eliminar este Perfil?');
                    if (msg) {controler('ver=2&eliminar=<?php echo $_POST[idperfil]?>&dmn=<?php echo $dmn; ?>','verContenido');} return false;" href="javascript:void(0);">Eliminar el Perfil</a>
            <div class="widget-body">
                <table class="table">
<?php
                    $indicemenu=1;
                    $resultx=paraTodos::arrayConsulta("*", "menu","1=1 order by menu_codigo" );
                    foreach ($resultx as $row) {
?>
                    <tr style="background: #EEEEEE;font-weight: bold;font-size: 13px;">
                        <td class="CeldaRecojeDatos" height="20">
                            <span style="width: 350px;font-weight: 800;color: #000000;"><b><?php echo $row["menu_descripcion"];?></b></span>
                        </td>
                        <td style="padding: 5px;font-weight: 700;color: #333333;">Consultar</td>
                        <td style="padding: 5px;font-weight: 700;color: #333333;">Insertar</td>
                        <td style="padding: 5px;font-weight: 700;color: #333333;">Modificar</td>
                        <td style="padding: 5px;font-weight: 700;color: #333333;">Eliminar</td>
                        <td style="padding: 5px;font-weight: 700;color: #333333;">Imprimir</td>
                    </tr>
                    <?php
                        $submenu=paraTodos::arrayConsulta("*", "menu_submenu","subm_menucodigo=$row[menu_codigo] order by subm_codigo" );
                        foreach($submenu as $resultado){
?>
                    <tr>
                        <td><?php echo $resultado[subm_descripcion];?></td>
<?php
                        $icon_s="remove";
                        $icon_u="remove";
                        $icon_d="remove";
                        $icon_i="remove";
                        $icon_p="remove";
                        $color_s="red";                            
                        $color_u="red";
                        $color_d="red";
                        $color_i="red";
                        $color_p="red";
                        $acc_s="0";
                        $acc_u="0";
                        $acc_d="0";
                        $acc_i="0";
                        $acc_p="0";
                        $consulpermisos = paraTodos::arrayConsulta("*", "perfiles_det pd", "pd.perdet_perfcodigo=$_POST[idperfil] and pd.perdet_menucodigo=$row[menu_codigo] and pd.perdet_submcodigo=$resultado[subm_codigo]");
                        foreach($consulpermisos as $permisos){
                            if($permisos[perdet_S]!="" and $permisos[perdet_S]!=0){$icon_s="check"; $color_s="green"; $acc_s=1;} else {$icon_s="remove"; $color_s="red"; $acc_s=0;}
                            if($permisos[perdet_U]!="" and $permisos[perdet_U]!=0){$icon_u="check"; $color_u="green"; $acc_u=1;} else {$icon_u="remove"; $color_u="red"; $acc_u=0;}
                            if($permisos[perdet_D]!="" and $permisos[perdet_D]!=0){$icon_d="check"; $color_d="green"; $acc_d=1;} else {$icon_d="remove"; $color_d="red"; $acc_d=0;}
                            if($permisos[perdet_I]!="" and $permisos[perdet_I]!=0){$icon_i="check"; $color_i="green"; $acc_i=1;} else {$icon_i="remove"; $color_i="red"; $acc_i=0;}
                            if($permisos[perdet_P]!="" and $permisos[perdet_P]!=0){$icon_p="check"; $color_p="green"; $acc_p=1;} else {$icon_p="remove"; $color_p="red"; $acc_p=0;}
                        }
?>
                        <td id="td_<?php echo $permisos[perdet_codigo]?>_s">
                            <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $permisos[perdet_codigo]?>&acc=<?php echo $acc_s;?>&perm=s&submen=<?php echo $resultado[subm_codigo]?>&perf=<?php echo $_POST[idperfil];?>&menu=<?php echo $row[menu_codigo];?>','td_<?php echo $permisos[perdet_codigo]?>_s','')">
                                <i class="glyphicon glyphicon-<?php echo $icon_s;?>" style="color:<?php echo $color_s;?>"></i>
                            </a>
                        </td>
                        <td id="td_<?php echo $permisos[perdet_codigo]?>_u">
                            <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $permisos[perdet_codigo]?>&acc=<?php echo $acc_u;?>&perm=u&submen=<?php echo $resultado[subm_codigo]?>&perf=<?php echo $_POST[idperfil];?>&menu=<?php echo $row[menu_codigo];?>','td_<?php echo $permisos[perdet_codigo]?>_u','')">
                                <i class="glyphicon glyphicon-<?php echo $icon_u;?>" style="color:<?php echo $color_u;?>"></i>
                            </a>
                        </td>
                        <td id="td_<?php echo $permisos[perdet_codigo]?>_d">
                            <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $permisos[perdet_codigo]?>&acc=<?php echo $acc_d;?>&perm=d&submen=<?php echo $resultado[subm_codigo]?>&perf=<?php echo $_POST[idperfil];?>&menu=<?php echo $row[menu_codigo];?>','td_<?php echo $permisos[perdet_codigo]?>_d','')">
                                <i class="glyphicon glyphicon-<?php echo $icon_d;?>" style="color:<?php echo $color_d;?>"></i>
                            </a>
                        </td>
                        <td id="td_<?php echo $permisos[perdet_codigo]?>_i">
                            <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $permisos[perdet_codigo]?>&acc=<?php echo $acc_i;?>&perm=i&submen=<?php echo $resultado[subm_codigo]?>&perf=<?php echo $_POST[idperfil];?>&menu=<?php echo $row[menu_codigo];?>','td_<?php echo $permisos[perdet_codigo]?>_i','')">
                                <i class="glyphicon glyphicon-<?php echo $icon_i;?>" style="color:<?php echo $color_i;?>"></i>
                            </a>
                        </td>
                        <td id="td_<?php echo $permisos[perdet_codigo]?>_p">
                            <a href="javascript:void(0);" onclick="controler('ver=1&dmn=<?php echo $idMenu;?>&act=3&codigo=<?php echo $permisos[perdet_codigo]?>&acc=<?php echo $acc_p;?>&perm=p&submen=<?php echo $resultado[subm_codigo]?>&perf=<?php echo $_POST[idperfil];?>&menu=<?php echo $row[menu_codigo];?>','td_<?php echo $permisos[perdet_codigo]?>_p','')">
                                <i class="glyphicon glyphicon-<?php echo $icon_p;?>" style="color:<?php echo $color_p;?>"></i>
                            </a>
                        </td>
                    </tr>
<?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
</div>                  