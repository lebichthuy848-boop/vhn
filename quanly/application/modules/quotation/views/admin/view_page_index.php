<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
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
                            Ngày
                        </div>
                        <div class="form-group search_input">
                            <div class="input-group input-append date" id="datePickerFromday">
                                <?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : ''); ?>
                                <input type="text" class="form-control input-sm" name="fromday" value="<?php echo $fromday; ?>" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="form-group search_title">
                            Đến ngày
                        </div>
                        <div class="form-group search_input">
                            <div class="input-group input-append date" id="datePickerToday">
                                <?php $today = (isset($get['today']) && ($get['today'] != '') ? $get['today'] : ''); ?>
                                <input type="text" class="form-control input-sm" name="today" value="<?php echo $today; ?>" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>

                        <div class="form-group search_title">
                            Tên khách hàng
                        </div>
                        <div class="form-group search_input">
                            <input class="form-control input-sm" type="text" value="<?php echo isset($get['full_name']) ? $get['full_name'] : ''; ?>" maxlength="64" name="full_name" placeholder="Nhập tên khách hàng">
                        </div>

                        <div class="form-group search_action pull-right">                                
                            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                        </div>
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách báo giá</h3>
				<div class="pull-right">
					<?php if ($role == 'ADMIN' || $have_add == 1): ?>
						<a class="btn btn-success pull-right" href="<?php echo base_url($module_slug . '/' . 'them'); ?>"><i class="fa fa-plus"></i> Thêm</a>
					<?php endif; ?>
				</div>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
                                        </th>
                                        <th>Khách hàng</th>
                                        <th class="text-center">Ngày báo giá</th>
                                        <th class="text-right">Tổng số tiền</th>
                                        <th class="text-center" style="width: 200px;">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
                                            </td>
                                            <td><?php echo $row['customer_full_name']; ?></td>
                                            <td class="text-center">
                                                <?php echo $row['date'] > 0 ? display_date($row['date']) : ''; ?>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $monetized = 0;
                                                //$discount = 0;
                                                if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])) {
                                                    $monetized = array_sum(array_column($row['items'], 'monetized'));
                                                    //$discount = array_sum(array_column($row['items'], 'discount'));
                                                }
                                                $VAT = $monetized * (float) $row['VAT'] / 100;
                                                echo formatRice($monetized + $VAT);
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <em class="fa fa-search-plus fa-lg">&nbsp;</em> <a href="<?php echo base_url($module_slug . '/xem/' . $row['id']); ?>">Xem</a>
                                                <?php if ($role == 'ADMIN' || $have_edit == 1): ?>
                                                    &nbsp;-&nbsp;
                                                    <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="<?php echo base_url($module_slug . '/them/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>">Sửa</a>
                                                <?php endif; ?>
                                                <?php if ($role == 'ADMIN' || $have_delete == 1): ?>
                                                    &nbsp;-&nbsp;
                                                    <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>" class="delete_bootbox">Xóa</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <?php if (!($role != 'ADMIN' && $have_add != 1 && $have_delete != 1)): ?>
                                    <tfoot>
                                        <tr class="text-left">
                                            <td colspan="6">
                                                <select class="form-control" name="action" id="action">
                                                    <?php if ($role == 'ADMIN' || $have_delete == 1): ?>
                                                        <option value="delete">Xóa</option>
                                                    <?php endif; ?>
                                                    <?php if ($role == 'ADMIN' || $have_add == 1): ?>
                                                        <option value="content">Thêm</option>
                                                    <?php endif; ?>
                                                </select>
                                                <input type="submit" class="btn btn-primary" value="Thực hiện">
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có báo giá nào!</p>
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