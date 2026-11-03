<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-info-circle">&nbsp;</em>Thông tin báo giá</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo base_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body" id="element_print">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="pull-left">
                            <img class="img-responsive" src="<?php echo base_url('assets/images/logo.png'); ?>" alt="" />
                        </div>
                        <div style="width: 180px;" class="pull-right text-bold">
                            <p>
                                <span class="pull-left">Số phiếu</span>
                                <span class="pull-right"><?php echo isset($row['code']) ? $row['code'] : ''; ?></span>
                            </p>
                            <div class="clearfix"></div>
                            <p>
                                <span class="pull-left">Ngày</span>
                                <span class="pull-right"><?php echo (isset($row['date']) && ($row['date'] > 0)) ? date('d/m/Y', $row['date']) : date('d/m/Y'); ?></span>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <h3 class="text-center text-bold no-margin">BÁO GIÁ</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <p class="no-margin-bottom">
                            <span>Khách hàng</span><strong class="customer-info-view"><?php echo (isset($row['customer_full_name']) ? $row['customer_full_name'] : '') . ' - ' . get_value_array($this->config->item('customer_type'), isset($row['customer_type']) ? $row['customer_type'] : 'KL'); ?></strong>
                        </p>
                        <div class="row">
                            <div class="col-md-6 col-sm-4 col-xs-5 col-lg-4">
                                Địa chỉ<strong class="customer-info-view"><?php echo isset($row['customer_address']) ? $row['customer_address'] : ''; ?></strong>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-4 col-lg-4">
                                Điện thoại<strong class="customer-info-view"><?php echo isset($row['customer_phone']) ? $row['customer_phone'] : ''; ?></strong>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-3 col-lg-4">
                                Email<strong class="customer-info-view"><?php echo isset($row['customer_email']) ? $row['customer_email'] : ''; ?></strong>
                            </div>
                        </div>
                        <br>
                        <?php if (isset($row['note']) && trim($row['note']) != ''): ?>
                            <p>
                                <span style="text-decoration: underline; font-style: italic;">Ghi chú:</span> <strong class="customer-info-view"><?php echo isset($row['note']) ? $row['note'] : ''; ?></strong>
                            </p>
                        <?php endif;?>
                        <?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
                            <div class="table-responsive table-view">
                                <table class="table table-bordered no-margin-bottom">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                STT
                                            </th>
                                            <th class="product-name">Tên sản phẩm</th>
                                            <th class="text-center">Đơn vị tính</th>
                                            <th class="text-center">Đơn giá</th>
                                            <th class="text-center">CK(%)</th>
                                            <th class="text-center">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$i = 0;
$total_monetized = 0;
foreach ($row['items'] as $value):
	$total_monetized += (float) $value['monetized'];
	$i++;
	?>
	                                       <tr>
	                                         <td class="text-center">
	                                             <?php echo $i; ?>
	                                         </td>
	                                         <td>
	                                             <?php echo $value['product_name']; ?>
	                                         </td>
	                                         <td class="text-center"><?php echo $value['product_unit']; ?></td>
	                                         <td class="text-right"><?php echo format_rice_en($value['unit_price']); ?></td>
	                                         <td class="text-right"><?php echo $value['discount']; ?></td>
	                                         <td class="text-right"><?php echo format_rice_en($value['unit_price'] * (1- ($value['discount'] / 100))); ?></td>
	                                     </tr>
	                                 <?php endforeach;?>
                                 <?php
									$total_number = $total_monetized;
									$total_VAT = $row['VAT'] * $total_number / 100;
								?>
										<tr class="borderless">
                                            <td colspan="6" class="borderless">
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
                                                <p style="font-style: italic;"><span>Viết bằng chữ:</span> <strong class="text-bold"><?php echo read_number_to_text($total_number + $total_VAT); ?></strong></p>
                                            </td>
                                        </tr>
								</tbody>
							</table>
						</div>
					<div class="clearfix"></div>
                <?php endif;?>
                 <div style="width: 260px; margin-right: 110px;" class="text-center pull-right">
                    <br/>
                    <p class="text-center" style="font-style: italic;">Ngày.....tháng......năm........</p>
                </div>
                <div class="clearfix"></div>
                <div style="width: 260px; margin-right: 110px;" class="text-center pull-right">
                    <p class="text-center">
                     <strong>Người lập phiếu</strong>
                     <br>
                     (Ký, họ tên)</p>
                     <br>
                     <?php
if (isset($role) && ($role != 'ADMIN')) {
	echo isset($row['user_full_name']) ? ('<strong>' . $row['user_full_name'] . '</strong>') : '';
}
?>
               </div>
           </div>

           <div class="col-sm-12 col-md-12">
            <div class="inline">
                <button class="btn btn-info noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
                <a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger noPrint">Thoát</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>