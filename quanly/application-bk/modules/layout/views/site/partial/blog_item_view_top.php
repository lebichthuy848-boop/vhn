<?php
if (isset($data) && is_array($data) && !empty($data)):
    foreach ($data as $value):
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_link = base_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
            'src' => base_url(get_module_path('posts') . $value['homeimgfile']),
            'alt' => $value['homeimgalt']
        );
        $data_date = date('M d, Y', $value['addtime']);
        ?>
        <li>
            <figure class="featured-thumb">
                <a href="<?php echo $data_link; ?>">
                    <img width="80" height="53" alt="<?php echo $data_image['alt']; ?>" src="<?php echo $data_image['src']; ?>">
                </a>
            </figure>
            <h4><a title="<?php echo $data_title; ?>" href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h4>
            <p class="post-meta"><i class="icon-calendar"></i><time datetime="2014-07-10T07:09:31+00:00" class="entry-date"><?php echo $data_date; ?></time></p>
        </li>
    <?php endforeach; ?>
<?php endif; ?>