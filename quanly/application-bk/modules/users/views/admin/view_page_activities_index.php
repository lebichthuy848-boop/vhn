<style type="text/css">
    .mt-5{
        margin-top: 5px !important;
    }
</style>
<?php $is_admin = isset($role) && in_array($role, array('ADMIN')); ?>
<div class="box-shops">
	<div class="card">
    <div class="card-header row d-md-flex justify-content-between align-items-center">
        <!-- <h4 class="card-title">Lịch sử nhật ký hệ thống</h4> -->
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Người dùng</th>
                                    <th>Hoạt động</th>
                                    <th>IP</th>
                                    <th class="text-center">Thời gian</th>
                                    <?php if($is_admin): ?>
                                    <th class="text-center">Chức năng</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['full_name']; ?></td>
                                        <td><?php echo $row['activity']; ?></td>
                                        <td><?php echo $row['ip']; ?></td>
                                        <td class="text-center"><?php echo display_date($row['created']); ?></td>
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
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h4 class="alert-heading">Thông báo!</h4>
                        <p><strong>Không</strong> có nhật ký hệ thống nào!</p>
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