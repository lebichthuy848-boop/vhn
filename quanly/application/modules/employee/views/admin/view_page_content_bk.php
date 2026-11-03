<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin</h4>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body">
				<form id="f-content" action="<?php echo base_url($module_slug . '/them'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
						<?php
						if (isset($row['userid'])) {
							echo '<input type="hidden" value="' . $row['userid'] . '" id="id" name="id" />';
						}
						?>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
									<label class="control-label">Tên nhân viên</label>
									<input type="text" class="form-control" name="full_name" value="<?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>">
									<?php echo form_error('full_name'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Mã nhân viên</label>
									<input class="form-control" name="staff_card" type="text" value="<?php echo isset($row['staff_card']) ? $row['staff_card'] : ''; ?>">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
									<label class="control-label">Tên đăng nhập</label>
									<input type="text" class="form-control" name="username" value="<?php echo isset($row['username']) ? $row['username'] : ''; ?>">
									<?php echo form_error('username'); ?>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group required">
									<label class="control-label">Mật khẩu</label>
									<input type="password" class="form-control" name="password" value="">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
									<label class="control-label">Email</label>
									<input type="email" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
									<?php echo form_error('email'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="phone" class="control-label">Điện thoại</label>
									<input class="form-control" name="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Quyền</label>
									<select class="form-control" name="role">
										<?php echo get_option_select($this->config->item('role'), isset($row['role']) ? $row['role'] : ''); ?>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Cấp bậc</label>
									<select class="form-control" name="level">
										<option>--Chưa xác định---</option>
			                            <?php echo get_option_select($this->config->item('level'), isset($row['level']) ? $row['level'] : ''); ?>
			                        </select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Phòng/ban</label>
									<select class="form-control" name="id_type_of_departments">
										<?php echo display_option_select($type_of_departments, 'id', 'name', isset($row['id_type_of_departments']) ? $row['id_type_of_departments'] : 0); ?>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Kho</label>
									<select class="form-control" name="warehouse_id">
										<?php echo display_option_select($warehouse, 'id', 'name', isset($row['warehouse_id']) ? $row['warehouse_id'] : 0); ?>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="datePickerStartday" class="control-label">Ngày sinh</label>
									<div class="input-group input-append date" id="datePickerStartday">
										<?php $birthday = (isset($row['birthday']) && ($row['birthday'] != 0)) ? date('d-m-Y', $row['birthday']) : ''; ?>
										<input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>" readonly="readonly" />
										<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="address" class="control-label">Địa chỉ</label>
									<input class="form-control" name="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="checkbox">
								<label for="have_add">
									<?php $checked = ((!isset($row['have_add']) || ($row['have_add'] == 1)) ? ' checked' : ''); ?>
									<input class="flat-blue" name="have_add" id="have_add" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Có quyền thêm</strong>
								</label>
							</div>
						</div>

						<div class="form-group">
							<div class="checkbox">
								<label for="have_edit">
									<?php $checked = ((!isset($row['have_edit']) || ($row['have_edit'] == 1)) ? ' checked' : ''); ?>
									<input class="flat-blue" name="have_edit" id="have_edit" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Có quyền sửa</strong>
								</label>
							</div>
						</div>

						<div class="form-group">
							<div class="checkbox">
								<label for="have_delete">
									<?php $checked = ((!isset($row['have_delete']) || ($row['have_delete'] == 1)) ? ' checked' : ''); ?>
									<input class="flat-blue" name="have_delete" id="have_delete" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Có quyền xóa</strong>
								</label>
							</div>
						</div>

						<?php if(isset($access_menus) && is_array($access_menus) && !empty($access_menus)): ?>
							<div class="row">
							<?php foreach ($access_menus as $access_menu): ?>
								<div class="col-md-4">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input class="flat-blue" name="access_menu[][<?php echo $access_menu['id']; ?>]" type="checkbox" value="1"> <strong><?php echo $access_menu['name']; ?></strong>
											</label>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<div class="text-center">
							<?php if (isset($row['userid'])) : ?>
								<button type="submit" class="btn btn-primary">Lưu thay đổi</button>
							<?php else : ?>
								<button type="submit" class="btn btn-success">Thêm</button>
							<?php endif; ?>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>