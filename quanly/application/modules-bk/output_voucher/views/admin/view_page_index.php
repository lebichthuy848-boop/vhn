<?php
$is_admin = isset($role) && ($role == 'ADMIN');

?>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Danh sách hóa đơn bán hàng</h4> -->
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
										<div class="col-xl-4 col-lg-4 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Khách hàng</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="customer_id" id="customer_id">
														<option value="0">---Tất cả---</option>
														<?php echo display_option_select($customers, 'id', 'full_name', isset($get['customer_id']) ? $get['customer_id'] : 0); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Tình trạng nợ</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="is_indebted" id="is_indebted">
															<option value="-1">---Tất cả---</option>
															<?php echo get_option_select($this->config->item('output_voucher_indebted'), isset($get['is_indebted']) ? $get['is_indebted'] : -1); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Tình trạng</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="status">
															<option value="">---Tất cả---</option>
															<?php echo get_option_select($this->config->item('output_voucher_status'), isset($get['status']) ? $get['status'] : -2); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Trạng thái thanh toán</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm" name="order_status">
															<option value="">---Tất cả---</option>
															<?php echo get_option_select($this->config->item('output_voucher_order_status'), isset($get['order_status']) ? $get['order_status'] : -1); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Từ khóa tìm kiếm</label>
												<div class="search_input">
													<input class="form-control form-control-sm input-sm" type="text" value="<?php echo isset($get['q']) ? $get['q'] : ''; ?>" maxlength="64" name="q" placeholder="Nhập mã phiếu hoặc tên khách hàng">
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
											<?php if($is_admin): ?>
											<th class="text-center">
												<input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
											</th>
											<?php endif;?>
											<th>Mã số phiếu</th>
											<th>Khách hàng</th>
											<th class="text-center">Ngày xuất</th>
											<th class="text-center">Tình trạng</th>
											<th class="text-center">Trạng thái thanh toán</th>
											<th class="text-center">Tình trạng giao hàng</th>
											<th class="text-right">Tổng số tiền</th>
											<th class="text-right">Số tiền trả</th>
											<th class="text-right">Số tiền còn lại</th>
											<th class="text-center">Chức năng</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($rows as $row): ?>
											<?php //$is_owned = $row['customer_id'] == $userid ? TRUE : FALSE; ?>
											<?php $is_owned = $row['created_by'] == $userid ? TRUE : FALSE; ?>
											<tr>
												<?php if($is_admin): ?>
												<td class="text-center">
													<input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
												</td>
												<?php endif;?>
												<td><?php echo $row['code']; ?></td>
												<td><?php echo $row['customer_full_name']; ?></td>
												<td class="text-center">
													<?php echo $row['date'] > 0 ? display_date($row['date']) : ''; ?>
												</td>
												<td class="text-center">
                                                    <?php
                                                    if($row['status'] == 1){
                                                        echo display_label('Đơn hàng thành công');
                                                    }elseif($row['status'] == 0){
                                                        echo display_label('Đã yêu cầu', 'warning');
                                                    }else{
                                                        echo display_label('Đã hủy', 'danger');
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                	<div class="btn-group order-status-container" data-id="<?php echo $row['id']; ?>">
                                                	    <button type="button" class="btn btn-sm btn-<?php echo display_value_array($this->config->item('output_voucher_order_status_label'), $row['order_status']); ?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                	        <?php echo display_value_array($this->config->item('output_voucher_order_status'), $row['order_status']); ?>
                                                	    </button>
                                                	    <?php if($is_admin): ?>
                                                	    <div class="dropdown-menu">
                                                	        <a class="dropdown-item order-status" data-status="0" href="javascript:void(0)">Chưa thanh toán</a>
                                                	        <a class="dropdown-item order-status" data-status="1" href="javascript:void(0)">Đã thanh toán</a>
                                                	    </div>
                                                		<?php endif; ?>
                                                	</div>
                                                </td>
                                                <td class="text-center">
                                                	<div class="btn-group delivery-status-container" data-id="<?php echo $row['id']; ?>">
                                                	    <button type="button" class="btn btn-sm btn-<?php echo display_value_array($this->config->item('output_voucher_delivery_status_label'), $row['delivery_status']); ?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                	        <?php echo display_value_array($this->config->item('output_voucher_delivery_status'), $row['delivery_status']); ?>
                                                	    </button>
                                                	    <?php if($is_admin): ?>
                                                	    <div class="dropdown-menu">
                                                	        <a class="dropdown-item delivery-status" data-status="0" href="javascript:void(0)">Hàng đã sẵn sàng</a>
                                                	        <a class="dropdown-item delivery-status" data-status="1" href="javascript:void(0)">Hàng đang trên đường</a>
                                                	        <a class="dropdown-item delivery-status" data-status="2" href="javascript:void(0)">Hàng đã giao</a>
                                                	        <a class="dropdown-item delivery-status" data-status="-1" href="javascript:void(0)">Đơn hàng hủy</a>
                                                	    </div>
                                                		<?php endif; ?>
                                                	</div>
                                                </td>
												<td class="text-right"><?php echo formatRice($row['amount']); ?></td>
												<td><?php echo $row['note_prepaid']; ?></td>
												<td><?php echo $row['note_remainder']; ?></td>
												<td class="text-center">
													<div class="dropdown">
														<span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
														</span>
														<div class="dropdown-menu dropdown-menu-right">
															<a class="dropdown-item" href="<?php echo base_url($module_slug . '/xem/' . $row['id']); ?>"><i class="bx bx-search mr-1"></i> Xem</a>
															<?php if($is_owned || $is_admin): ?>
																<?php if($row['status'] == 0 || $is_admin): ?>
																	<?php if ($is_admin || $have_edit == 1): ?>
																		<a class="dropdown-item" href="<?php echo base_url($module_slug . '/them/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page) : '')); ?>"><i class="bx bx-edit-alt mr-1"></i> Sửa</a>
																	<?php endif;?>
																	<?php if ($is_admin || $have_delete == 1): ?>
																		<a class="dropdown-item delete_bootbox" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
																	<?php endif;?>
																<?php endif;?>
															<?php endif;?>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									</tbody>
									<?php if ($is_admin): ?>
									<tfoot>
										<tr class="text-left">
											<td colspan="3">
												<select class="form-control" name="action" id="action">
													<option value="delete">Xóa</option>
												</select>
												<input type="submit" class="btn btn-primary" value="Thực hiện">
											</td>
										</tr>
									</tfoot>
									<?php endif;?>
								</table>
							</div>
						</form>
					<?php else: ?>
						<div class="callout callout-warning">
							<h4>Thông báo!</h4>
							<p><b>Không</b> có hóa đơn bán hàng nào!</p>
						</div>
					<?php endif;?>
				</div>
				<?php if ($pagination != ''): ?>
					<div class="box-pagination clearfix">
						<?php echo $pagination; ?>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>