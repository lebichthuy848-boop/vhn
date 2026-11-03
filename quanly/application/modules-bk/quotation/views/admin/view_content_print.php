<?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
    <style>
        .customer-info-view{
            margin-left: 10px;
        }
        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
            border-top: 1px solid #f4f4f4;
        }
        .table:last-child{
            border:none !important;
        }
        .table tr.borderless, .table td.borderless{
            border: none !important;
        }
    </style>
    <div>
        <img class="img-responsive" src="<?php echo base_url('assets/images/logo.png'); ?>" alt="" />
    </div>
    <div style="width: 180px;" class="pull-right text-bold">
        <p>
            <span class="pull-left">Ngày</span>
            <span class="pull-right"><?php echo (isset($row['date']) && ($row['date'] > 0)) ? date('d/m/Y', $row['date']) : date('d/m/Y'); ?></span>
        </p>
        <div class="clearfix"></div>
        <h4 class="text-bold">BÁO GIÁ VL - DC</h4>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <p>
                Khách hàng<strong class="customer-info-view"><?php echo (isset($row['customer']['full_name']) ? $row['customer']['full_name'] : '') . ' - ' . get_value_array($this->config->item('customer_type'), isset($row['customer']['customer_type']) ? $row['customer']['customer_type'] : 'KL'); ?></strong>
            </p>
            <p>
                Địa chỉ11<strong class="customer-info-view"><?php echo isset($row['customer']['address']) ? $row['customer']['address'] : ''; ?></strong>
            </p>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-6 col-lg-4">
                    Điện thoại<strong class="customer-info-view"><?php echo isset($row['customer']['phone']) ? $row['customer']['phone'] : ''; ?></strong>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 col-lg-4">
                    Email<strong class="customer-info-view"><?php echo isset($row['customer']['email']) ? $row['customer']['email'] : ''; ?></strong>
                </div>
            </div>
            <br>            

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">
                                STT
                            </th>
                            <th>Tên sản phẩm</th>
                            <th class="text-right">Số lượng</th>
                            <th class="text-center">Đơn vị tính</th>
                            <th class="text-right">Đơn giá</th>
                            <th class="text-right">CK(%)</th>
                            <th class="text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody id="content_print">
                        <?php
                        $i = 0;
                        $total_monetized = 0;
                        $total_discount = 0;
                        foreach ($row['items'] as $value):
                            $total_monetized += (float) $value['monetized'];
                            $total_discount += (float) (($value['monetized'] * $value['discount']) / 100);
                            $i++;
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $value['product_name']; ?>
                                </td>
                                <td class="text-right"><?php echo $value['quantity']; ?></td>
                                <td class="text-center"><?php echo $value['product_unit']; ?></td>
                                <td class="text-right"><?php echo format_rice_en($value['unit_price']); ?></td>
                                <td class="text-right"><?php echo $value['discount']; ?></td>
                                <td class="text-right"><?php echo format_rice_en($value['monetized'] - (($value['monetized'] * $value['discount']) / 100)); ?></td>
                            </tr><?php endforeach; ?>
                        <?php
                        $total_number = $total_monetized - $total_discount;
                        $total_VAT = $row['VAT'] * $total_number / 100;
                        ?>
                        <tr class="borderless">
                            <td colspan="3" class="borderless">
                                <p style="text-decoration: underline; font-style: italic;">Viết bằng chữ:</p>
                                <p style="font-style: italic;"><?php echo read_number_to_text($total_number + $total_VAT); ?></p>
                                <?php if (isset($row['note']) && trim($row['note']) != ''): ?>
                                    <p style="text-decoration: underline; font-style: italic;">Ghi chú:</p>
                                    <p style="font-style: italic;"><?php echo $row['note']; ?></p>
                                <?php endif; ?>
                            </td>
                            <td colspan="4" class="borderless">
                                <p>
                                    <span class="pull-left">Cộng tiền hàng</span>
                                    <span class="pull-right text-bold"><?php echo format_rice_en($total_monetized); ?></span>
                                </p>
                                <div class="clearfix"></div>
                                <p>
                                    <span class="pull-left">Tiền thuế GTGT (<?php echo $row['VAT']; ?> %)</span>
                                    <span class="pull-right text-bold"><?php echo format_rice_en($total_VAT); ?></span>
                                </p>
                                <div class="clearfix"></div>
                                <p>
                                    <span class="pull-left">Tiền phải thu</span>
                                    <span class="pull-right text-bold"><?php echo format_rice_en($total_number + $total_VAT); ?></span>
                                </p>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 180px;" class="text-center pull-right">
                <p class="text-center text-bold">Người lập phiếu</p>
                <p class="text-center">(Ký, họ tên)</p>
                <br>
                <br>
                <p class="text-center"><?php echo isset($row['user_full_name']) ? $row['user_full_name'] : ''; ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>