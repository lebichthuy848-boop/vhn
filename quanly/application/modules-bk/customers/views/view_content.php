<form id="customer-form" action="#" method="post" autocomplete="off">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label for="full_name" class="control-label">Khách hàng</label>
                <input class="form-control" name="full_name" id="full_name" type="text" value="">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="customer_type" class="control-label">Loại khách hàng</label>
                <select class="form-control" name="customer_type" id="customer_type">
                    <?php echo get_option_select($this->config->item('customer_type'), ''); ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="discount" class="control-label">Chiết khấu(%)</label>
                <input class="form-control" name="discount" id="discount" type="text" value="">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <br>
                <div class="checkbox">
                    <label for="active">
                        <input class="flat-blue" name="active" id="active" type="checkbox" value="1" checked> <strong>Kích hoạt</strong>
                    </label>
                </div>                        
            </div>
        </div>
    </div>


    <div class="row">                      
        <div class="col-md-3">
            <div class="form-group">
                <label for="phone" class="control-label">Di động</label>
                <input class="form-control" name="phone" id="phone" type="text" value="">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input class="form-control" name="email" id="email" type="text" value="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="address" class="control-label">Địa chỉ</label>
                <input class="form-control" name="address" id="address" type="text" value="">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="note" class="control-label">Ghi chú</label>
        <textarea id="note" name="note" data-autoresize rows="3" class="form-control"></textarea>
    </div>
</form>