<footer>
  <?php if(is_home()) : ?>
    <div class="embed-map embed-responsive embed-responsive-21by9">
      <?php echo isset($iframe_map) ? $iframe_map : ''; ?>
    </div>
  <?php endif; ?>
  <div class="box-footer">
    <div class="footer--top">
      <div class="container">
        <div class="footer--top-contact-us">
          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
              <p>Nếu bạn có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi</p>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
              <a href="<?php echo site_url('lien-he'); ?>" class="btn btn-lg btn-success btn-block">Liên hệ chúng tôi ngay</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 footer-top-bg-left">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="block-title-footer">
                  <h3><?php echo isset($info_address_none['title']) ? $info_address_none['title'] : ''; ?>:</h3>
                </div>
                <div class="block-content-footer">
                  <p><?php echo isset($info_address_none['content']) ? $info_address_none['content'] : ''; ?></p>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="block-title-footer">
                  <h3><?php echo isset($info_timework_none['title']) ? $info_timework_none['title'] : ''; ?>:</h3>
                </div>
                <div class="block-content-footer">
                  <p><?php echo isset($info_timework_none['content']) ? $info_timework_none['content'] : ''; ?></p>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="block-title-footer">
                  <h3><?php echo isset($info_hotline_none['title']) ? $info_hotline_none['title'] : ''; ?>:</h3>
                </div>
                <div class="block-content-footer">
                  <p><?php echo isset($info_hotline_none['content']) ? $info_hotline_none['content'] : ''; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 footer-top-bg-right">
            <div class="text-center">
              <div class="block-title-footer">
                <h3>Theo dõi chúng tôi:</h3>
              </div>
              <div class="block-content-footer">
                <ul>
                  <li><a href="<?php echo isset($facebook_fanpage) ? $facebook_fanpage : ''; ?>"><i class="fab fa-facebook"></i></a></li>
                  <li><a href="<?php echo isset($twitter_page) ? $twitter_page : ''; ?>"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="<?php echo isset($google_plus) ? $google_plus : ''; ?>"><i class="fab fa-google-plus-square"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="footer--bottom">
      <div class="container">
        <div class="row">
          <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
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
          <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
            <div class="images-orther">
              <img src="<?php echo get_asset('img_path'); ?>sec1_300x.png" alt="" class="img-fluid">
              <img src="<?php echo get_asset('img_path'); ?>sec2_300x.png" alt="" class="img-fluid">
            </div>
          </div> -->
          <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7">
            <p class="design-by text-right">Design by Thietkewebuytin.vn</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
