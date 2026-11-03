<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">                           
                        <div class="form-group">
                            <label for="name" class="control-label">Tên <?php echo $module_name; ?></label>
                            <input readonly type="text" maxlength="255" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>" name="name" id="name" class="form-control">
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="control-label">Địa chỉ</label>
                            <?php $address = (isset($row['address']) ? $row['address'] : ''); ?>
                            <input readonly class="form-control" name="address" id="address" type="text" value="<?php echo $address; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
						<div class="form-group">
							<label for="id_supplier_type" class="control-label">Loại nhà cung cấp</label>
							<select readonly class="form-control" name="id_supplier_type" id="id_supplier_type">
								<?php echo display_option_select($supplier_type, 'id', 'name', isset($row['id_supplier_type']) ? $row['id_supplier_type'] : 0); ?>
							</select>
						</div>
					</div>
					
					<div class="col-md-3">
                        <div class="form-group">
                            <label for="provider_code" class="control-label">Mã</label>
                            <input readonly class="form-control" name="provider_code" id="provider_code" type="text" value="<?php echo isset($row['provider_code']) ? $row['provider_code'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="phone" class="control-label">Di động</label>
                            <input readonly class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input readonly class="form-control" name="email" id="email" type="text" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="<?php echo base_url($module_slug); ?>" class="btn btn-primary">Đóng</a>
                </div>
            </div>
        </div>
    </div>
</div>