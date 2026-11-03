<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow">
                <div class="page-title">
                    <h2>Shopping Cart</h2>
                </div>
                <?php if (!$this->cart->contents()): ?>
                    <!-- Main Heading Starts -->
                    <h2 class="main-heading text-danger">
                        Giỏ hàng trống!
                    </h2>            
                    <!-- Main Heading Ends -->
                <?php else: ?>
                    <div class="table-responsive">
                        <form method="post" action="<?php echo base_url('shops/cart/update'); ?>">
                            <fieldset>
                                <table class="data-table cart-table" id="shopping-cart-table">
                                    <colgroup>
                                        <col width="1">
                                        <col>
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                    </colgroup>
                                    <thead>
                                        <tr class="first last">
                                            <th rowspan="1">&nbsp;</th>
                                            <th rowspan="1"><span class="nobr">Product Name</span></th>
                                            <th rowspan="1"></th>
                                            <th colspan="1" class="a-center"><span class="nobr">Unit Price</span></th>
                                            <th class="a-center" rowspan="1">Qty</th>
                                            <th colspan="1" class="a-center">Subtotal</th>
                                            <th class="a-center" rowspan="1">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="first last">
                                            <td class="a-right last" colspan="50"><button onclick="setLocation('#')" class="button btn-continue" title="Continue Shopping" type="button"><span><span>Continue Shopping</span></span></button>
                                                <button class="button btn-update" title="Update Cart" value="update_qty" name="update_cart_action" type="submit"><span><span>Update Cart</span></span></button>
                                                <a href="<?php echo base_url('shops/cart/remove'); ?>"><button id="empty_cart_button" class="button btn-empty" title="Clear Cart" value="empty_cart" name="update_cart_action" type="button"><span><span>Clear Cart</span></span></button></a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $count = count($this->cart->contents());
                                        foreach ($this->cart->contents() as $items):
                                            if ($i == 0) {
                                                $class = '';
                                            }
                                            $i++;
                                            ?>
                                        <input type="hidden" name="rowid[]" id="rowid" value="<?php echo $items['rowid']; ?>" />
                                        <tr class="first odd">
                                            <td class="image"><a class="product-image" title="<?php echo $items['name']; ?>" href="<?php echo $items['url']; ?>"><img width="75" alt="<?php echo $items['name']; ?>" src="<?php echo base_url('uploads/shops/' . $items['img']); ?>"></a></td>
                                            <td><h2 class="product-name"> <a href="<?php echo $items['url']; ?>"><?php echo $items['name']; ?></a> </h2></td>
                                            <td class="a-center"><a title="Edit item parameters" class="edit-bnt" href="#configure/id/15945/"></a></td>
                                            <td class="a-right"><span class="cart-price"> <span class="price">$<?php echo formatRice($items['price']); ?></span> </span></td>
                                            <td class="a-center movewishlist"><input maxlength="12" class="input-text qty" title="Qty" size="4" value="<?php echo $items['qty']; ?>" name="quantity[]"></td>
                                            <td class="a-right movewishlist"><span class="cart-price"> <span class="price">$<?php echo formatRice($items['subtotal']); ?></span> </span></td>
                                            <td class="a-center last"><a class="button remove-item" title="Remove item" href="#"><span><span>Remove item</span></span></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </fieldset>
                        </form>
                    </div>
                    <!-- BEGIN CART COLLATERALS -->
                    <div class="cart-collaterals row">
                        <div class="col-sm-4 col-sm-offset-4">
                            <div class="discount">
                                <h3>Discount Codes</h3>
                                <form method="post" action="#couponPost/" id="discount-coupon-form">
                                    <label for="coupon_code">Enter your coupon code if you have one.</label>
                                    <input type="hidden" value="0" id="remove-coupone" name="remove">
                                    <input type="text" value="" name="coupon_code" id="coupon_code" class="input-text fullwidth">
                                    <button value="Apply Coupon" onclick="discountForm.submit(false)" class="button coupon " title="Apply Coupon" type="button"><span>Apply Coupon</span></button>
                                </form>
                            </div>
                        </div>
                        <div class="totals col-sm-4">
                            <h3>Shopping Cart Total</h3>
                            <div class="inner">
                                <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                    <colgroup>
                                        <col>
                                        <col width="1">
                                    </colgroup>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""><strong>Grand Total</strong></td>
                                            <td class="a-right" style=""><strong><span class="price">$<?php echo formatRice($this->cart->total()); ?></span></strong></td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""> Subtotal </td>
                                            <td class="a-right" style=""><span class="price">$<?php echo formatRice($this->cart->total()); ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="checkout">
                                    <li>
                                        <a href="<?php base_url('checkout'); ?>"><button class="button btn-proceed-checkout" title="Proceed to Checkout" type="button"><span>Proceed to Checkout</span></button></a>
                                    </li>
                                </ul>
                            </div>
                            <!--inner--> 

                        </div>
                    </div>

                    <!--cart-collaterals--> 

                <?php endif; ?>
            </div>
            <div class="crosssel">
                <div class="new_title center">
                    <h2>Based on your selection, you may be interested in the following items:</h2>
                </div>
                <div class="category-products">
                    <ul id="crosssell-products-list" class="products-grid first odd">
                        <?php echo $bestsellers_products; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>