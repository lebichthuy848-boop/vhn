<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách đơn hàng</h4> -->
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
			
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
								<div class="navbar-form card-body py-50">
									<div class="row">
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Ngày</label>
												<div class="search_input">
													<div class="input-group input-append date" id="datePickerFromday">
															<?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : ''); ?>
															<input type="text" class="form-control form-control-sm input-sm" name="fromday" value="<?php echo $fromday; ?>" />
															<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Đến ngày</label>
												<div class="search_input">
													<div class="input-group input-append date" id="datePickerToday">
																<?php $today = (isset($get['today']) && ($get['today'] != '') ? $get['today'] : ''); ?>
																<input type="text" class="form-control form-control-sm input-sm" name="today" value="<?php echo $today; ?>" />
																<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
														</div>
												</div>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Số phiếu</label>
												<div class="search_input">
													<input class="form-control form-control-sm input-sm" type="text" value="<?php echo (isset($get['code'])) ? $get['code'] : ''; ?>" maxlength="64" name="code" placeholder="Nhập mã phiếu">
												</div>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
											<label class="col-form-label search_title"></label>
											<div class="form-group search_action">
													<button type="submit" class="btn btn-block btn-primary btn-sm">Tìm kiếm</button>
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
				<div class="box-body">
					<?php if (!empty($rows)): ?>
						<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
										<thead>
												<tr>
														<th>Mã số phiếu</th>
														<th>Khách hàng</th>
														<th class="text-center">Ngày xuất</th>
														<th class="text-center">Trạng thái thanh toán</th>
														<th class="text-right">Tổng số tiền</th>
														<th class="text-right">Số tiền trả</th>
														<th class="text-right">Số tiền còn lại</th>
														<th class="text-center" style="width: 200px;">Chức năng</th>
												</tr>
										</thead>
										<tbody>
												<?php foreach ($rows as $row): ?>
														<tr>
																<td>
																	<?php echo $row['code']; ?>
																</td>
																<td><?php echo $row['customer_full_name']; ?></td>
																<td class="text-center">
																	<?php echo $row['date'] > 0 ? display_date($row['date']) : ''; ?>
																</td>
																<td><?php echo ($row['order_status'] == 1) ? 'Đã thanh toán' : 'Chưa thanh toán'; ?></td>
																<td class="text-right"><?php echo formatRice($row['amount']); ?></td>
																<td class="text-right"><?php echo formatRice($row['prepaid']); ?></td>
																<td class="text-right"><?php echo formatRice($row['remainder']); ?></td>
																<td class="text-center">
																	<div class="dropdown">
																		<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
																		</span>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="<?php echo base_url('phieu-xuat/xem/' . $row['id']); ?>"><i class="bx bx-search mr-1"></i> Xem</a>
																			<?php if ($role == 'ADMIN' || $have_edit == 1): ?>
																			<!-- <a class="dropdown-item" href="<?php echo base_url('phieu-xuat/them/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a> -->
																			<?php endif; ?>
																			<?php if ($role == 'ADMIN' || $have_delete == 1): ?>
																			<!-- <a class="dropdown-item delete_bootbox" href="<?php echo base_url('phieu-xuat/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a> -->
																			<?php endif; ?>
																		</div>
																	</div>
																</td>
														</tr>
												<?php endforeach; ?>
										</tbody>
								</table>
						</div>
					<?php else: ?>
							<div class="callout callout-warning">
									<h4>Thông báo!</h4>
									<p><b>Không</b> có đơn hàng nào!</p>
							</div>
					<?php endif; ?>
				</div>
				<?php if ($pagination != ''): ?>
						<div class="box-pagination clearfix">
								<?php echo $pagination; ?>
						</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>