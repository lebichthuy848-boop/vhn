<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-file-text-o">&nbsp;</em>Thông tin tài khoản</h3>
            </div>
            <div class="box-body">
                <?php
                if (isset($row['userid'])) {
                    $action = get_admin_url('users/content/' . $row['userid']);
                } else {
                    $action = get_admin_url('users/content');
                }
                ?>
                <form id="f-user-add" role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['userid'])) {
                        echo '<input type="hidden" value="' . $row['userid'] . '" id="userid" name="userid" class="form-control" />';
                    }
                    ?>
                    <div class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
                        <label for="username" class="control-label">Tài khoản</label>
                        <?php $ad_username = (isset($row['username']) ? $row['username'] : ((form_error('username') != '') ? set_value('username') : '')); ?>
                        <input class="form-control" name="username" id="username" type="text" value="<?php echo $ad_username; ?>">
                        <?php echo form_error('username'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
                        <label for="email" class="control-label">Email</label>
                        <?php $ad_email = (isset($row['email']) ? $row['email'] : ((form_error('email') != '') ? set_value('email') : '')); ?>
                        <input class="form-control" name="email" id="email" type="text" value="<?php echo $ad_email; ?>">
                        <?php echo form_error('email'); ?>
                    </div>

					<div class="form-group">
                        <label for="role" class="control-label">Quyền</label>
                        <select class="form-control" name="role" id="role">
							<?php echo display_option_select($groups, 'group_id', 'title', isset($row['group_id']) ? $row['group_id'] : 0); ?>
                        </select>
                    </div>

                    <div class="form-group required<?php echo form_error('password') != '' ? ' has-error' : ''; ?>">
                        <label for="password" class="control-label">Mật khẩu</label>
                        <input class="form-control" name="password" id="password" type="password" value="">
                        <?php echo form_error('password'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('passconf') != '' ? ' has-error' : ''; ?>">
                        <label for="passconf" class="control-label">Lặp lại mật khẩu</label>
                        <input class="form-control" name="passconf" id="passconf" type="password" value="">
                        <?php echo form_error('passconf'); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Sản phẩm được bán</label>
                        <div class="input-group">
                            <select class="form-control chosen chosen-update" multiple="true" name="products[]">
                                <option value="0">---None---</option>
                                <?php echo display_option_select($products, 'id', 'title', isset($row['products']) ? $row['products'] : 0); ?>
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-info chosen-toggle select" type="button">Chọn tất cả</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group required<?php echo form_error('commission') != '' ? ' has-error' : ''; ?>">
                        <label for="commission" class="control-label">Hoa hồng (%)</label>
                        <input class="form-control mask-price" type="text" maxlength="50" value="<?php echo isset($row['commission']) ? $row['commission'] : ''; ?>" name="commission">
                        <?php echo form_error('commission'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
                        <label for="full_name" class="control-label">Họ tên</label>
                        <?php $ad_full_name = (isset($row['full_name']) ? $row['full_name'] : ((form_error('full_name') != '') ? set_value('full_name') : '')); ?>
                        <input class="form-control" name="full_name" id="full_name" type="text" value="<?php echo $ad_full_name; ?>">
                        <?php echo form_error('full_name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="address" class="control-label">Địa chỉ</label>
                        <input class="form-control" name="address" id="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                    </div>

					<div class="form-group">
                        <label for="phone" class="control-label">Điện thoại</label>
                        <input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender" class="control-label">Giới tính</label>
                        <select class="form-control" name="gender">
                            <?php echo get_option_gender(isset($row['gender']) ? $row['gender'] : 'N'); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="view_mail">
                                <input class="flat-blue" name="view_mail" id="view_mail" type="checkbox" value="1"<?php echo ((isset($row['view_mail']) && ($row['view_mail'] == 0)) ? '' : ' checked'); ?>> Hiển thị email
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <?php
                        if (isset($row['userid'])) {
                            echo '<button class="btn btn-primary" type="submit">Lưu thay đổi</button>';
                        } else {
                            echo '<button class="btn btn-primary" type="submit">Thêm</button>';
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>