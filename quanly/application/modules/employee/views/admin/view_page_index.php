<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách nhân viên</h4> -->
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
				<a class="btn btn-custom btn-import" href="<?php echo base_url($module_slug . '/' . 'them'); ?>">Thêm</a>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
							<div class="navbar-form card-body py-50">
								<div class="row">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
											<div class="search_input">
												<input class="form-control form-control-sm input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
											</div>
											<label><em>Từ khóa tìm kiếm không dùng các mã html</em></label>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Số dòng hiển thị</label>
											<div class="search_input">
												<select class="form-control form-control-sm input-sm" name="per_page">
													<?php
													$records_in_page = 5;
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
					<?php if (!empty($rows)): ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="text-center">
													<input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
												</th>
												<th>#ID</th>
												<th>Tên thành viên</th>
												<th>Tên Đăng Nhập</th>
												<th>Quyền</th>
												<th>Cấp</th>
												<th class="text-center">Chức năng</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($rows as $row): ?>
												<?php if ($row['userid'] != 1): ?>
													<tr>
														<td class="text-center">
															<input type="checkbox" class="check flat-blue" value="<?php echo $row['userid']; ?>" name="idcheck[]">
														</td>
														<td>
															<?php echo $row['userid']; ?>
														</td>
														<td><?php echo $row['full_name']; ?></td>
														<td><?php echo $row['username']; ?></td>
														<td><?php echo get_value_array($this->config->item('role'), $row['role']); ?></td>
														<td><?php echo get_value_array($this->config->item('level'), $row['level']); ?></td>
														<td class="text-center">
															<div class="dropdown">
																<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
																</span>
																<div class="dropdown-menu dropdown-menu-right">
																	<?php if(isset($role) && in_array($role, array('ADMIN'))): ?>
																	<a class="dropdown-item" href="<?php echo base_url('login-by/' . $row['userid']); ?>"><i class="bx bx-log-in-circle mr-1"></i> Đăng nhập</a>
																	<?php endif; ?>
																	<a class="dropdown-item" href="<?php echo base_url($module_slug . '/them/' . $row['userid']); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a>
																	<a class="dropdown-item delete_bootbox" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['userid']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
																</div>
															</div>
														</td>
													</tr>
												<?php endif; ?>
											<?php endforeach; ?>
										</tbody>
										<tfoot>
											<tr class="text-left">
												<td colspan="3">
													<select class="form-control" name="action" id="action">
														<option value="delete">Xóa</option>
														<option value="content">Thêm</option>
													</select>
													<input type="submit" class="btn btn-primary" value="Thực hiện">
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
						</form>
					<?php else: ?>
						<div class="callout callout-warning">
							<h4>Thông báo!</h4>
							<p><b>Không</b> có nhân viên nào!</p>
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