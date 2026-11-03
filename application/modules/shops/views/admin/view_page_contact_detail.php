<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Liên hệ</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div id="accordion" class="box-group">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                Thông tin cá nhân
                            </h4>
                        </div>
                        <div class="box-body">
                            <p>Họ tên: <?php echo $row['full_name']; ?></p>
                            <p>Email: <?php echo $row['email']; ?></p>
                            <p>Điện thoại: <?php echo $row['phone']; ?></p>
							<?php if(isset($row['product']) && is_array($row['product']) && !empty($row['product'])): ?>
							<p>Sản phẩm: <a href="<?php echo site_url($this->config->item('url_shops_rows') . '/' . $row['product']['cat_alias'] . '/' . $row['product']['alias'] . '-' . $row['product']['id']); ?>" target="_blank"><?php echo $row['product']['title']; ?></a></p>
							<?php endif; ?>
                        </div>
                    </div>
                    <div class="panel box box-success">
                        <div class="box-header">
                            <h4 class="box-title">
                                Nội dung liên hệ: <strong><?php echo $row['subject']; ?></strong>
                            </h4>
                        </div>
                        <div class="box-body">
                            <?php echo nl2br($row['message']); ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>