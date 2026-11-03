<?php
if (isset($data) && is_array($data) && !empty($data)):
    foreach ($data as $value):
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_hometext = word_limiter($value['hometext'], 5);
        $data_link = base_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
            'src' => base_url(get_module_path('posts') . $value['homeimgfile']),
            'alt' => $value['homeimgalt']
        );
        $data_date = date('M d, Y', $value['addtime']);
        ?>
        <div class="col-xs-12 col-sm-4">
            <div class="blog-img">
                <a href="<?php echo $data_link; ?>">
                    <img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_image['alt']; ?>">
                </a>
            </div>
            <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a> </h3>
            <p><?php echo $data_hometext; ?></p>
            <div class="post-date"><i class="icon-calendar"></i> <?php echo $data_date; ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>