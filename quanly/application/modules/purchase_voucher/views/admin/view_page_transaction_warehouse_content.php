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
	#total_text:first-letter{
        text-transform: capitalize;
    }
	#total_VAT_text::first-letter {
		text-transform: uppercase;
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
    @media (max-width: 767px) {
        .table-container-tblAppendGrid{
            width: 100%;
            overflow-x: auto;
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
	.ui-button-text-icon-primary .ui-button-text, .ui-button-text-icons .ui-button-text {
        padding: 0;
    }
	#category_id_chosen{
		width: 100%;
	}
</style>
<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Thông tin</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo site_url($module_slug) . '?type=transaction&fromday=&today=&q='; ?>"><i class="bx bx-table"></i> Danh sách</a>
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
								<div class="col-md-2">
										<div class="form-group">
												<label for="datePickerEndday" class="control-label">Ngày nhập</label>
												<div class="input-group input-append date" id="datePickerStartday">
														<?php $date = (isset($row['date']) && ($row['date'] > 0)) ? date('d-m-Y', $row['date']) : date('d-m-Y'); ?>
														<input type="text" readonly="readonly" class="form-control text-right" name="date" id="start_date" value="<?php echo $date; ?>" />
														<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
										</div>
								</div>
						</div>

						<div class="row">
								<div class="col-md-12">
										<div class="table-container-tblAppendGrid">
												<table id="tblAppendGrid">
												</table>
										</div>
										<br/>

										<table class="table table-no-border text-bold">
				<tr class="text-red">
					<td style="width: 120px;">Tổng số tiền: </td>
					<td><span id="total_VAT_number">0</span> đồng (<span id="total_VAT_text">Không đồng</span>)</td>
				</tr>
			</table>
								</div>
						</div>

						<div class="form-group">
								<label for="note" class="control-label">Ghi chú</label>
								<textarea class="form-control" data-autoresize name="note" id="note"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
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

<div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="product-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="f-product" action="#" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="customer-modal-label">Thêm sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group required">
                                <label for="name" class="control-label">Tên sản phẩm</label>
                                <input class="form-control" name="name" type="text" value="" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group required">
                                <label for="code" class="control-label">Mã sản phẩm</label>
                                <input class="form-control" name="code" type="text" value="" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id" class="control-label">Loại sản phẩm</label>
                                <select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
                                    <?php echo display_option_select($category, 'id', 'name', 0); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit" class="control-label">Đơn vị</label>
                                <input class="form-control" name="unit" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="datePicker" class="control-label">Ngày hết hạn</label>
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" readonly="readonly" class="form-control text-right" name="EXP" id="EXP" value="" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="safety_margin" class="control-label">Lượng an toàn</label>
                                <input class="form-control" name="safety_margin" type="text" value="" required>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quantity" class="control-label">Số lượng</label>
                                <input class="form-control" name="quantity" type="number" value="" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit_price" class="control-label">Đơn giá nhập</label>
                                <input class="form-control" name="unit_price" type="text" value="" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="retail_price" class="control-label">Giá lẻ</label>
                                <input class="form-control" name="retail_price" type="text" value="" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cost_price" class="control-label">Giá sỉ</label>
                                <input class="form-control" name="cost_price" type="text" value="" required>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specification" class="control-label">Quy cách</label>
                                <input class="form-control" name="specification" type="text" value="">
                            </div>
                        </div>
						
						<div class="col-md-6">
                            <div class="form-group">
                                <label for="origin" class="control-label">Xuất xứ</label>
                                <input class="form-control" name="origin" id="origin" type="text" value="">
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

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active" class="control-label" style="padding-left: 0;">
                                <input readonly class="flat-blue" name="active" type="checkbox" value="1" checked> <strong>Kích hoạt</strong>
                            </label>
                        </div>
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
            product_item['warehouse_id'] = "<?php echo $value['warehouse_id']; ?>";
            product_item['transaction_warehouse_id'] = "<?php echo $value['transaction_warehouse_id']; ?>";
            product_item['unit'] = "<?php echo $value['product_unit']; ?>";
            product_item['quantity'] = "<?php echo $value['quantity']; ?>";
            product_item['unit_price'] = "<?php echo $value['unit_price']; ?>";
			product_item['provider_id'] = "<?php echo $value['provider_id']; ?>";
            product_init.push(product_item);
        <?php endforeach; ?>
    <?php else: ?>
        var product_item = {};
        product_item['product_id'] = "0";
        product_item['warehouse_id'] = "<?php echo isset($warehouse[0]['id']) ? $warehouse[0]['id'] : 0; ?>";
        product_item['transaction_warehouse_id'] = "<?php echo isset($warehouse[1]['id']) ? $warehouse[1]['id'] : 0; ?>";
        product_item['unit'] = "";
        product_item['quantity'] = "1";
        product_item['unit_price'] = "0";
		product_item['provider_id'] = "<?php echo isset($provider[0]['id']) ? $provider[0]['id'] : 0; ?>";
        product_init.push(product_item);
    <?php endif; ?>

    var products = {};
    products[0] = 'Chọn sản phẩm';
    <?php if (isset($products) && is_array($products) && !empty($products)): ?>
        <?php foreach ($products as $value) : ?>
            products[<?php echo $value['id'] ?>] = '<?php echo html_escape($value['name']); ?>' + " - " + "<?php echo html_escape($value['code']); ?>";
        <?php endforeach; ?>
    <?php endif; ?>

    var warehouse = {};
    <?php if (isset($warehouse) && is_array($warehouse) && !empty($warehouse)): ?>
        <?php foreach ($warehouse as $value) : ?>
            warehouse[<?php echo $value['id'] ?>] = "<?php echo html_escape($value['name']); ?>";
        <?php endforeach; ?>
    <?php endif; ?>

    var provider = {};
    <?php if (isset($provider) && is_array($provider) && !empty($provider)): ?>
        <?php foreach ($provider as $value) : ?>
            provider[<?php echo $value['id'] ?>] = "<?php echo html_escape($value['name']); ?>";
        <?php endforeach; ?>
    <?php endif; ?>
</script>