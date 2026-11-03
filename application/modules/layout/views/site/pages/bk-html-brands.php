<article id="main-content">
	<!-- <section>
		<div class="box-banner-pages" style="background-image: url(<?php echo get_image(get_module_path('posts') . (isset($row['homeimgfile']) ? $row['homeimgfile'] : ''), get_module_path('posts') . 'no-image.png'); ?>);">
			<div class="container">
				<h3><?php echo isset($row['title']) ? $row['title'] : ''; ?></h3>
			</div>
		</div>
	</section> -->
	<section>
		<div class="box-brands-wrapper">
			<div class="container">
				<?php if(isset($brands_block) && is_array($brands_block) && !empty($brands_block)): ?>
				<?php foreach ($brands_block as $key => $value): ?>
				<div class="block-brands-item">
					<div class="row">
						<div class="medium-up--9-quarters">
							<img src="<?php echo base_url(get_module_path('images') . $value['image']); ?>" alt="" class="img-fluid">
						</div>
						<div class="medium-up--3-quarters">
							<div class="brands--description">
								<div class="brands-logo"><img src="<?php echo base_url(get_module_path('images') . $value['logo']); ?>" alt="" class="img-fluid"></div>
								<div class="brands-content">
									<?php echo $value['content']; ?>
								</div>
								<div class="btn-group">
									<a href="<?php echo $value['link']; ?>" class="btn btn-block btn-secondary">Shop</a>
									<a href="<?php echo $value['link1']; ?>" class="btn btn-block btn-secondary">Brochure</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</article>
