<?php
if (isset($data) && is_array($data) && !empty($data)):
    $i = 0;
    foreach ($data as $value):
        $i++;
        $data_id = $value['id'];
        $data_title = word_limiter($value['title'], 15);
        $data_hometext = word_limiter($value['hometext'], 80);
        $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_cat_link = site_url('danh-muc-bai-viet/' . $value['categories']['alias']);
    		$data_cat_name = $value['categories']['name'];
        $data_image = array(
            'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '381x381x1'),
            'alt' => $value['homeimgalt']
        );
        $data_date = date('d', $value['addtime']) . ' ' . date('M', $value['addtime']) . ' ' . date('Y', $value['addtime']);
        ?>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
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
    <?php endforeach; ?>
<?php endif; ?>
