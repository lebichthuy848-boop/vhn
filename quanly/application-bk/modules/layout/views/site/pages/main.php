<!-- Slider -->
<?php $this->load->view('slider'); ?>            
<!-- End Slider --> 

<!-- header service -->
<?php $this->load->view('service'); ?>            
<!-- end header service --> 

<!-- offer banner section -->
<?php $this->load->view('offer'); ?>            
<!-- end offer banner section --> 

<section class="main-container col1-layout home-content-container">
    <div class="container">
        <div class="row">
            <div class="std">
                <div class="col-lg-8 col-xs-12 col-sm-8 best-seller-pro wow">
                    <div class="slider-items-products">
                        <div class="new_title center">
                            <h2><?php echo $this->lang->line('best_seller'); ?></h2>
                        </div>
                        <div id="best-seller-slider" class="product-flexslider hidden-buttons">
                            <div class="slider-items slider-width-col4">                                
                                <!-- Item -->
                                <?php echo $bestsellers_products; ?>
                                <!-- End Item -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 col-sm-4 wow latest-pro small-pr-slider">
                    <div class="slider-items-products">
                        <div class="new_title center">
                            <h2><?php echo $this->lang->line('latest_products'); ?></h2>
                        </div>
                        <div id="latest-deals-slider" class="product-flexslider hidden-buttons latest-item">
                            <div class="slider-items slider-width-col4"> 
                                <?php echo $latest_products; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- recommend slider -->
<?php //$this->load->view('recommend'); ?>   
<!-- End Recommend slider --> 

<!-- banner section -->
<?php $this->load->view('banner'); ?>            
<!-- End banner section --> 

<!-- middle slider -->
<?php //$this->load->view('middle'); ?> 
<!-- End middle slider --> 

<!-- promo banner section -->
<!--<div class="promo-banner-section container wow">
    <div class="container">
        <div class="row"> <img alt="promo-banner3" src="images/bottom-banner.jpg"></div>
    </div>
</div>-->
<!-- End promo banner section --> 

<!-- Latest Blog -->
<?php $this->load->view('latest'); ?> 
<!-- End Latest Blog --> 

<!-- Featured Slider -->
<?php $this->load->view('featured'); ?>             
<!-- End Featured Slider --> 