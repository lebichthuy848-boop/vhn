<style type="text/css">
    .warehouse-info{
        margin-left: 0px;
    }
    .warehouse-info span{
        display: block;
        color: #111;
        font-weight: 600;
        font-size: 13px;
    }
    .warehouse-info span:first-child{
        font-weight: 700;
        font-size: 13.5px;
        color: #000;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
				<h3 class="box-title"><em class="fa fa-info-circle">&nbsp;</em>Thông tin phiếu chuyển kho</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo base_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body" id="element_print">
				<div class="row">
                    <div class="col-sm-12 col-md-12">
						<div class="pull-left">
							<p class="warehouse-info">
                                <span><?php echo isset($store) ? $store : ''; ?></span>
                                <span>Địa chỉ: <?php echo isset($address) ? $address : ''; ?></span>
                                <span>Điện thoại: <?php echo isset($phone) ? $phone : ''; ?></span>
                            </p>
						</div>
						<div style="width: 180px;" class="pull-right text-bold">
							<p>
								<span class="pull-left">Số phiếu</span>
								<span class="pull-right"><?php echo isset($row['code']) ? $row['code'] : ''; ?></span>
							</p>
							<div class="clearfix"></div>
							<p>
								<span class="pull-left">Ngày</span>
								<span class="pull-right"><?php echo (isset($row['date']) && ($row['date'] > 0)) ? date('d/m/Y', $row['date']) : date('d/m/Y'); ?></span>
							</p>
						</div>
						<div class="clearfix"></div>
						<h3 class="text-center text-bold no-margin">PHIẾU CHUYỂN KHO</h3>
					</div>
				</div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
						<?php if (isset($row['note']) && trim($row['note']) != ''): ?>
                        <p>
                            Ghi chú
                            <br/>
                            <?php echo nl2br($row['note']); ?>
                        </p>
						<?php endif;?>
                        <?php if (isset($row['items']) && is_array($row['items']) && !empty($row['items'])): ?>
                            <div class="table-responsive table-view">
                                <table class="table table-bordered no-margin-bottom">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="product-name">Tên sản phẩm</th>
                                            <th>Kho xuất</th>
                                            <th>Kho nhập</th>
                                            <th class="text-center">Đơn vị tính</th>
                                            <th class="text-center">Số lượng</th>
											<th>Nhà cung cấp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $total_number = 0;
                                        $total_monetized = 0;
                                        foreach ($row['items'] as $value):
                                        	$total_monetized += (float) $value['monetized'];
                                        	$i++;
                                        	?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td><?php echo $value['product_name']; ?></td>
                                                <td><?php echo $value['warehouse_name']; ?></td>
                                                <td><?php echo $value['transaction_warehouse_name']; ?></td>
                                                <td class="text-center"><?php echo $value['product_unit']; ?></td>
                                                <td class="text-center"><?php echo $value['quantity']; ?></td>
                                                <td><?php echo $value['provider_name']; ?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php $total_number = $total_monetized;?>
                                        <tr class="borderless">
                                            <td colspan="3" class="borderless">
                                                <p>Cộng tiền hàng</p>
												<div class="clearfix"></div>
                                            </td>
											<td colspan="3" class="borderless text-red" style="font-style: italic;">
                                                <p>Viết bằng chữ: <span class="text-bold" style="font-style: italic;"><?php echo read_number_to_text($total_number); ?></span></p>
                                            </td>
											<td class="borderless text-red">
                                                <p>
                                                    <span class="pull-right text-bold"><?php echo format_rice_en($total_monetized); ?></span>
                                                </p>
												<div class="clearfix"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif;?>
                        <div style="width: 180px;" class="text-center pull-right">
                            <p class="text-center" style="font-style: italic;">Ngày.....tháng......năm........</p>
                        </div>
                        <div class="clearfix"></div>
                        <div style="width: 180px;" class="text-center pull-right">
                            <p class="text-center">
							<strong>Người lập phiếu</strong>
							<br>
							(Ký, họ tên)</p>
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="inline">
                            <button class="btn btn-info noPrint" id="click_print" type="button"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
                            <a href="<?php echo base_url($module_slug); ?>" class="btn btn-danger noPrint">Thoát</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>