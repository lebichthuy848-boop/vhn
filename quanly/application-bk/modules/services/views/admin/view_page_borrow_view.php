<style>
    select{
        width: 240px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary" id="element_print">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" id="f-content" action="#" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="customer_id" class="control-label col-md-2">Khách hàng</label>
                                <div class="col-md-6">
                                    <select disabled class="form-control chosen-select" tabindex="1" data-placeholder="Chọn khách hàng" name="customer_id" id="customer_id">
                                        <option value="0">Chọn</option>
                                        <?php echo get_option_select($customer_kl, isset($row['customer_id']) ? $row['customer_id'] : ''); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="address" class="control-label col-md-2">Địa Chỉ</label>
                                <div class="col-md-10">
                                    <input disabled class="form-control" name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group info-customer <?php echo (!isset($row['id']) ? 'hide' : ''); ?>">
                                <label for="phone" class="control-label col-md-2">Điện thoại</label>
                                <div class="col-md-10">
                                    <input disabled class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
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
                                    <input disabled class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
                                </div>
                            </div>

                            <div style="border: 5px double #ccc; padding: 15px 5px;">
                                <div class="form-group">
                                    <label  class="control-label col-md-6">Ngày nhận</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date">
                                            <?php $start_date = (isset($row['start_date']) && ($row['start_date'] > 0)) ? date('d-m-Y', $row['start_date']) : date('d-m-Y'); ?>
                                            <input disabled type="text" class="form-control text-right" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-6">Ngày trả</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-append date">
                                            <?php $end_date = (isset($row['end_date']) && ($row['end_date'] > 0)) ? date('d-m-Y', $row['end_date']) : ''; ?>
                                            <input disabled type="text" class="form-control text-right" name="end_date" id="end_date" value="<?php echo $end_date; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="returned-yes" class="control-label col-md-6">
                                        <input disabled name="returned" type="radio" id="returned-yes" value="1" <?php echo (isset($row['returned']) && $row['returned'] == 1 ? ' checked' : ''); ?>> Trả hàng
                                    </label>
                                    <label for="returned-no" class="control-label col-md-6">
                                        <input disabled name="returned" type="radio" id="returned-no" value="0" <?php echo (!isset($row['returned']) || $row['returned'] == 0 ? ' checked' : ''); ?>> Chưa trả hàng
                                    </label>
                                </div>

                                <div class="clearfix">
                                    <button class="btn btn-info btn-block noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
                                    <a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger btn-block noPrint">Thoát</a> 
                                </div>
                            </div>
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
            consignment_item['returned'] = <?php echo $value['returned']; ?>;
            consignment_item['note'] = '<?php echo remove_special_string_textarea($value['note']); ?>';
            consignment_init.push(consignment_item);
    <?php endforeach; ?>
<?php endif; ?>
</script>