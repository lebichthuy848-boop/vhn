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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Báo cáo theo ngày</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            STT
                                        </th>
                                        <th>Tên khách</th>
                                        <th>Số phiếu</th>
                                        <th>VAT</th>
                                        <th>Mã thuốc</th>
                                        <th>Tên thuốc</th>
                                        <th>Đơn vị</th>
                                        <th class="text-right">Số lượng</th>
                                        <th class="text-right">Đơn giá</th>                                        
                                        <th class="text-right">CK</th>
                                        <th class="text-right">Thành tiền</th>
                                        <th class="text-right">Lợi nhuận</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $j = 0;
                                    foreach ($rows as $row):
                                        $j++;
                                        ?>
                                        <?php if (isset($row['items']) && !empty($row['items'])): ?>
                                            <?php
                                            $i = 0;
                                            $count = count($row['items']);
                                            foreach ($row['items'] as $value):
                                                $i++;
                                                ?>
                                                <tr>
                                                    <?php if ($i == 1): ?>
                                                        <td class="text-center" rowspan="<?php echo $count; ?>">
                                                            <?php echo $j; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if ($i == 1): ?>
                                                        <td rowspan="<?php echo $count; ?>"><?php echo $row['customer_full_name']; ?></td>
                                                    <?php endif; ?>
                                                    <?php if ($i == 1): ?>
                                                        <td rowspan="<?php echo $count; ?>">
                                                            <?php echo $row['code']; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php echo $value['VAT']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['product_code']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['product_unit']; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo $value['quantity']; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo formatRice($value['unit_price']); ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo $value['discount']; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo formatRice($value['monetized']); ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo formatRice($value['monetized']); ?>
                                                        <?php
                                                        /*
                                                        $monetized = 0;
                                                        $discount = 0;
                                                        $VAT = 0;
                                                        if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])) {
                                                            $arr_monetized = array_column($row['items'], 'monetized');
                                                            $arr_VAT = array_column($row['items'], 'VAT');
                                                            $count = (count($arr_monetized) > count($arr_VAT) ? count($arr_VAT) : count($arr_monetized));
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $VAT += ($arr_VAT[$i] * $arr_monetized[$i] / 100);
                                                            }

                                                            $monetized = array_sum($arr_monetized);
                                                            $discount = array_sum(array_column($row['items'], 'discount'));
                                                        }
                                                        echo formatRice($monetized + $VAT - $discount);
                                                         * 
                                                         */
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
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