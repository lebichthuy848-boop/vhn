<header>
  <div class="box-header">
    <div class="container">
      <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3">
          <div class="box-header--logo d-xl-block d-lg-block d-md-none d-sm-none d-none">
            <a href="<?php echo base_url(); ?>" class="logo-pc"><img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" alt="" class="img-fluid"></a>
            <!-- <a href="<?php echo base_url(); ?>" class="logo-mobile"><img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" alt="" class="img-fluid"></a> -->
          </div>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-9 col-sm-9">
          <div class="box-header--menu-main">
            <div class="wsmenucontainer clearfix">
              <div id="overlapblackbg" class="overlapblackbg"></div>
              <div class="wsmobileheader clearfix">
                <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
                <div class="smallogo box-header--logo">
                  <a href="<?php echo base_url(); ?>" class="logo-pc"><img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" alt="" class="img-fluid"></a>
                  <!-- <a href="<?php echo base_url(); ?>" class="logo-mobile"><img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" alt="" class="img-fluid"></a> -->
                </div>
              </div>
              <div class="header">
                <div class="wsmain">
                  <nav id="cssmenu1" class="wsmenu clearfix">
                    <ul class="mobile-sub wsmenu-list">
                      <?php echo menu_main(0, $menu_main_list, $menu_main_data, 0); ?>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
