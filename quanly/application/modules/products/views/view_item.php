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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="name" class="control-label">Tên sản phẩm</label>
                                <input class="form-control" name="name" id="name" type="text" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                                <?php echo form_error('name'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group required">
                                <label for="code" class="control-label">Mã sản phẩm</label>
                                <input class="form-control" name="code" id="code" type="text" value="<?php echo isset($row['code']) ? $row['code'] : ''; ?>">
                                <?php echo form_error('code'); ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="category_id" class="control-label">Loại sản phẩm</label>
                                <select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
                                    <?php echo display_option_select($category, 'id', 'name', isset($row['category_id']) ? $row['category_id'] : 0); ?>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit" class="control-label">Đơn vị</label>
                                <input class="form-control" name="unit" id="unit" type="text" value="<?php echo isset($row['unit']) ? $row['unit'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specification" class="control-label">Quy cách</label>
                                <input class="form-control" name="specification" id="specification" type="text" value="<?php echo isset($row['specification']) ? $row['specification'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="safety_margin" class="control-label">Lượng an toàn</label>
                                <input class="form-control" name="safety_margin" id="safety_margin" type="text" value="<?php echo isset($row['safety_margin']) ? $row['safety_margin'] : ''; ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quantity" class="control-label">Số lượng</label>
                                <input class="form-control" name="quantity" id="quantity" type="text" value="<?php echo isset($row['quantity']) ? $row['quantity'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit_price" class="control-label">Đơn giá nhập</label>
                                <input class="form-control" name="unit_price" id="unit_price" type="text" value="<?php echo isset($row['unit_price']) ? $row['unit_price'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="retail_price" class="control-label">Giá lẻ</label>
                                <input class="form-control" name="retail_price" id="retail_price" type="text" value="<?php echo isset($row['retail_price']) ? $row['retail_price'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cost_price" class="control-label">Giá sỉ</label>
                                <input class="form-control" name="cost_price" id="cost_price" type="text" value="<?php echo isset($row['cost_price']) ? $row['cost_price'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active">
                                <?php $checked = ((!isset($row['active']) || ($row['active'] == 1)) ? ' checked' : ''); ?>
                                <input class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo $checked; ?>> <strong>Kích hoạt</strong>
                            </label>
                        </div>                        
                    </div>

                    <div class="text-center">
                        <?php if (isset($row['id'])) : ?>
                            <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                        <?php else : ?>
                            <input class="btn btn-primary" type="submit" value="Thêm">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>