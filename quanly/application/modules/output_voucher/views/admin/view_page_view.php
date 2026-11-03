<?php $is_admin = isset($role) && ($role == 'ADMIN'); ?>
<style type="text/css">
    .print-only{
        display: none;
    }
    @media print {
        .print-only{
            display: block;
        }
    }
</style>
<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin hóa đơn bán hàng</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body" id="element-print-pdf">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<!-- <div class="pull-left">
							<p class="warehouse-info">
								<span><?php echo isset($row['warehouse_store']) ? $row['warehouse_store'] : ''; ?></span>
								<span>Địa chỉ: <?php echo isset($row['warehouse_address']) ? $row['warehouse_address'] : ''; ?></span>
								<span>Điện thoại: <?php echo isset($row['warehouse_phone']) ? $row['warehouse_phone'] : ''; ?></span>
							</p>
						</div> -->
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
						</div>
						<div class="clearfix"></div>
						<h3 class="text-center text-bold no-margin">HÓA ĐƠN BÁN HÀNG</h3>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12 col-md-12">
						<p class="no-margin-bottom">
							Khách hàng<strong class="customer-info-view"> <?php echo (isset($row['customer_full_name']) ? $row['customer_full_name'] : '') . ' - ' . $row['customer_type_name'];// get_value_array($this->config->item('customer_type'), isset($row['customer_type']) ? $row['customer_type'] : 'KL'); ?></strong>
						</p>
						<div class="row">
							<div class="col-md-6 col-sm-4 col-xs-5 col-lg-4">
								Địa chỉ<strong class="customer-info-view"> <?php echo isset($row['customer_address']) ? $row['customer_address'] : ''; ?></strong>
							</div>
							<div class="col-md-3 col-sm-4 col-xs-4 col-lg-4">
								Điện thoại<strong class="customer-info-view"> <?php echo isset($row['customer_phone']) ? $row['customer_phone'] : ''; ?></strong>
							</div>
							<div class="col-md-3 col-sm-4 col-xs-3 col-lg-4">
								Email<strong class="customer-info-view"> <?php echo isset($row['customer_email']) ? $row['customer_email'] : ''; ?></strong>
							</div>
						</div>
						<br>
						<?php if (isset($row['note']) && trim($row['note']) != ''): ?>
							<p>
								<span style="text-decoration: underline; font-style: italic;">Ghi chú:</span> <strong class="customer-info-view"><?php echo isset($row['note']) ? nl2br($row['note']) : ''; ?></strong>
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
											<th class="el-print-only print-only">Mã sản phẩm</th>
											<th class="product-name">Tên sản phẩm</th>
											<th class="text-center">Đơn vị tính</th>
											<th class="text-right">Số lượng</th>
											<th class="text-right">Đơn giá</th>
											<th class="text-right">Chiết khấu</th>
											<th class="text-right">Thành tiền</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 0;
										foreach ($row['items'] as $value):
											$i++;
										?>
										<tr>
											<td class="text-center">
												<?php echo $i; ?>
											</td>
											<td class="el-print-only print-only">
												<?php echo trim($value['product_code']) != '' ? $value['product_code'] : ''; ?>
											</td>
											<td>
												<?php echo trim($value['product_name']) != '' ? $value['product_name'] : $value['product_name_current']; ?>
											</td>
											<td class="text-center"><?php echo $value['product_unit']; ?></td>
											<td class="text-right"><?php echo $value['quantity']; ?></td>
											<td class="text-right"><?php echo format_rice_en($value['unit_price']); ?></td>
											<td class="text-right"><?php echo format_rice_en($value['price_discount']); ?> (<?php echo $value['price_discount_percent']; ?>%)</td>
											<td class="text-right"><?php echo format_rice_en($value['monetized']); ?></td>
										</tr>
										<?php endforeach;?>
										<tr class="borderless">
											<td colspan="8" class="borderless">
												<p>
													<span class="pull-left">Cộng tiền hàng</span>
													<span class="pull-right text-bold"><?php echo format_rice_en($row['amount']); ?></span>
												</p>
												<div class="clearfix"></div>
												<p>
													<span class="pull-left">Chiết khấu (<?php echo number_format($row['discount_percent'], 2); ?>%)</span>
													<span class="pull-right text-bold"><?php echo format_rice_en($row['discount']); ?></span>
												</p>
												<div class="clearfix"></div>
												<p>
													<span class="pull-left">Tiền phải thu</span>
													<span class="pull-right text-bold text-red"><?php echo format_rice_en($row['monetized']); ?></span>
												</p>
												<div class="clearfix"></div>
												<p><span style="font-style: italic;">Viết bằng chữ:</span> <strong class="text-bold text-red"><?php echo read_number_to_text(round($row['monetized'])); ?></strong></p>
												<div class="clearfix"></div>
                                                <!--
												<p>
                                                    <span class="pull-left">Tiền mặt khách đưa</span>
                                                    <span class="pull-right text-success text-bold"><?php echo format_rice_en($row['cash']); ?></span>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>
                                                    <span class="pull-left">Tiền thối lại</span>
                                                    <span class="pull-right text-info text-bold"><?php echo format_rice_en($row['change']); ?></span>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>
                                                    <span class="pull-left">Tiền mặt khách trả</span>
                                                    <span class="pull-right text-success text-bold"><?php echo format_rice_en($row['prepaid']); ?></span>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>
                                                    <span class="pull-left">Tiền còn nợ</span>
                                                    <span class="pull-right text-danger text-bold"><?php echo format_rice_en($row['remainder']); ?></span>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>
                                                    <span class="pull-left">Tiền nợ cũ</span>
                                                    <span class="pull-right text-warning text-bold"><?php echo isset($arrears) ? format_rice_en($arrears) : 0; ?></span>
                                                </p>
                                                <?php if (isset($row['note_prepaid']) && trim($row['note_prepaid']) != ''): ?>
	                                                <div class="clearfix"></div>
	                                                <p>
	                                                    <span class="pull-left" style="font-style: italic;">Ghi chú số tiền trả</span>
	                                                    <span class="pull-right text-danger text-bold"><?php echo $row['note_prepaid']; ?></span>
	                                                </p>
												<?php endif;?>
												<?php if (isset($row['note_remainder']) && trim($row['note_remainder']) != ''): ?>
	                                                <div class="clearfix"></div>
	                                                <p>
	                                                    <span class="pull-left" style="font-style: italic;">Ghi chú số tiền còn lại</span>
	                                                    <span class="pull-right text-danger text-bold"><?php echo $row['note_remainder']; ?></span>
	                                                </p>
												<?php endif;?>-->
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						<?php endif;?>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 pull-left print-clearfix">
								<div class="text-center">
									<p class="text-center text-bold no-margin-bottom">Người bán hàng</p>
									<p class="text-center">(Ký, họ tên)</p>
									<br>
									<?php
									if (!$is_admin) {
										echo isset($row['user_full_name']) ? ('<strong>' . $row['user_full_name'] . '</strong>') : '';
									}
									?>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 pull-left print-clearfix">
								<div class="text-center">
									<p class="text-center text-bold no-margin-bottom">Thủ kho</p>
									<p class="text-center">(Ký, họ tên)</p>
									<br>
									<br>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 pull-left print-clearfix">
								<div class="text-center">
									<p class="text-center text-bold no-margin-bottom">Người giao hàng</p>
									<p class="text-center">(Ký, họ tên)</p>
									<br>
									<br>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 pull-left print-clearfix">
								<div class="text-center">
									<p class="text-center text-bold no-margin-bottom">Người mua hàng</p>
									<p class="text-center">(Ký, họ tên)</p>
									<br>
									<br>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 noPrint">
						<div class="inline text-right" id="btn-group-action">
							<?php if ($row['status'] == 0): ?>
						        <?php if($is_role_edit): ?>
						        <a class="btn btn-success btn-group-action" href="<?php echo base_url($module_slug . '/them/' . $row['id']); ?>"><i class="bx bx-edit-alt">&nbsp;</i>Sửa</a>
						        <?php endif; ?>
						        <?php if($is_role_comfirm): ?>
						        <button type="button" class="btn btn-primary btn-group-action btn-confirm" data-id="<?php echo $row['id']; ?>">Xác nhận</button>
						        <button type="button" class="btn btn-danger btn-group-action btn-cancel" data-id="<?php echo $row['id']; ?>">Hủy</button>
						        <?php endif; ?>
							<?php elseif ($row['status'] == -1): ?>
							    <button class="btn btn-danger" type="button">Đã hủy</button>
							<?php else: ?>
							    <button class="btn btn-success" type="button">Đơn hàng thành công</button>
							<?php endif; ?>
							<button class="btn btn-info" id="btn-print-pdf" type="button"><i class="bx bxs-file-pdf"></i>&nbsp;In PDF</button>
							<a href="<?php echo base_url($module_slug); ?>" class="btn btn-warning" onclick="return confirm('Bạn có muốn rời khỏi trang này?')"><i class="bx bx-block"></i>&nbsp;Thoát</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div id="element-print-default">
		        <div class="box box-primary" style="border-top: none; width: 100%;">
		            <div class="box-body">
		                <div class="row">
		                    <div class="col-sm-12 col-md-12 text-center">
		                        <p class="warehouse-info font-info">
		                            <span class="font-info"><?php echo isset($row['warehouse_store']) ? $row['warehouse_store'] : ''; ?></span>
		                            <span class="font-info" style="font-size: 10px;">Địa chỉ: <?php echo isset($row['warehouse_address']) ? $row['warehouse_address'] : ''; ?></span>
		                            <span class="font-info" style="font-size: 10px;">Điện thoại: <?php echo isset($row['warehouse_phone']) ? $row['warehouse_phone'] : ''; ?></span>
		                        </p>
		                        <h3 class="text-center text-bold no-margin font-13">HÓA ĐƠN BÁN HÀNG</h3>
		                        <div class="text-center margin-bottom-10">
		                            <div class="customer-info font-info">
		                                Số phiếu: <?php echo isset($row['code']) ? $row['code'] : ''; ?>
		                            </div>
		                            <?php if(isset($row['date']) && $row['date'] > 0): ?>
		                            <div class="customer-info font-info">
		                                Ngày <?php echo date('d', $row['date']); ?> tháng <?php echo date('m', $row['date']); ?> năm <?php echo date('Y', $row['date']); ?>
		                            </div>
		                            <?php endif; ?>
		                        </div>
		                    </div>
		                </div>

		                <div class="row">
		                    <div class="col-sm-12 col-md-12">
		                        <div class="customer-info font-info">
		                            Khách hàng: <?php echo isset($row['customer_full_name']) ? $row['customer_full_name'] : ''; ?></strong>
		                        </div>
		                        <div class="customer-info font-info">
		                            Điện thoại: <?php echo isset($row['customer_phone']) ? $row['customer_phone'] : ''; ?>
		                        </div>
		                        <?php if(isset($row['customer_address']) && trim($row['customer_address']) != ''): ?>
		                        <div class="customer-info font-info">
		                            Địa chỉ: <?php echo isset($row['customer_address']) ? $row['customer_address'] : ''; ?>
		                        </div>
		                        <?php endif; ?>
		                        <?php if(isset($row['customer_email']) && trim($row['customer_email']) != ''): ?>
		                        <div class="customer-info font-info">
		                            Email: <?php echo isset($row['customer_email']) ? $row['customer_email'] : ''; ?>
		                        </div>
		                        <?php endif; ?>
		                        <?php if(isset($row['user_full_name']) && trim($row['user_full_name']) != ''): ?>
		                        <div class="customer-info font-info">
		                            Thu ngân: <?php echo $row['user_full_name']; ?>
		                        </div>
		                        <div class="customer-info font-info">
		                            Ngày lập phiếu <?php echo date('d/m/Y'); ?> lúc <?php echo date('h:s A'); ?>
		                        </div>
		                        <?php endif; ?>
		                        <?php if (isset($row['note']) && trim($row['note']) != ''): ?>
		                        <div class="customer-info font-info">
		                            Ghi chú: <?php echo isset($row['note']) ? nl2br($row['note']) : ''; ?>
		                        </div>
		                        <?php endif;?>
		                        <div class="margin-bottom-10"></div>
		                        <?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
		                            <table class="no-margin-bottom" style="width: 100%;">
		                                <thead>
		                                    <tr class="border-solid-top-bottom">
		                                        <th>Đơn giá</th>
		                                        <th class="text-right">SL</th>
		                                        <th class="text-right">Thành tiền</th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                    <?php
		                                    $i = 0;
		                                    foreach ($row['items'] as $value):
		                                        $i++;
		                                    ?>
		                                    <tr class="border-dashed-bottom">
		                                        <td>
		                                            <?php echo $value['product_name'] . ' (' . $value['product_unit'] . ')'; ?>
		                                            <br/>
		                                            <?php echo format_rice_en($value['unit_price']); ?>
		                                        </td>
		                                        <td class="text-right"><?php echo $value['quantity']; ?></td>
		                                        <td class="text-right"><?php echo format_rice_en($value['monetized']); ?></td>
		                                    </tr>
		                                    <?php endforeach;?>
		                                    <tr class="borderless">
		                                        <td colspan="7" class="borderless">
		                                            <p>
		                                                <span class="pull-left font-info">Tổng tiền hàng</span>
		                                                <span class="pull-right text-bold font-info"><?php echo format_rice_en($row['amount']); ?></span>
		                                            </p>
		                                            <p class="border-dashed-bottom"><span style="font-style: italic;">(Viết bằng chữ:</span> <?php echo read_number_to_text($row['amount']); ?>)</p>
		                                            <div class="clearfix"></div>
		                                        </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                            <div class="clearfix"></div>
		                            <div class="slogun-goodbye">
		                                Cảm ơn và hẹn gặp lại!
		                            </div>
		                        <?php endif;?>
		                    </div>
		                </div>
		            </div>
		        </div>
			</div>
		</div>
	</div>
</div>