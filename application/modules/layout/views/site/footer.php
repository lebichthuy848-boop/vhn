<footer>
  <div class="box-footer">
    <div class="footer--top-custom">
      <div class="container">
        <div class="row">
          <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
            <div class="footer-title">
              <h3>Địa chỉ liên hệ</h3>
            </div>
            <div class="footer-content">
              <?php echo isset($info_contact_footer_none['content']) ? $info_contact_footer_none['content'] : ''; ?>
              <br>
              <div class="footer-content-social">
                <ul>
                  <li><a href="<?php echo isset($facebook_fanpage) ? $facebook_fanpage : ''; ?>"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a href="https://tongdaihoidap.com/" title="Tổng Đài"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="<?php echo isset($google_plus) ? $google_plus : ''; ?>"><i class="fab fa-google-plus-g"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="footer-content">
              <ul>
                <?php echo menu_main(0, $menu_main_list, $menu_main_data, 0); ?>
              </ul>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <div class="footer-title">
              <h3>Fanpage</h3>
            </div>
            <div class="footer-content">
              <?php echo isset($fb_page) ? $fb_page : ''; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer--bottom">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-9">
            <div class="footer--bottom-copyright">
              <div class="block-images">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" alt="" class="img-fluid"></a>
              </div>
              <div class="block-content">
                <p><?php echo isset($info_copyright_none['content']) ? $info_copyright_none['content'] : ''; ?></p>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-3">
            <p class="design-by text-right"><a id="back-to-top" href="#" class="btn btn-link back-to-top" role="button" title="Quay lại đầu trang" data-toggle="tooltip" data-placement="left"><i class="fas fa-chevron-up"></i></a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
