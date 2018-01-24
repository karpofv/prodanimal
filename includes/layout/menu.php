<?php
    $consuldatospersonales = paraTodos::arrayConsulta("*", "persona", "per_cedula=$_SESSION[ci]");
    foreach($consuldatospersonales as $datospersonales){
        $nombre_perfil = $datospersonales[per_nombres];
        $apellido_perfil = $datospersonales[per_apellidos];
    }
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index-2.html" class="site_title"><i class="fa fa-paw"></i> <span>Producción Animal </span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $apellido_perfil." ".$nombre_perfil;?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Menu principal</h3>
                <ul class="nav side-menu">
                    <?php
                    $menu = new Menu();
                    $menu->menuprinc(1);
                    ?>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Salir" href="control.php?salir=1">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>