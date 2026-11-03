<?php if (isset($data) && is_array($data) && !empty($data)): ?>
<div class="box-bestseller">
	<h3 class="title">SẢN PHẨM BÁN CHẠY</h3>
	<ul>
	<?php
	foreach ($data as $value):
		$data_id = $value['id'];
		$data_title = $value['title'];
		$data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
		$data_image = array(
			'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '270x270x1'),
			'alt' => ''
		);
		$data_price = $value['product_price'];
		$data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
		?>
		<li>
			<a href="<?php echo $data_link; ?>" class="bestseller-img">
				<img class="img-responsive" src="<?php echo $data_image['src']; ?>">
			</a>
			<div class="bestseller-info">
				<h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
				<div class="price-box">
					<?php if ($data_sales_price > 0): ?>
						<?php if ($data_sales_price == $data_price): ?>
							<span><?php echo formatRice($data_price); ?>VNĐ</span>
						<?php else: ?>
							<span><?php echo  formatRice($data_sales_price);?> VNĐ</span>
							<span><?php echo  formatRice($data_price);?> VNĐ</span>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
