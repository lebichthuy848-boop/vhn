<?php if (isset($data) && is_array($data) && !empty($data)): ?>
  <section>
    <div class="box-product-our-home">
      <div class="container">
        <div class="block-header-title">
          <h2>Sản phẩm của chúng tôi</h2>
        </div>
        <div class="row">
          <?php
          foreach ($data as $value):
            $data_title = $value['name'];
            $data_hometext = nl2br($value['slogun']);
            $data_link = site_url($this->config->item('url_shops_cat') . '/' . $value['alias']);
            $data_image = array(
              'src' => get_media('shops_cat', $value['image'], 'no-image.png', '345x345x1'),
              'alt' => ''
            );
            ?>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
              <div class="product-home-item">
                <a href="<?php echo $data_link; ?>" class="text-link">
                  <div class="block-images">
                    <img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid">
                    <div class="overlay-desc">
                      <p><?php echo $data_hometext; ?></p>
                    </div>
                  </div>
                </a>
                <div class="block-content">
                  <h3><?php echo $data_title; ?></h3>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
