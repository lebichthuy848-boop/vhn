<?php
if ($this->cart->contents()) {
    $i = 0;
    $count = count($this->cart->contents());
}
?>
<div class="mini-cart">
    <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle">
        <a href="<?php echo base_url('shops/cart' . $url_suffix); ?>"> <i class="icon-cart"></i>
            <div class="cart-box">
                <span class="title">My Cart</span>
                <?php if ($this->cart->contents()): ?>
                    <span id="cart-total"> <?php echo $count; ?> </span>
                <?php else: ?>
                    <span id="cart-total">0</span>
                <?php endif; ?>
            </div>
        </a>
    </div>
    <?php if ($this->cart->contents()): ?>
        <div>
            <div class="top-cart-content arrow_box">
                <div class="block-subtitle">Recently added item(s)</div>
                <ul id="cart-sidebar" class="mini-products-list">
                    <?php
                    foreach ($this->cart->contents() as $items):
                        $i++;
                        if ($i != $count) {
                            $class_item = 'item even';
                        } else {
                            $class_item = 'item last odd';
                        }
                        $homeimgfile = $items['img'];
                        $src_img = base_url('uploads/shops/' . $homeimgfile);
                        ?>
                        <li class="<?php echo $class_item; ?>">
                            <a class="product-image" href="<?php echo $items['url']; ?>" title="<?php echo $items['name']; ?>">
                                <img alt="<?php echo $items['name']; ?>" src="<?php echo $src_img; ?>" width="80">
                            </a>
                            <div class="detail-item">
                                <div class="product-details"> <a href="#" title="Remove This Item" onClick="" class="glyphicon glyphicon-remove">&nbsp;</a> <a class="glyphicon glyphicon-pencil" title="Edit item" href="#">&nbsp;</a>
                                    <p class="product-name"> <a href="<?php echo $items['url']; ?>" title="<?php echo $items['name']; ?>"><?php echo $items['name']; ?></a> </p>
                                </div>
                                <div class="product-details-bottom"> <span class="price">$<?php echo formatRice($items['price']); ?></span> <span class="title-desc">Qty:</span> <strong><?php echo $items['qty']; ?></strong> </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="top-subtotal">Subtotal: <span class="price">$<?php echo formatRice($this->cart->total()); ?></span></div>
                <div class="actions">
                    <button class="btn-checkout" type="button"><span>Checkout</span></button>
                    <a class="view-cart" href="<?php echo base_url('shops/cart'); ?>"><span>View Cart</span></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>