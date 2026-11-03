<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form name="filter" method="get" action="<?php echo get_admin_url('users'); ?>">
            <nav class="search_bar navbar navbar-default" role="search">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#filter-bar-7adecd427b033de80d2a0e30cf74e735">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="filter-bar-7adecd427b033de80d2a0e30cf74e735">
                    <div class="navbar-form">
                        <div class="form-group search_title">
                            Tìm thành viên theo
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="method" id="f_method">
                                <option value="">---</option>
                                <?php if (isset($get['method']) && $get['method'] == 'userid') : ?>
                                    <option selected="selected" value="userid">ID thành viên</option>
                                <?php else : ?>
                                    <option value="userid">ID thành viên</option>
                                <?php endif; ?>

                                <?php if (isset($get['method']) && $get['method'] == 'username') : ?>
                                    <option selected="selected" value="username">Tài khoản thành viên</option>
                                <?php else : ?>
                                    <option value="username">Tài khoản thành viên</option>
                                <?php endif; ?>

                                <?php if (isset($get['method']) && $get['method'] == 'full_name') : ?>
                                    <option selected="selected" value="full_name">Tên thành viên</option>
                                <?php else : ?>
                                    <option value="full_name">Tên thành viên</option>
                                <?php endif; ?>

                                <?php if (isset($get['method']) && $get['method'] == 'email') : ?>
                                    <option selected="selected" value="email">Email thành viên</option>
                                <?php else : ?>
                                    <option value="email">Email thành viên</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Trạng thái
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="usactive">
                                <?php if (isset($get['usactive']) && $get['usactive'] == 1) : ?>
                                    <option selected="selected" value="1">Tài khoản hoạt động</option>
                                <?php else : ?>
                                    <option value="1">Tài khoản hoạt động</option>
                                <?php endif; ?>

                                <?php if (isset($get['usactive']) && $get['usactive'] == 0) : ?>
                                    <option selected="selected" value="0">Tài khoản bị khóa</option>
                                <?php else : ?>
                                    <option value="0">Tài khoản bị khóa</option>
                                <?php endif; ?>                                
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Số tài khoản hiển thị
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="per_page">
                                <?php
                                $records_in_page = 5;
                                for ($i = 1; $i <= 10; $i++) {
                                    $per_page = $i * $records_in_page;
                                    ?>
                                    <?php if (isset($get['per_page']) && $get['per_page'] == $per_page) : ?>
                                        <option selected="selected" value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
                                    <?php endif; ?>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Từ khóa tìm kiếm
                        </div>
                        <div class="form-group search_input">
                            <input class="form-control input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
                        </div>
                        <div class="form-group search_action pull-right">                                
                            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                        </div>
                        <br>
                        <label><em>Từ khóa tìm kiếm không ít hơn 3 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
                    </div>
                </div>
            </nav>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách thành viên</h3>
                <a class="btn btn-success pull-right" href="<?php echo get_admin_url('users' . '/' . 'content'); ?>"><i class="fa fa-plus"></i> Thêm</a>
            </div>
            <div class="box-body">
                <?php if (empty($rows)): ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> tìm thấy tài khoản nào!</p>
                    </div>
                <?php else: ?>
                    <form class="form-inline" name="block_list" action="#">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Tài khoản</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th class="text-center">Loại</th>
                                        <th class="text-center">Quyền</th>
                                        <th class="text-center">Ngày đăng ký</th>
                                        <th class="text-center">Hoạt động</th>
                                        <th class="text-center" style="width: 160px;">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $row['userid']; ?></td>
                                        <td>
                                            <?php echo $row['username']; ?>
                                        </td>
                                        <td><?php echo $row['full_name']; ?></td>
                                        <td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
                                        <td class="text-center"><?php echo display_value_array($this->config->item('oauth_provider'), $row['oauth_provider']); ?></td>
                                        <td class="text-center"><?php echo $row['role_name']; ?></td>
                                        <td class="text-center"><?php echo display_date($row['regdate']); ?></td>
                                        <td class="text-center">
                                            <?php
                                            $checked = '';
                                            $disabled = '';
                                            if ($row['active'] == 1) {
                                                $checked = ' checked="checked"';
                                            }

                                            if ($row['group_id'] > 5) {
                                                $disabled = ' disabled="disabled"';
                                            }
                                            echo '<input type="checkbox" name="active" class="change_status flat-blue" id="change_status_' . $row['userid'] . '" value="' . $row['userid'] . '"' . $checked . $disabled . '>';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            &nbsp;&nbsp; <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url('users/content/' . $row['userid']); ?>">Sửa</a>
                                            &nbsp;&nbsp; <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url('users/delete?id=' . $row['userid']); ?>" class="confirm_bootstrap">Xóa</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            <?php if ($pagination != ''): ?>
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>