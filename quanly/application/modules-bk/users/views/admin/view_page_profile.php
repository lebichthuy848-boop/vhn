<?php
$is_admin = FALSE;
if(isset($row['role']) && $row['role'] == 'ADMIN'){
	$is_admin = TRUE;
}
?>
<!-- BEGIN: Content-->
<section class="page-user-profile">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-content">
					<div class="user-profile-images">
						<?php $photo = (isset($row['photo']) && ($row['photo'] != '') ? $row['photo'] : 'no_avatar.jpg'); ?>
						<img src="<?php echo base_url('assets/Frest/app-assets/images/profile/post-media/profile-banner.jpg'); ?>" class="img-fluid rounded-top user-timeline-image" alt="user timeline image">
						<img src="<?php echo base_url(get_module_path('users') . $photo); ?>" class="user-profile-image rounded" alt="user profile image" height="140" width="140">
					</div>
					<div class="user-profile-text">
						<h4 class="mb-0 text-bold-500 profile-text-color"><?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?></h4>
						<small><?php echo isset($row['level']) ? $row['level'] : ''; ?></small>
					</div>
					<div class="card-body px-0">
							<ul class="nav user-profile-nav justify-content-center justify-content-md-start nav-tabs border-bottom-0 mb-0" role="tablist">
								<li class="nav-item pb-0">
									<a class=" nav-link d-flex px-1 active" data-toggle="tab" href="#profiles" role="tab"><i class="bx bx-home pr-1"></i><span class="d-none d-md-block"> Thông tin</span></a>
								</li>
								<li class="nav-item pb-0">
									<a class="nav-link d-flex px-1" data-toggle="tab" data-toggle="tab" href="#wallet" role="tab"><i class="bx bxs-wallet pr-1"></i><span class="d-none d-md-block">Ví cá nhân</span></a>
								</li>
								<!-- <li class="nav-item pb-0 ml-auto">
									<a class="nav-link d-flex px-1" href="page-user-profile-edit.html"><i class="bx bxs-wallet pr-1"></i><span class="d-none d-md-block">Chỉnh sữa</span></a>
								</li> -->
							</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="tab-content">
						<div class="tab-pane active" id="profiles" aria-labelledby="profiles" role="tabpanel">
							<div class="card">
								<div class="card-content">
										<div class="card-body">
												<!-- <h5 class="card-title">THÔNG TIN CƠ BẢN</h5>
												<div class="row">
													<div class="col-xl-6 col-lg-6 col-md-6 col-12">
														<ul class="list-unstyled">
															<li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i> <?php echo isset($row['address']) ? $row['address'] : ''; ?></li>
															<li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i> <?php echo isset($row['phone']) ? $row['phone'] : ''; ?></li>
															<li><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i><?php echo isset($row['email']) ? $row['email'] : ''; ?></li>
														</ul>
														<div class="row form-group align-items-center font-small-2">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Mã ID quản lý hoặc mã khuyến mãi (nếu có )</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																	<div class="input-group">
																		<input type="text" class="form-control form-control-sm" placeholder="" value="<?php echo isset($row['referred_by']) ? $row['referred_by'] : ''; ?>" readonly>
																	</div>
																</fieldset>
															</div>
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6 col-12 font-small-2">
														<div class="row form-group align-items-start">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Ảnh đại diện</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<div class="border p-25">
																	<img src="<?php echo base_url(get_module_path('users') . $photo); ?>" class="img-fluid d-block w-100">
																</div>
															</div>
														</div>
														<div class="row form-group align-items-start">
															<div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-50">Ảnh CMND</div>
															<div class="col-xl-6 col-lg-6 col-md-6 col-12">
																<div class="border p-25">
																	<img src="app-assets/images/slider/06.jpg" class="img-fluid d-block w-100">
																</div>
																<p class="text-center font-small-2">Mặt trước</p>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-6 col-12">
																<div class="border p-25">
																	<img src="app-assets/images/slider/06.jpg" class="img-fluid d-block w-100">
																</div>
																<p class="text-center font-small-2">Mặt sau</p>
															</div>
														</div>
													</div>
												</div> -->
												<!-- <h5 class="card-title">THÔNG TIN NÂNG CAO</h5>
												<div class="row align-items-center">
													<div class="col-xl-4 col-lg-4 col-md-4 col-12 font-small-2">
														<div class="row form-group align-items-center">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">ID Cá nhân</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																		<div class="input-group">
																				<input type="text" class="form-control form-control-sm" placeholder="" value="DS00005980" readonly>
																				<div class="input-group-append" id="button-addon2">
																						<button class="btn btn-sm btn-primary" type="button"><i class="bx bx-copy font-small-3"></i></button>
																				</div>
																		</div>
																</fieldset>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-4 col-12 font-small-2">
														<div class="row form-group align-items-center">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">CMND</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																		<div class="input-group">
																				<input type="text" class="form-control form-control-sm" placeholder="" value="1683515460" readonly>
																				<div class="input-group-append" id="button-addon2">
																						<button class="btn btn-sm btn-primary" type="button"><i class="bx bx-copy font-small-3"></i></button>
																				</div>
																		</div>
																</fieldset>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-4 col-12 font-small-2">
														<div class="row form-group align-items-center">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Link Cá Nhân</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																		<div class="input-group">
																				<input type="text" class="form-control form-control-sm" placeholder="" value="ducanh.ecosite.vn" readonly>
																				<div class="input-group-append" id="button-addon2">
																						<button class="btn btn-sm btn-primary" type="button"><i class="bx bx-copy font-small-3"></i></button>
																				</div>
																		</div>
																</fieldset>
															</div>
														</div>
													</div>
												</div> -->
												<h5 class="card-title">CHIA SẺ ĐĂNG KÝ THÀNH VIÊN</h5>
												<div class="row align-items-start">
													<div class="col-xl-6 col-lg-6 col-md-6 col-12 font-small-2">
														<div class="row form-group align-items-center">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">ID Giới thiệu</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																	<div class="input-group">
																		<input type="text" class="form-control form-control-sm" value="<?php echo $row['username']; ?>" readonly>
																		<div class="input-group-append" id="button-addon2">
																			<button class="btn btn-sm btn-primary" type="button"><i class="bx bx-copy font-small-3"></i></button>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6 col-12 font-small-2">
														<div class="row form-group align-items-center">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Link Giới thiệu</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">
																<fieldset>
																	<div class="input-group">
																		<input type="text" class="form-control form-control-sm" value="<?php echo site_url('dang-ky') . '?ref=' . $row['username']; ?>" readonly>
																		<div class="input-group-append" id="button-addon2">
																			<button class="btn btn-sm btn-primary" type="button"><i class="bx bx-copy font-small-3"></i></button>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</div>
												</div>
												<!-- <h5 class="card-title">THÔNG TIN TÀI KHOẢN NGÂN HÀNG</h5>
												<div class="row">
													<div class="col-xl-6 col-lg-6 col-md-6 col-12">
														<div class="row form-group font-small-2">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Tên chủ sở hữu</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">Nhàn</div>
														</div>
														<div class="row form-group font-small-2">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Số tài khoản</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">021391239129</div>
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6 col-12">
														<div class="row form-group font-small-2">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Tên ngân hàng</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">Sacombank</div>
														</div>
														<div class="row form-group font-small-2">
															<div class="col-xl-4 col-lg-4 col-md-4 col-12">Chi nhánh ngân hàng</div>
															<div class="col-xl-8 col-lg-8 col-md-8 col-12">Chi nhánh Thủ Đức</div>
														</div>
													</div>
												</div> -->
										</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="wallet" aria-labelledby="wallet" role="tabpanel">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="card">
										<div class="card-body d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="avatar bg-rgba-success m-0 p-25 mr-75 mr-xl-2">
													<div class="avatar-content">
														<i class="bx bx-wallet text-success font-medium-2"></i>
													</div>
												</div>
												<div class="total-amount">
													<h5 class="mb-0"><?php echo formatRice($balance); ?> VNĐ</h5>
													<small class="text-muted">Tổng doanh thu</small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="card">
										<div class="card-body d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="avatar bg-rgba-info m-0 p-25 mr-75 mr-xl-2">
													<div class="avatar-content">
														<i class="bx bx-shopping-bag text-info font-medium-2"></i>
													</div>
												</div>
												<div class="total-amount">
													<h5 class="mb-0"><?php echo formatRice($total_buy); ?> VNĐ</h5>
													<small class="text-muted">Bán hàng</small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="card">
										<div class="card-body d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
													<div class="avatar-content">
														<i class="bx bxs-user-plus text-primary font-medium-2"></i>
													</div>
												</div>
												<div class="total-amount">
													<h5 class="mb-0"><?php echo formatRice($total_commission_buy); ?> VNĐ</h5>
													<small class="text-muted">Hoa hồng</small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="card">
										<div class="card-body d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="avatar bg-rgba-warning m-0 p-25 mr-75 mr-xl-2">
													<div class="avatar-content">
														<i class="bx bxs-trophy text-warning font-medium-2"></i>
													</div>
												</div>
												<div class="total-amount">
													<h5 class="mb-0">4.956 VNĐ</h5>
													<small class="text-muted">Hoa hồng thưởng thêm - Chuyển đổi: 0</small>
												</div>
											</div>
										</div>
									</div>
								</div> -->
								<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="card">
										<div class="card-body d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="avatar bg-rgba-secondary m-0 p-25 mr-75 mr-xl-2">
													<div class="avatar-content">
														<i class="bx bxs-gift text-secondary font-medium-2"></i>
													</div>
												</div>
												<div class="total-amount">
													<h5 class="mb-0">500</h5>
													<small class="text-muted">Điểm tích lủy - Chuyển đổi: 0</small>
												</div>
											</div>
										</div>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Content-->


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-file-text-o">&nbsp;</em>Thông tin tài khoản</h3>
            </div>
            <div class="box-body">
                <form id="f-content" role="form" action="<?php echo site_url('profile'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['userid'])) {
                        echo '<input type="hidden" value="' . $row['userid'] . '" id="userid" name="userid" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
                                <label class="control-label">Họ tên</label>
                                <input class="form-control" name="full_name" type="text" value="<?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>">
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Điện thoại</label>
                                <input class="form-control" name="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
		                        <label class="control-label">Giới tính</label>
		                        <select class="form-control" name="gender">
		                            <option value="N"<?php if (isset($row['gender']) && ($row['gender'] == 'N')) echo ' selected="selected"'; ?>>N/A</option>
		                            <option value="M"<?php if (isset($row['gender']) && ($row['gender'] == 'M')) echo ' selected="selected"'; ?>>Nam</option>
		                            <option value="F"<?php if (isset($row['gender']) && ($row['gender'] == 'F')) echo ' selected="selected"'; ?>>Nữ</option>
		                        </select>
		                    </div>
                        </div>

                        <div class="col-md-3">
	                        <div class="form-group">
		                        <label for="birthday" class="control-label">Ngày tháng năm sinh</label>
		                        <div class="input-group input-append date" id="datePicker">
		                            <?php $birthday = (isset($row['birthday']) && ($row['birthday'] != 0) ? date('d-m-Y', $row['birthday']) : ''); ?>
		                            <input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>" />
		                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
		                        </div>
		                    </div>
	                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('password') != '' ? ' has-error' : ''; ?>">
                                <label for="password" class="control-label">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" value="">
                                <?php echo form_error('password'); ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('passconf') != '' ? ' has-error' : ''; ?>">
                                <label for="passconf" class="control-label">Lặp lại mật khẩu</label>
                                <input type="password" class="form-control" name="passconf" value="">
                                <?php echo form_error('passconf'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <?php if($is_admin): ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
                                <label class="control-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" name="username" value="<?php echo isset($row['username']) ? $row['username'] : ''; ?>">
                                <?php echo form_error('username'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                    </div>
                	<?php endif; ?>

                    <div class="form-group">
                        <?php $photo = (isset($row['photo']) && ($row['photo'] != '') ? $row['photo'] : 'no_avatar.jpg'); ?>
                        <label for="photo" class="control-label">Ảnh đại diện</label>
                        <input id="photo" name="photo[]" class="file" type="file">
                        <div id="current-photo" style="margin-top: 10px;">
                            <img src="<?php echo get_image(get_module_path('users') . $photo, get_module_path('users') . 'no-avatar.jpg'); ?>" width="100px" alt="" class="img-thumbnail">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>