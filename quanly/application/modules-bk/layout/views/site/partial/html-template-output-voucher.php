<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="890">
                    <tbody>
                        <tr>
                            <td valign="top" style="border:1px solid #c7c7c7;border-top:none">
                                <table border="0" cellpadding="0" cellspacing="0" width="890">
                                    <tbody>
                                        <tr>
                                            <td valign="top" width="100%">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top">
                                                                <table border="0" cellpadding="15" cellspacing="0" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td valign="top">
                                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td valign="top" style="line-height:150%;color:#5e5e5e;font-size:14px;font-family:Arial;text-align:left">
                                                                                                <div>
                                                                                                    Chào ban quản trị,
                                                                                                    <br>
                                                                                                    <div>Dưới đây là chi tiết hóa đơn bán hàng:</div>
                                                                                                    <br>
                                                                                                    <br>
                                                                                                    <div>
                                                                                                        <p>Thông tin kho hàng</p>
                                                                                                        <p class="warehouse-info">
                                                                                                            <span style="display: inline;"><?php echo isset($row['warehouse_store']) ? $row['warehouse_store'] : ''; ?></span>
                                                                                                            <span style="display: inline;">Địa chỉ: <?php echo isset($row['warehouse_address']) ? $row['warehouse_address'] : ''; ?></span>
                                                                                                            <span style="display: inline;">Điện thoại: <?php echo isset($row['warehouse_phone']) ? $row['warehouse_phone'] : ''; ?></span>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <br>
                                                                                                    <div>
                                                                                                        <p>Thông tin đơn hàng</p>
                                                                                                        <p class="warehouse-info">
                                                                                                            Ngày xuất: <?php echo (isset($row['date']) && ($row['date'] > 0)) ? date('d/m/Y', $row['date']) : date('d/m/Y'); ?> lúc <?php echo date('h:i A', $row['date']); ?><br>
                                                                                                            Số phiếu: <strong style="color: #f00;"><?php echo isset($row['code']) ? $row['code'] : ''; ?></strong>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <br>
                                                                                                    <div>
                                                                                                        <p>Thông tin khách hàng</p>
                                                                                                        <p class="no-margin-bottom">
                                                                                                            Khách hàng<strong class="customer-info-view"><?php echo (isset($row['customer_full_name']) ? $row['customer_full_name'] : '') . ' - ' . get_value_array($this->config->item('customer_type'), isset($row['customer_type']) ? $row['customer_type'] : 'KL'); ?></strong><br>
                                                                                                            Địa chỉ<strong class="customer-info-view"><?php echo isset($row['customer_address']) ? $row['customer_address'] : ''; ?></strong><br>
                                                                                                            Điện thoại<strong class="customer-info-view"><?php echo isset($row['customer_phone']) ? $row['customer_phone'] : ''; ?></strong><br>
                                                                                                            Email<strong class="customer-info-view"><?php echo isset($row['customer_email']) ? $row['customer_email'] : ''; ?></strong>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <br>
                                                                                                    <?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
                                                                                                    <table cellspacing="0" cellpadding="0" width="100%">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-right:40px" align="right">STT</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-right:40px" align="left">Tên sản phẩm</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right">Đơn vị tính</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right">Số lượng</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right">Đơn giá</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right">CK(%)</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right">Thành tiền (vnđ)</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="7" bgcolor="#888888" height="1"></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="7">&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <?php
                                                                                                            $i = 0;
                                                                                                            $total_monetized = 0;
                                                                                                            foreach ($row['items'] as $value):
                                                                                                                $total_monetized += (float) $value['monetized'];
                                                                                                                $i++;
                                                                                                            ?>
                                                                                                                <tr>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-right:40px" align="right"><?php echo $i; ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-right:40px" align="left"><?php echo $value['product_name']; ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-right:40px" align="left"><?php echo $value['product_unit']; ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right"><?php echo $value['quantity']; ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right"><?php echo format_rice_en($value['unit_price']); ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right"><?php echo $value['discount']; ?></td>
                                                                                                                    <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;padding-left:10px;padding-right:10px" align="right"><strong><?php echo format_rice_en($value['monetized']); ?></strong></td>
                                                                                                                </tr>
                                                                                                            <?php endforeach; ?>
                                                                                                            <?php
                                                                                                            $total_number = $total_monetized;
                                                                                                            $total_VAT = $row['VAT'] * $total_number / 100;
                                                                                                            ?>
                                                                                                            <tr>
                                                                                                                <td colspan="7" bgcolor="#888888" height="1"></td>
                                                                                                            </tr>
                                                                                                            <tr class="borderless">
                                                                                                                <td colspan="7" class="borderless">
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
                                                                                                                        <span class="pull-right text-bold text-red"><?php echo format_rice_en($total_number + $total_VAT); ?></span>
                                                                                                                    </p>
                                                                                                                    <div class="clearfix"></div>
                                                                                                                    <p><span style="font-style: italic;">Viết bằng chữ:</span> <strong class="text-bold text-red"><?php echo read_number_to_text($total_number + $total_VAT); ?></strong></p>
                                                                                                                    <div class="clearfix"></div>
                                                                                                                    <p>
                                                                                                                        <span class="pull-left">Tiền trả trước</span>
                                                                                                                        <span class="pull-right text-success text-bold"><?php echo format_rice_en($row['prepaid']); ?></span>
                                                                                                                    </p>
                                                                                                                    <div class="clearfix"></div>
                                                                                                                    <p>
                                                                                                                        <span class="pull-left">Tiền còn nợ</span>
                                                                                                                        <span class="pull-right text-warning text-bold"><?php echo format_rice_en($row['remainder']); ?></span>
                                                                                                                    </p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <!-- <tr>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;border-bottom:solid 3px;padding-right:40px" align="left" colspan="4">Tổng cộng</td>
                                                                                                                <td style="font-family:Verdana,Tahoma,Sans-serif;font-size:12px;border-bottom:solid 3px;padding-left:10px;padding-right:10px;" align="right"><strong style="color: #f00; font-weight: 700;"><?php echo formatRice($row['order_amount']); ?> vnđ</strong></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="5" bgcolor="#888888" height="1"></td>
                                                                                                            </tr> -->
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if (isset($row['note']) && trim($row['note']) != ''): ?>
                                                                                                        <i>Ghi chú:</i>
                                                                                                        <br>
                                                                                                        <?php echo nl2br($row['note']); ?>
                                                                                                    <?php endif; ?>
                                                                                                    <br>
                                                                                                    <br>
                                                                                                    Để biết thêm thông tin, xin vui lòng tham khảo điều khoản của chúng tôi.<br>
                                                                                                    <br>
                                                                                                    Trân trọng<br>
                                                                                                    <a href="<?php echo base_url(); ?>" style="text-decoration:none;color:#5e5e5e!important" target="_blank"><span class="il"><?php echo ucfirst(str_ireplace('www.', '', parse_url(base_url(), PHP_URL_HOST))); ?></span></a><br>
                                                                                                    <br>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>