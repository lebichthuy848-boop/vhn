<style type="text/css">
	.table-no-border {
		border-bottom:0px !important;
	}
	.table-no-border th, .table-no-border td {
		border: 1px !important;
	}
	.table-no-border tr td {
		padding-left: 0 !important;
		padding-top: 5px !important;
		padding-bottom: 0 !important;
	}
	.table-no-border .fixed-table-container {
		border:0px !important;
	}
    .text-bold{
        font-weight: bold;
    }
    .modal-static {
        position: fixed;
        top: 50% !important;
        left: 50% !important;
        margin-top: -100px;
        margin-left: -100px;
        overflow: visible !important;
    }
    .modal-static,
    .modal-static .modal-dialog,
    .modal-static .modal-content {
        width: 200px;
        height: 200px;
    }
    .modal-static .modal-dialog,
    .modal-static .modal-content {
        padding: 0 !important;
        margin: 0 !important;
    }
    .modal-static .modal-content .icon {
    }
    select{
        width: 200px;
    }
    #tblAppendGrid .chosen-container:first {
        width: 400px !important;
    }
    #total_text:first-letter{
        text-transform: capitalize;
    }

    @media (max-width: 767px) {
        .table-container-tblAppendGrid{
            width: 100%;
            overflow-x: auto;
            //overflow-y: hidden;
        }
        .table-container-tblAppendGrid::-webkit-scrollbar{
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
        }
        .table-container-tblAppendGrid::-webkit-scrollbar-thumb{
            border-radius: 8px;
            border: 3px solid #fff;
            background-color: rgba(0, 0, 0, .3);
        }
    }
</style>
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
				<form role="form" id="f-content" action="#" method="post" autocomplete="off">
					<?php
					if (isset($row['id'])) {
						echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
						echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
					}
					?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="customer_id" class="control-label">Khách hàng</label>
								<div class="input-group">
									<select class="form-control chosen-select-enable-search" tabindex="1" data-placeholder="Chọn khách hàng" name="customer_id" id="customer_id">
										<!-- <option value="0">---Chọn khách hàng---</option> -->
										<?php echo display_option_select($customers, 'id', array('full_name', 'customer_types_name'), isset($row['customer_id']) ? $row['customer_id'] : 0); ?>
									</select>
									<span style="font-size: 16px; color: rgba(12, 165, 53, 0.88); margin-left: 6px; cursor: pointer;" class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#customer-modal"></span>
								</div>
							</div>

							<p class="info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
								<span>Loại khách hàng:</span> <strong id="type"></strong>
								<br>
								<span>Địa chỉ:</span> <strong id="address"></strong>
								<br>
								<span>Điện thoại:</span> <strong id="phone"></strong>
								<br>
								<span>Email:</span> <strong id="email"></strong>
							</p>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="warehouse_id" class="control-label">Kho hàng</label>
								<select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn kho hàng" name="warehouse_id" id="warehouse_id">
									<?php echo display_option_select($warehouse, 'id', 'name', isset($row['warehouse_id']) ? $row['warehouse_id'] : 0); ?>
								</select>
							</div>
						</div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="datePickerEndday" class="control-label">Ngày bán</label>
                                <div class="input-group input-append date" id="datePickerStartday">
                                    <?php $date = (isset($row['date']) && ($row['date'] > 0)) ? date('d-m-Y', $row['date']) : date('d-m-Y'); ?>
                                    <input type="text" readonly="readonly" class="form-control text-right" name="date" id="start_date" value="<?php echo $date; ?>" style="height: 27px;" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
					</div>

					<div class="row">
						<div class="col-md-12">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-container-tblAppendGrid">
								<table id="tblAppendGrid">
								</table>
							</div>
							<br/>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cash" class="control-label">Tiền khách đưa</label>
                                        <input class="form-control text-right mask-number" name="cash" id="cash" type="text" value="<?php echo isset($row['cash']) ? $row['cash'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="change" class="control-label">Tiền thối lại</label>
                                        <input class="form-control text-right mask-number" name="change" id="change" type="text" value="<?php echo isset($row['change']) ? $row['change'] : 0; ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="prepaid" class="control-label">Số tiền trả trước</label>
                                        <input class="form-control text-right mask-number" name="prepaid" id="prepaid" type="text" value="<?php echo isset($row['prepaid']) ? $row['prepaid'] : 0; ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="remainder" class="control-label">Số tiền còn nợ lại</label>
                                        <input class="form-control text-right mask-number" name="remainder" id="remainder" type="text" value="<?php echo isset($row['remainder']) ? $row['remainder'] : 0; ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="arrears" class="control-label text-red">Nợ cũ - nếu có</label>
                                        <input class="form-control text-right text-red mask-number" name="arrears" id="arrears" type="text" value="<?php echo isset($arrears) ? $arrears : 0; ?>" readonly="readonly">
                                    </div>
                                </div>
                            </div>

        					<div class="row">
        						<div class="col-md-6">
            						<table class="table table-no-border text-bold">
                                        <tr>
                                            <td style="width: 200px;">Tạm tính: </td>
                                            <td class="text-right" style="width: 1px;"><span id="total_number">0</span></td>
                                            <td>Đồng</td>
                                        </tr>
                                        <tr>
                                            <td>Chiết khấu: </td>
                                            <td colspan="2">
                                                <div class="input-group" style="width: 95px;">
                                                    <input type="text" class="form-control text-right" name="discount_percent" id="discount_percent" value="<?php echo isset($row['discount_percent']) ? $row['discount_percent'] : 0; ?>" min="0" max="100" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-red">
                                            <td>Tổng số tiền: </td>
                                            <td class="text-right"><span id="total_VAT_number">0</span></td>
                                            <td>Đồng (<span id="total_VAT_text">Không đồng</span>)</td>
                                        </tr>
            						</table>
    							</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Ghi chú số tiền trả</label>
                                        <input type="text" class="form-control" name="note_prepaid" value="<?php echo isset($row['note_prepaid']) ? $row['note_prepaid'] : ''; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Ghi chú số tiền còn lại</label>
                                        <input type="text" class="form-control" name="note_remainder" value="<?php echo isset($row['note_remainder']) ? $row['note_remainder'] : ''; ?>" />
                                    </div>
                                </div>
    						</div>
    					</div>
    				</div>

					<div class="form-group">
						<label for="note" class="control-label">Ghi chú</label>
						<textarea class="form-control" data-autoresize name="note"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
					</div>

					<div class="row">
						<div class="col-sm-12 col-md-12">
							<button type="submit" class="btn btn-primary">Lưu</button>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger">Thoát</a> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="customer-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="f-customer" action="#" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="customer-modal-label">Thêm khách hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="full_name" class="control-label">Khách hàng</label>
                                <input class="form-control" name="full_name" id="full_name" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer_type" class="control-label">Loại khách hàng</label>
                                <select class="form-control" name="customer_type" id="customer_type">
                                    <?php echo get_option_select($this->config->item('customer_type'), ''); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount" class="control-label">Chiết khấu(%)</label>
                                <input class="form-control" name="discount" id="discount" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    	    <div class="form-group required">
                    	        <label for="customer_code" class="control-label">Mã khách hàng</label>
                    	        <input class="form-control" name="customer_code" id="customer_code" type="text" value="">
                    	    </div>
                    	</div>

                    	<div class="col-md-6">
                    	    <div class="form-group">
                    	        <label for="id_type_of_customer" class="control-label">Loại khách hàng</label>
                    	        <select class="form-control" name="id_type_of_customer" id="id_type_of_customer">
                    	            <?php echo display_option_select($type_of_customer, 'id', 'name', 0); ?>
                    	        </select>
                    	    </div>
                    	</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="control-label">Di động</label>
                                <input class="form-control" name="phone" id="phone" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input class="form-control" name="email" id="email" type="text" value="">
                            </div>
                        </div>
                    </div>

					<div class="row">
                    	<div class="col-md-6">
                            <div class="form-group">
                                <label for="area" class="control-label">Khu vực</label>
                                <input class="form-control" name="area" id="area" type="text" value="">
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="control-label">Thành phố</label>
                                <input class="form-control" name="city" id="city" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="address" class="control-label">Địa chỉ</label>
                                <input class="form-control" name="address" id="address" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <br>
                                <div class="checkbox">
                                    <label for="active" class="control-label" style="padding-left: 0;">
                                        <input class="flat-blue" name="active" id="active" type="checkbox" value="1" checked> <strong>Kích hoạt</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note" class="control-label">Ghi chú</label>
                        <textarea id="note" name="note" data-autoresize rows="3" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Static Modal -->
