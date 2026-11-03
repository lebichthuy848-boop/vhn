<?php if (isset($data) && is_array($data) && !empty($data)):?>
	<section>
    <div class="box-post-home">
      <div class="container">
        <div class="block-header-title">
          <h3>TIN TỨC & HOẠT ĐỘNG CÔNG TY</h3>
          <p>1 số hoạt động về công ty và thị trường thực phẩm Việt Nam</p>
        </div>
        <div class="row row-45px">
					<?php
					$i = 0;
					$count = count($data);
					foreach ($data as $value):
						$i++;
						$data_id = $value['id'];
						$data_title = word_limiter($value['title'], 15);
						$data_hometext = word_limiter($value['hometext'], 50);
						$data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
						$data_image = array(
							'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '322x202x1'),
							'alt' => $value['homeimgalt']
						);
						?>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-45px">
              <div class="post-item">
                <div class="block-images">
                  <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                </div>
                <div class="block-content">
                  <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                  <p><?php echo $data_hometext; ?></p>
                </div>
              </div>
            </div>
						<?php if($i == 3): ?>
							<?php break; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	</div>
<?php endif; ?>
