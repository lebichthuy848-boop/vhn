<?php
$warehouse_id = 0;

if(!isset($warehouse_visibility)){
	$warehouse_visibility = array();
}
$count_warehouse = count($warehouse_visibility);

if(!isset($options)){
	$options = array();
}

if(!isset($current_page)){
	$current_page = 0;
}
?>
<style type="text/css">
	.has-border-top{
		border-top: 2px solid #E5E5EA !important;
	}
</style>
<div class="box-shops">	
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Báo cáo theo kho hàng</h4> -->
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
				<a href="<?php echo base_url($module_slug . '/' . 'xuat') . ((isset($get) && is_array($get) && !empty($get)) ? '?' . http_build_query($get, '', "&") : ''); ?>" class="btn btn-custom btn-export mr-1">Xuất dữ liệu</a>
				<button class="btn btn-custom btn-import noPrint" id="click_print" type="button">In</button>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
							<div class="navbar-form card-body">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Loại sản phẩm</label>
											<div class="search_input">
												<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
													<option value="0">Tất cả</option>
													<?php echo display_option_select($category, 'id', 'name', isset($get['category_id']) ? $get['category_id'] : 0); ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
										<label class="col-form-label search_title">Loại kho hàng</label>
										<div class="search_input">
											<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn kho hàng" name="warehouse_id">
												<option value="0">Tất cả</option>
												<option value="-1"<?php echo (isset($get['warehouse_id']) && ($get['warehouse_id'] == -1)) ? ' selected="selected"' : '';?>>Kho khác</option>
												<?php echo display_option_select($warehouse, 'id', 'name', isset($get['warehouse_id']) ? $get['warehouse_id'] : 0); ?>
											</select>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
										<label class="col-form-label search_title">Sản phẩm</label>
										<div class="search_input">
											<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn sản phẩm" name="product_id" id="product_id">
												<option value="0">Tất cả</option>
												<?php echo display_option_select($products, 'id', 'name', isset($get['product_id']) ? $get['product_id'] : 0); ?>
											</select>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<label class="col-form-label search_title">Ngày</label>
										<div class="search_input">
											<div class="input-group input-append date" id="datePickerFromday">
												<?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : '');?>
												<input type="text" class="form-control form-control-sm input-sm" name="fromday" value="<?php echo $fromday; ?>" />
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<label class="col-form-label search_title">Đến ngày</label>
										<div class="search_input">
											<div class="input-group input-append date" id="datePickerToday">
												<?php $today = (isset($get['today']) && ($get['today'] != '') ? $get['today'] : '');?>
												<input type="text" class="form-control form-control-sm input-sm" name="today" value="<?php echo $today; ?>" />
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<label class="col-form-label search_title">Số dòng hiển thị</label>
										<div class="search_input">
											<select class="form-control form-control-sm input-sm" name="per_page">
												<?php
												$records_in_page = 10;
												for ($i = 1; $i <= 10; $i++) {
													$per_page = $i * $records_in_page;
													?>
													<?php if (isset($get['per_page']) && $get['per_page'] == $per_page): ?>
														<option selected="selected" value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
													<?php else: ?>
														<option value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
													<?php endif;?>
												<?php
												}
												?>
												<option value=""<?php echo (isset($get['per_page']) && (int)$get['per_page'] == 0) ? ' selected="selected"' : ''; ?>>Tất cả</option>
											</select>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<label class="col-form-label search_title"></label>
										<div class="search_action">
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
			<div class="box-body" id="element_print">
				<?php if (empty($rows)): ?>
					<div class="callout callout-warning">
						<h4>Thông báo!</h4>
						<p><b>Không</b> tìm thấy thông tin nào!</p>
					</div>
				<?php else: ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th rowspan="2" class="text-center">
										STT
									</th>
									<th rowspan="2">Mã sản phẩm</th>
									<th rowspan="2">Tên sản phẩm</th>
									<th rowspan="2">Kho hàng</th>
									<th colspan="2" class="text-center">Nhập</th>
									<th colspan="5" class="text-center">Xuất</th>
									<th colspan="2" class="text-center">Tồn</th>
								</tr>
								<tr>
									<th class="text-right">Số lượng</th>
									<th class="text-right">Giá trị</th>
									<th class="text-right">Số lượng lẻ</th>
									<th class="text-right">Giá trị</th>
									<th class="text-right">Số lượng sỉ</th>
									<th class="text-right">Giá trị</th>
									<th class="text-right">Tổng cộng</th>
									<th class="text-right">Số lượng</th>
									<th class="text-right">Tổng giá trị</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$j = 0;
								foreach ($rows as $row):
									$j++;
									$row['import'] = 0;
									$row['import_monetized'] = 0;
									$row['export_retail'] = 0;
									$row['export_cost'] = 0;
									$row['export_retail_monetized'] = 0;
									$row['export_cost_monetized'] = 0;
									$row['inventory'] = 0;
									$clone_warehouse = $warehouse_visibility;
								?>
									<tr>
										<td class="text-center" rowspan="<?php echo $count_warehouse; ?>">
											<?php echo $j + $current_page; ?>
										</td>
										<td rowspan="<?php echo $count_warehouse; ?>"><?php echo $row['code']; ?></td>
										<td rowspan="<?php echo $count_warehouse; ?>"><?php echo $row['name']; ?></td>
										<?php if($count_warehouse > 0): ?>
											<?php
											$wh = $clone_warehouse[0];
											unset($clone_warehouse[0]);
											$statistics = get_statistics($row['id'], $wh['id'], $options);
											$row['import'] = $statistics['import'];
											$row['import_monetized'] = $statistics['import_monetized'];
											$row['export_retail'] = $statistics['export_retail'];
											$row['export_cost'] = $statistics['export_cost'];
											$row['export_retail_monetized'] = $statistics['export_retail_monetized'];
											$row['export_cost_monetized'] = $statistics['export_cost_monetized'];
											$row['inventory'] = $statistics['inventory'];
											?>
											<td><?php echo $wh['name']; ?></td>
											<td class="text-right"><?php echo formatRice($row['import']); ?></td>
											<td class="text-right"><?php echo formatRice($row['import_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_cost']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_cost_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail_monetized'] + $row['export_cost_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['inventory']); ?></td>
											<td class="text-right"><?php echo formatRice($row['inventory'] * $row['unit_price']); ?></td>
										<?php else: ?>
											<td>Kho khác</td>
											<td class="text-right"><?php echo formatRice($row['import']); ?></td>
											<td class="text-right"><?php echo formatRice($row['import_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_cost']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_cost_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['export_retail_monetized'] + $row['export_cost_monetized']); ?></td>
											<td class="text-right"><?php echo formatRice($row['inventory']); ?></td>
											<td class="text-right"><?php echo formatRice($row['inventory'] * $row['unit_price']); ?></td>
										<?php endif; ?>
									</tr>
									<?php if(isset($clone_warehouse) && is_array($clone_warehouse) && !empty($clone_warehouse)): ?>
										<?php foreach ($clone_warehouse as $wh): ?>
											<?php
											$statistics = get_statistics($row['id'], $wh['id'], $options);
											$row['import'] = $statistics['import'];
											$row['import_monetized'] = $statistics['import_monetized'];
											$row['export_retail'] = $statistics['export_retail'];
											$row['export_cost'] = $statistics['export_cost'];
											$row['export_retail_monetized'] = $statistics['export_retail_monetized'];
											$row['export_cost_monetized'] = $statistics['export_cost_monetized'];
											$row['inventory'] = $statistics['inventory'];
											?>
											<tr>
												<td><?php echo $wh['name']; ?></td>
												<td class="text-right"><?php echo formatRice($row['import']); ?></td>
												<td class="text-right"><?php echo formatRice($row['import_monetized']); ?></td>
												<td class="text-right"><?php echo formatRice($row['export_retail']); ?></td>
												<td class="text-right"><?php echo formatRice($row['export_retail_monetized']); ?></td>
												<td class="text-right"><?php echo formatRice($row['export_cost']); ?></td>
												<td class="text-right"><?php echo formatRice($row['export_cost_monetized']); ?></td>
												<td class="text-right"><?php echo formatRice($row['export_retail_monetized'] + $row['export_cost_monetized']); ?></td>
												<td class="text-right"><?php echo formatRice($row['inventory']); ?></td>
												<td class="text-right"><?php echo formatRice($row['inventory'] * $row['unit_price']); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="6" class="has-border-top text-right text-bold text-danger">
										<?php echo formatRice($global_total_purchase_voucher_monetized); ?>
									</td>
									<td colspan="2" class="has-border-top text-right text-bold text-danger">
										<?php echo formatRice($global_total_output_voucher_KL_monetized); ?>
									</td>
									<td colspan="2" class="has-border-top text-right text-bold text-danger">
										<?php echo formatRice($global_total_output_voucher_KS_monetized); ?>
									</td>
									<td class="has-border-top text-right text-bold text-danger">
										<?php echo formatRice($global_total_output_voucher_monetized); ?>
									</td>
									<td colspan="2" class="has-border-top text-right text-bold text-danger">
										<?php echo formatRice($global_total_voucher_unit_price_end); ?>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				<?php endif; ?>
			</div>
			<?php if (isset($pagination) && $pagination != ''): ?>
				<div class="box-pagination mt-1 clearfix">
					<?php echo $pagination; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>