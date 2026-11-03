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
                            Trạng thái
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="returned" id="f_returned">
                                <option value="-1">---</option>
                                <?php if (isset($get['returned']) && $get['returned'] == 1) : ?>
                                    <option selected="selected" value="1">Đã trả</option>
                                <?php else : ?>
                                    <option value="1">Đã trả</option>
                                <?php endif; ?>                                

                                <?php if (isset($get['returned']) && $get['returned'] == 0) : ?>
                                    <option selected="selected" value="0">Chưa trả</option>
                                <?php else : ?>
                                    <option value="0">Chưa trả</option>
                                <?php endif; ?>
                            </select>
                        </div>

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
                            Số phiếu
                        </div>
                        <div class="form-group search_input">
                            <input class="form-control input-sm" type="text" value="<?php if (isset($get['q'])) echo $get['q']; ?>" maxlength="64" name="q" placeholder="Nhập mã phiếu">
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách mượn hàng</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã số phiếu</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày nhận</th>
                                        <th>Ngày trả</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['code']; ?>
                                            </td>
                                            <td><?php echo $row['full_name']; ?></td>
                                            <td><?php echo $row['start_date'] > 0 ? display_date($row['start_date']) : ''; ?></td>
                                            <td><?php echo $row['end_date'] > 0 ? display_date($row['end_date']) : ''; ?></td>
                                            <td>
                                                <?php
                                                echo $row['returned'] == 1 ? 'Đã trả' : 'Chưa trả';
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo base_url($module_slug . '/xoa?id=' . $row['id']); ?>" class="delete_bootbox">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có mượn hàng nào!</p>
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