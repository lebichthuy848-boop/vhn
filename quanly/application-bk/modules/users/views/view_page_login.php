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
                Đăng nhập
            </h2>
            <!-- Main Heading Ends -->

            <section class="registration-area">
                <!-- Shipping & Shipment Block Starts -->
                <div class="panel panel-smart">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Thông tin đăng nhập
                        </h3>
                    </div>
                    <div style="padding-top:30px" class="panel-body">
                        <?php $this->load->view('layout/notify'); ?>
                        <form id="f-login" role="form" action="<?php echo base_url() . 'login' . $url_suffix; ?>" method="post" autocomplete="off">
                            <?php $has_error = (form_error('username') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label class="control-label" for="username">Tên đăng nhập</label>                                
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <?php $username = (set_value('username') != '' ? set_value('username') : ''); ?>
                                    <input id="username" type="text" class="form-control" name="username" value="<?php echo $username; ?>" placeholder="Tên đăng nhập..." />
                                </div>
                                <?php echo form_error('username'); ?>
                            </div>

                            <?php $has_error = (form_error('password') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label class="control-label" for="password">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" value="" placeholder="Mật khẩu..." />
                                </div>                                
                                <?php echo form_error('password'); ?>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input id="remember_me" type="checkbox" name="remember_me"> Ghi nhớ đăng nhập
                                    </label>
                                </div>
                            </div>

                            <p class="required"><i>Các trường <span class="required"></span> là bắt buộc!</i></p>

                            <div style="margin-top:10px" class="form-group">
                                <button type="submit" class="btn btn-success">Đăng nhập</button>
                            </div>

                            <div class="form-group">
                                <div style="border-top: 1px solid#888; padding-top:15px;" >
                                    <a href="<?php echo base_url(); ?>">Quên mật khẩu</a>
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