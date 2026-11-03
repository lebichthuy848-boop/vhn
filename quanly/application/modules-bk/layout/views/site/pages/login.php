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
                            <button onclick="window.location = '<?php echo base_url('register' . $url_suffix); ?>';" class="button create-account" type="button"><span>Create an Account</span></button>
                        </div>
                    </div>
                </div>
                <div class="col-2 registered-users">
                    <p>
                        <strong>Registered Customers</strong>
                    </p>
                    <form class="form" method="post" action="<?php echo base_url('login'); ?>" autocomplete="off">
                        <div class="content">
                            <p>If you have an account with us, please log in.</p>
                            <ul class="form-list">
                                <li>
                                    <label for="email">User name <span class="required">*</span></label>
                                    <br>
                                    <input type="text" title="Username" class="input-text required-entry" id="email" value="" name="username">
                                </li>
                                <li>
                                    <label for="pass">Password <span class="required">*</span></label>
                                    <br>
                                    <input type="password" title="Password" id="pass" class="input-text required-entry validate-password" name="password">
                                </li>
                            </ul>
                            <p class="required">* Required Fields</p>
                            <div class="buttons-set">
                                <button type="submit" class="button login"><span>Login</span></button>
                                <a class="forgot-word" href="http://demo.magentomagik.com/computerstore/customer/account/forgotpassword/">Forgot Your Password?</a>
                            </div>
<!--                            <div>
                                <a href="<?php echo base_url('google-login'); ?>" class="btn btn-default">Login google</a>
                            </div>-->
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