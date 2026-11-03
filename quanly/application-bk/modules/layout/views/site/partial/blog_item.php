<?php
if (isset($data) && is_array($data) && !empty($data)):
    foreach ($data as $value):
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_hometext = word_limiter($value['hometext'], 5);
        $data_full_name = $value['full_name'];
        $data_total_view = $value['hitstotal'];
        $data_link = base_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
            'src' => base_url(get_module_path('posts') . $value['homeimgfile']),
            'alt' => $value['homeimgalt']
        );
        $data_date = date('d M Y', $value['addtime']);
        ?>
        <div class="col-sm-6 col-md-6">
            <article class="container-paper-table">
                <div class="title">
                    <h2 class="entry-title"><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h2>
                </div>
                <div class="post-container"> <a href="<?php echo $data_link; ?>"><img class="img-responsive" src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_image['alt']; ?>"></a>
                    <div class="text">
                        <ul class="list-info">
                            <li><span class="icon-user">&nbsp;</span>By <?php echo $data_full_name; ?></li>
                            <li><span class="icon-time">&nbsp;</span>Posted on <?php echo $data_date; ?></li>
                        </ul>
                        <p class="post-excerpt"><?php echo $data_hometext; ?></p>
                        <a href="<?php echo $data_link; ?>" class="btn btn-mega">Read more &nbsp; <span class="icon icon-arrow-right-5"></span></a>
                        <ul class="list-info">
                            <li><span class="icon-eye-open">&nbsp;</span><?php echo $data_total_view; ?> Views</li>
                            <li><span class="icon-comments">&nbsp;</span><a href="#">3 Comments</a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
<?php endif; ?>