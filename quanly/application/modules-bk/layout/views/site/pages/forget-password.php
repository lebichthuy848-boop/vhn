<section class="main-container col1-layout">
    <div class="main container">
        <div class="account-login">
            <div class="page-title">
                <h2>Login or Create an Account</h2>
            </div>
            <fieldset class="col2-set">
                <legend>Login or Create an Account</legend>
                <div class="col-1 new-users"><strong>New Customers</strong>
                    <div class="content">
                        <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                        <div class="buttons-set">
                            <button onclick="window.location = '<?php echo base_url('login'); ?>';" class="button create-account" type="button"><span>Login</span></button>
                        </div>
                    </div>
                </div>
                <div class="col-2 registered-users">
                    <p>
                        <strong>Registered Customers</strong>
                    </p>
                    <form id="f-register" class="form-horizontal" action="<?php echo base_url('forget-password' . $url_suffix); ?>" method="post" role="form" autocomplete="off">
                        <?php $has_error = (form_error('email') != '' ? ' has-error' : ''); ?>
                        <div class="form-group <?php echo $has_error; ?>">
                            <label for="email" class="col-md-4 control-label">Email <span class="required">(*)</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="email" id="id_email" value="<?php echo set_value('email'); ?>" placeholder="Nhập địa chỉ email...">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>

                        <?php $has_error = (form_error('captcha') != '' ? ' has-error' : ''); ?>
                        <div class="form-group <?php echo $has_error; ?>">
                            <label class="col-md-4 control-label" for="id_captcha">Mã xác nhận <span class="required">(*)</span></label>
                            <div class="col-md-8">
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

                        <p class="required">* Required Fields</p>
                        <hr>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Đăng ký</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</section>