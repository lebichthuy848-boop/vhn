<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo base_url($module_slug . '/them'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                        echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
                    }
                    ?>
                    <div class="form-group required">
                        <label for="code" class="control-label">Mã thiết bị</label>
                        <?php $code = (isset($row['code']) ? $row['code'] : ''); ?>
                        <input class="form-control" name="code" id="code" type="text" value="<?php echo $code; ?>">
                        <?php echo form_error('code'); ?>
                    </div>
                    
                    <div class="form-group required">
                        <label for="name" class="control-label">Tên thiết bị</label>
                        <?php $name = (isset($row['name']) ? $row['name'] : ''); ?>
                        <input class="form-control" name="name" id="name" type="text" value="<?php echo $name; ?>">
                        <?php echo form_error('name'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="unit" class="control-label">Đơn Vị Tính</label>
                        <select class="form-control" name="unit">
                            <?php
                            $selected_unit = isset($row['unit']) ? $row['unit'] : '';
                            echo get_option_select($this->config->item('unit'), $selected_unit);
                            ?>
                        </select>
                    </div>

                    <div class="text-center">
                        <?php if (isset($row['id'])) : ?>
                            <input class="btn btn-primary" name="status1" type="submit" value="Lưu thay đổi">
                        <?php else : ?>
                            <input class="btn btn-primary" name="status1" type="submit" value="Thêm">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>