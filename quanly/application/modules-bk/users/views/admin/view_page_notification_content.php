<?php
$this->config->set_item('role', array(
    'MEMBER' => 'Thành viên',
    'PARTNER' => 'Đối tác',
));
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Loại người dùng</label>
                                <select class="form-control" name="role" id="role">
                                    <?php echo get_option_select($this->config->item('role'), ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('user_id') != '' ? ' has-error' : ''; ?>">
                                <label class="control-label">Người nhận</label>
                                <select class="form-control chosen-select-enable-search" tabindex="1" data-placeholder="Chọn người nhận" name="user_id" id="user_id">
                                    <?php echo display_option_select($users, 'userid', 'full_name', 0); ?>
                                </select>
                                <?php echo form_error('user_id'); ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Token</label>
                        <input class="form-control" name="token" id="token" type="text" value="<?php echo isset($token) ? $token : ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Tiêu đề</label>
                        <input class="form-control" name="title" type="text" value="">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nội dung</label>
                        <textarea class="form-control" data-autoresize name="message"></textarea>
                    </div>

                    <div class="text-center">
                        <input class="btn btn-success" type="submit" value="Gửi thông báo">
                        &nbsp;<a class="btn btn-sm btn-danger" href="<?php echo get_admin_url($module_slug); ?>">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>