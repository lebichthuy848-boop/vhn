<?php if (!empty($data)): ?>
    <ul id="products-list" class="products-list">
        <?php
        $this->load->library('../modules/shops/controllers/rating');
        foreach ($data as $value):
            $data_id = $value['id'];
            $data_title = $value['title'];
            $data_hometext = $value['hometext'];
            $data_link = base_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id . $this->config->item('url_suffix'));
            $data_link_quickview = base_url() . 'abc/' . $value['alias'] . '-' . $data_id;
            $data_image = array(
                'src' => base_url(get_module_path('shops') . $value['homeimgfile']),
                'alt' => ''
            );
            $data_price = $value['product_price'];
            $data_discounts = $value['product_discounts'];
            //rating
            $rating = modules::run('module/shops/rating/get_info_rating_product_id', $data_id);
            $data_percent = $rating['percent'];
            ?>
            <li class="item even">
                <div class="col-item">
                    <div class="product_image">
                        <div class="images-container">
                            <a class="product-image"  title="<?php echo $data_title; ?>" href="<?php echo $data_link; ?>">
                                <img src="<?php echo $data_image['src']; ?>" class="img-responsive" alt="<?php echo $data_image['alt']; ?>" />
                            </a>
                            <div class="qv-button-container">
                                <a class="qv-e-button btn-quickview-1" href="<?php echo $data_link; ?>"><span><span>Quick View</span></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-shop">
                        <h2 class="product-name">
                            <a title="<?php echo $data_title; ?>" href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a>
                        </h2>
                        <div class="price-box">
                            <?php if ($data_discounts > 0): ?>                                
                                <p class="old-price"> <span class="price-sep">-</span> <span class="price">$<?php echo formatRice($data_price); ?></span></p>
                                <p class="special-price"> <span class="price">$<?php echo formatRice(price_discounts($data_price, $data_discounts)); ?></span> </p>
                            <?php else: ?>
                                <span class="regular-price"> <span class="price">$<?php echo formatRice($data_price); ?></span> </span>
                            <?php endif; ?>
                        </div>
                        <div class="ratings">
                            <div class="rating-box">
                                <div style="width:<?php echo $data_percent; ?>%" class="rating"></div>
                            </div>
                            <p class="rating-links">
                                <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#review-form">Add Your Review</a>
                            </p>
                        </div>
                        <div class="desc std">
                            <?php echo $data_hometext; ?>
                            <p><a class="link-learn" title="<?php echo $data_title; ?>" href="<?php echo $data_link; ?>">Learn More</a></p>
                        </div>
                        <div class="actions cart-button">
                            <form class="add-to-cart" method="get" action="<?php echo base_url('shops/cart/add-to-cart'); ?>">
                                <input type="hidden" name="product_id" id="product_id" value="<?php echo $data_id; ?>" />
                                <button class="button btn-cart ajx-cart" style="font-size: inherit; padding-top: 10px;" title="Add to Cart" type="submit"><span>Add to Cart</span></button>
                                <span class="add-to-links">
                                    <a title="Add to Wishlist" id="like_id_<?php echo $data_id; ?>" class="button link-wishlist" href="#wishlist.html"><span>Add to Wishlist</span></a>
                                    <a title="Add to Compare" id="compare_id_<?php echo $data_id; ?>"  class="button link-compare" href="<?php echo base_url('compare/add/' . $data_id); ?>"><span>Add to Compare</span></a>                                    
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>