<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blogmate.css" type="text/css">
<?php
$data_id = $row['id'];
$data_title = $row['title'];
$data_bodyhtml = $row['bodyhtml'];
$data_full_name = $row['full_name'];
$data_total_view = $row['hitstotal'];
$data_link = base_url() . $row['alias'] . '-' . $data_id;
$data_image = array(
    'src' => base_url(get_module_path('posts') . $row['homeimgfile']),
    'alt' => $row['homeimgalt']
);
$data_date = date('M d, Y', $row['addtime']);

$category_prefix = $cat_prefix['values'] . '/';
$category_name = $row['categories']['name'];
$category_link = base_url($category_prefix . $row['categories']['alias']);
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <div class="col-main col-sm-9 wow">
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
                                    <div class="featured-thumb">
                                        <a href="#"><img alt="<?php echo $data_image['alt']; ?>" src="<?php echo $data_image['src']; ?>"></a>
                                    </div>
                                    <div class="entry-content">
                                        <?php echo $data_bodyhtml; ?>
                                    </div>
                                </div>
                                <footer class="entry-meta">
                                    This entry was posted in <a rel="category tag" title="View all posts in <?php echo $category_name; ?>" href="<?php echo $category_link; ?>"><strong><?php echo $category_name; ?></strong></a> On <time datetime="2014-07-10T06:53:43+00:00" class="entry-date"><?php echo $data_date; ?></time>.
                                </footer>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-right sidebar col-sm-3">
                <div role="complementary" class="widget_wrapper13" id="secondary">
                    <div class="popular-posts widget widget__sidebar wow" id="recent-posts-4">
                        <h3 class="widget-title"><span>Most Popular Post</span></h3>
                        <div class="widget-content">
                            <ul class="posts-list unstyled clearfix">
                                <?php echo $items_view_top; ?>
                            </ul>
                        </div>
                        <!--widget-content--> 
                    </div>
                    <div class="popular-posts widget widget_categories wow" id="categories-2">
                        <h3 class="widget-title"><span>Categories</span></h3>
                        <ul>
                            <?php foreach ($catagories as $value): ?>
                                <li class="cat-item cat-item-<?php echo $value['id']; ?>">
                                    <a href="<?php echo base_url($category_prefix . $value['alias']); ?>"><?php echo $value['name']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- Banner Ad Block -->
                    <div class="ad-spots widget widget__sidebar">
                        <h3 class="widget-title"><span>Ad Spots</span></h3>
                        <div class="widget-content"><a target="_self" href="#" title=""><img alt="offer banner" src="images/RHS-banner-img.jpg"></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>