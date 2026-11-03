<?php if (isset($data) && is_array($data) && !empty($data)): ?>
<section>
    <div class="box-video">
		<div class="container">
			<h3 class="title">VIDEO</h3>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-lg-5 col-md-5 col-sm-5">
					<?php
					$i = 0;
					foreach ($data as $value):
						$i++;
						$data_id = $value['id'];
						$data_title = $value['title'];
						$data_image = array(
							'src' => get_media('videos', $value['homeimgfile'], 'no-image.png', '373x90x1'),
							'alt' => $value['homeimgalt']
						);
					?>
					<div class="tabs-item-video" data-toggle="tab" href="#home<?php echo $data_id; ?>">
						<div class="play-anim">NOW PLAYING</div>
						<img src="<?php echo $data_image['src']; ?>" alt="" class="img-responsive">
					</div>
					<?php endforeach; ?>
				</div>
				<div class="col-lg-7 col-md-7 col-sm-7">
					<div class="tab-content">
						<?php
						$i = 0;
						foreach ($data as $value):
							$i++;
							$data_id = $value['id'];
							$data_title = $value['title'];
							$data_iframe_video = $value['iframe_video'];
							preg_match('/src="([^"]+)"/', $value['iframe_video'], $match);
							$data_iframe_src = $match[1];
						?>
						<div id="home<?php echo $data_id; ?>" class="tab-pane fade<?php echo $i == 1 ? ' in active' : ''; ?>">
							<div class="embed-responsive embed-responsive-16by9">
								<?php echo $data_iframe_video; ?>
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