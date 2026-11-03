<?php if (isset($data) && is_array($data) && !empty($data)): ?>
  <?php
  foreach ($data as $value):
    $data_id = $value['id'];
    $data_title = convert_to_uppercase($value['title']);
    $data_hometext = word_limiter($value['hometext'], 16);
    $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
    $data_image = array(
      'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '221x221x1'),
      'alt' => ''
    );
    //$data_price = $value['product_price'];
    //$data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
    ?>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6 col-0px">
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
<?php endif; ?>
