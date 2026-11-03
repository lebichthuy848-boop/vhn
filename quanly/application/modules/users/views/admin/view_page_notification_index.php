<?php $is_admin = isset($group_id) && in_array($group_id, array(6)); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form name="filter" method="get" action="<?php echo get_admin_url($module_slug); ?>" autocomplete="off">
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
                            Số dòng hiển thị
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="per_page">
                                <?php echo get_option_per_page(isset($get['per_page']) ? (int) $get['per_page'] : $this->config->item('item', 'admin_list')); ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Từ khóa tìm kiếm
                        </div>
                        <div class="form-group search_input">
                            <input class="form-control input-sm" type="text" value="<?php echo isset($get['q']) ? $get['q'] : ''; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
                        </div>

                        <div class="form-group search_action pull-right">
                            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                        </div>
                        <br>
                        <label><em>Từ khóa tìm kiếm không dùng các mã html</em></label>
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông báo</h3>
                <a class="btn btn-success pull-right" href="<?php echo get_admin_url($module_slug . '/' . 'content'); ?>"><i class="fa fa-plus"></i> Gửi thông báo</a>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo get_admin_url($module_slug . '/' . 'main'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
                                        </th>
                                        <th>#ID</th>
                                        <th>Người gửi</th>
                                        <th>Người nhận</th>
                                        <th>Hoạt động</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Nội dung</th>
                						<th class="text-center">Trạng thái</th>
                                        <?php if($is_admin): ?>
                                        <th class="text-center">Chức năng</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->config->set_item('role', array(
                                        'MEMBER' => 'Thành viên',
                                        'PARTNER' => 'Đối tác',
                                        'MARKETING' => 'Marketing',
                                        'ADMIN' => 'Hệ thống',
                                    ));
                                    ?>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
                                            </td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>
                                                <?php echo $row['actor_full_name']; ?>
                                                <?php echo display_label(display_value_array($this->config->item('role'), $row['role']), display_value_array($this->config->item('role_label'), $row['role'])); ?>
                                            </td>
                                            <td>
                                                <?php echo $row['notifier_full_name']; ?>
                                                <?php echo display_label(display_value_array($this->config->item('role'), $row['role']), display_value_array($this->config->item('role_label'), $row['role'])); ?>
                                            </td>
                                            <td>
                                                <?php echo display_label(display_value_array($this->config->item('users_modules_notification'), $row['action']), display_value_array($this->config->item('users_modules_notification_label'), $row['action'])); ?>
                                                <p><?php //echo $row['order_code']; ?></p>
                                            </td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row['status'] == 1){
                                                    echo display_label('Đã xem') . "<br>" . display_label('Xem lúc ' . display_date($row['modified']), 'info');
                                                }else{
                                                    echo display_label('Chưa xem', 'warning') . "<br>" . display_label('Đã gửi lúc ' . display_date($row['created']), 'info');
                                                }
                                                ?>
                                            </td>
                                            <?php if($is_admin): ?>
                                            <td class="text-center">
                                                <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url($module_slug . '/delete?id=' . $row['id']); ?>" class="btn-delete-confirm">Xóa</a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="text-left">
                                        <td colspan="3">
                                            <div class="input-group">
                                                <select class="form-control" name="action" id="action">
                                                    <option value="delete">Xóa</option>
                                                    <option value="content">Gửi thông báo</option>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit">Thực hiện</button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có thông báo nào!</p>
                    </div>
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