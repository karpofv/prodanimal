<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt=""><?php echo $apellido_perfil." ".$nombre_perfil;?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="control.php?salir=1"><i class="fa fa-sign-out pull-right"></i>Salir</a></li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">0</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php
                    /*                        
                        <li>
                            <a>
                                <span class="image"><img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt="Profile Image" /></span>
                                <span>
                          <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt="Profile Image" /></span>
                                <span>
                          <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt="Profile Image" /></span>
                                <span>
                          <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="<?php echo $img_perfil."/".$_SESSION[imgperfil];?>" alt="Profile Image" /></span>
                                <span>
                          <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>*/
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
<div id="VentanaVer"></div>
<div class="right_col" role="main" id="verContenido">