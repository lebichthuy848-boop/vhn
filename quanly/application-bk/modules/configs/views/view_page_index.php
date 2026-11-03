<div class="card">
	<div class="card-content">
		<div class="card-body">
			<form id="f-cat" role="form" action="<?php echo current_url(); ?>" method="post" autocomplete="off">
					<div class="row">
							<div class="col-md-6">
									<div class="form-group required<?php echo form_error('site_name') != '' ? ' has-error' : ''; ?>">
											<label for="site_name" class="control-label">Tên phần mềm</label>
											<?php $configs_site_name = (set_value('site_name') != '') ? set_value('site_name') : $configs['site_name']; ?>
											<input class="form-control" name="site_name" id="site_name" type="text" value="<?php echo $configs_site_name; ?>">
											<?php echo form_error('site_name'); ?>
									</div>
							</div>

							<div class="col-md-3">
									<div class="form-group required<?php echo form_error('site_email') != '' ? ' has-error' : ''; ?>">
											<label for="site_email" class="control-label">Email</label>
											<?php $configs_site_email = (set_value('site_email') != '') ? set_value('site_email') : $configs['site_email']; ?>
											<input class="form-control" name="site_email" id="site_email" type="text" value="<?php echo $configs_site_email; ?>">
											<?php echo form_error('site_email'); ?>
									</div>
							</div>

							<div class="col-md-3">
									<div class="form-group required<?php echo form_error('site_phone') != '' ? ' has-error' : ''; ?>">
											<label for="site_phone" class="control-label">Điện thoại</label>
											<?php $configs_site_phone = (set_value('site_phone') != '') ? set_value('site_phone') : $configs['site_phone']; ?>
											<input type="text" maxlength="255" value="<?php echo $configs_site_phone; ?>" name="site_phone" id="site_phone" class="form-control">
											<?php echo form_error('site_phone'); ?>
									</div>
							</div>
					</div>

					<div class="row">
							<div class="col-md-6">
									<div class="form-group required<?php echo form_error('site_store') != '' ? ' has-error' : ''; ?>">
											<label for="site_store" class="control-label">Tên cửa hàng</label>
											<?php $configs_site_store = (set_value('site_store') != '') ? set_value('site_store') : $configs['site_store']; ?>
											<input type="text" maxlength="255" value="<?php echo $configs_site_store; ?>" name="site_store" id="site_store" class="form-control">
											<?php echo form_error('site_store'); ?>
									</div>
							</div>

							<div class="col-md-6">
									<div class="form-group required<?php echo form_error('site_address') != '' ? ' has-error' : ''; ?>">
											<label for="site_address" class="control-label">Địa chỉ</label>
											<?php $configs_site_address = (set_value('site_address') != '') ? set_value('site_address') : $configs['site_address']; ?>
											<input class="form-control" name="site_address" id="site_address" type="text" value="<?php echo $configs_site_address; ?>">
											<?php echo form_error('site_address'); ?>
									</div>
							</div>
					</div>

					<div class="text-right">
							<button class="btn btn-primary" type="submit">Lưu</button>
					</div>
			</form>
		</div>
	</div>
</div>