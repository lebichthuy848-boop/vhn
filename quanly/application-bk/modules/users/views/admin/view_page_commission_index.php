<style type="text/css">
    .mt-5{
        margin-top: 5px !important;
    }
</style>
<?php $is_admin = isset($role) && in_array($role, array('ADMIN')); ?>
<div class="box-shops">
	<div class="card">
    <div class="card-header row d-md-flex justify-content-between align-items-center">
        <!-- <h4 class="card-title">Lịch sử giao dịch</h4> -->
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
																						<?php echo get_option_per_page(isset($get['per_page']) ? (int) $get['per_page'] : $this->config->item('item', 'admin_list')); ?>
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
                                            <th>Người dùng</th>
                                            <th>Hoạt động</th>
                                            <th class="text-right">Giá trị</th>
                                            <th class="text-right">Phần trăm</th>
                                            <th class="text-right">Hoa hồng</th>
                                            <th class="text-center">Thời gian</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th>Ghi chú</th>
                                            <?php if($is_admin): ?>
                                            <th class="text-center">Chức năng</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row): ?>
                                            <?php if ($row['user_id'] != 1): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
                                                    </td>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td>
                                                        <?php echo $row['full_name']; ?>
                                                        <?php echo display_label(display_value_array($this->config->item('role'), $row['role']), display_value_array($this->config->item('role_label'), $row['role'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo display_label(display_value_array($this->config->item('users_modules_commission'), $row['action']), display_value_array($this->config->item('users_modules_commission_label'), $row['action'])); ?>
                                                        <?php if(in_array($row['action'], array('BUY', 'SUB_BUY_MY', 'SUB_BUY_ROOT'))): ?>
                                                        <p><?php echo $row['order_code']; ?></p>
                                                        <?php endif; ?>
                                                        <?php
                                                        if(isset($row['note']) && trim($row['note']) != ''){
                                                            echo display_label($row['note'], 'danger');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-right"><?php echo ($row['value_cost'] > 0 ? '+' : '') . formatRice($row['value_cost']); ?></td>
                                                    <td class="text-right"><?php echo $row['action'] == 'BUY' ? '' : $row['percent']; ?></td>
                                                    <td class="text-right"><?php echo ($row['value'] > 0 ? '+' : '') . formatRice($row['value']); ?></td>
                                                    <td class="text-center"><?php echo display_date($row['created']); ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        if($row['status'] == 1){
                                                            echo display_label('Khả dụng');
                                                        }elseif($row['status'] == 0){
                                                            echo display_label('Đã yêu cầu', 'warning');
                                                            if(in_array($row['action'], array('BUY'))){
                                                                echo ' <span class="badge badge-primary btn-status-confirm mt-5" data-id="' . $row['id'] . '" style="cursor: pointer;">Xác nhận</span>';
                                                                echo ' <span class="badge badge-danger btn-status-cancel mt-5" data-id="' . $row['id'] . '" style="cursor: pointer;">Hủy</span>';
                                                            }
                                                        }else{
                                                            echo display_label('Đã hủy yêu cầu', 'danger');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['message']; ?></td>
                                                    <?php if($is_admin): ?>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                            </span>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item btn-delete-confirm" href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>"><i class="bx bx-trash mr-1"></i> Xóa</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
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
                                </table>
                            </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h4 class="alert-heading">Thông báo!</h4>
                        <p><strong>Không</strong> có giao dịch nào!</p>
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