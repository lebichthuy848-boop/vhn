<style type="text/css">
    .fileUpload {
        position: relative;
        overflow: hidden;
        width: 160px;
    }
    .fileUpload input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        cursor: pointer;
        opacity: 0;
    }
    #abc{
        margin-top: 8px;
    }
</style>
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
                            <h3 class="panel-title">Thông tin cá nhân</h3>
                        </div>
                        <div class="panel-body">
                            <?php $this->load->view('layout/notify'); ?>
                            <form id="f-editinfo" action="<?php echo base_url('users/editinfo'); ?>" method="post" role="form" class="form-horizontal" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="col-sm-3 control-label">Tên đăng nhập</label>
                                    <div class="col-sm-9">
                                        <label class="control-label te"><strong><?php echo $users['username']; ?></strong></label>
                                    </div>
                                </div>

                                <?php $has_error = (form_error('email') != '' ? ' has-error' : ''); ?>
                                <div class="form-group <?php echo $has_error; ?>">
                                    <label for="id_email" class="col-sm-3 control-label">Email <span class="required">(*)</span></label>
                                    <div class="col-sm-9">
                                        <?php $email = (set_value('email') != '' ? set_value('email') : $users['email']); ?>
                                        <input type="text" class="form-control email" name="email" value="<?php echo $email; ?>" id="id_email" maxlength="100" placeholder="Email">
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>

                                <?php $has_error = (form_error('full_name') != '' ? ' has-error' : ''); ?>
                                <div class="form-group<?php echo $has_error; ?>">
                                    <label for="id_full_name" class="col-sm-3 control-label">Họ tên <span class="required">(*)</span></label>
                                    <div class="col-sm-9">
                                        <?php $full_name = (set_value('full_name') != '' ? set_value('full_name') : $users['full_name']); ?>
                                        <input type="text" class="form-control" name="full_name" value="<?php echo $full_name; ?>" id="id_full_name" maxlength="100" placeholder="Họ tên">
                                        <?php echo form_error('full_name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_gender" class="col-sm-3 control-label">Giới tính</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender" id="id_gender">
                                            <?php
                                            echo get_option_gender($users['gender']);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_avatar" class="col-sm-3 control-label">Ảnh đại diện</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="fileUpload btn btn-default">
                                                        <span class="glyphicon glyphicon-upload"></span> Chọn ảnh
                                                    </span>                                                        
                                                    <?php $avatar = ($users['photo'] != '' ? $users['photo'] : 'no_avatar.jpg'); ?>
                                                    <input type="hidden" class="form-control" id="id_avatar" name="avatar" value="<?php echo $avatar; ?>" readonly="readonly">
                                                </div>
                                                <div id="current-photo" class="pull-left text-center">                                            
                                                    <br>
                                                    <img id="img_avatar" src="<?php echo $path_avatar . $avatar; ?>" alt="lenhan10th" class="img-thumbnail m-bottom">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="progress hide" id="abc">
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                                        40%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_birthday" class="col-sm-3 control-label">Ngày sinh</label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-append date" id="datePicker">
                                            <?php $birthday = ($users['birthday'] != 0 ? date('d-m-Y', $users['birthday']) : ''); ?>
                                            <input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>" readonly="readonly" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_view_mail" class="col-sm-3 control-label">Hiển thị email</label>
                                    <div class="col-sm-9">
                                        <select name="view_mail" id="id_view_mail" class="form-control valid">
                                            <?php if ($users['view_mail'] == 0): ?>
                                                <option selected="selected" value="0">Không</option>
                                                <option value="1">Có</option>
                                            <?php else: ?>
                                                <option value="0">Không</option>
                                                <option selected="selected" value="1">Có</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <p class="required">* Required Fields</p>
                                <hr>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button class="btn btn-primary" type="submit">
                                            Lưu thay đổi
                                        </button>
                                    </div>
                                </div>
                            </form>                          

                            <form class="hide">
                                <input type="file" id="uploadFile" />
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
            </aside>
        </div>
    </div>
</div>