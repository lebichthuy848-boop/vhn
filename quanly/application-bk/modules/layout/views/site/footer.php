<footer class="footer">
    <div class="brand-logo ">
        <div class="container">
            <div class="slider-items-products">
                <div id="brand-logo-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col6">
                        <?php foreach ($slideshow_bottom as $value): ?>
                            <!-- Item -->
                            <div class="item">
                                <a href="<?php echo $value['link']; ?>">
                                    <img src="<?php echo base_url(get_module_path('images') . $value['image']); ?>" alt="<?php echo $value['alt']; ?>">
                                </a>
                            </div>
                            <!-- End Item --> 
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle container">
        <div class="col-md-3 col-sm-4">
            <?php echo $footer_bottom['content']; ?>
        </div>
        <?php foreach ($menu_bottom_list[0] as $key => $value): ?>
            <?php if (isset($menu_bottom_data[$value])): ?>
                <div class="col-md-2 col-sm-4">
                    <h4><?php echo $menu_bottom_data[$value]['lname']; ?></h4>
                    <?php echo menu_bottom($value, $menu_bottom_list, $menu_bottom_data); ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <!--
        <div class="col-md-2 col-sm-4">
            <h4>Shopping Guide</h4>
            <ul class="links">
                <li class="first"><a href="#" title="How to buy">How to buy</a></li>
                <li><a href="faq.html" title="FAQs">FAQs</a></li>
                <li><a href="#" title="Payment">Payment</a></li>
                <li><a href="#" title="Shipment&lt;/a&gt;">Shipment</a></li>
                <li><a href="delivery.html" title="delivery">Delivery</a></li>
                <li class="last"><a href="#" title="Return policy">Return policy</a></li>
            </ul>
        </div>
        <div class="col-md-2 col-sm-4">
            <h4>Style Advisor</h4>
            <ul class="links">
                <li class="first"><a title="Your Account" href="login.html">Your Account</a></li>
                <li><a title="Information" href="#">Information</a></li>
                <li><a title="Addresses" href="#">Addresses</a></li>
                <li><a title="Addresses" href="#">Discount</a></li>
                <li><a title="Orders History" href="<?php echo base_url('order-history'); ?>">Orders History</a></li>
                <li class="last"><a title=" Additional Information" href="#">Additional Information</a></li>
            </ul>
        </div>
        <div class="col-md-2 col-sm-4">
            <h4>Information</h4>
            <ul class="links">
                <li class="first"><a href="sitemap.html" title="Site Map">Site Map</a></li>
                <li><a href="#/" title="Search Terms">Search Terms</a></li>
                <li><a href="#" title="Advanced Search">Advanced Search</a></li>
                <li><a href="contact_us.html" title="Contact Us">Contact Us</a></li>
                <li><a href="#" title="Suppliers">Suppliers</a></li>
                <li class=" last"><a href="#" title="Our stores" class="link-rss">Our stores</a></li>
            </ul>
        </div>-->
        <div class="col-md-3 col-sm-4">
            <h4>Contact us</h4>
            <div class="contacts-info">
                <address>
                    <i class="add-icon">&nbsp;</i><?php echo $site_address; ?>
                </address>
                <div class="phone-footer"><i class="phone-icon">&nbsp;</i> <?php echo $site_phone; ?></div>
                <div class="email-footer"><i class="email-icon">&nbsp;</i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a> </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom container">
        <div class="col-sm-5 col-xs-12 coppyright"> &copy; <?php echo date('Y'); ?> <?php echo $site_name; ?>. All Rights Reserved.</div>
        <div class="col-sm-7 col-xs-12 company-links">
            <ul class="links">
                <li><a href="#" title="Magento Themes">Magento Themes</a></li>
                <li><a href="#" title="Premium Themes">Premium Themes</a></li>
                <li><a href="#" title="Responsive Themes">Responsive Themes</a></li>
                <li class="last"><a href="#" title="Magento Extensions">Magento Extensions</a></li>
            </ul>
        </div>
    </div>
</footer>