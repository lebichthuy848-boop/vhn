<article id="main-content">
	<!-- <section>
		<div class="box-banner-pages" style="background-image: url(<?php echo get_image(get_module_path('posts') . (isset($row['homeimgfile']) ? $row['homeimgfile'] : ''), get_module_path('posts') . 'no-image.png'); ?>);">
			<div class="container">
				<h3><?php echo isset($row['title']) ? $row['title'] : ''; ?></h3>
			</div>
		</div>
	</section> -->
	<?php if(isset($pages_abouts_block) && is_array($pages_abouts_block) && !empty($pages_abouts_block)): ?>
		<section>
			<div class="box-introdues-page-top">
				<?php foreach ($pages_abouts_block as $key => $value): ?>
					<div class="container">
						<div class="block-content">
							<h2><?php echo $value['title']; ?></h2>
							<p><?php echo $value['content']; ?></p>
						</div>
					</div>
					<img src="<?php echo get_media('images', $value['image'], 'no-image.png'); ?>" alt="" class="img-fluid d-block mx-auto">
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
	<?php if(isset($build_brands) && is_array($build_brands) && !empty($build_brands)): ?>
		<section>
			<div class="box-build-brands">
				<div class="container">
					<div class="row">
						<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1">
							<div class="row">
								<?php foreach ($build_brands as $key => $value): ?>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-mobile">
										<div class="build-brands-item">
											<img src="<?php echo get_media('images', $value['image'], 'no-image.png'); ?>" alt="" class="img-fluid">
											<div class="overlay-content">
												<h2><?php echo $value['content']; ?></h2>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<section>
		<div class="box-partner-page-about">
			<div class="container">
				<h3 class="title">ĐỐI TÁC ĐỘC QUYỀN<br>PHÁT TRIỂN THƯƠNG HIỆU</h3>
			</div>
			<div class="container container-custom">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-images">
							<img src="<?php echo get_asset('img_path'); ?>logo-obm-1.jpg" alt="" class="img-fluid d-block mx-auto">
						</div>
						<div class="block-content">
							<p>Thương hiệu được gầy dựng bởi Winning Solution INC., hơn 30 năm tại Hoa Kỳ và hiện đang sở hữu độc quyền quy trình chiết tách Gel UltraAloe giúp tạo ra hơn 50 sản phẩm chăm sóc da, sức khỏe và sắc đẹp độc đáo, hiệu quả cao từ Aloe Vera.</p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-videos">
							<a href="#" class="volume"><i class="fas fa-volume-off"></i></a>
							<video poster="" playsinline="true" autoplay="true" loop="true" muted="muted" >
								<source type="video/mp4" src="<?php echo get_asset('img_path'); ?>MiracleofAloe.mp4">
							</video>
						</div>
					</div>
				</div>
			</div>
			<div class="container container-custom">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-images">
							<img src="<?php echo get_asset('img_path'); ?>logo-obm-2.png" alt="" class="img-fluid d-block mx-auto">
						</div>
						<div class="block-content">
							<p>Dòng mỹ phẩm trang điểm sang trọng, quý phái giúp tô điểm nét đẹp Á Đông của người phụ nữ Việt Nam với thương hiệu TIGI.</p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-videos">
							<a href="#" class="volume"><i class="fas fa-volume-off"></i></a>
							<video poster="" playsinline="true" autoplay="true" loop="true" muted="muted" >
								<source type="video/mp4" src="<?php echo get_asset('img_path'); ?>TIGI.MP4">
							</video>
						</div>
					</div>
				</div>
			</div>
			<div class="container container-custom">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-images">
							<img src="<?php echo get_asset('img_path'); ?>logo-obm-3.gif" width="300" height="286" alt="" class="img-fluid d-block mx-auto">
						</div>
						<div class="block-content">
							<p class="text-center">Dòng sản phẩm có thành phần từ loài thực vật nổi tiếng khu vực Châu Mỹ - #Bơ hạt mỡ - mang nhãn hiệu #TREE HUT</p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-videos">
							<a href="#" class="volume"><i class="fas fa-volume-off"></i></a>
							<video poster="" playsinline="true" autoplay="true" loop="true" muted="muted" >
								<source type="video/mp4" src="<?php echo get_asset('img_path'); ?>TreeHut2.mp4">
							</video>
						</div>
					</div>
				</div>
			</div>
			<div class="container container-custom">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-images">
							<img src="<?php echo get_asset('img_path'); ?>logo-obm-4.png" alt="" class="img-fluid d-block mx-auto">
						</div>
						<div class="block-content">
							<p>Đối tác phát triển các sản phẩm #Thực phẩm chức năng ưu việt, chất lượng cao, đa dạng về chủng loại, mẫu mã và tính năng mang thương hiệu #ALFA có nguồn gốc từ #Hoa Kỳ.</p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="block-videos">
							<a href="#" class="volume"><i class="fas fa-volume-off"></i></a>
							<video poster="" playsinline="true" autoplay="true" loop="true" muted="muted" >
								<source type="video/mp4" src="<?php echo get_asset('img_path'); ?>alfa.MP4">
							</video>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="box-value-core">
			<div class="container">
				<h3 class="title"><?php echo isset($info_value_core_none['title']) ? $info_value_core_none['title'] : ''; ?></h3>
				<?php echo isset($info_value_core_none['content']) ? $info_value_core_none['content'] : ''; ?>
			</div>
		</div>
	</section>
</article>
