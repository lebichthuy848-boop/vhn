<style>
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
    #total_text:first-letter{
        text-transform: capitalize;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form role="form" id="f-content" action="#" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="customer_id" class="control-label">Khách hàng</label>
                                <select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn khách hàng" name="customer_id" id="customer_id">
                                    <?php echo display_option_select($customers, 'id', array('full_name', 'customer_types_name'), 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="datePickerEndday" class="control-label">Ngày tạo báo giá</label>
                                <div class="input-group input-append date" id="datePickerStartday">
                                    <input type="text" class="form-control" name="date" id="start_date" value="<?php echo date('d-m-Y'); ?>" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblAppendGrid">
                            </table>
                            <br/>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="VAT" class="control-label">VAT</label>
                                        <div class="input-group">
                                            <input class="form-control" name="VAT" id="VAT" type="text" value="0">
                                            <span class="input-group-addon add-on"><i class="fa fa-percent fa-lg" aria-hidden="true"></i></span>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row">							
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label text-danger text-bold">
                                            Tổng số tiền: <span id="total_number">0</span> đồng (<span id="total_text">Không đồng</span>)
                                        </label>
                                    </div>
                                </div>								
                            </div>
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="note" class="control-label">Ghi chú</label>
                        <textarea class="form-control" data-autoresize name="note" id="note"></textarea>
                    </div>

                    <div class="row noPrint">
                        <div class="col-sm-12 col-md-12">
                            <button type="button" id="click_view" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Xem</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="click_print"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger">Thoát</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box-body" id="element_print">
            </div>
        </div>
    </div>
</div>
<script>
    var products = {};
    products[0] = 'Chọn sản phẩm';
<?php if (isset($products) && is_array($products) && !empty($products)): ?>
    <?php foreach ($products as $value) : ?>
            products[<?php echo $value['id'] ?>] = "<?php echo $value['name']; ?>" + " - " + "<?php echo $value['code']; ?>";
    <?php endforeach; ?>
<?php endif; ?>
</script>