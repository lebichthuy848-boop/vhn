<?php
$this->load->library('../modules/shops/controllers/rating');

foreach ($data as $value):
    $data_id = $value['id'];
    $data_title = $value['title'];
    $data_link = base_url() . 'shops/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id;
    $data_link_quickview = base_url() . 'abc/' . $value['alias'] . '-' . $data_id;
    $data_image = array(
        'src' => base_url('uploads/shops/' . $value['homeimgfile']),
        'alt' => ''
    );
    $data_price = $value['product_price'];
    $data_discounts = $value['product_discounts'];
    $rating = modules::run('module/shops/rating/get_info_rating_product_id', $data_id);
    $data_percent = $rating['percent'];
    ?>
    <div class="item col-md-3 col-sm-6 col-xs-6">
        <div class="col-item">
            <?php if ($value['product_discounts'] > 0): ?>
                <div class="sale-label sale-top-right">Sale</div>
            <?php elseif ($value['inhome'] == 1): ?>                                                            
                <div class="new-label new-top-right">New</div>
            <?php endif; ?>
            <div class="images-container">
                <a class="product-image" title="<?php echo $data_title; ?>" href="<?php echo $data_link; ?>">
                    <img src="<?php echo $data_image['src']; ?>" class="img-responsive" alt="<?php echo $data_image['alt']; ?>" />
                </a>
                <div class="actions">
                    <div class="actions-inner cart-button">
                        <form class="add-to-cart" method="get" action="<?php echo base_url('shops/cart/add-to-cart'); ?>">
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo $data_id; ?>" />
                            <button type="submit" title="Add to Cart" class="button btn-cart"><span>Add to Cart</span></button>                        
                            <ul class="add-to-links">
                                <li>
                                    <a title="Add to Wishlist" id="like_id_<?php echo $data_id; ?>" class="link-wishlist" href="#wishlist.html"><span>Add to Wishlist</span></a>
                                </li>
                                <li><a title="Add to Compare" id="compare_id_<?php echo $data_id; ?>" class="link-compare" href="<?php echo base_url('compare/add/' . $data_id); ?>"><span>Add to Compare</span></a></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="qv-button-container">
                    <a class="qv-e-button btn-quickview-1 btn-quickview" href="<?php echo $data_link; ?>"><span><span>Quick View</span></span></a>
                </div>
            </div>
            <div class="info">
                <div class="info-inner">
                    <div class="item-title"><a href="<?php echo $data_link; ?>" title="<?php echo $data_title; ?>"><?php echo $data_title; ?></a> </div>
                    <!--item-title-->
                    <div class="item-content">
                        <div class="ratings">
                            <div class="rating-box">
                                <div style="width:<?php echo $data_percent; ?>%" class="rating"></div>
                            </div>
                        </div>
                        <div class="price-box">
                            <?php if ($data_discounts > 0): ?>
                                <p class="special-price"> <span class="price">$<?php echo formatRice(price_discounts($data_price, $data_discounts)); ?></span> </p>
                                <p class="old-price"> <span class="price-sep">-</span> <span class="price">$<?php echo formatRice($data_price); ?></span></p>
                            <?php else: ?>
                                <span class="regular-price"> <span class="price">$<?php echo formatRice($data_price); ?></span> </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--item-content--> 
                </div>
                <!--info-inner--> 

                <!--actions-->

                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>