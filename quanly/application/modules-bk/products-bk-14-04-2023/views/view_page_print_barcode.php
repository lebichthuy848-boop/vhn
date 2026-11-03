<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-edit">&nbsp;</em>In barcode sản phẩm</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo base_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body">
                <form role="form" action="<?php echo current_url(); ?>" method="get" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ids" class="control-label">Sản phẩm</label>
                                <select class="form-control chosen-select" tabindex="1" data-placeholder="Chọn sản phẩm" name="ids[]" multiple="true">
                                    <option value="0">Tất cả</option>
                                    <?php echo display_option_select($products, 'id', 'name', isset($get['ids']) ? $get['ids'] : 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="quantity" class="control-label">Số lượng in mỗi sản phẩm</label>
                            <div class="input-group">
                                <input class="form-control text-right" name="quantity" id="quantity" type="number" value="<?php echo isset($get['quantity']) ? (int) $get['quantity'] : 1; ?>" min="1">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Lọc kết quả</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="div1">
                            <?php $quantity = isset($get['quantity']) ? (int) $get['quantity'] : 1; ?>
                            <?php if(is_array($rows) && !empty($rows)): ?>
                                <?php foreach ($rows as $row): ?>
                                    <?php if(isset($row['barcode']) && trim($row['barcode']) != ''): ?>
                                        <?php for ($i = 1; $i <= $quantity; $i++): ?>
                                        <img src="<?php echo base_url(get_module_path('barcodes') . $row['barcode'] . '.png'); ?>" alt="" />
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="btn-print"><span class="glyphicon glyphicon-print"></span> In tất cả</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>