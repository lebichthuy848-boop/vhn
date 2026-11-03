<?php if ((isset($data) && is_array($data) && !empty($data)) || (isset($row) && is_array($row) && !empty($row))): ?>
  <div class="box-content-catelogy">
    <div class="block-title">
      <h3>TIN TỨC TIN TỨC TIN TỨC</h3>
    </div>
    <div class="block-content">
      <div class="row">
          <?php
          if (isset($row) && is_array($row) && !empty($row)):
            $data_id = $row['id'];
            $data_title = word_limiter($row['title'], 30);
            $data_hometext = word_limiter($row['hometext'], 200);
            $data_link = site_url($row['categories']['alias'] . '/' . $row['alias'] . '-' . $data_id);
            $data_image = array(
              'src' => get_media('posts', $row['homeimgfile'], 'no-image.png', '248x147x1'),
              'alt' => $row['homeimgalt']
            );
            ?>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
              <div class="post-item-first">
                <div class="block-images">
                  <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                </div>
                <div class="block-description">
                  <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                  <small>21/05/2018</small>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          <?php endif; ?>
          <?php if (isset($data) && is_array($data) && !empty($data)): ?>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
              <?php
              foreach ($data as $value):
                $data_id = $value['id'];
                $data_title = $value['title'];
                $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                $data_image = array(
                  'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '84x64x1'),
                  'alt' => $value['homeimgalt']
                );
                ?>
                <div class="post-item-orther">
                  <div class="block-images">
                    <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                  </div>
                  <div class="block-description">
                    <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
    </div>
  </div>
<?php endif; ?>
