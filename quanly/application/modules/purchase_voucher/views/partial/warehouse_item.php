<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <?php
    foreach ($data as $value):
		$data_params = (isset($value['params']) && trim($value['params']) != '') ? $value['params'] : '';
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id) . $data_params;
        $data_image = array(
            'src' => get_image(get_module_path('shops') . $value['homeimgfile'], get_module_path('shops') . 'no-image.png'),
            'alt' => ''
        );
        $data_price = $value['data_price'];
        $data_sales_price = $value['data_sales_price'];
        ?>
        <div class="item">
          <div class="product-related">
            <a href="<?php echo $data_link; ?>"><img class="img-responsive center-block" src="<?php echo base_url('timthumb.php?src=' . $data_image['src'] . '&w=250&h=170&zc=2&q=100'); ?>"></a>
            <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
            <!-- <div class="rating">
              <a href="<?php echo $data_link; ?>">
                <i class="ac-rating fa fa-star" aria-hidden="true"></i>
                <i class="ac-rating fa fa-star" aria-hidden="true"></i>
                <i class="ac-rating fa fa-star" aria-hidden="true"></i>
                <i class="no-ac-rating fa fa-star-o" aria-hidden="true"></i>
                <i class="no-ac-rating fa fa-star-o" aria-hidden="true"></i>
                <span><?php echo random_string('nozero', 5); ?></span>
              </a>
            </div> -->
            <div class="price">
              <p>
                <?php if($data_sales_price != $data_price): ?>
          			<span><?php echo formatRice($data_sales_price);?> đ</span> - <span><?php echo  formatRice($data_price);?> đ</span></p>
          			<?php else: ?>
          			<span><?php echo  formatRice($data_sales_price); ?> đ</span>
          			<?php endif; ?>
              </p>
            </div>
          </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
