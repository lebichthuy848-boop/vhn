<?php $is_admin = isset($role) && in_array($role, array('ADMIN')); ?>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách khách hàng</h4> -->
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
				<?php if($is_admin): ?>
				<a class="btn btn-custom mr-1" id="btn-print" href="<?php echo base_url($module_slug . '/' . 'in-barcode'); ?>">In mã code</a>
				<a class="btn btn-custom btn-export mr-1" href="<?php echo base_url($module_slug . '/' . 'xuat'); ?>">Xuất dữ liệu</a>
				<a class="btn btn-custom btn-import mr-1" href="<?php echo base_url($module_slug . '/' . 'nhap'); ?>">Nhập dữ liệu</a>
				<?php endif; ?>
				<?php if ($is_admin || $have_add == 1): ?>
				<a class="btn btn-custom btn-import" href="<?php echo base_url($module_slug . '/' . 'them'); ?>">Thêm</a>
				<?php endif; ?>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
							<div class="navbar-form card-body py-50">
								<div class="row">
									<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
											<div class="search_input">
												<input class="form-control form-control-sm input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
											</div>
											<label><em>Từ khóa tìm kiếm không ít hơn 3 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Số dòng hiển thị</label>
											<div class="search_input">
												<select class="form-control form-control-sm input-sm" name="per_page">
														<?php
														$records_in_page = 10;
														for ($i = 1; $i <= 10; $i++) {
															$per_page = $i * $records_in_page;
															?>
															<?php if (isset($get['per_page']) && $get['per_page'] == $per_page) : ?>
																<option selected="selected" value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
															<?php else : ?>
																<option value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
															<?php endif; ?>
														<?php
														}
														?>
												</select>
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
					<?php if (empty($rows)): ?>
						<div class="callout callout-warning">
							<h4>Thông báo!</h4>
							<p><b>Không</b> tìm thấy khách hàng nào!</p>
						</div>
					<?php else: ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th class="text-center">
												<input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
											</th>
											<th>#ID</th>
											<th>Tên KH</th>
											<th>Tên công ty</th>
											<th>Điện thoại</th>
											<!-- <th>Barcode</th> -->
											<th class="text-right">Doanh thu bán được</th>
											<th class="text-right">Công nợ</th>
											<th class="text-center">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<?php $is_owned = $row['created_by'] == $userid ? TRUE : FALSE; ?>
											<tr>
												<td class="text-center">
													<input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
												</td>
												<td class="text-right"><?php echo $row['id']; ?></td>
												<td><?php echo $row['full_name']; ?></td>
												<td><?php echo $row['company']; ?></td>
												<td><?php echo $row['phone']; ?></td>
												<!-- <td>
													<?php if(isset($row['customer_code']) && trim($row['customer_code']) != ''): ?>
													<a href="<?php echo base_url('barcode/download') . '?file=' . rawurlencode(base_url(get_module_path('customers') . $row['customer_code'] . '.png')); ?>"><img src="<?php echo base_url(get_module_path('customers') . $row['customer_code'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
													<?php endif; ?>
												</td> -->
												<td class="text-right"><?php echo formatRice(abs($row['amount'])); ?></td>
												<td class="text-right"><?php echo formatRice(abs($row['arrears'])); ?></td>
												<td class="text-center">
													<?php if($is_owned || $is_admin): ?>
													<div class="dropdown">
														<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
														</span>
														<div class="dropdown-menu dropdown-menu-right">
															<a class="dropdown-item" target="_blank" href="<?php echo base_url($module_slug . '/don-hang/' . $row['id']); ?>"><i class="bx bx-cart-alt mr-1"></i> Đơn hàng</a>
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/xem/' . $row['id']); ?>"><i class="bx bxs-show mr-1"></i> Xem</a>
															<?php if ($is_admin || $have_edit == 1): ?>
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/them/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a>
															<?php endif; ?>
															<?php if ($is_admin || $have_delete == 1): ?>
															<a class="dropdown-item delete_bootbox" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
															<?php endif; ?>
														</div>
													</div>
													<?php else: ?>
														---
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
										<tfoot>
											<tr class="text-left">
												<td colspan="3">
													<div class="input-group">
														<select class="form-control" name="action" id="action">
															<option value="delete">Xóa</option>
															<option value="content">Thêm khách hàng</option>
														</select>
														<span class="input-group-btn">
															<button class="btn btn-primary" type="submit">Thực hiện</button>
														</span>
													</div>
												</td>
											</tr>
										</tfoot>
								</table>
							</div>
						</form>
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