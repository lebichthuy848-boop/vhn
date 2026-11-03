<style>
    .text-bold{
        font-weight: 700;
    }
</style>
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
                            Loại sản phẩm
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
                                <option value="0">Tất cả</option>
                                <?php echo display_option_select($category, 'id', 'name', isset($get['category_id']) ? $get['category_id'] : 0); ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Sản phẩm
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm chosen-select" tabindex="1" data-placeholder="Chọn sản phẩm" name="product_id" id="product_id">
                                <option value="0">Tất cả</option>
                                <?php echo display_option_select($products, 'id', 'name', isset($get['product_id']) ? $get['product_id'] : 0); ?>
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

                        <div class="form-group search_action pull-right">                                
                            <button type="submit" class="btn btn-primary btn-sm">Xem</button>
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Báo cáo theo mặt hàng</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo base_url($module_slug . '/' . 'xuat'); ?>"><i class="fa fa-cloud-download"></i> Xuất dữ liệu</a>&nbsp;
                    <a class="btn btn-primary" href="<?php echo base_url($module_slug . '/' . 'nhap'); ?>"><i class="fa fa-cloud-upload"></i> Nhập dữ liệu</a>&nbsp;
                    <button class="btn btn-info noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
                </div>
            </div>
            <div class="box-body" id="element_print">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            STT
                                        </th>
                                        <th>Ngày</th>
                                        <th>Mã thuốc</th>
                                        <th>Tên thuốc</th>
                                        <th>Số lượng</th>
                                        <th class="text-right">Thành tiền</th>
                                        <th class="text-right">Lợi nhuận</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $j = 0;
                                    $total_monetized = 0;
                                    $total_profit = 0;
                                    foreach ($rows as $row):
                                        $j++;
                                        $monetized = $row['monetized'];
                                        $discount = $row['discount'];
                                        $VAT = $row['VAT'] * $monetized / 100;

                                        $sub_total_monetized = $monetized + $VAT - $discount;
                                        $total_monetized += $sub_total_monetized;
                                        $total_profit += $row['profit'];
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $j; ?>
                                            </td>
                                            <td><?php echo display_date($row['date']); ?></td>
                                            <td>
                                                <?php echo $row['product_code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo ($row['quantity'] . ' ' . $row['product_unit']); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo formatRice($sub_total_monetized); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo formatRice($row['profit']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-right text-bold text-danger">
                                            <?php echo formatRice($total_monetized); ?>
                                        </td>
                                        <td class="text-right text-bold text-danger">
                                            <?php echo formatRice($total_profit); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có dữ liệu nào!</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (isset($pagination) && ($pagination != '')): ?>
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>