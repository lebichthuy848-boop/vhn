<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow">
                <div class="my-account">
                    <div class="page-title">
                        <h2>My Account</h2>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thông tin đổi mật khẩu</h3>
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
                                <div class="form-group <?php echo $has_error; ?>">
                                    <label for="current_password" class="col-sm-3 control-label">Mật khẩu hiện tại <span class="required">(*)</span></label>
                                    <div class="col-sm-9">                            
                                        <input type="password" class="form-control" name="current_password" value="" id="id-current-password" maxlength="20" placeholder="Mật khẩu hiện tại">
                                        <?php echo form_error('current_password'); ?>
                                    </div>
                                </div>

                                <?php $has_error = (form_error('password') != '' ? ' has-error' : ''); ?>
                                <div class="form-group <?php echo $has_error; ?>">
                                    <label for="password" class="col-sm-3 control-label">Mật khẩu mới <span class="required">(*)</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" value="" id="password" maxlength="20" placeholder="Mật khẩu mới">
                                        <?php echo form_error('password'); ?>
                                    </div>
                                </div>

                                <?php $has_error = (form_error('password_confirm') != '' ? ' has-error' : ''); ?>
                                <div class="form-group <?php echo $has_error; ?>">
                                    <label for="password_confirm" class="col-sm-3 control-label">Nhập lại mật khẩu mới <span class="required">(*)</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password_confirm" value="" id="password_confirm" maxlength="20" placeholder="Nhập lại mật khẩu mới">
                                        <?php echo form_error('password_confirm'); ?>
                                    </div>
                                </div>

                                <p class="required">* Required Fields</p>
                                <hr>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button class="btn btn-primary" type="submit">
                                            Đổi mật khẩu
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <aside class="col-right sidebar col-sm-3 wow">
                <div class="block block-account">
                    <div class="block-title">My Account</div>
                    <div class="block-content">
                        <ul>
                            <li class="current"><a>Account Dashboard</a></li>
                            <li><a href="<?php echo base_url('users/changepass'); ?>">Change Password</a></li>
                            <li><a href="<?php echo base_url('order-history'); ?>">My Orders</a></li>
                            <li><a href="<?php echo base_url('wishlist' . $url_suffix); ?>">My Wishlist</a></li>
                            <li class="last"><a href="#newsletter/manage/tt">Newsletter Subscriptions</a></li>
                        </ul>
                    </div>
                </div>
                <!--                <div class="block block-compare">
                                    <div class="block-title "><span>Compare Products (2)</span></div>
                                    <div class="block-content">
                                        <ol id="compare-items">
                                            <li class="item odd">
                                                <input type="hidden" value="2173" class="compare-item-id">
                                                <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Polyester Wrapped Cushions</a> </li>
                                            <li class="item last even">
                                                <input type="hidden" value="2174" class="compare-item-id">
                                                <a class="btn-remove1" title="Remove This Item" href="#"></a> <a href="#" class="product-name"> Sofa with Box-Edge Down-Blend Wrapped Cushions</a> </li>
                                        </ol>
                                        <div class="ajax-checkout">
                                            <button type="submit" title="Submit" class="button button-compare"><span>Compare</span></button>
                                            <button type="submit" title="Submit" class="button button-clear"><span>Clear</span></button>
                                        </div>
                                    </div>
                                </div>-->
            </aside>
        </div>
    </div>
</div>