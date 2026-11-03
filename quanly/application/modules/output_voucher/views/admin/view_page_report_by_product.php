<style>
    .text-bold{
        font-weight: 700;
    }
</style>
<div class="box-shops">
	<div class="card">
		<div class="card-header row d-md-flex justify-content-between align-items-center">
			<!-- <h4 class="card-title">Báo cáo theo mặt hàng</h4> -->
			<div class="card-header-left">
				<div class="collapsible collapse-icon accordion-icon-rotate">
					<div class="search_bar">
						<div class="card collapse-header">
							<div id="headingCollapse5" class="card-header" data-toggle="collapse" role="button" data-target="#filter-bar-7adecd427b033de80d2a0e30cf74e735">
									<span class="collapse-title">
											<i class='bx bx-filter-alt align-middle'></i>
											<span class="align-middle">Bộ lọc</span>
									</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header-right">
				<a href="<?php echo base_url($module_slug . '/' . 'xuat'); ?>" class="btn btn-custom btn-export mr-1">Xuất dữ liệu</a>
				<button class="btn btn-custom noPrint" id="click_print" type="button">In</button>
			</div>
			<div class="clearfix"></div>
			<div class="block-content-searchbox">
				<form name="filter" method="get" action="<?php echo base_url($module_slug); ?>" autocomplete="off">
					<div id="filter-bar-7adecd427b033de80d2a0e30cf74e735" role="tabpanel" class="collapse">
						<div class="card-content">
								<div class="navbar-form card-body">
									<div class="row">
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Loại sản phẩm</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn loại sản phẩm" name="category_id" id="category_id">
															<option value="0">Tất cả</option>
															<?php echo display_option_select($category, 'id', 'name', isset($get['category_id']) ? $get['category_id'] : 0); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Sản phẩm</label>
												<div class="search_input">
													<select class="form-control form-control-sm input-sm chosen-select" tabindex="1" data-placeholder="Chọn sản phẩm" name="product_id" id="product_id">
															<option value="0">Tất cả</option>
															<?php echo display_option_select($products, 'id', 'name', isset($get['product_id']) ? $get['product_id'] : 0); ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Ngày</label>
												<div class="search_input">
													<div class="input-group input-append date" id="datePickerFromday">
															<?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : '');?>
															<input type="text" class="form-control form-control-sm input-sm" name="fromday" value="<?php echo $fromday; ?>" />
															<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="col-form-label search_title">Đến ngày</label>
												<div class="search_input">
													<div class="input-group input-append date" id="datePickerFromday">
															<?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : '');?>
															<input type="text" class="form-control form-control-sm input-sm" name="fromday" value="<?php echo $fromday; ?>" />
															<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 offset-xl-5 offset-lg-5 offset-md-5 offset-sm-0">
											<div class="form-group search_action">
													<button type="submit" class="btn btn-block btn-primary btn-sm">Xem</button>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card-content custom-card-table">
			<div class="card-body px-0">
				<div class="box-body" id="element_print">
					<?php if (!empty($rows)): ?>
						<form class="form-inline" name="main" method="post" action="<?php echo base_url($module_slug . '/' . 'cap-nhat'); ?>" autocomplete="off">
								<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
												<thead>
														<tr>
																<th class="text-center">STT</th>
																<th class="text-center">Ngày</th>
																<th>Mã sản phẩm</th>
																<th>Tên sản phẩm</th>
																<th>Kho</th>
																<th>Khách hàng</th>
																<th>Số lượng</th>
																<th class="text-right">Thành tiền</th>
																<!-- <th class="text-right">Lợi nhuận</th> -->
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
															$discount = 0;//$row['discount'];
															$VAT = $row['VAT'] * $monetized / 100;

															$sub_total_monetized = $monetized + $VAT - $discount;
															$total_monetized += $sub_total_monetized;
															$total_profit += $row['profit'];
													?>
														<tr>
																<td class="text-center">
																		<?php echo $j; ?>
																</td>
																<td class="text-center"><?php echo display_date($row['date']); ?></td>
																<td>
																		<?php echo $row['product_code']; ?>
																</td>
																<td><?php echo $row['name']; ?></td>
																<td><?php echo $row['warehouse_name']; ?></td>
																<td><?php echo $row['full_name']; ?></td>
																<td>
																		<?php echo ($row['quantity'] . ' ' . $row['product_unit']); ?>
																</td>
																<td class="text-right">
																		<?php echo formatRice($sub_total_monetized); ?>
																</td>
																<!-- <td class="text-right">
																		<?php echo formatRice($row['profit']); ?>
																</td> -->
														</tr>
														<?php endforeach;?>
												</tbody>
												<tfoot>
														<tr>
																<td colspan="8" class="text-right text-bold text-danger">
																		<?php echo formatRice($total_monetized); ?>
																</td>
																<!-- <td class="text-right text-bold text-danger">
																		<?php echo formatRice($total_profit); ?>
																</td> -->
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
						<div class="box-pagination clearfix">
								<?php echo $pagination; ?>
						</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>