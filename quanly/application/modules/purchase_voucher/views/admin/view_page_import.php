<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Nhập kho hàng loạt sản phẩm</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url($module_slug); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="box-body">
				<form role="form" action="<?php echo current_url(); ?>" method="post" autocomplete="off">
						<input name="token" type="hidden" value="<?php echo rand(0, 1000); ?>" />
						<div class="row">
								<div class="col-md-2">
										<div class="form-group">
												<label for="datePickerEndday" class="control-label">Ngày nhập</label>
												<div class="input-group input-append date" id="datePickerStartday">
														<input type="text" readonly="readonly" class="form-control text-right" name="date" id="start_date" value="<?php echo date('d-m-Y'); ?>" />
														<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
										</div>
								</div>
								<div class="col-md-2">
										<div class="form-group">
												<label for="quantity" class="control-label">Số lượng nhập</label>
												<input id="quantity" name="quantity" class="form-control text-right" type="number" value="1" min="1" max="100000">
										</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
												<label for="warehouse_id" class="control-label">Kho nhập</label>
												<select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn kho nhập" name="warehouse_id" id="warehouse_id">
														<?php echo display_option_select($warehouse, 'id', 'name', 0); ?>
												</select>
										</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
												<label for="provider_id" class="control-label">Nhà cung cấp</label>
												<select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn nhà cung cấp" name="provider_id" id="provider_id">
														<?php echo display_option_select($provider, 'id', 'name', 0); ?>
												</select>
										</div>
								</div>
						</div>

						<div class="text-center">
								<button class="btn btn-success" type="submit"><i class="fa fa-database"></i> Nhập kho</button>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>