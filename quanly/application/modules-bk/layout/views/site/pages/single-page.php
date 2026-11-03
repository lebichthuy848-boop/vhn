<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blogmate.css" type="text/css">
<?php
$data_id = $row['id'];
$data_title = $row['title'];
$data_bodyhtml = $row['bodyhtml'];
$data_full_name = $row['full_name'];
$data_total_view = $row['hitstotal'];
$data_link = base_url() . $row['alias'] . '-' . $data_id;
$data_image = array(
    'src' => base_url(get_module_path('pages') . $row['homeimgfile']),
    'alt' => $row['homeimgalt']
);
$data_date = date('M d, Y', $row['addtime']);
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <div class="col-main col-sm-12 wow">
                <div class="blog-wrapper" id="main">
                    <div class="site-content" id="primary">
                        <div role="main" id="content">
                            <article class="blog_entry clearfix" id="post-29">
                                <header class="blog_entry-header clearfix">
                                    <div class="blog_entry-header-inner">
                                        <h2 class="blog_entry-title"><?php echo $data_title; ?></h2>
                                    </div>
                                </header>
                                <div class="entry-content">
                                    <!--<div class="featured-thumb">
                                        <a href="#"><img alt="<?php echo $data_image['alt']; ?>" src="<?php echo $data_image['src']; ?>"></a>
                                    </div>-->
                                    <div class="entry-content">
                                        <?php echo $data_bodyhtml; ?>
                                    </div>
                                </div>
                                <!--<footer class="entry-meta">
                                    This entry  s d sd fds fdsfds sdfds fdsf was posted in <a rel="category tag" title="View all posts in First Category" href="#first-category">First Category</a> On <time datetime="2014-07-10T06:53:43+00:00" class="entry-date"><?php echo $data_date; ?></time>.
                                </footer>-->
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>