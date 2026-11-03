<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blogmate.css" type="text/css">
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <div class="col-main col-sm-9">
                <div class="page-title">
                    <h2>Blog</h2>
                </div>
                <div class="blog-wrapper" id="main">
                    <div id="ajax_table" class="posts-isotope row">
                    </div>  
                    <div class="text-center">
<!--                        <button type="button" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Submit Order</button>-->
                        <button class="btn" id="load_more" data-val = "0">
                            Load more..<img style="display: none" id="loader" src="<?php echo base_url(); ?>assets/images/loader.GIF">
                        </button>
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
                            <li class="cat-item cat-item-19599"><a href="#/first-category">First Category</a></li>
                            <ul>
                            </ul>
                            <li class="cat-item cat-item-19599"><a href="#/second-category">Second Category</a></li>
                            <ul>
                            </ul>
                        </ul>
                    </div>
                    <!-- Banner Ad Block -->
                    <div class="ad-spots widget widget__sidebar">
                        <h3 class="widget-title"><span>Ad Spots</span></h3>
                        <div class="widget-content"><a target="_self" href="#" title=""><img alt="offer banner" src="images/RHS-banner-img.jpg"></a></div>
                    </div>
                    <!-- Banner Text Block -->
                    <div class="text-widget widget widget__sidebar">
                        <h3 class="widget-title"><span>Text Widget</span></h3>
                        <div class="widget-content">Mauris at blandit erat. Nam vel tortor non quam scelerisque cursus. Praesent nunc vitae magna pellentesque auctor. Quisque id lectus.<br>
                            <br>
                            Massa, eget eleifend tellus. Proin nec ante leo ssim nunc sit amet velit malesuada pharetra. Nulla neque sapien, sollicitudin non ornare quis, malesuada.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var cat_alias = '<?php echo $cat_alias; ?>';
</script>