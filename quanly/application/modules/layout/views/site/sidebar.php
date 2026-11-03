<div class="col-md-3">
    <div id="vertical">
        <h2 class="main-heading2">Menu</h2>
        <ul class="dropdown-menu" role="menu" style="display: block; margin-bottom: 5px; width: 100%; position: relative;">
            <?php echo menu_left(0, $menu_left_list, $menu_left_data); ?>
            <!--
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="dropdown-submenu">
                <a tabindex="-1" href="#">More options</a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" href="#">Second level</a></li>
                    <li class="dropdown-submenu">
                        <a href="#">More..sd s ds d sd s ds d s ds d s ds ds d sd sd</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">3rd level</a></li>
                            <li><a href="#">3rd level</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Second level</a></li>
                    <li><a href="#">Second level</a></li>
                </ul>
            </li>
            -->
        </ul>
    </div>
    <div class="clearfix"></div>
    <?php
    foreach ($banner as $value):
        if ($value['position'] == 'Left'):
            ?>
    <img src="<?php echo base_url($value['image']); ?>" class="img-responsive" style="width: 100%;" />
            <?php
        endif;
    endforeach;
    ?>
</div>