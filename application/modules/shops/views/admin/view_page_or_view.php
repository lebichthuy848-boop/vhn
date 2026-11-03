<style type="text/css">
    .payment {
        color: #f00;
        font-weight: bold;
        display: block;
        margin-top: 10px;
        border: 1px solid #f00;
        padding: 3px;
        text-transform: uppercase;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary" id="element_print">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Xem Đơn Hàng: <?php echo $order['order_code']; ?></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="border-top: none;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td width="150px">Họ tên khách hàng:</td>
                                                <td><strong><?php echo $customer['full_name']; ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Email khách hàng:</td>
                                                <td><?php echo $customer['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Điện thoại:</td>
                                                <td><?php echo $customer['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Địa chỉ:</td>
                                                <td><?php echo $customer['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ngày đặt hàng:</td>
                                                <td><?php echo date('d/m/Y', $order['add_time']); ?> lúc <?php echo date('h:i A', $order['add_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Hình thức thanh toán:</td>
                                                <td><strong><?php echo display_value_array($this->config->item($order['forms_of_payment'], 'forms_of_payment'), 'title'); ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="border-top: none;" width="100px" valign="top" class="text-center">
                                    <div class="order_code">
                                        Mã đơn hàng
                                        <br>
                                        <span class="text_date"><strong><?php echo $order['order_code']; ?></strong></span>
                                        <br>
                                        <span class="payment">
                                            <?php
                                            if ($order['transaction_status'] == 0) {
                                                $transaction_status = 'Chưa thanh toán';
                                            } elseif ($order['transaction_status'] == 1) {
                                                $transaction_status = 'Chờ thanh toán';
                                            } else {
                                                $transaction_status = 'Đã thanh toán, tiền đã nhận'; //4
                                            }
                                            echo $transaction_status;
                                            ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td width="30px">STT</td>
                                <td>Tên sản phẩm</td>
                                <td class="text-right">Giá sản phẩm</td>
                                <td class="text-right">Số lượng</td>                                
                                <td class="text-right">Thành tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            foreach ($products as $product) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $stt; ?></td>
                                    <td><?php echo $product['title']; ?></td>
                                    <td class="text-right"><strong><?php echo formatRice($product['price_curent']); ?> vnđ</strong></td>
                                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                                    <td class="text-right"><strong><?php echo formatRice(($product['quantity'] * $product['price_curent'])); ?> vnđ</strong></td>
                                </tr>
                                <?php
                                $stt++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="4">Tổng cộng</td>
                                <td class="text-right"><strong id="total"><?php echo formatRice($order['order_amount']); ?> vnđ</strong></td>
                            </tr>                            
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php if ($order['order_note'] != ''): ?>
                <div class="box-footer clearfix">
                    <i>Ghi chú:</i> <?php echo $order['order_note']; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="text-center">
        <?php if ($order['transaction_status'] != 4): ?>
            <form class="form-inline noPrint" action="<?php echo get_admin_url('orders/or_view/' . $order['order_id']); ?>" method="post" id="f-post">
                <input type="hidden" value="<?php echo $order['order_id']; ?>" name="order_id" id="order_id" />                    
                <button class="btn btn-primary" id="click_pay" type="submit" style="margin-bottom: 10px;">Xác nhận thanh toán đơn hàng này</button>
                <button class="btn btn-info" id="click_print" type="button" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
            </form>
        <?php else: ?>
            <button class="btn btn-info noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
        <?php endif; ?>
    </div>
</div>