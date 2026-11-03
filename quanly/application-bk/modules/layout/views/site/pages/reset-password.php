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
                    <form id="f-register" class="form-horizontal" action="<?php echo base_url('reset-password' . $url_suffix . '?code=' . $code); ?>" method="post" role="form" autocomplete="off">
                        <?php $has_error = (form_error('pass') != '' ? ' has-error' : ''); ?>
                        <div class="form-group <?php echo $has_error; ?>">
                            <label for="pass" class="col-md-4 control-label">Mật khẩu <span class="required">(*)</span></label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="pass" placeholder="Nhập mật khẩu...">
                                <?php echo form_error('pass'); ?>
                            </div>
                        </div>

                        <?php $has_error = (form_error('confirm-pass') != '' ? ' has-error' : ''); ?>
                        <div class="form-group <?php echo $has_error; ?>">
                            <label for="confirm-pass" class="col-md-4 control-label">Nhập lại mật khẩu <span class="required">(*)</span></label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="confirm-pass" placeholder="Nhập lại mật khẩu...">
                                <?php echo form_error('confirm-pass'); ?>
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