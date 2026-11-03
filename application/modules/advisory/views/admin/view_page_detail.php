<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Tư vấn</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div id="accordion" class="box-group">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                Thông tin tư vấn
                            </h4>
                        </div>
                        <div class="box-body">
                            <p>Họ tên: <?php echo $row['full_name']; ?></p>
                            <p>Email: <?php echo $row['email']; ?></p>
                            <p>Tên công ty: <?php echo $row['company']; ?></p>
                            <p>Điện thoại: <?php echo $row['phone']; ?></p>
                            <p>Địa chỉ: <?php echo $row['address']; ?></p>
                            <p>Nhu cầu: <?php echo $row['need']; ?></p>
                            <p>Loại sản phẩm: <?php echo $row['category']; ?></p>
                            <p>Công dụng: <?php echo $row['uses']; ?></p>
                            <p>Dung tích: <?php echo $row['capacity']; ?></p>
                            <p>Yêu cầu khác: <?php echo nl2br($row['note']); ?></p>
                            <p>Giá thành: <?php echo $row['price']; ?></p>
                            <p>Thông điệp: <?php echo nl2br($row['message']); ?></p>
                            <p>Thời gian thực hiện: <?php echo nl2br($row['execution_time']); ?></p>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>