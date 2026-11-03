<?php
if (isset($data) && is_array($data) && !empty($data)):
  foreach ($data as $value):
    $data_id = $value['id'];
    $data_title = $value['title'];
    $data_hometext = word_limiter($value['hometext'], 50);
    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
    $data_image = array(
      'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '262x164x1'),
      'alt' => $value['homeimgalt']
    );
    ?>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
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
