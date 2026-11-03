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
                Đăng ký
            </h2>
            <!-- Main Heading Ends -->

            <section class="registration-area">
                <!-- Shipping & Shipment Block Starts -->
                <div class="panel panel-smart">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Thông tin đăng ký
                        </h3>
                    </div>
                    <div style="padding-top:30px" class="panel-body">
                        <?php $this->load->view('layout/notify'); ?>
                        <form id="f-register" class="form-horizontal" action="<?php echo base_url() . 'register.html'; ?>" method="post" role="form" autocomplete="off">
                            
                            <?php $has_error = (form_error('full_name') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="full_name" class="col-md-3 control-label">Họ tên</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="full_name" value="<?php echo set_value('full_name'); ?>" placeholder="Nhập họ tên...">
                                    <?php echo form_error('full_name'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('username') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="username" class="col-md-3 control-label">Tên đăng nhập</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="username" id="id_username" value="<?php echo set_value('username'); ?>" placeholder="Tên đăng nhập...">
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('email') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="email" class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" id="id_email" value="<?php echo set_value('email'); ?>" placeholder="Nhập địa chỉ email...">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('password') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="password" class="col-md-3 control-label">Mật khẩu</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu...">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>

                            <?php $has_error = (form_error('captcha') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label class="col-sm-3 control-label" for="id_captcha">Mã xác nhận</label>
                                <div class="col-sm-9">
                                    <span id="captcha">
                                        <?php if (isset($captcha)) echo $captcha; ?>
                                    </span>
                                    <div class="input-group" style="margin-top: 15px;">
                                        <input id="id_captcha" type="text" class="form-control" name="captcha" placeholder="Nhập mã xác nhận...">
                                        <span class="input-group-addon" id="reload_captcha" style="cursor: pointer;">
                                            <i class="fa fa-refresh"></i>
                                        </span>
                                    </div>
                                    <?php echo form_error('captcha'); ?>
                                </div>
                            </div>

                            <p class="required"><i>Các trường <span class="required"></span> là bắt buộc!</i></p>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Đăng ký</button>
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