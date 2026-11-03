<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách <?php echo (isset($get['type']) && $get['type'] == 'transaction') ? 'phiếu chuyển kho' : 'phiếu nhập'; ?></h4> -->
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
				<?php if ($role == 'ADMIN' || $have_add == 1): ?>
					<a class="btn btn-custom btn-import mr-1" href="<?php echo base_url($module_slug . '/' . 'nhap-hang-loat'); ?>">Nhập hàng loạt</a>
					<a class="btn btn-custom btn-import" href="<?php echo base_url($module_slug . '/' . 'them'); ?>">Thêm</a>
				<?php endif;?>
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
											<label class="col-form-label search_title">Loại</label>
											<div class="search_input">
												<select name="type" class="form-control form-control-sm input-sm">
													<option value="">Mặc định</option>
													<?php echo get_option_select($this->config->item('purchase_voucher_type'), isset($get['type']) ? $get['type'] : ''); ?>
												</select>
											</div>
										</div>
									</div>
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
									<div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Số phiếu</label>
											<div class="search_input">
												<input class="form-control form-control-sm input-sm" type="text" value="<?php echo isset($get['q']) ? $get['q'] : ''; ?>" maxlength="64" name="q" placeholder="Nhập mã phiếu">
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
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th class="text-center">
												<input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
											</th>
											<th>Mã số phiếu</th>
											<th class="text-right">Tổng số tiền</th>
											<th class="text-center">Ngày nhập</th>
											<th class="text-center">Ngày cập nhật</th>
											<th class="text-center" style="width: 200px;">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<tr>
												<td class="text-center">
													<input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
												</td>
												<td>
													<?php echo $row['code']; ?>
												</td>
												<td class="text-right">
													<?php
													$monetized = 0;
													$discount = 0;
													$VAT = 0;
													if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])) {
														$arr_monetized = array_column($row['items'], 'monetized');
														$arr_VAT = array_column($row['items'], 'VAT');
														$count = (count($arr_monetized) > count($arr_VAT) ? count($arr_VAT) : count($arr_monetized));
														for ($i = 0; $i < $count; $i++) {
																$VAT += ($arr_VAT[$i] * $arr_monetized[$i] / 100);
														}

														$monetized = array_sum($arr_monetized);
														$discount = array_sum(array_column($row['items'], 'discount'));
													}
													echo formatRice($monetized + $VAT - $discount);
													?>
												</td>
												<td class="text-center">
													<?php echo $row['date'] > 0 ? display_date($row['date']) : ''; ?>
												</td>
												<td class="text-center">
													<?php echo $row['modified'] > 0 ? display_date($row['modified']) : ''; ?>
												</td>
												<td class="text-center">
													<div class="dropdown">
														<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
														</span>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/xem/' . $row['id']); ?>"><i class="bx bx-search mr-1"></i> Xem</a>
															<?php if ($role == 'ADMIN' || $have_edit == 1): ?>
																<a class="dropdown-item" href="<?php echo base_url(($row['type'] == 'transaction' ? $module_slug . '/chuyen-kho/' . $row['id'] : $module_slug . '/them/' . $row['id']) . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a>
															<?php endif;?>
															<?php if ($role == 'ADMIN' || $have_delete == 1): ?>	
																<a class="dropdown-item delete_bootbox" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
															<?php endif;?>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<?php if (!($role != 'ADMIN' && $have_add != 1 && $have_delete != 1)): ?>
									<tfoot>
										<tr class="text-left">
											<td colspan="3">
												<div class="input-group">
													<select class="form-control" name="action" id="action">
														<?php if ($role == 'ADMIN'): ?>
															<option value="delete">Xóa</option>
														<?php endif; ?>
														<?php if ($role == 'ADMIN' || $have_add == 1): ?>
															<option value="content">Thêm</option>
														<?php endif; ?>
													</select>
													<span class="input-group-btn">
														<button class="btn btn-primary" type="submit">Thực hiện</button>
													</span>
												</div>
											</td>
										</tr>
									</tfoot>
									<?php endif; ?>
								</table>
							</div>
						</form>
					<?php else: ?>
						<div class="callout callout-warning">
							<h4>Thông báo!</h4>
							<p><b>Không</b> có phiếu nhập nào!</p>
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