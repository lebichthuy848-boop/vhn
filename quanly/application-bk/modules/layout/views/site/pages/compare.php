<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow">
                <div class="page-title">
                    <h2>Compare Products</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped compare-table">
                        <colgroup>
                            <col width="1">
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                        <tbody>
                            <tr class="product-shop-row first odd">
                                <th>&nbsp;</th>
                                <td>
                                    <a href="#" class="btn btn-cancel icon-remove" title="Remove This Item"></a>
                                    <a class="product-image" href="<?php echo base_url('shops/' . $compare[0]['cat_alias'] . '/' . $compare[0]['alias'] . '-' . $compare[0]['id']); ?>" title="<?php echo $compare[0]['title']; ?>">
                                        <img src="<?php echo base_url('uploads/shops/' . $compare[0]['homeimgfile']); ?>" alt="<?php echo $compare[0]['title']; ?>" width="200">
                                    </a>
                                    <h2 class="product-name"><a href="<?php echo base_url('shops/' . $compare[0]['cat_alias'] . '/' . $compare[0]['alias'] . '-' . $compare[0]['id']); ?>" title="<?php echo $compare[0]['title']; ?>"><?php echo $compare[0]['title']; ?></a></h2>
                                    <div class="price-box">
                                        <?php if ($compare[0]['product_discounts'] > 0): ?>
                                            <p class="special-price"><span class="price">$<?php echo formatRice(price_discounts($compare[0]['product_price'], $compare[0]['product_discounts'])); ?></span> </p>
                                            <p class="old-price">
                                                <span class="price-sep">-</span><span class="price">$<?php echo formatRice($compare[0]['product_price']); ?></span>
                                            </p>
                                        <?php else: ?>
                                            <span class="regular-price"><span class="price">$<?php echo formatRice($compare[0]['product_price']); ?></span></span>
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <button type="button" title="Add to Cart" class="button"><span><span>Add to Cart</span></span></button>
                                    </p>
                                    <a href="#" class="button wishlist">Add to Wishlist</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-cancel icon-remove" title="Remove This Item"></a>
                                    <a class="product-image" href="<?php echo base_url('shops/' . $compare[1]['cat_alias'] . '/' . $compare[1]['alias'] . '-' . $compare[1]['id']); ?>" title="<?php echo $compare[1]['title']; ?>">
                                        <img src="<?php echo base_url('uploads/shops/' . $compare[1]['homeimgfile']); ?>" alt="<?php echo $compare[1]['title']; ?>" width="200">
                                    </a>
                                    <h2 class="product-name"><a href="<?php echo base_url('shops/' . $compare[1]['cat_alias'] . '/' . $compare[1]['alias'] . '-' . $compare[1]['id']); ?>" title="<?php echo $compare[1]['title']; ?>"><?php echo $compare[1]['title']; ?></a></h2>
                                    <div class="price-box">
                                        <?php if ($compare[1]['product_discounts'] > 1): ?>
                                            <p class="special-price"><span class="price">$<?php echo formatRice(price_discounts($compare[1]['product_price'], $compare[1]['product_discounts'])); ?></span> </p>
                                            <p class="old-price">
                                                <span class="price-sep">-</span><span class="price">$<?php echo formatRice($compare[1]['product_price']); ?></span>
                                            </p>
                                        <?php else: ?>
                                            <span class="regular-price"><span class="price">$<?php echo formatRice($compare[1]['product_price']); ?></span></span>
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <button type="button" title="Add to Cart" class="button"><span><span>Add to Cart</span></span></button>
                                    </p>
                                    <a href="#" class="button wishlist">Add to Wishlist</a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="odd">
                                <th>Description</th>
                                <td><div><?php echo $compare[0]['bodytext']; ?></div></td>
                                <td><div><?php echo $compare[1]['bodytext']; ?></div></td>
                            </tr>
                            <tr class="even">
                                <th>Short Description</th>
                                <td><div><?php echo $compare[0]['hometext']; ?></div></td>
                                <td><div><?php echo $compare[1]['hometext']; ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>