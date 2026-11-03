<?php $is_more_info = isset($role) && in_array($role, array('ADMIN')); ?>
<?php $is_admin = isset($role) && in_array($role, array('ADMIN')); ?>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách sản phẩm</h4> -->
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
				<a class="btn btn-custom mr-1" id="btn-print" href="<?php echo base_url($module_slug . '/' . 'in-barcode'); ?>">In Mã Code</a>
				<a class="btn btn-custom btn-export mr-1" href="<?php echo base_url($module_slug . '/' . 'xuat') . ((isset($get) && is_array($get) && !empty($get)) ? '?' . http_build_query($get, '', "&") : ''); ?>">Xuất Dữ Liệu</a>
				<?php if($is_more_info): ?>
				<a class="btn btn-custom btn-import mr-1" href="<?php echo base_url($module_slug . '/' . 'nhap'); ?>">Nhập Dữ Liệu</a>
				<?php endif; ?>
				<a class="btn btn-custom btn-import" href="<?php echo base_url($module_slug . '/' . 'them'); ?>">Thêm</a>
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
												<label class="col-form-label search_title">Loại sản phẩm</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="category_id" id="category_id">
														<option value="">---</option>
														<?php echo display_option_select($category, 'id', 'name', isset($get['category_id']) ? $get['category_id'] : 0); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Kho</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="warehouse_id" id="warehouse_id">
														<option value="">---</option>
														<?php echo display_option_select($warehouse, 'id', 'name', isset($get['warehouse_id']) ? $get['warehouse_id'] : 0); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
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
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
												<div class="search_input">
													<input class="form-control form-control-sm input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
												</div>
												<label><em>Từ khóa tìm kiếm không ít hơn 3 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 offset-xl-5 offset-lg-5 offset-md-5 offset-sm-0">
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
							<p><b>Không</b> tìm thấy sản phẩm nào!</p>
						</div>
					<?php else: ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th class="text-center">
												<input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
											</th>
											<th style="width: 200px;">Tên sản phẩm</th>
											<th style="width: 150px;">Mã sản phẩm</th>
											<th style="width: 100px;">Barcode</th>
											<th style="width: 100px;" class="text-center">ĐVT</th>
											<th style="width: 100px;" class="text-right">Số lượng</th>
											<?php if($is_admin): ?>
											<th style="width: 100px;" class="text-right">Giá nhập</th>
											<?php endif; ?>
											<th style="width: 100px;" class="text-right">Giá lẻ</th>
											<th style="width: 100px;" class="text-right">Giá sỉ</th>
											<?php if($is_more_info): ?>
											<th style="width: 100px;" class="text-center">Ngày tạo</th>
											<?php endif; ?>
											<th style="width: 100px;" class="text-center">Ngày cập nhật</th>
											<th style="width: 100px;" class="text-center">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<tr<?php echo $row['quantity'] <= $row['safety_margin'] ? ' class="danger"' : ''; ?><?php echo ($row['EXP'] > 0 && ($row['EXP'] - (6*24*3600)) < time()) ? ' style="background-color: ' . (($row['EXP'] < time()) ? '#ff4747' : '#fbe651') . ' !important;"' : ''; ?>>
												<td class="text-center">
													<input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
												</td>
												<td><?php echo $row['name']; ?></td>
												<td>
													<?php echo $row['code']; ?>
													<img class="img-thumbnail img-responsive" src="<?php echo get_image(get_module_path('products') . $row['image'], get_module_path('products') . 'no-image.png'); ?>" alt="" width="50">
												</td>
												<td>
													<?php if(isset($row['barcode']) && trim($row['barcode']) != ''): ?>
													<a href="<?php echo base_url('barcode/download') . '?file=' . rawurlencode(base_url(get_module_path('barcodes') . $row['barcode'] . '.png')); ?>"><img src="<?php echo base_url(get_module_path('barcodes') . $row['barcode'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
													<?php endif; ?>
												</td>
												<td class="text-center"><?php echo $row['unit']; ?></td>
												<?php if($is_admin): ?>
												<td class="text-right"><?php echo formatRice($row['quantity']); ?></td>
												<?php endif; ?>
												<td class="text-right"><?php echo formatRice($row['unit_price']); ?></td>
												<td class="text-right"><?php echo formatRice($row['retail_price']); ?> <strong><?php echo $row['asc_desc'] == 'DESC' ? '<i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>' : ($row['asc_desc'] == 'ASC' ? '<i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>' : '-'); ?></strong></td>
												<td class="text-right"><?php echo formatRice($row['cost_price']); ?></td>
												<?php if($is_more_info): ?>
												<td class="text-center"><?php echo display_date($row['created']); ?></td>
												<?php endif; ?>
												<td class="text-center"><?php echo $row['modified'] > 0 ? display_date($row['modified']) : ''; ?></td>
												<td class="text-center">
													<div class="dropdown">
														<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
														</span>
														<div class="dropdown-menu dropdown-menu-right">
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/xem-doi-gia/' . $row['id']); ?>"><i class="bx bx-history mr-1"></i> Xem lịch sử</a>
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/xem/' . $row['id']); ?>"><i class="bx bxs-show mr-1"></i> Xem</a>
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/them/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a>
															<a class="dropdown-item btn-delete" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6">Hiển thị <?php echo $current_page + 1; ?> - <?php echo $current_page + count($rows); ?> / Tổng số <?php echo $total_record; ?> sản phẩm</td>
											<td colspan="6">
												<?php if ($pagination != ''): ?>
													<div class="box-pagination clearfix">
														<?php echo $pagination; ?>
													</div>
												<?php endif; ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="input-group">
									<select class="form-control" name="action" id="action">
											<option value="delete">Xóa</option>
											<option value="content">Thêm</option>
									</select>
									<span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Thực hiện</button>
									</span>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>