<style>
    select{
        width: 160px;
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
                                        <?php echo display_option_select($customers, 'id', 'full_name', isset($row['customer_id']) ? $row['customer_id'] : 0); ?>
                                    </select>
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
                                    <input readonly class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="employee_id" class="control-label col-md-6">Nhân viên</label>
                                <div class="col-md-6">
                                    <select disabled class="form-control chosen-select" tabindex="1" data-placeholder="Chọn nhân viên" name="employee_id" id="employee_id">
                                        <?php echo display_option_select($employee, 'userid', 'full_name', isset($row['employee_id']) ? $row['employee_id'] : 0); ?>
                                    </select>
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
    var product_init = [];
<?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
    <?php foreach ($row['items'] as $value) : ?>
            var product_item = {};
            product_item['product_id'] = <?php echo $value['product_id']; ?>;
            product_item['quantity'] = <?php echo $value['quantity']; ?>;
            product_item['unit_price'] = <?php echo $value['unit_price']; ?>;
            product_item['monetized'] = <?php echo $value['monetized']; ?>;
            product_item['VAT'] = <?php echo $value['VAT']; ?>;
            product_item['note'] = '<?php echo remove_special_string_textarea($value['note']); ?>';
            product_init.push(product_item);
    <?php endforeach; ?>
<?php endif; ?>

    var products = {};
<?php if (isset($products) && is_array($products) && !empty($products)): ?>
    <?php foreach ($products as $value) : ?>
            products['<?php echo $value['id'] ?>'] = '<?php echo $value['name']; ?>';
    <?php endforeach; ?>
<?php endif; ?>
</script>