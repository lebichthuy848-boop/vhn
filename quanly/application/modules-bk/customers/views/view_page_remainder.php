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
				<?php if ($role == 'ADMIN' || $have_add == 1): ?>
					<a class="btn btn-custom btn-export mr-1" href="<?php echo base_url($module_slug . '/' . 'xuat') . ((isset($get) && !empty($get)) ? '?' . http_build_query($get, '', "&") : ''); ?>">Xuất Dữ Liệu</a>
				<?php endif;?>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
							<div class="navbar-form card-body py-50">
								<div class="row">
									<!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
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
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
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
									</div> -->
									<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
											<div class="search_input">
												<input class="form-control form-control-sm input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
											</div>
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
							<p><b>Không</b> tìm thấy công nợ khách hàng nào!</p>
						</div>
					<?php else: ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Tên KH</th>
											<th>Tên công ty</th>
											<!-- <th>Nợ đầu kỳ</th> -->
											<th>Nợ phát sinh</th>
											<th>Đã trả</th>
											<th>Nợ cuối kỳ</th>
											<th class="text-center">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<?php $is_owned = $row['created_by'] == $userid ? TRUE : FALSE; ?>
											<tr>
												<td><?php echo $row['full_name']; ?></td>
												<td><?php echo $row['company']; ?></td>
												<!-- <td class="text-right"><?php echo formatRice(abs($row['total'])); ?></td> -->
												<td class="text-right"><?php echo formatRice(abs($row['remainder'])); ?></td>
												<td class="text-right"><?php echo formatRice(abs($row['paid'])); ?></td>
												<td class="text-right"><?php echo formatRice(abs($row['arrears'])); ?></td>
												<td class="text-center">
													<?php if($is_owned || $is_admin): ?>
													<div class="dropdown">
														<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
														</span>
														<div class="dropdown-menu dropdown-menu-right">
															<a class="dropdown-item" href="<?php echo site_url('tra-tien-no/them') . '?customer_id=' . $row['id']; ?>"><i class="bx bx-money mr-1"></i> Thanh toán công nợ</a>
															<a class="dropdown-item" href="<?php echo site_url('khach-hang/don-hang/' . $row['id']) . '?remainder=1'; ?>"><i class="bx bx-table mr-1"></i> Đơn hàng nợ</a>
															<a class="dropdown-item" href="<?php echo site_url('cong-no-khach-hang/lich-su-tra-tien-no') . '?customer_id=' . $row['id']; ?>"><i class="bx bx-history mr-1"></i> Lịch sử thanh toán</a>
														</div>
													</div>
													<?php else: ?>
														---
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
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