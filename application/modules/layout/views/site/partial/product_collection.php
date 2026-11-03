<?php if (isset($data) && is_array($data) && !empty($data)): ?>
  <div class="product-catelogy--item">
    <div class="row">
      <?php
      $i = 0;
      $count = count($data);
      foreach ($data as $data_cat):
        $i++;
        if (isset($data_cat['items']) && !empty($data_cat['items'])):
          ?>
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
            <div class="product-catelogy--introdues">
              <h2><?php echo $data_cat['name']; ?></h2>
              <div class="block-content"><?php echo nl2br($data_cat['slogun']); ?></div>
              <a href="<?php echo site_url($this->config->item('url_shops_cat') . '/' . $data_cat['alias']); ?>" class="btn btn-success">Xem thêm</a>
            </div>
          </div>
          <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
            <div class="row row-0px">
              <?php
              foreach ($data_cat['items'] as $value):
                $data_id = $value['id'];
                $data_title = convert_to_uppercase($value['title']);
                $data_hometext = word_limiter($value['hometext'], 16);
                $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
                $data_image = array(
                  'src' => get_image(get_module_path('shops') . $value['homeimgfile'], get_module_path('shops') . 'no-image-thumb.png'),
                  'alt' => ''
                );
                ?>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 col-0px">
                    <div class="product-item">
                      <div class="block-images">
                        <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                      </div>
                      <div class="block-content">
                        <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                        <a href="<?php echo $data_link; ?>" class="btn btn-success">Xem thêm</a>
                      </div>
                    </div>
                  </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
