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
                <div class="form-group">
                    <label for="code" class="control-label">Mã số phiếu</label>
                    <input disabled class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="customer_id" class="control-label">Khách hàng</label>
                    <select disabled class="form-control chosen-select" tabindex="1" data- 
                            placeholder="Chọn khách hàng" name="customer_id" id="customer_id">
                        <option value="0">Chọn</option>
                        <?php
                        echo get_option_select($customer_kl, isset($row['customer_id']) ? $row['customer_id'] : '');
                        ?>
                    </select>
                </div>

                <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                    <label for="address" class="control-label">Địa Chỉ</label>
                    <input class="form-control" readonly name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                </div>

                <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                    <label for="phone" class="control-label">Điện thoại</label>
                    <input class="form-control" readonly name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                </div>

                <table id="tblAppendGrid">
                </table>
                <br/>

                <div style="border: 5px double #ccc; padding: 15px 5px;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Ngày nhận</label>
                                <div class="input-group input-append date">
                                    <?php $start_date = isset($row['start_date']) ? date('d-m-Y', $row['start_date']) : date('d-m-Y'); ?>
                                    <input disabled type="text" class="form-control text-right" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Ngày trả</label>
                                <div class="input-group input-append date">
                                    <input disabled type="text" class="form-control text-right" name="end_date" id="end_date" value="" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1">
                            <div class="form-group">
                                <label for="fixed-yes" class="control-label col-md-6">
                                    <input disabled name="fixed" type="radio" id="fixed-yes" value="1" <?php echo (isset($row['fixed']) && $row['fixed'] == 1 ? ' checked' : ''); ?>> Sửa xong
                                </label>
                                <label for="fixed-no" class="control-label col-md-6">
                                    <input disabled name="fixed" type="radio" id="fixed-no" value="0" <?php echo (!isset($row['fixed']) || $row['fixed'] == 0 ? ' checked' : ''); ?>> Chưa sửa xong
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="returned-yes" class="control-label col-md-6">
                                    <input disabled name="returned" type="radio" id="returned-yes" value="1" <?php echo (isset($row['returned']) && $row['returned'] == 1 ? ' checked' : ''); ?>> Trả hàng
                                </label>
                                <label for="returned-no" class="control-label col-md-6">
                                    <input disabled name="returned" type="radio" id="returned-no" value="0" <?php echo (!isset($row['returned']) || $row['returned'] == 0 ? ' checked' : ''); ?>> Chưa trả hàng
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="clearfix">
                        <a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger">Thoát</a> 
                    </div>
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
            consignment_item['consignment_id'] = '<?php echo ($value['code'] != NULL ? $value['code'] : ''); ?>';
            consignment_item['unit'] = '<?php echo ''; ?>';
            consignment_item['quantity'] = <?php echo $value['quantity']; ?>;
            consignment_item['status'] = '<?php echo $value['status']; ?>';
            consignment_item['note'] = '<?php echo $value['note']; ?>';
            consignment_item['fee'] = '<?php echo $value['fee']; ?>';
            consignment_init.push(consignment_item);
    <?php endforeach; ?>
<?php endif; ?>
</script>