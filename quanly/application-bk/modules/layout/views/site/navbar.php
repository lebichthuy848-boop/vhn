<nav>
    <div class="container">
        <div class="nav-inner"> 

            <!-- mobile-menu -->
            <div class="hidden-desktop" id="mobile-menu">
                <ul class="navmenu">
                    <li>
                        <div class="menutop">
                            <div class="toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></div>
                            <h2>Menu</h2>
                        </div>
                        <ul style="display:none;" class="submenu">
                            <li>
                                <ul class="topnav">
                                    <?php echo menu_mobile(0, $menu_main_list, $menu_main_data); ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--navmenu--> 
            </div>
            <!--End mobile-menu --> 
            <a class="logo-small" title="<?php echo $site_name; ?>" href="<?php echo base_url(); ?>"><img alt="<?php echo $site_name; ?>" src="<?php echo $path_img . 'logo-small.png'; ?>"></a>
            <ul id="nav" class="hidden-xs">
                <?php echo menu_main(0, $menu_main_list, $menu_main_data); ?>                
            </ul>
        </div>
    </div>
</nav>