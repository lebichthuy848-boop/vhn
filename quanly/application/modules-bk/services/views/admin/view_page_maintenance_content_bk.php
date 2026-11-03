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
                <form class="form-horizontal" role="form" id="f-content" action="#<?php //echo base_url('sell-buy/buy/store-received-voucher');          ?>" method="post" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
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
                                        echo get_option_select($customer_kl, '');
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="address" class="control-label col-md-2">Địa Chỉ</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="address" id="address" type="text" value="<?php echo isset($customer['address']) ? $customer['address'] : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="phone" class="control-label col-md-2">Điện thoại</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($customer['phone']) ? $customer['phone'] : ''; ?>">
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
                                    <input class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
                                </div>
                            </div>

                            <div style="border: 5px double #ccc; padding: 15px 5px;">
                                <div class="form-group">
                                    <label for="datePickerStartday" class="control-label col-md-6">Ngày nhận</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date" id="datePickerStartday">
                                            <?php $start_date = isset($row['start_date']) ? date('d-m-Y', $row['start_date']) : date('d-m-Y'); ?>
                                            <input type="text" class="form-control text-right" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="datePickerEndday" class="control-label col-md-6">Ngày trả</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date" id="datePickerEndday">
                                            <input type="text" class="form-control text-right" name="end_date" id="end_date" value="" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fixed-yes" class="control-label col-md-6">
                                        <input name="fixed" type="radio" id="fixed-yes" value="1" <?php echo (isset($row['fixed']) && $row['fixed'] == 1 ? ' checked' : ''); ?>> Sửa xong
                                    </label>
                                    <label for="fixed-no" class="control-label col-md-6">
                                        <input name="fixed" type="radio" id="fixed-no" value="0" <?php echo (!isset($row['fixed']) || $row['fixed'] == 0 ? ' checked' : ''); ?>> Chưa sửa xong
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="returned-yes" class="control-label col-md-6">
                                        <input name="returned" type="radio" id="returned-yes" value="1" <?php echo (isset($row['returned']) && $row['returned'] == 1 ? ' checked' : ''); ?>> Trả hàng
                                    </label>
                                    <label for="returned-no" class="control-label col-md-6">
                                        <input name="returned" type="radio" id="returned-no" value="0" <?php echo (!isset($row['returned']) || $row['returned'] == 0 ? ' checked' : ''); ?>> Chưa trả hàng
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="fee" class="control-label col-md-6">Phí sửa chữa</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" name="fee" id="fee" type="text" value="<?php echo isset($row['fee']) ? $row['fee'] : ''; ?>">
                                    </div>
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
<div class="modal modal-static" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="http://www.travislayne.com/images/loading.gif" class="icon" />
                    <h4>Processing... </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var consignment = {};
<?php foreach ($consignments as $value) : ?>
        consignment['<?php echo $value['id'] ?>'] = '<?php echo $value['code'] ?>';
<?php endforeach; ?>
</script>