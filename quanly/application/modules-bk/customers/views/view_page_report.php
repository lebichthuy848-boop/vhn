<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Báo cáo theo khách hàng</h4> -->
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
							<div class="navbar-form card-body">
								<div class="row">
									<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
											<div class="search_input">
												<div class="search_input">
																			<input class="form-control form-control-sm input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
												</div>
												<label class="font-small-1 mb-1"><em>Từ khóa tìm kiếm không ít hơn 3 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
										<div class="form-group">
											<label class="col-form-label search_title">Loại khách hàng</label>
											<div class="search_input">
												<select class="form-control form-control-sm input-sm" name="customer_type_id" id="customer_type_id">
														<option value="">---</option>
														<?php echo display_option_select($type_of_customer, 'id', 'name', isset($get['customer_type_id']) ? $get['customer_type_id'] : 0); ?>
												</select>
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
							<p><b>Không</b> tìm thấy khách hàng nào!</p>
						</div>
					<?php else: ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Mã KH</th>
											<th>Khách hàng</th>
											<th>Điện thoại</th>
											<th>Email</th>
											<th class="text-right">Số lượng sản phẩm</th>
											<th class="text-right">Thành tiền</th>
											<th class="text-center" style="width: 120px;">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<tr>
												<td class="text-right"><?php echo $row['id']; ?></td>
												<td><?php echo $row['full_name']; ?></td>
												<td><?php echo $row['phone']; ?></td>
												<td><?php echo $row['email']; ?></td>
												<td class="text-right"><?php echo formatRice($row['total_quantity']); ?></td>
												<td class="text-right"><?php echo formatRice($row['total_monetized']); ?></td>
												<td class="text-center">
													<?php if($row['total_quantity'] > 0 && $row['total_monetized'] > 0): ?>
														<em class="fa fa-history fa-lg">&nbsp;</em> <a target="_blank" href="<?php echo base_url('khach-hang/don-hang/' . $row['id']); ?>">Lịch sử mua</a>
													<?php else: ?>
														--Chưa mua--
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