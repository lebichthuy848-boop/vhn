<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <section class="product-home">
         <?php
        $i = 0;
        $count = count($data);
        foreach ($data as $data_cat):
            $i++;
            if (isset($data_cat['items']) && !empty($data_cat['items'])):
            ?>
            <br>
            <div class="container text-center">
                <h3 class="title"><?php echo ($data_cat['name']); ?></h3>
                <div class="clearfix"></div>
                <i class="fa fa-heart relative" aria-hidden="true"><hr class="hr1 absolute"><hr class="hr2 absolute"></i>
            </div>
            <br><p></p>
            <div class="container">
                <div id="owl-demo" class="owl-carousel owl-carousel-1"> 
                    <?php
                    foreach ($data_cat['items'] as $value):
                        $data_id = $value['id'];
                        $data_title = convert_to_uppercase($value['title']);
                        $data_hometext = word_limiter($value['hometext'], 16);
                        $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
                        $data_image = array(
                            'src' => get_image(get_module_path('shops_thumbnais') . $value['homeimgfile'], get_module_path('shops') . 'no-image-thumb.png'),
                            'alt' => ''
                        );
                        $data_price = $value['product_price'];
                        $data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
                        $data_code = $value['product_code'];
                        $data_discounts_percent = $value['product_discounts_percent'];
                        ?>
                        <div class="item">
                            <div class="border">
                                <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>"></a>
                            </div>
                            <h3 class="cat-name"><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                        </div>
                   <?php endforeach; ?>
                </div>
            </div>
         <?php endif; ?>
        <?php endforeach; ?>
    </section>
<?php endif; ?>


