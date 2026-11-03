<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body">
				<div class="row">
						<div class="col-md-6">
								<div class="form-group">
										<label for="name" class="control-label">Tên sản phẩm</label>
										<?php $name = (isset($row['name']) ? $row['name'] : ''); ?>
										<input readonly class="form-control" name="name" id="name" type="text" value="<?php echo $name; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="code" class="control-label">Mã sản phẩm</label>
										<input readonly class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
										<div class="form-group">
												<label for="datePicker" class="control-label">Ngày hết hạn</label>
												<div class="input-group input-append date" id="datePicker">
														<?php $EXP = (isset($row['EXP']) && ($row['EXP'] > 0)) ? date('d-m-Y', $row['EXP']) : ''; ?>
														<input type="text" readonly="readonly" class="form-control text-right" name="EXP" id="EXP" value="<?php echo $EXP; ?>" />
														<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
										</div>
								</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="category_id" class="control-label">Loại sản phẩm</label>
										<select disabled class="form-control chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
												<?php echo display_option_select($category, 'id', 'name', isset($row['category_id']) ? $row['category_id'] : 0); ?>
										</select>
								</div>
						</div>
				</div>

				<div class="row">
						<div class="col-md-2">
								<div class="form-group">
										<label for="unit" class="control-label">Đơn vị</label>
										<input readonly class="form-control" name="unit" id="unit" type="text" value="<?php echo isset($row['unit']) ? $row['unit'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="safety_margin" class="control-label">Lượng an toàn</label>
										<input readonly class="form-control" name="safety_margin" id="safety_margin" type="text" value="<?php echo isset($row['safety_margin']) ? $row['safety_margin'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="quantity" class="control-label">Số lượng</label>
										<input readonly class="form-control" name="quantity" id="quantity" type="text" value="<?php echo isset($row['quantity']) ? $row['quantity'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="unit_price" class="control-label">Đơn giá nhập</label>
										<input readonly class="form-control" name="unit_price" id="unit_price" type="text" value="<?php echo isset($row['unit_price']) ? $row['unit_price'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="retail_price" class="control-label">Giá lẻ</label>
										<input readonly class="form-control" name="retail_price" id="retail_price" type="text" value="<?php echo isset($row['retail_price']) ? $row['retail_price'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
								<div class="form-group">
										<label for="cost_price" class="control-label">Giá sỉ</label>
										<input readonly class="form-control" name="cost_price" id="cost_price" type="text" value="<?php echo isset($row['cost_price']) ? $row['cost_price'] : ''; ?>">
								</div>
						</div>
				</div>

					<div class="row">
						<div class="col-md-4">
								<div class="form-group">
										<label for="specification" class="control-label">Quy cách</label>
										<input readonly class="form-control" name="specification" id="specification" type="text" value="<?php echo isset($row['specification']) ? $row['specification'] : ''; ?>">
								</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="origin" class="control-label">Xuất xứ</label>
								<input readonly class="form-control" name="origin" id="origin" type="text" value="<?php echo isset($row['origin']) ? $row['origin'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="note" class="control-label">Ghi chú</label>
								<input readonly class="form-control" name="note" id="note" type="text" value="<?php echo isset($row['note']) ? $row['note'] : ''; ?>">
							</div>
						</div>
					</div>

					<div class="row">
							<div class="col-md-2">
									<div class="form-group">
											<label for="barcode" class="control-label">Barcode (Tối đa 15 ký tự + số)</label>
											<input readonly class="form-control" name="barcode" id="barcode" type="text" value="<?php echo isset($row['barcode']) ? $row['barcode'] : ''; ?>" minlength="1" maxlength="15">
									</div>
							</div>
							<?php if(isset($row['barcode']) && trim($row['barcode']) != ''): ?>
							<div class="col-md-2">
									<a href="<?php echo base_url('barcode/download') . '?file=' . $row['barcode'] . '.png'; ?>"><img src="<?php echo base_url(get_module_path('barcodes') . $row['barcode'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
							</div>
							<?php endif; ?>
					</div>

					<div class="form-group">
							<div class="checkbox">
									<label for="active">
											<?php $checked = ((!isset($row['active']) || ($row['active'] == 1)) ? ' checked' : ''); ?>
											<input disabled class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Kích hoạt</strong>
									</label>
							</div>
					</div>

					<div class="text-center">
							<a href="<?php echo base_url($module_slug); ?>" class="btn btn-primary">Đóng</a>
					</div>
			</div>
		</div>
	</div>
</div>