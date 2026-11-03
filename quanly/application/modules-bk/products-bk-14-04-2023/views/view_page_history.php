<div class="card">
	<div class="card-header d-md-flex justify-content-between align-items-center">
		<h4 class="card-title">Lịch sử đổi giá</h4>
		<div class="header-right mt-md-0 mt-50">
			<a class="btn btn-info mb-1 mr-1" href="<?php echo base_url('san-pham'); ?>"><i class="bx bx-table"></i> Danh sách</a>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body px-0">
			<div class="box-body" id="element_print">
				<?php if (empty($rows)): ?>
						<div class="callout callout-warning">
								<h4>Thông báo!</h4>
								<p><b>Không</b> tìm thấy thông tin nào!</p>
						</div>
				<?php else: ?>
						<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
										<thead>
												<tr>
														<th class="text-center">
																STT
														</th>
														<th>Mã thuốc</th>
														<th>Tên thuốc</th>
														<th class="text-center">Ngày</th>
														<th class="text-right">Giá cũ</th>
														<th class="text-right">Giá mới</th>
												</tr>
										</thead>
										<tbody>
												<?php
												$j = 0;
												foreach ($rows as $value):
														$j++;
														?>
														<tr>
																<td class="text-center">
																		<?php echo $j; ?>
																</td>                                            
																<td><?php echo $row['code']; ?></td>
																<td><?php echo $row['name']; ?></td>
																<td class="text-center"><?php echo display_date($value['date']); ?></td>
																<td class="text-right"><?php echo formatRice($value['unit_price_current']); ?></td>
																<td class="text-right"><?php echo formatRice($value['unit_price']); ?></td>
														</tr>
												<?php endforeach; ?>
										</tbody>
								</table>
						</div>
				<?php endif; ?>
			</div>
			<?php if (isset($pagination) && $pagination != ''): ?>
					<div class="box-pagination clearfix">
							<?php echo $pagination; ?>
					</div>
			<?php endif; ?>
		</div>
	</div>
</div>