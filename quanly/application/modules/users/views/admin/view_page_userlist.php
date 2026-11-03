<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Các thành viên</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Tài khoản</th>
                                <th class="text-center">Họ tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $row) {
                                ?>
                                <tr>
                                    <td class="text-right">
                                        <?php echo $row['userid']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($row['group_id']) {
                                            case 6:
                                                $img_role = 'admin1.png';
                                                break;
                                            case 5:
                                                $img_role = 'admin2.png';
                                                break;
                                            case 4:
                                                $img_role = 'admin3.png';
                                                break;
                                            default:
                                                $img_role = '';
                                                break;
                                        }
                                        if ($img_role != '') {
                                            ?>
                                            <img alt="" src="<?php echo $path_img . $img_role; ?>" width="38" height="18">
                                            <?php
                                        }
                                        ?>
                                        <a title="Chi tiết" href="<?php echo get_admin_url('users/user_add?userid=' . $row['userid']); ?>"><?php echo $row['username']; ?></a>
                                    </td>
                                    <td><?php echo $row['full_name']; ?></td>
                                    <td>
                                        <a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
                                    </td>
                                    <td class="text-center">
                                        <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url('users/user_add?userid=' . $row['userid']); ?>">Sửa</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>