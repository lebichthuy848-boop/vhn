<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-edit">&nbsp;</em>Nhập dữ liệu khách hàng</h3>
            </div>
            <div class="box-body">
                <form role="form" action="<?php echo base_url($module_slug . '/nhap'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input name="token" type="hidden" value="<?php echo rand(0, 1000); ?>" />
                    <div class="form-group">
                        <label for="file" class="control-label">Chọn file Excel (Phần mở rộng xls hoặc xlsx)</label>
                        <input id="file" name="file[]" class="file" type="file" data-min-file-count="1">
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-cloud-upload"></i> Nhập dữ liệu</button>
                    </div>
                </form>
            </div>
        </div><!-- /.box -->
    </div>
</div>