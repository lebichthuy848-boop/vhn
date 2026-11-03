<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-edit">&nbsp;</em>Nhập dữ liệu sản phẩm</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo base_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body">
                <form role="form" action="<?php echo base_url($module_slug . '/nhap'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input name="token" type="hidden" value="<?php echo rand(0, 1000); ?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file" class="control-label">Chọn file excel (Phần mở rộng xls hoặc xlsx)</label>
                                <input id="file" name="file[]" class="file" type="file" data-min-file-count="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Cài đặt</label>
                                <div class="checkbox" style="margin-top: 0;">
                                    <label for="is_purchase_voucher">
                                        <input class="flat-blue" name="is_purchase_voucher" id="is_purchase_voucher" type="checkbox" value="1"> <strong>Nhập hàng nếu có số lượng</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 is-purchase-voucher-option hide">
                            <div class="form-group required">
                                <label for="warehouse_id" class="control-label">Kho hàng</label>
                                <select class="form-control" name="warehouse_id">
                                    <option value="0">--Theo file tải lên--</option>
                                    <?php echo display_option_select($warehouse , 'id', 'name', 0); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 is-purchase-voucher-option hide">
                            <div class="form-group required">
                                <label for="provider_id" class="control-label">Nhà cung cấp</label>
                                <select class="form-control" name="provider_id">
                                    <option value="0">--Theo file tải lên--</option>
                                    <?php echo display_option_select($provider , 'id', 'name', 0); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 is-purchase-voucher-option hide">
                            <div class="form-group required">
                                <label for="datePickerEndday" class="control-label">Ngày nhập</label>
                                <div class="input-group input-append date" id="datePickerStartday">
                                    <input type="text" readonly="readonly" class="form-control text-right" name="date" id="start_date" value="<?php echo date('d-m-Y'); ?>" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-cloud-upload"></i> Nhập dữ liệu</button>
                    </div>
                </form>
            </div>
        </div><!-- /.box -->
    </div>
</div>