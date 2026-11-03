<?php
if(!isset($notification_counts)){
	$notification_counts = 0;
}
?>
<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
	<div class="navbar-wrapper">
		<div class="navbar-container content">
			<div class="box-breadcrumb navbar-collapse" id="navbar-mobile">
				<div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
					<ul class="nav navbar-nav breadcrumb rounded-pill.breadcrumb-divider mb-0">
						<li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
						<li class="breadcrumb-item">
							<a href="<?php echo base_url(); ?>">
								<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/ico/ico-home.svg'); ?>" class="img-fluid" />
							</a>
						</li>
							<?php
								$end_breadcrumbs = count($breadcrumbs_admin);
								$start_breadcrumbs = 1;
								foreach ($breadcrumbs_admin as $value) {
										if ($start_breadcrumbs != $end_breadcrumbs) {
												echo "<li class=\"breadcrumb-item\"><a href=\"" . get_admin_url($value['url']) . "\">" . $value['name'] . "</a></li>";
										} else {
												echo "<li class=\"breadcrumb-item active\">" . '<img src="' . $value['image'] . '" /> ' . '<span>' . $value['name'] . "</span></li>";
										}
										$start_breadcrumbs++;
								}
							?>
					</ul>
				</div>
				<ul class="nav navbar-nav float-right">
					<!-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li> -->
					<!-- <li class="dropdown dropdown-notification nav-item">
							<a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bxs-collection bx-flip-horizontal"></i> Thiết lập</a>
							<div class="dropdown-menu dropdown-menu-right pb-0">
								<a class="dropdown-item" href="page-user-profile.html"><i class="bx bx-file mr-50"></i> Quản lý mẫu in</a>
								<a class="dropdown-item" href="auth-login.html"><i class="bx bxs-user-rectangle mr-50"></i> Quản lý người dùng</a>
								<a class="dropdown-item" href="auth-login.html"><i class="bx bx-shape-triangle mr-50"></i> Quản lý chi nhánh</a>
							</div>
					</li> -->
					<li class="dropdown dropdown-notification nav-item">
						<a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
							<img src="<?php echo base_url('assets/Frest/app-assets/images/svg/ico/ico-notification.svg'); ?>" class="img-fluid" />
							<span class="badge badge-pill badge-danger badge-up"><?php echo $notification_counts; ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
							<li class="dropdown-menu-header">
								<div class="dropdown-header d-flex justify-content-between align-items-center">
									<span class="text-bold-700 notification-title"><?php echo $notification_counts; ?> Thông báo</span>
									<span class="text-bold-400 notification-check-seen cursor-pointer">Đánh dấu đã xem</span>
								</div>
							</li>
							<li class="scrollable-container media-list">
								<?php if(isset($notifications) && is_array($notifications) && !empty($notifications)): ?>
									<?php foreach ($notifications as $notification): ?>
									<div class="d-flex justify-content-between<?php echo ($notification['status'] == -1) ? ' read-notification' : ''; ?> cursor-pointer">
										<div class="media d-flex align-items-center">
											<div class="media-left pr-0">
												<div class="avatar mr-1 m-0"><img src="<?php echo base_url('assets/Frest/app-assets/images/portrait/small/avatar-s-4.jpg'); ?>" alt="avatar" height="45" width="45"></div>
											</div>
											<div class="media-body">
												<h6 class="media-heading">
													<span class="text-bold-500"><?php echo $notification['actor_full_name']; ?></span> 
													<?php echo $notification['title']; ?></h6>
													<small class="notification-text"><?php echo time_ago($notification['created']); ?></small>
											</div>
										</div>
									</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</li>
							<li class="dropdown-menu-footer"><a class="dropdown-item justify-content-center" href="javascript:void(0)">Đọc tất cả thông báo</a></li>
						</ul>
					</li>
					<li class="dropdown dropdown-user nav-item">
						<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
							<div class="user-nav d-sm-flex d-none">
								<span class="user-name"><?php echo $full_name; ?></span>
							</div>
							<span class="online-status"><img class="round" src="<?php echo get_image(get_module_path('users') . $photo, get_module_path('users') . 'no-avatar.jpg'); ?>" alt="avatar" height="40" width="40"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- <a class="dropdown-item dropdown-profile" data-toggle="modal" data-target="#modal_profile" href="<?php echo get_admin_url('users/profile'); ?>">Tài khoản</a> -->
							<a class="dropdown-item dropdown-profile" href="<?php echo site_url('profile'); ?>">Tài khoản</a>
							<a class="dropdown-item dropdown-sign-out" href="<?php echo get_admin_url('logout'); ?>">Đăng xuất</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
<!-- END: Header-->