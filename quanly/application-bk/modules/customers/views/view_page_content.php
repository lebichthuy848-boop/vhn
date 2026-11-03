<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mr-1 mb-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body">
				<form id="f-content" action="<?php echo current_full_url(); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
					<?php
					if (isset($row['id'])) {
						echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
						echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
					}
					?>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
								<label for="full_name" class="control-label">Khách hàng</label>
								<input class="form-control" name="full_name" id="full_name" type="text" value="<?php echo isset($row['full_name']) ? html_escape($row['full_name']) : ''; ?>">
								<?php echo form_error('full_name'); ?>
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="email" class="control-label">Email</label>
								<input class="form-control" name="email" id="email" type="text" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<br>
								<div class="checkbox">
									<label for="active">
										<input class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo (!isset($row['active']) || ($row['active'] == 1)) ? ' checked' : ''; ?>> <strong>Kích hoạt</strong>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<label class="control-label">Tên công ty (Nếu có)</label>
								<input type="text" class="form-control" name="company" value="<?php echo isset($row['company']) ? html_escape($row['company']) : ''; ?>">
							</div>
						</div>
						<div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Đối tượng khách hàng</label>
                                <select class="form-control" name="id_type_of_customer">
                                    <?php echo display_option_select($type_of_customer, 'id', 'name', isset($row['id_type_of_customer']) ? $row['id_type_of_customer'] : 0); ?>
                                </select>
                            </div>
                        </div>
					</div>

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="taxcode" class="control-label">Mã số thuế</label>
								<input class="form-control" name="taxcode" id="taxcode" type="text" value="<?php echo isset($row['taxcode']) ? html_escape($row['taxcode']) : ''; ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="id_card" class="control-label">Chứng minh thư</label>
								<input class="form-control" name="id_card" id="id_card" type="text" value="<?php echo isset($row['id_card']) ? html_escape($row['id_card']) : ''; ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="datePickerStartday" class="control-label">Ngày sinh</label>
								<div class="input-group input-append date" id="datePickerStartday">
									<?php $birthday = (isset($row['birthday']) && ($row['birthday'] != 0)) ? date('d-m-Y', $row['birthday']) : ''; ?>
									<input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>" readonly="readonly" />
									<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="area" class="control-label">Giới tính</label>
								<select class="form-control" name="gender">
		                            <option value="N"<?php if (isset($row['gender']) && ($row['gender'] == 'N')) echo ' selected="selected"'; ?>>N/A</option>
		                            <option value="M"<?php if (isset($row['gender']) && ($row['gender'] == 'M')) echo ' selected="selected"'; ?>>Nam</option>
		                            <option value="F"<?php if (isset($row['gender']) && ($row['gender'] == 'F')) echo ' selected="selected"'; ?>>Nữ</option>
		                        </select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="area" class="control-label">Khu vực</label>
								<input class="form-control" name="area" id="area" type="text" value="<?php echo isset($row['area']) ? $row['area'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="city" class="control-label">Thành phố</label>
								<input class="form-control" name="city" id="city" type="text" value="<?php echo isset($row['city']) ? $row['city'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group required<?php echo form_error('phone') != '' ? ' has-error' : ''; ?>">
								<label for="phone" class="control-label">Di động</label>
								<input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
								<?php echo form_error('phone'); ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group required<?php echo form_error('customer_code') != '' ? ' has-error' : ''; ?>">
								<label for="customer_code" class="control-label">Mã khách hàng</label>
								<input class="form-control" name="customer_code" id="customer_code" type="text" value="<?php echo isset($row['customer_code']) ? $row['customer_code'] : ''; ?>">
								<?php echo form_error('customer_code'); ?>
							</div>
						</div>
						<?php if(isset($row['customer_code']) && trim($row['customer_code']) != ''): ?>
						<div class="col-md-3">
							<a href="<?php echo base_url('barcode/download') . '?file=' . rawurlencode(base_url(get_module_path('customers') . $row['customer_code'] . '.png')); ?>"><img src="<?php echo base_url(get_module_path('customers') . $row['customer_code'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
						</div>
						<?php endif; ?>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="address" class="control-label">Địa chỉ</label>
								<input class="form-control" name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="note" class="control-label">Ghi chú</label>
						<textarea id="note" name="note" data-autoresize rows="3" class="form-control"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
					</div>

					<div class="text-center">
						<?php if (isset($row['id'])) : ?>
							<input class="btn btn-primary" type="submit" value="Lưu thay đổi">
						<?php else : ?>
							<input class="btn btn-success" type="submit" value="Thêm">
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>