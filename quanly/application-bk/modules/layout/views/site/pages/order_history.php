<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow">
                <div class="my-account">
                    <div class="page-title">
                        <h2>My Orders</h2>
                    </div>
                    <?php if (empty($rows)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="clearfix">
                                    <h5 class="text-danger">Bạn chưa đặt hàng lần nào!</h5>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="my-wishlist">

                            <div class="table-responsive">
                                <table id="wishlist-table" class="table-bordered clean-table linearize-table data-table">
                                    <thead>
                                        <tr class="first last">
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã đơn hàng</th>
                                            <th class="text-center">Thời gian</th>
                                            <th class="text-center">Tổng tiền</th>
                                            <th class="text-center">Trạng thái thanh toán</th>
                                            <th class="text-center">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stt = isset($s_limit) ? ($s_limit - 1) : 0;
                                        foreach ($rows as $row) {
                                            $stt++;
                                            if ($row['transaction_status'] == 0) {
                                                $tr_view = 'warning';
                                                $transaction_status = 'Chưa thanh toán';
                                            } elseif ($row['transaction_status'] == 1) {
                                                $tr_view = 'info';
                                                $transaction_status = 'Đang thanh toán, chờ phản hồi';
                                            } else {
                                                $tr_view = '';
                                                $transaction_status = 'Đã thanh toán, tiền đã nhận'; //4
                                            }
                                            ?>
                                            <tr class="<?php echo $tr_view; ?>">
                                                <td class="text-right"><?php echo $stt; ?></td>
                                                <td class="text-center"><?php echo $row['order_id']; ?></td>
                                                <td class="text-center"><?php echo display_date($row['order_time']); ?></td>                                            
                                                <td class="text-right"><?php echo formatRiceVND($row['order_total']); ?></td>
                                                <td>
                                                    <?php echo $transaction_status; ?>                                
                                                </td>
                                                <td class="text-center">
                                                    <span class="edit_icon"><a href="<?php echo base_url() . 'shops/payment?order-id=' . $row['order_id']; ?>" title="Xem">Xem</a></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>                                    
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                                <div class="buttons-set buttons-set2">
                                    <button class="button btn-share" title="Share Wishlist" name="save_and_share" type="submit"><span>Share Wishlist</span></button>
                                    <button class="button btn-add" onclick="addAllWItemsToCart()" title="Add All to Cart" type="button"><span>Add All to Cart</span></button>
                                    <button class="button btn-update" title="Update Wishlist" name="do" type="submit"><span>Update Wishlist</span></button>
                                </div>
                            </div>
                        </div>                    
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $pagination; ?>
                            </div>    
                            <div class="col-md-12">
                                <em>
                                    Hiển thị từ <?php echo $s_limit; ?> đến <?php echo $f_limit; ?> của <?php echo $total_rows; ?> đơn đặt hàng (<?php echo $total_page; ?> trang)
                                </em>
                            </div>
                        </div>
                        <!--                    <div class="buttons-set">
                                                <p class="back-link"><a href="#/customer/account/"><small>« </small>Back</a></p>
                                            </div>-->
                    <?php endif; ?>
                </div>
            </section>
            <aside class="col-right sidebar col-sm-3 wow">
                <div class="block block-account">
                    <div class="block-title">My Account</div>
                    <div class="block-content">
                        <ul>
                            <li class="current"><a>Account Dashboard</a></li>
                            <li><a href="#customer/account/edit/">Account Information</a></li>
                            <li><a href="#customer/address/">Address Book</a></li>
                            <li><a href="#sales/order/history/">My Orders</a></li>
                            <li><a href="#sales/billing_agreement/">Billing Agreements</a></li>
                            <li><a href="#sales/recurring_profile/">Recurring Profiles</a></li>
                            <li><a href="#review/customer/">My Product Reviews</a></li>
                            <li><a href="#tag/customer/">My Tags</a></li>
                            <li><a href="#wishlist/">My Wishlist</a></li>
                            <li><a href="#downloadable/customer/products/">My Downloadable</a></li>
                            <li class="last"><a href="#newsletter/manage/">Newsletter Subscriptions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="block block-compare">
                    <div class="block-title "><span>Compare Products (2)</span></div>
                    <div class="block-content">
                        <ol id="compare-items">
                            <li class="item odd">
                                <input type="hidden" value="2173" class="compare-item-id">
                                <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Polyester Wrapped Cushions</a> </li>
                            <li class="item last even">
                                <input type="hidden" value="2174" class="compare-item-id">
                                <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Down-Blend Wrapped Cushions</a> </li>
                        </ol>
                        <div class="ajax-checkout">
                            <button type="submit" title="Submit" class="button button-compare"><span>Compare</span></button>
                            <button type="submit" title="Submit" class="button button-clear"><span>Clear</span></button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>