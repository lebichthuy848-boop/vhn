<!-- Main Container Starts -->
<div id="main-container" class="container">
    <div class="row">
        <!-- Primary Content Starts -->
        <div class="col-md-9">
            <!-- Breadcrumb Starts -->
            <?php $this->load->view('breadcrumb'); ?>
            <!-- Breadcrumb Ends -->

            <!-- Main Heading Starts -->
            <h2 class="main-heading">
                Đổi mật khẩu
            </h2>
            <!-- Main Heading Ends -->

            <section class="registration-area">
                <!-- Shipping & Shipment Block Starts -->
                <div class="panel panel-smart">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Thông tin đổi mật khẩu
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php $this->load->view('layout/notify'); ?>
                        <form id="f-changepass" action="<?php echo base_url('users/changepass'); ?>" method="post" role="form" class="form-horizontal" autocomplete="off">
                            <p class="text-info">
                                <em class="fa fa-quote-left">&nbsp;</em> 
                                Để thay đổi mật khẩu bạn cần điền đầy đủ các thông tin sau
                                <em class="fa fa-quote-right">&nbsp;</em> 
                            </p>
                            <?php $has_error = (form_error('current_password') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="current_password" class="col-sm-3 control-label">Mật khẩu hiện tại</label>
                                <div class="col-sm-9">                            
                                    <input type="password" class="form-control required password" name="current_password" value="" id="id-current-password" maxlength="20" placeholder="Mật khẩu hiện tại">
                                    <?php echo form_error('current_password'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('password') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="password" class="col-sm-3 control-label">Mật khẩu mới</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required password" name="password" value="" id="password" maxlength="20" placeholder="Mật khẩu mới">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('password_confirm') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="password_confirm" class="col-sm-3 control-label">Nhập lại mật khẩu mới</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required password" name="password_confirm" value="" id="password_confirm" maxlength="20" placeholder="Nhập lại mật khẩu mới">
                                    <?php echo form_error('password_confirm'); ?>
                                </div>
                            </div>

                            <p class="required"><i>Các trường <span class="required"></span> là bắt buộc!</i></p>
                            <hr>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button class="btn btn-warning" type="submit">
                                        Đổi mật khẩu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Shipping & Shipment Block Ends -->
            </section>
        </div>
        <!-- Primary Content Ends -->
        <!-- Sidebar Starts -->
        <div class="col-md-3">            
            <!-- Shopping Advanced Search Starts -->
            <?php $this->load->view('view_advanced_search'); ?>
            <!-- Shopping Advanced Search Ends -->

            <!-- Bestsellers Links Starts -->
            <?php $this->load->view('view_bestsellers'); ?>
            <!-- Bestsellers Links Ends -->
        </div>
        <!-- Sidebar Ends -->
    </div>
</div>
<!-- Main Container Ends -->