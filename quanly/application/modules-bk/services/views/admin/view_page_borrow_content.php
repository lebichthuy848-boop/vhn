<style>
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
        width: 240px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" id="f-content" action="#" method="post" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                        echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="customer_id" class="control-label col-md-2">Khách hàng</label>
                                <div class="col-md-6">
                                    <select class="form-control chosen-select" tabindex="1" data- 
                                            placeholder="Chọn khách hàng" name="customer_id" id="customer_id">
                                        <option value="0">Chọn</option>
                                        <?php
                                        echo get_option_select($customer_kl, isset($row['customer_id']) ? $row['customer_id'] : '');
                                        ?>
                                    </select>
                                </div>
                                <?php if (isset($role) && $role != 'TECHNICIAN'): ?>
                                    <div class="col-md-2">
                                        <a data-toggle="modal" href="#myModal2" class="btn btn-success btn-sm">Thêm khách hàng</a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="address" class="control-label col-md-2">Địa Chỉ</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="phone" class="control-label col-md-2">Điện thoại</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                                </div>
                            </div>

                            <table id="tblAppendGrid">
                            </table>
                            <br/>
                        </div>


                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="code" class="control-label col-md-6">Mã số phiếu</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : $max_code; ?>" placeholder="MHxxxxxxxxx">
                                </div>
                            </div>

                            <div style="border: 5px double #ccc; padding: 15px 5px;">
                                <div class="form-group">
                                    <label for="datePickerStartday" class="control-label col-md-6">Ngày nhận</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date" id="datePickerStartday">
                                            <?php $start_date = (isset($row['start_date']) && ($row['start_date'] > 0)) ? date('d-m-Y', $row['start_date']) : date('d-m-Y'); ?>
                                            <input type="text" class="form-control text-right" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="datePickerEndday" class="control-label col-md-6">Ngày trả</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date" id="datePickerEndday">
                                            <?php $end_date = (isset($row['end_date']) && ($row['end_date'] > 0)) ? date('d-m-Y', $row['end_date']) : ''; ?>
                                            <input type="text" class="form-control text-right" name="end_date" id="end_date" value="<?php echo $end_date; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="returned-yes" class="control-label col-md-6">
                                        <input name="returned" type="radio" id="returned-yes" value="1" <?php echo (isset($row['returned']) && $row['returned'] == 1 ? ' checked' : ''); ?>> Trả hàng
                                    </label>
                                    <label for="returned-no" class="control-label col-md-6">
                                        <input name="returned" type="radio" id="returned-no" value="0" <?php echo (!isset($row['returned']) || $row['returned'] == 0 ? ' checked' : ''); ?>> Chưa trả hàng
                                    </label>
                                </div>

                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary btn-block">Lưu</button> 
                                    <a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger btn-block">Thoát</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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

<div class="modal" id="myModal2" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Thêm khách hàng</h4>
            </div><div class="container"></div>
            <div class="modal-body">
                <form id="f-customer" method="post" action="#">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="f_full_name" class="control-label">Khách hàng</label>
                                <input class="form-control" name="full_name" id="f_full_name" type="text" value="" required>
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_types_id" class="control-label">Loại khách hàng</label>
                                <select class="form-control" name="customer_types_id" id="f_customer_types_id">
                                    <?php echo display_option_select($customer_types, 'id', 'name', 0); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_address" class="control-label">Địa chỉ</label>
                        <input class="form-control" name="address" id="f_address" type="text" value="">
                    </div>

                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_email" class="control-label">Email</label>
                                <input class="form-control" name="email" id="f_email" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_code" class="control-label">Mã số thuế</label>
                                <input class="form-control" name="tax_code" id="f_tax_code" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_tel" class="control-label">Tel</label>
                                <input class="form-control" name="tel" id="f_tel" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_phone" class="control-label">Di động</label>
                                <input class="form-control" name="phone" id="f_phone" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_discount_HDPARAGON" class="control-label">Chiếc khấu HDPARAGON</label>
                                <input class="form-control" name="discount_HDPARAGON" id="f_discount_HDPARAGON" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_discount_HIKVISION" class="control-label">Chiếc khấu HIKVISION</label>
                                <input class="form-control" name="discount_HIKVISION" id="f_discount_HIKVISION" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_address" class="control-label">Địa chỉ giao hàng</label>
                                <input class="form-control" name="delivery_address" id="f_delivery_address" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact" class="control-label">Người liên hệ</label>
                                <input class="form-control" name="contact" id="f_contact" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_freight_id" class="control-label">Chành xe</label>
                                <select class="form-control" tabindex="1" data-placeholder="Chọn khách hàng" name="freight_id" id="f_freight_id">
                                    <?php echo display_option_select($freight, 'id', 'name', isset($row['freight_id']) ? $row['freight_id'] : 0); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_note" class="control-label">Ghi chú</label>
                        <textarea id="f_note" name="note" data-autoresize rows="3" class="form-control"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var consignment_init = [];
<?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
    <?php foreach ($row['items'] as $value) : ?>
            var consignment_item = {};
            consignment_item['consignment_id'] = <?php echo $value['consignment_id']; ?>;
            consignment_item['unit'] = '<?php echo ''; ?>';
            consignment_item['quantity'] = <?php echo $value['quantity']; ?>;
            consignment_item['returned'] = <?php echo $value['returned']; ?>;
            consignment_item['note'] = '<?php echo remove_special_string_textarea($value['note']); ?>';
            consignment_init.push(consignment_item);
    <?php endforeach; ?>
<?php endif; ?>

    var consignment = {};
<?php foreach ($consignments as $value) : ?>
        consignment['<?php echo $value['id'] ?>'] = '<?php echo $value['code'] . ' - ' . $value['name']; ?>';
<?php endforeach; ?>
</script>