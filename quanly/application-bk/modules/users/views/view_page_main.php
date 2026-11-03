<style type="text/css">
    .list-item {
        list-style: none;
        margin: 0;
        padding: 0;
    }
</style>
<!-- Main Container Starts -->
<div id="main-container" class="container">
    <div class="row">
        <!-- Primary Content Starts -->
        <div class="col-md-9">
            <!-- Breadcrumb Starts -->
            <?php $this->load->view('breadcrumb'); ?>
            <!-- Breadcrumb Ends -->
            <!-- Product Description Starts -->
            <div class="product-info-box">
                <h4 class="heading">Thông tin thành viên</h4>
                <div class="content panel-smart">
                    <div class="row m-bottom">
                        <div class="col-md-3 text-center">
                            <img src="<?php echo $path_avatar . $avatar; ?>" alt="lenhan10th" class="img-thumbnail m-bottom"><br>
                            Ảnh hiển thị
                        </div>
                        <div class="col-md-9">
                            <ul class="list-item xsm">
                                <li><em class="fa fa-chevron-right ">&nbsp;</em> Tài khoản: <strong><?php echo $row['username']; ?></strong> (<?php echo $row['email']; ?>)</li>
                                <li><em class="fa fa-chevron-right ">&nbsp;</em> Đăng nhập nhờ tài khoản <?php echo $row['group_title']; ?></li>
                                <li><em class="fa fa-chevron-right ">&nbsp;</em> Vào: <?php echo get_day_of_week($row['last_login']) . ', ' . date('d-m-Y H:i', $row['last_login']); ?></li>
                                <li><em class="fa fa-chevron-right ">&nbsp;</em> Bằng IP: <?php echo $row['last_ip']; ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Họ tên</th>
                                    <td><?php echo $row['full_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày tháng năm sinh</th>
                                    <td><?php echo date('d-m-Y', $row['birthday']); ?></td>
                                </tr>
                                <tr>
                                    <th>Giới tính</th>
                                    <td>
                                        <?php
                                        switch ($row['gender']) {
                                            case 'F':
                                                echo 'Nữ';
                                                break;
                                            case 'M':
                                                echo 'Nam';
                                                break;
                                            default:
                                                echo 'N/A';
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Hiển thị email</th>
                                    <td>
                                        <?php
                                        if ($row['view_mail'] == 1) {
                                            echo 'Có';
                                        } else {
                                            echo 'Không';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tham gia</th>
                                    <td><?php echo date('d-m-Y', $row['regdate']); ?></td>
                                </tr>
                                <tr>
                                    <th>Khả năng đăng nhập thông thường</th>
                                    <td>Có</td>
                                </tr>
                                <tr>
                                    <th>Lần truy cập trước</th>
                                    <td><?php echo get_day_of_week($row['last_login']) . ', ' . date('d-m-Y H:i', $row['last_login']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Product Description Ends -->
        </div>
        <!-- Primary Content Ends -->
        <!-- Sidebar Starts -->
        <div class="col-md-3">            
            <!-- Shopping Advanced Search Starts -->
            <?php $this->load->view('shops/view_advanced_search'); ?>
            <!-- Shopping Advanced Search Ends -->

            <!-- Bestsellers Links Starts -->
            <?php $this->load->view('shops/view_bestsellers'); ?>
            <!-- Bestsellers Links Ends -->
        </div>
        <!-- Sidebar Ends -->
    </div>
</div>
<!-- Main Container Ends -->