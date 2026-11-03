<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin khách hàng</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="full_name" class="control-label">Khách hàng</label>
							<input readonly class="form-control" name="full_name" id="full_name" type="text" value="<?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>">
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label for="email" class="control-label">Email</label>
							<input readonly class="form-control" name="email" id="email" type="text" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<br>
							<div class="checkbox">
								<label for="active">
									<?php $checked = ((!isset($row['active']) || ($row['active'] == 1)) ? ' checked' : ''); ?>
									<input disabled class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Kích hoạt</strong>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label for="area" class="control-label">Khu vực</label>
							<input readonly class="form-control" name="area" id="area" type="text" value="<?php echo isset($row['area']) ? $row['area'] : ''; ?>">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="city" class="control-label">Thành phố</label>
							<input readonly class="form-control" name="city" id="city" type="text" value="<?php echo isset($row['city']) ? $row['city'] : ''; ?>">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="phone" class="control-label">Di động</label>
							<input readonly class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="customer_code" class="control-label">Mã khách hàng</label>
							<input readonly class="form-control" name="customer_code" id="customer_code" type="text" value="<?php echo isset($row['customer_code']) ? $row['customer_code'] : ''; ?>">
						</div>
					</div>
					<?php if(isset($row['customer_code']) && trim($row['customer_code']) != ''): ?>
					<div class="col-md-2">
						<a href="<?php echo base_url('barcode/download') . '?file=' . rawurlencode(base_url(get_module_path('customers') . $row['customer_code'] . '.png')); ?>"><img src="<?php echo base_url(get_module_path('customers') . $row['customer_code'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
					</div>
					<?php endif; ?>
				</div>
				<div class="form-group">
					<label for="address" class="control-label">Địa chỉ</label>
					<input readonly class="form-control" name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
				</div>
				<div class="form-group">
					<label for="note" class="control-label">Ghi chú</label>
					<textarea readonly id="note" name="note" data-autoresize rows="3" class="form-control"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
				</div>
				<div class="text-center">
					<a href="<?php echo base_url($module_slug); ?>" class="btn btn-primary">Đóng</a>
				</div>
			</div>
		</div>
	</div>
</div>