<div class="modal modal-static face" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="<?php echo base_url('assets/images/loading.gif'); ?>" class="icon" />
                    <h4>Đang xử lý... </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var product_init = [];
    <?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
        <?php foreach ($row['items'] as $value) : ?>
            var product_item = {};
            product_item['product_id'] = "<?php echo $value['product_id']; ?>";
            product_item['image'] = "<?php echo get_image(get_module_path('products') . $value['image'], get_module_path('products') . 'no-image-icon.png'); ?>";
            product_item['unit'] = "<?php echo $value['product_unit']; ?>";
            product_item['price_type'] = "<?php echo $value['price_type']; ?>";
            product_item['price_discount_percent'] = "<?php echo $value['price_discount_percent']; ?>";
            product_item['price_discount'] = "<?php echo numberFormatEncode($value['price_discount']); ?>";
            product_item['quantity'] = "<?php echo $value['quantity']; ?>";
            product_item['unit_price'] = "<?php echo $value['unit_price']; ?>";
            product_item['monetized'] = "<?php echo numberFormatEncode($value['monetized']); ?>";
            product_init.push(product_item);
        <?php endforeach; ?>
    <?php else: ?>
        var product_item = {};
        product_item['product_id'] = "0";
        product_item['image'] = "<?php echo base_url('uploads/products/no-image-icon.png'); ?>";
        product_item['unit'] = "";
        product_item['price_type'] = "retail_price";
        product_item['price_discount_percent'] = "0";
        product_item['price_discount'] = "0";
        product_item['quantity'] = "1";
        product_item['unit_price'] = "0";
        product_item['monetized'] = "0";
        product_init.push(product_item);
    <?php endif; ?>

    var products = {};
    products[0] = 'Chọn sản phẩm';
    <?php if (isset($products) && is_array($products) && !empty($products)): ?>
        <?php foreach ($products as $value) : ?>
            //products[<?php echo $value['id'] ?>] = "<?php echo $value['code']; ?>";
            products[<?php echo $value['id'] ?>] = '<?php echo html_escape($value['name']); ?>' + " - " + "<?php echo html_escape($value['code']); ?>";
        <?php endforeach; ?>
    <?php endif; ?>

    var price_type = {
        'retail_price': 'Giá lẻ',
        'cost_price': 'Giá sỉ'
    };
</script>