<style>
    .text-bold{
        font-weight: 700;
    }
</style>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
				<!-- <h4 class="card-title">Báo cáo theo ngày</h4> -->
				<div class="card-header-left">
					<div class="collapsible collapse-icon accordion-icon-rotate">
						<div class="search_bar">
							<div class="card collapse-header">
								<div id="headingCollapse5" class="card-header" data-toggle="collapse" role="button" data-target="#filter-bar-7adecd427b033de80d2a0e30cf74e735">
										<span class="collapse-title">
												<i class='bx bx-filter-alt align-middle'></i>
												<span class="align-middle">Bộ lọc</span>
										</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-header-right">
					<a href="<?php echo base_url($module_slug . '/' . 'xuat' . ((isset($get) && is_array($get) && !empty($get)) ? '?' . http_build_query($get, '', "&") : '')); ?>" class="btn btn-custom btn-import mr-1">Xuất dữ liệu</a>
					<button class="btn btn-custom noPrint" id="click_print" type="button">In</button>
				</div>
				<div class="clearfix"></div>
				<div class="block-content-searchbox">
					<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
						<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
							<div class="card-content">
									<div class="navbar-form card-body">
										<div class="row">
											<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
												<div class="form-group">
													<label class="col-form-label search_title">Tháng</label>
													<div class="search_input">
														<div class="input-group input-append date" id="datePickerMonth">
															<?php $month = (isset($get['month']) && ($get['month'] != '') ? $get['month'] : date('m-Y'));?>
															<input type="text" class="form-control form-control-sm input-sm" name="month" value="<?php echo $month; ?>" />
															<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													</div>
												</div>
											</div>
											<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
												<div class="form-group">
													<label class="col-form-label search_title">Loại kho hàng</label>
													<div class="search_input">
														<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn kho hàng" name="warehouse_id" id="warehouse_id">
																<option value="">Tất cả</option>
																<option value="-1"<?php echo (isset($get['warehouse_id']) && ($get['warehouse_id'] == -1)) ? ' selected="selected"' : '';?>>Kho khác</option>
																<?php echo display_option_select($warehouse, 'id', 'name', isset($get['warehouse_id']) ? $get['warehouse_id'] : 0); ?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
												<label class="col-form-label search_title"></label>
												<div class="form-group search_action">
														<button type="submit" class="btn btn-block btn-primary btn-sm">Xem</button>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>
					</form>
				</div>
		</div>
		<div class="card-content custom-card-table">
			<div class="card-body px-0">
				<div class="box-body" id="element_print">
					<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
							<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
											<thead>
													<tr>
															<th class="text-center">Ngày</th>
						<th class="text-right">Số đơn hàng</th>
															<th class="text-right">Số sản phẩm</th>
															<th class="text-right">Thành tiền</th>
															<th class="text-right">Lợi nhuận</th>
															<th class="text-center">Chức năng</th>
													</tr>
											</thead>
											<tbody>
					<?php
					$total_VAT = 0;
					$total_count_order = 0;
					$total_quantity = 0;
					$total_monetized = 0;
													$total_sub_total_monetized = 0;
													$total_profit = 0;
					$total_remainder = 0;
					foreach($rows as $key => $row):
						$count_order = $row['count_order'];
						$quantity = $row['quantity'];
						$VAT = $row['VAT'];
						$monetized = $row['monetized'];
															$sub_total_monetized = $row['sub_total_monetized'];
															$profit = $row['profit'];
						$remainder = $row['remainder'];
						$total_VAT += $VAT;
						$total_count_order += $count_order;
						$total_quantity += $quantity;
						$total_monetized += $monetized;
															$total_sub_total_monetized += $sub_total_monetized;
															$total_profit += $profit;
						$total_remainder += $remainder;
					?>
													<tr<?php echo $quantity > 0 ? ' style="background-color: #337ab7; color: #fff;"' : ''; ?>>
															<td class="text-center">
																	<?php echo $key >= 10 ? $key : "0" . $key; ?>
															</td>
						<td class="text-right">
																	<?php echo formatRice($count_order); ?>
															</td>
															<td class="text-right">
																	<?php echo $quantity; ?>
															</td>
															<td class="text-right">
																	<?php echo formatRice($monetized); ?>
															</td>
															<td class="text-right">
																	<?php echo formatRice($profit); ?>
															</td>
															<td class="text-center">
																	<?php if($quantity > 0): ?>
							<a style="color: #fff;" target="_blank" href="<?php echo base_url('bao-cao/theo-ngay-chi-tiet') . '?date=' . $key . '-' . $month; ?>">Xem chi tiết</a>
							<?php else: ?>
							-
							<?php endif; ?>
															</td>
													</tr>
													<?php endforeach;?>
											</tbody>
											<tfoot>
													<tr class="text-bold text-danger">
															<td>
																	Tổng cộng
															</td>
															<td class="text-right">
																	<?php echo formatRice($total_count_order); ?>
															</td>
						<td class="text-right">
																	<?php echo formatRice($total_quantity); ?>
															</td>
															<td class="text-right">
																 <?php echo formatRice($total_monetized); ?>
															</td>
															<td class="text-right">
																	<?php echo formatRice($total_profit); ?>
															</td>
															<td class="text-center">-</td>
													</tr>
											</tfoot>
									</table>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
