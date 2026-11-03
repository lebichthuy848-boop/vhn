<style>
    .text-bold{
        font-weight: 700;
    }
</style>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Báo cáo</h4> -->
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
				<a href="<?php echo base_url($module_slug . '/' . 'xuat' . ((isset($get) && is_array($get) && !empty($get)) ? '?' . http_build_query($get, '', "&") : '')); ?>" class="btn btn-custom btn-export mr-1">Xuất dữ liệu</a>
				<button class="btn btn-custom noPrint" id="click_print" type="button">In</button>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
							<div class="navbar-form card-body">
								<div class="row">
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Ngày</label>
											<div class="search_input">
												<div class="input-group input-append date" id="datePickerFromday">
													<?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : '');?>
													<input type="text" class="form-control form-control-sm input-sm" name="fromday" value="<?php echo $fromday; ?>" />
													<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Đến ngày</label>
											<div class="search_input">
												<div class="input-group input-append date" id="datePickerToday">
													<?php $today = (isset($get['today']) && ($get['today'] != '') ? $get['today'] : '');?>
													<input type="text" class="form-control form-control-sm input-sm" name="today" value="<?php echo $today; ?>" />
													<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 offset-xl-5 offset-lg-5 offset-md-5 offset-sm-0">
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
					<?php if (!empty($rows)): ?>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">STT</th>
										<th>Mã hóa đơn</th>
										<th>Thời gian tạo</th>
										<th>Mã khách hàng</th>
										<th>Tên khách hàng</th>
										<th>Email</th>
										<th>Điện thoại</th>
										<th>Địa chỉ (Khách hàng)</th>
										<th>Người bán</th>
										<th>Kênh bán</th>
										<th>Người tạo</th>
										<th>Ghi chú</th>
										<th>Tổng tiền hàng</th>
										<th>Giảm giá hóa đơn</th>
										<th>Khách cần trả</th>
										<th>Trạng thái</th>
										<th>Trạng thái giao hàng</th>
										<th>Mã hàng</th>
										<th>Tên hàng</th>
										<th>Thương hiệu</th>
										<th>ĐVT</th>
										<th>Số lượng</th>
										<th>Đơn giá</th>
										<th>Giảm giá %</th>
										<th>Giảm giá</th>
										<th>Giá bán</th>
										<th>Thành tiền</th>
										<th class="text-right">Doanh thu</th>
									</tr>
								</thead>
								<tbody>
									<?php $j = 0; foreach ($rows as $row): $j++; ?>
									<tr>
										<td class="text-right"><?php echo $current_page + $j; ?></td>
										<td><?php echo $row['code']; ?></td>
										<td class="text-center"><?php echo display_date($row['date']); ?></td>
										<td><?php echo $row['customer_code']; ?></td>
										<td><?php echo $row['customer_full_name']; ?></td>
										<td><?php echo $row['customer_email']; ?></td>
										<td><?php echo $row['customer_phone']; ?></td>
										<td><?php echo $row['customer_address']; ?></td>
										<td><?php echo $row['full_name']; ?></td>
										<td></td>
										<td><?php echo $row['full_name']; ?></td>
										<td><?php echo $row['note']; ?></td>
										<td class="text-right"><?php echo formatRice($row['unit_price'] * $row['quantity']); ?></td>
										<td class="text-right"><?php echo formatRice($row['price_discount']); ?></td>
										<td class="text-right"><?php echo formatRice($row['monetized']); ?></td>
										<td class="text-center">
                                            <?php
                                            if($row['status'] == 1){
                                                echo display_label('Hoàn thành');
                                            }elseif($row['status'] == 0){
                                                echo display_label('Đã yêu cầu', 'warning');
                                            }else{
                                                echo display_label('Đã hủy', 'danger');
                                            }
                                            ?>
                                        </td>
										<td></td>
										<td><?php echo $row['product_code']; ?></td>
										<td><?php echo $row['product_name']; ?></td>
										<td><?php echo $row['product_origin']; ?></td>
										<td><?php echo $row['product_unit']; ?></td>
										<td class="text-right"><?php echo formatRice($row['quantity']); ?></td>
										<td class="text-right"><?php echo formatRice($row['unit_price']); ?></td>
										<td class="text-right"><?php echo formatRice($row['price_discount_percent']); ?></td>
										<td class="text-right"><?php echo formatRice($row['price_discount']); ?></td>
										<td class="text-right"><?php echo formatRice($row['unit_price']); ?></td>
										<td class="text-right"><?php echo formatRice($row['monetized']); ?></td>
										<td class="text-right"><?php echo formatRice($row['monetized']); ?></td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>
					<?php else: ?>
						<div class="callout callout-warning">
							<h4>Thông báo!</h4>
							<p><b>Không</b> có dữ liệu nào!</p>
						</div>
					<?php endif;?>
				</div>
				<div class="clearfix" style="margin-top: 15px;"></div>
				<p style="float: left; font-weight: 700;">Hiển thị <?php echo $current_page + 1; ?> - <?php echo $current_page + count($rows); ?> / Tổng số <?php echo $total_record; ?></p>
				<?php if (isset($pagination) && ($pagination != '')): ?>
					<div class="box-pagination" style="float: right;">
						<?php echo $pagination; ?>
					</div>
				<?php endif;?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>