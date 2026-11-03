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
                Cập nhật hồ sơ
            </h2>
            <!-- Main Heading Ends -->

            <section class="registration-area">
                <!-- Shipping & Shipment Block Starts -->
                <?php $this->load->view('files/modal_file_upload'); ?>
                <div class="panel panel-smart">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Thông tin cá nhân
                        </h3>
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
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="id_email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <?php $email = (set_value('email') != '' ? set_value('email') : $users['email']); ?>
                                    <input type="text" class="form-control required email" name="email" value="<?php echo $email; ?>" id="id_email" maxlength="100" placeholder="Email">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                            
                            <?php $has_error = (form_error('full_name') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="id_full_name" class="col-sm-3 control-label">Họ tên</label>
                                <div class="col-sm-9">
                                    <?php $full_name = (set_value('full_name') != '' ? set_value('full_name') : $users['full_name']); ?>
                                    <input type="text" class="form-control required" name="full_name" value="<?php echo $full_name; ?>" id="id_full_name" maxlength="100" placeholder="Họ tên">
                                    <?php echo form_error('full_name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_gender" class="col-sm-3 control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="gender" id="id_gender">
                                        <?php
                                        if ($users['gender'] == 'N') {
                                            echo '<option selected="selected" value="N">N/A</option>';
                                        } else {
                                            echo '<option value="N">N/A</option>';
                                        }
                                        if ($users['gender'] == 'M') {
                                            echo '<option selected="selected" value="M">Nam</option>';
                                        } else {
                                            echo '<option value="M">Nam</option>';
                                        }
                                        if ($users['gender'] == 'F') {
                                            echo '<option selected="selected" value="F">Nữ</option>';
                                        } else {
                                            echo '<option value="F">Nữ</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_avatar" class="col-sm-3 control-label">Ảnh đại diện</label>
                                <div class="col-sm-9">
                                    <div id="change-photo" style="display: block;">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <em style="cursor: pointer;" class="fa fa-trash-o fa-fix fa-pointer" data-toggle="tooltip" data-placement="left" title="Xóa trắng" onclick="$('#id_avatar').val('');">&nbsp;</em>
                                            </span>
                                            <?php $avatar = ($users['photo'] != '' ? $users['photo'] : 'no_avatar.jpg'); ?>
                                            <input type="text" class="form-control" id="id_avatar" name="avatar" value="<?php echo $avatar; ?>" readonly="readonly">
                                            <span class="input-group-btn">
                                                <button data-toggle="modal" data-target="#myModal" class="btn btn-default" type="button" id="btn_upload" data-toggle="tooltip" data-placement="right" title="Tải lên ảnh đại diện"> <em class="fa fa-folder-open-o fa-fix">&nbsp;</em></button>
                                            </span>
                                        </div>
                                        <div id="current-photo" class="pull-left text-center">                                            
                                            <br>
                                            <img id="img_avatar" src="<?php echo $path_avatar . $avatar; ?>" alt="lenhan10th" class="img-thumbnail m-bottom">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="example1">
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
                            
                            <p class="required"><i>Các trường <span class="required"></span> là bắt buộc!</i></p>
                            <hr>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button class="btn btn-warning" type="submit">
                                        Chấp nhận
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