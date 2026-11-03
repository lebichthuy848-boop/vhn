<style>
    .text-bold{
        font-weight: 700;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Báo cáo theo ngày <?php echo isset($get['date']) ? $get['date'] : ''; ?></h3>
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?php echo base_url($module_slug) . (isset($get['date']) ? '?month=' . date('m-Y', strtotime($get['date'])) : ''); ?>"><i class="fa fa-table"></i> Danh sách báo cáo theo ngày</a>&nbsp;
                    <button class="btn btn-info noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
                </div>
            </div>
            <div class="box-body" id="element_print">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            STT
                                        </th>
                                        <th>Tên khách</th>
                                        <th>Số phiếu</th>
                                        <th>Nhân viên</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn vị</th>
                                        <th>Kho</th>
                                        <th class="text-right">Số lượng</th>
                                        <th class="text-right">Đơn giá</th>
                                        <th class="text-right">CK (%)</th>
                                        <th class="text-right">Thành tiền</th>
                                        <th class="text-right">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $j = 0;
                                    $total_monetized = 0;
                                    $total_profit = 0;
                                    foreach ($rows as $row):
                                    	$j++;
                                    	$VAT = $row['VAT']/100;
                                    	?>
                                    <?php if (isset($row['items']) && !empty($row['items'])): ?>
                                    <?php
                                    	$arr_monetized = array_sum(array_column($row['items'], 'monetized'));
                                    	$discount = $arr_monetized * $VAT;
                                    	$sub_total_monetized = $arr_monetized + $discount;
                                    	$total_monetized += $sub_total_monetized;
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
                                                <?php endif;?>
                                                <?php if ($i == 1): ?>
                                                    <td rowspan="<?php echo $count; ?>"><?php echo $row['customer_full_name']; ?></td>
                                                <?php endif;?>
                                                <?php if ($i == 1): ?>
                                                    <td rowspan="<?php echo $count; ?>">
                                                        <?php echo $row['code']; ?>
                                                    </td>
                                                <?php endif;?>
                                                <?php if ($i == 1): ?>
                                                    <td rowspan="<?php echo $count; ?>">
                                                        <?php echo $row['employee_full_name']; ?>
                                                    </td>
                                                <?php endif;?>
                                                <td>
                                                    <?php echo $value['product_code']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['product_unit']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value['warehouse_name']; ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo $value['quantity']; ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo formatRice($value['unit_price']); ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo $value['price_discount_percent']; ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo formatRice($value['monetized']); ?>
                                                </td>
												<?php if ($i == 1): ?>
													<td rowspan="<?php echo $count; ?>" class="text-right text-bold text-danger"><?php echo formatRice($sub_total_monetized); ?></td>
												<?php endif;?>
                                            </tr>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
										<td colspan="12">Tổng cộng</td>
                                        <td class="text-right text-bold text-danger">
                                            <?php echo formatRice($total_monetized); ?>
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
                <?php endif;?>
            </div>
            <?php if (isset($pagination) && ($pagination != '')): ?>
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>