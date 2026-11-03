<style>
    .box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title {
        font-size: 35px;
        line-height: 1.25;
    }
    .box-body .small-box-footer{
        font-size: 22px;
        line-height: 1.5;
    }
    .box.box-solid>.box-header .btn:hover, .box.box-solid>.box-header a:hover {
        background: none !important;
    }
</style>
<?php
$is_admin = (isset($role) && in_array($role, array('ADMIN')));
$i = 0;
?>
<!-- BEGIN: Content-->
<section id="dashboard-analytics" class="box-dashboard">
	<div class="box-morning-newday">
		<h1>Thống kê hôm nay <small><?php echo date('d/m/Y'); ?></small></h1>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-8">
			<div class="card ">
				<div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-1">
					<h4 class="card-title d-flex mb-25 mb-sm-0">Doanh Thu Tháng</h4>
					<!-- <ul class="list-inline d-flex mb-25 mb-sm-0">
						<li class="d-flex align-items-center toggle-filter-date">
							<div class="dropdown">
								<div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hôm nay</div>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 22px, 0px);">
									<a class="dropdown-item" href="#">Hôm nay</a>
									<a class="dropdown-item" href="#">Hôm qua</a>
									<a class="dropdown-item" href="#">7 ngày qua</a>
									<a class="dropdown-item" href="#">Tháng này</a>
									<a class="dropdown-item" href="#">Tháng trước</a>
								</div>
							</div>
						</li>
					</ul> -->
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="analytics-bar-chart"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="analytics-item">
							<div class="block-images">
								<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/dong.svg'); ?>" class="img-fluid" />
							</div>
							<div class="block-content">
								<h3><?php echo isset($amount_output_voucher) ? format_number($amount_output_voucher) : 0 ?></h3>
								<small><?php echo isset($count_output_voucher) ? formatRice($count_output_voucher) : 0 ?> Hóa đơn</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="analytics-item">
							<div class="block-images">
								<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/tra_hang.svg'); ?>" class="img-fluid" />
							</div>
							<div class="block-content">
								<h3>12</h3>
								<small>Trả hàng</small>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="analytics-item">
							<div class="block-images">
								<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/tong_thu_nhap.svg'); ?>" class="img-fluid" />
							</div>
							<div class="block-content">
								<h3><?php echo isset($compared_to_the_same_period_last_month_output_voucher) ? number_format($compared_to_the_same_period_last_month_output_voucher, 2) : number_format(0, 2) ?>%</h3>
								<small>So với cùng kỳ tháng trước</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if($is_admin): ?>
		<div class="col-md-5 col-sm-5">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="block-notification-day-item">
							<div class="block-header-title">
								<h3>Thông Báo Hôm Nay</h3>
							</div>
							<div class="block-panel-content">
								<div class="block-images">
									<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/birthday.svg'); ?>" class="img-fluid" />
								</div>
								<div class="block-content">
									<p>Có <a href="#"><?php echo isset($count_birthday_customers) ? formatRice($count_birthday_customers) : 0 ?> khách hàng</a> sinh nhật hôm nay</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card ">
				<div class="box-notification-recent">
					<div class="card-header">
						<div class="block-header-title">
							<h3>Các Hoạt Động Gần Đây</h3>
						</div>
					</div>
					<div class="card-content">
						<div class="card-body widget-scroll">
							<?php if(isset($activities) && is_array($activities) && !empty($activities)): ?>
        						<?php $i = 0; $count_activities = count($activities); foreach ($activities as $activiti): $i++; ?>
									<h3 class="label-title<?php echo $i == 1 ? ' mt-0' : ''; ?>"><?php echo $activiti['title']; ?></h3>
									<ul class="widget-timeline mb-0">
										<?php if(isset($activiti['items']) && is_array($activiti['items']) && !empty($activiti['items'])): ?>
			        						<?php $k = 0; $count_items = count($activiti['items']); ?>
			        						<?php foreach ($activiti['items'] as $item): $k++; ?>
											<li class="timeline-items timeline-icon-success active<?php echo (($k == $count_items) && ($i == $count_activities)) ? ' pb-0' : ''; ?>">
												<h6 class="timeline-title"><a href="javascript:void(0)"><?php echo $item['employee_full_name']; ?></a> vừa bán đơn hàng với giá trị <strong><?php echo formatRice($item['amount']); ?> VND</strong></h6>
												<div class="timeline-time float-right"><?php echo time_ago($item['date']); ?></div>
												<div class="clearfix"></div>
											</li>
										    <?php endforeach; ?>
										<?php endif; ?>
									</ul>
							    <?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-7 col-sm-7">
			<div class="card ">
				<div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-1">
					<h4 class="card-title d-flex mb-25 mb-sm-0">Top 10 Hàng Hóa Bán Chạy Tháng Này</h4>
					<!-- <ul class="list-inline d-flex mb-25 mb-sm-0">
						<li class="d-flex align-items-center toggle-filter-date">
							<div class="dropdown">
								<div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hôm nay</div>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 22px, 0px);">
									<a class="dropdown-item" href="#">Hôm nay</a>
									<a class="dropdown-item" href="#">Hôm qua</a>
									<a class="dropdown-item" href="#">7 ngày qua</a>
									<a class="dropdown-item" href="#">Tháng này</a>
									<a class="dropdown-item" href="#">Tháng trước</a>
								</div>
							</div>
						</li>
					</ul> -->
				</div>
				<div class="card-content">
					<div class="card-body">
                        <?php if(isset($products_bestseller) && is_array($products_bestseller) && !empty($products_bestseller)): ?>
						<div id="analytics-bar-chart-horizontal"></div>
                        <?php else: ?>
                            Chưa có sản phẩm nào!
                        <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>
<script type="text/javascript">
	<?php  ?>
    var analyticsBarChartSeries = [];
    var analyticsBarChartCategories = [];
    var analyticsBarChartMax = parseInt('<?php echo isset($max) ? $max : 0; ?>');
    if(analyticsBarChartMax > 1000000){
    	analyticsBarChartMax = 10000000;
    }else if(analyticsBarChartMax > 100000){
    	analyticsBarChartMax = 1000000;
    }
    <?php if(isset($charts) && is_array($charts) && !empty($charts)): ?>
        <?php foreach ($charts as $name => $value): ?>
        	var serie = {};
        	serie['name'] = '<?php echo $name; ?>';
        	serie['data'] = <?php echo json_encode($value); ?>;
        	analyticsBarChartSeries.push(serie);
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(isset($months) && is_array($months) && !empty($months)): ?>
    	analyticsBarChartCategories = <?php echo json_encode($months); ?>;
    <?php endif; ?>

    var analyticsBarChartHorizontalSeries = [];
    var analyticsBarChartHorizontalCategories = [];
    <?php if(isset($products_bestseller) && is_array($products_bestseller) && !empty($products_bestseller)): ?>
    	var serie = {};
    	serie['name'] = 'Số lượng bán';
    	serie['data'] = <?php echo json_encode(array_column($products_bestseller, 'total_quantity')); ?>;
    	analyticsBarChartHorizontalSeries.push(serie);
    	analyticsBarChartHorizontalCategories = <?php echo json_encode(array_column($products_bestseller, 'name')); ?>;
    <?php endif; ?>
</script>