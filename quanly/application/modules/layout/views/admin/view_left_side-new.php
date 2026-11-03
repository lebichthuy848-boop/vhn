<!-- BEGIN: Main Menu-->
<div class="navigation-custom main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
	<div class="navbar-header">
		<ul class="nav navbar-nav flex-row">
			<li class="nav-item mr-auto">
				<a class="navbar-brand" href="<?php echo base_url(); ?>">
					<div class="brand-logo"></div>
				</a>
			</li>
			<li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 white toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon white" data-ticon="bx-disc"></i></a></li>
		</ul>
	</div>
	<div class="shadow-bottom"></div>
	<div class="main-menu-content">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
			<?php if(isset($menus) && is_array($menus) && !empty($menus)): ?>
				<?php foreach ($menus as $menu): ?>
					<?php
					$menu_name = $menu['name'];
					$menu_url = $menu['url'];
					$menu_childs = $menu['childs'];
					?>
					<li<?php if ($menu_admin_active == $menu_url) echo ' class="nav-item active"'; ?>>
							<a href="<?php echo base_url($menu_url); ?>">
								<i class="menu-svgicon" style="visibility: visible; width: 60px;">
									<div class="svg-wrapper">
										<?php echo $menu['icon']; ?>
									</div>
								</i>
							<span class="menu-title"><?php echo $menu_name; ?></span>
						</a>
						<?php if(is_array($menu_childs) && !empty($menu_childs)): ?>
						<ul class="menu-content">
							<?php foreach ($menu_childs as $menu_child): ?>
								<li<?php echo ($menu_admin_active == $menu_url && $menu_sub_admin_active == '') ? ' class="active"': ''; ?>><a href="<?php echo base_url($menu_child['url']); ?>"><?php echo $menu_child['icon']; ?><span class="menu-item"><?php echo $menu_child['name']; ?></span></a></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
<!-- END: Main Menu-->