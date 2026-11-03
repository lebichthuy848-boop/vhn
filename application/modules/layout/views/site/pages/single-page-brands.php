<article id="main-content">
	<section>
		<div class="box-brands-wrapper">
			<?php if(isset($brands_block) && is_array($brands_block) && !empty($brands_block)): ?>
				<?php foreach ($brands_block as $key => $value): ?>
					<div class="block-brands-item" style="background-image: url(<?php echo get_media('images', $value['image'], 'no-image.png'); ?>);">
						<div class="container">
							<div class="row">
								<div class="brands-item--description">
									<div class="brands-logo"><img src="<?php echo get_media('images', $value['logo'], 'no-image.png'); ?>" alt="" class="img-fluid"></div>
									<div class="brands-content">
										<?php echo $value['content']; ?>
									</div>
									<div class="btn-meta">
										<a href="<?php echo $value['link']; ?>" class="btn btn-secondary">Các Sản Phẩm</a>
										<a href="<?php echo $value['link1']; ?>" class="btn btn-secondary">Brochure</a>
									</div>
								</div>
								<div class="brands-item--empty">Empty</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>
</article>
