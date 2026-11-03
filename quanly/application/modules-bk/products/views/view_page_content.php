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
				<form id="f-content" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
					<?php
					if (isset($row['id'])) {
						echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
						echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
					}
					?>
					<div class="row">
							<div class="col-md-4">
								<div class="form-group required">
									<label for="name" class="control-label">Tên sản phẩm</label>
									<input class="form-control" name="name" id="name" type="text" value='<?php echo isset($row['name']) ? $row['name'] : ''; ?>'>
									<?php echo form_error('name'); ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group required">
									<label for="code" class="control-label">Mã sản phẩm (Tối đa 15 ký tự + số)</label>
									<input class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>" minlength="1" maxlength="15">
									<?php echo form_error('code'); ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="category_id" class="control-label">Loại sản phẩm</label>
									<select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
										<?php echo display_option_select($category, 'id', 'name', isset($row['category_id']) ? $row['category_id'] : 0); ?>
									</select>
								</div>
							</div>
					</div>

					<div class="row">
						

						

						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label">Số lượng nhập đầu</label>
								<input type="text" class="form-control" name="quantity_init" value="<?php echo isset($row['quantity_init']) ? $row['quantity_init'] : ''; ?>" >
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label">Số lượng</label>
								<input type="text" class="form-control" name="quantity" value="<?php echo isset($row['quantity']) ? $row['quantity'] : ''; ?>" readonly="readonly">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="unit_price" class="control-label">Giá nhập</label>
								<input class="form-control" name="unit_price" id="unit_price" type="text" value="<?php echo isset($row['unit_price']) ? $row['unit_price'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="retail_price" class="control-label">Giá bán</label>
								<input class="form-control" name="retail_price" id="retail_price" type="text" value="<?php echo isset($row['retail_price']) ? $row['retail_price'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="safety_margin" class="control-label">Lượng an toàn</label>
								<input class="form-control" name="safety_margin" id="safety_margin" type="text" value="<?php echo isset($row['safety_margin']) ? $row['safety_margin'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Hạn sử dụng</label>
                                <select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn hạn sử dụng" name="unit_id">
                                    <?php echo display_option_select($unit, 'id', 'name', isset($row['unit_id']) ? $row['unit_id'] : 0); ?>
                                </select>
                            </div>
                        </div>

						
					</div>

					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label for="origin" class="control-label">Xuất xứ</label>
								<input class="form-control" name="origin" id="origin" type="text" value="<?php echo isset($row['origin']) ? $row['origin'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="unit" class="control-label">Đơn vị</label>
								<input class="form-control" name="unit" id="unit" type="text" value="<?php echo isset($row['unit']) ? $row['unit'] : ''; ?>">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="specification" class="control-label">Quy cách</label>
								<input class="form-control" name="specification" id="specification" type="text" value="<?php echo isset($row['specification']) ? $row['specification'] : ''; ?>">
							</div>
						</div>

						

						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label">Ngày sản xuất</label>
								<div class="input-group input-append date" id="datePicker">
									<?php $MFG = (isset($row['MFG']) && ($row['MFG'] > 0)) ? date('d-m-Y', $row['MFG']) : ''; ?>
									<input type="text" class="form-control text-right" name="MFG" value="<?php echo $MFG; ?>" readonly="readonly" />
									<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label">Ngày hết hạn</label>
								<div class="input-group input-append date" id="datePicker1">
									<?php $EXP = (isset($row['EXP']) && ($row['EXP'] > 0)) ? date('d-m-Y', $row['EXP']) : ''; ?>
									<input type="text" class="form-control text-right" name="EXP" value="<?php echo $EXP; ?>" readonly="readonly" />
									<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>

						
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="note" class="control-label">Ghi chú</label>
								<input class="form-control" name="note" id="note" type="text" value="<?php echo isset($row['note']) ? $row['note'] : ''; ?>">
							</div>
						</div>
					</div>

					<div class="form-group<?php echo!isset($row['id']) ? ' required' : ''; ?>">
                        <label class="control-label">Hình minh họa</label>
                        <input type="file" class="file" name="image[]"<?php echo isset($row['id']) ? '' : ' data-min-file-count="1"'; ?>>
                        <?php if(isset($row['image']) && trim($row['image']) != ''): ?>
						<div style="margin-top: 10px;">
                            <img class="img-thumbnail img-responsive" src="<?php echo get_image(get_module_path('products') . $row['image'], get_module_path('products') . 'no-image.png'); ?>" alt="" width="100">
                        </div>
						<?php endif; ?>
                    </div>

					<div class="row">
						<div class="col-md-2">
							<div class="form-group required">
								<label for="barcode" class="control-label">Barcode (Tối đa 15 ký tự + số)</label>
								<input class="form-control" name="barcode" id="barcode" type="text" value="<?php echo isset($row['barcode']) ? $row['barcode'] : ''; ?>" minlength="1" maxlength="15">
								<?php echo form_error('barcode'); ?>
							</div>
						</div>
						<?php if(isset($row['barcode']) && trim($row['barcode']) != ''): ?>
						<div class="col-md-2">
							<a href="<?php echo base_url('barcode/download') . '?file=' . rawurlencode(base_url(get_module_path('barcodes') . $row['barcode'] . '.png')); ?>"><img src="<?php echo base_url(get_module_path('barcodes') . $row['barcode'] . '.png'); ?>" alt="" class="img-thumbnail"></a>
						</div>
						<?php endif; ?>
						<div class="col-md-4">
							<div class="form-group">
								<div class="checkbox">
									<label for="active">
										<?php $checked = ((!isset($row['active']) || ($row['active'] == 1)) ? ' checked' : ''); ?>
										<input class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Kích hoạt</strong>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="text-center">
						<?php if (isset($row['id'])) : ?>
							<input class="btn btn-primary" type="submit" value="Lưu thay đổi">
						<?php else : ?>
							<input class="btn btn-primary" type="submit" value="Thêm">
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>