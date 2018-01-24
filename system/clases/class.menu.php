<?php
Class Menu {
    function submenu($codigo, $nivel, $subc){
        $nivel = $nivel+1;
?>
    <ul class="nav child_menu">
        <?php
        if($nivel==1){
            $consulsubmenu = paraTodos::arrayConsulta("*","menu_submenu sm, perfiles_det pd","sm.subm_codigo=pd.perdet_submcodigo and subm_menucodigo=$codigo and subm_status=1 and subm_nivel=1 and perdet_S=1");
        } else {
            $consulsubmenu = paraTodos::arrayConsulta("*","menu_submenu sm, perfiles_det pd","sm.subm_codigo=pd.perdet_submcodigo and subm_conexion=$subc and subm_status=1 and subm_nivel=$nivel and perdet_S=1");
        }
        foreach($consulsubmenu as $submenu){
            if (strlen($submenu['subm_descripcion']) > 14) {
                $submenuli = substr($submenu['subm_descripcion'],0,14).'... ';
            } else {
                $submenuli = $submenu['subm_descripcion'];
            }
?>
            <li>
                <a href="#" title="<?php echo $submenu['subm_descripcion']; ?>" onclick="controler('dmn=<?php echo $submenu['subm_codigo'];?>&ver=1', 'verContenido')">
                    <i class="<?php echo $submenu[subm_icono]?>"></i>
                    <span><?php echo $submenuli; ?></span>
                </a>
                <?php
                Menu::submenu($codigo, $nivel, $submenu['subm_codigo']);
?>
            </li>
            <?php
        }
?>
    </ul>
    <?php
    }
    function menuprinc() {
        /*Se consulta menu principal*/
        $consulmenu = paraTodos::arrayConsulta("distinct m.*","menu m, perfiles_det pd","m.menu_codigo=pd.perdet_menucodigo and m.menu_status=1 and perdet_S=1");
        foreach($consulmenu as $menu){
            if (strlen($menu['menu_descripcion']) > 14) {
              $menuli = substr($menu['menu_descripcion'],0,14).'... ';
            } else {
              $menuli = $menu['menu_descripcion'];
            }
            ?>
        <li>
            <a href="#" title="<?php echo $menu['menu_descripcion']; ?>">
                <i class="<?php echo $menu[menu_icono]?>"></i>
                <span class="nav-label"><?php echo $menuli; ?></span><span class="fa arrow"></span>
            </a>
                <?php
                    Menu::submenu($menu['menu_codigo'], 0, 0);
                ?>
        </li>

        <?php
        }
        ////////////////////////////////////////////////////////////////////
    }
}
?>
