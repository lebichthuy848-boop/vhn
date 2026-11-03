<style type="text/css">
    .warehouse-info{
        margin-left: 0px;
    }
    .warehouse-info span{
        display: block;
        color: #111;
        font-weight: 600;
        font-size: 13px;
    }
    .warehouse-info span:first-child{
        font-weight: 700;
        font-size: 13.5px;
        color: #000;
    }
</style>
<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin phiếu nhập</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body" id="element_print">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="pull-left">
							<p class="warehouse-info">
									<span><?php echo isset($store) ? $store : ''; ?></span>
									<span>Địa chỉ: <?php echo isset($address) ? $address : ''; ?></span>
									<span>Điện thoại: <?php echo isset($phone) ? $phone : ''; ?></span>
							</p>
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
						</div>
						<div class="clearfix"></div>
						<h3 class="text-center text-bold no-margin">PHIẾU NHẬP HÀNG</h3>
					</div>
				</div>
				<div class="row">
						<div class="col-sm-12 col-md-12">
								<p class="no-margin-bottom">
										Họ và tên người giao<strong class="customer-info-view"><?php echo isset($row['customer_address']) ? $row['customer_address'] : ''; ?></strong>
								</p>
								<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-6 col-lg-4">
												Nhập tại kho<strong class="customer-info-view"></strong>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-6 col-lg-4">
												địa điểm<strong class="customer-info-view"></strong>
										</div>
								</div>
								<br>
		<?php if (isset($row['note']) && trim($row['note']) != ''): ?>
								<p>
										Ghi chú<strong class="customer-info-view"><?php echo isset($row['note']) ? $row['note'] : ''; ?></strong>
								</p>
		<?php endif;?>
								<?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
										<div class="table-responsive table-view">
												<table class="table table-bordered no-margin-bottom">
														<thead>
																<tr>
																		<th class="text-center">STT</th>
																		<th class="product-name">Tên sản phẩm</th>
																		<th>Kho</th>
																		<th class="text-center">Đơn vị tính</th>
																		<th class="text-center">Số lượng</th>
																		<th class="text-right">Đơn giá</th>
																		<th class="text-right">Thành tiền</th>
							<th>Nhà cung cấp</th>
																</tr>
														</thead>
														<tbody>
																<?php
																$i = 0;
																$total_number = 0;
																$total_monetized = 0;
																foreach ($row['items'] as $value):
																		$total_monetized += (float) $value['monetized'];
																		$i++;
																		?>
																		<tr>
																				<td class="text-center">
																						<?php echo $i; ?>
																				</td>
																				<td><?php echo $value['product_name']; ?></td>
																				<td><?php echo $value['warehouse_name']; ?></td>
																				<td class="text-center"><?php echo $value['product_unit']; ?></td>
																				<td class="text-center"><?php echo $value['quantity']; ?></td>
																				<td class="text-right"><?php echo format_rice_en($value['unit_price']); ?></td>
																				<td class="text-right"><?php echo format_rice_en($value['monetized']); ?></td>
																				<td><?php echo $value['provider_name']; ?></td>
																		</tr>
																<?php endforeach;?>
																<?php $total_number = $total_monetized;?>
																<tr class="borderless">
																		<td colspan="3" class="borderless">
																				<p>Cộng tiền hàng</p>
								<div class="clearfix"></div>
																		</td>
							<td colspan="3" class="borderless text-red" style="font-style: italic;">
																				<p>Viết bằng chữ: <span class="text-bold" style="font-style: italic;"><?php echo read_number_to_text($total_number); ?></span></p>
																		</td>
							<td class="borderless text-red">
																				<p>
																						<span class="pull-right text-bold"><?php echo format_rice_en($total_monetized); ?></span>
																				</p>
								<div class="clearfix"></div>
																		</td>
																</tr>
														</tbody>
												</table>
										</div>
								<?php endif;?>
								<div style="width: 180px;" class="text-center pull-right">
										<p class="text-center" style="font-style: italic;">Ngày.....tháng......năm........</p>
								</div>
								<div class="clearfix"></div>
								<div style="width: 180px;" class="text-center pull-right">
										<p class="text-center">
			<strong>Người lập phiếu</strong>
			<br>
			(Ký, họ tên)</p>
										<br>
										<br>
								</div>
						</div>

						<div class="col-sm-12 col-md-12">
								<div class="inline text-right">
										<button class="btn btn-info noPrint" id="click_print" type="button"><i class="bx bxs-printer"></i>&nbsp;In</button>
										<a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger noPrint"><i class="bx bx-block"></i>&nbsp;Thoát</a>
								</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>