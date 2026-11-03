<?php if (isset($data) && is_array($data) && !empty($data)):?>
	<section>
		<div class="product-featured">
			<div class="container">
				<div class="block-header">
          <h4>NHỮNG SẢN PHẨM MỚI NHẤT VÀ TỐT NHẤT</h4>
          <h3>SẢN PHẨM NỔI BẬT</h3>
        </div>
				<div class="row row-25px">
					<?php
					$i = 0;
				  foreach ($data as $value):
				    $i++;
						$data_id = $value['id'];
						$data_title = convert_to_uppercase($value['title']);
						$data_hometext = word_limiter($value['hometext'], 16);
						$data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
						$data_image = array(
							'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '222x200x1'),
							'alt' => ''
						);
						$data_price = $value['product_price'];
		        		$data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
						?>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 col-25px">
              <div class="product-item">
                <div class="block-images">
                  <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-responsive"></a>
                </div>
                <div class="block-content">
                  <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                  <div class="price"><?php echo formatRice($data_price); ?>VNĐ</div>
                  <div class="block-btn">
                    <a href="<?php echo $data_link; ?>" class="btn-viewmore">Chi Tiết</a>
                  </div>
                </div>
              </div>
            </div>
						<!-- <?php if ($data_sales_price > 0): ?>
							<?php if ($data_sales_price == $data_price): ?>
								<p><?php echo formatRice($data_price); ?>VNĐ</p>
							<?php else: ?>
								<p><?php echo  formatRice($data_sales_price);?> VNĐ</p>
								<small><?php echo  formatRice($data_price);?> VNĐ</small>
							<?php endif; ?>
						<?php endif; ?> -->
						<?php if($i==4) : ?>
				      <div class="clearfix"></div>
				    <?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
