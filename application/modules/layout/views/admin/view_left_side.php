<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(get_module_path('users') . $photo); ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Chào <?php echo $full_name; ?>!</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li<?php if ($menu_admin_active == '') echo ' class="active"'; ?>>
                <a href="<?php echo get_admin_url(); ?>">
                    <i class="fa fa-dashboard"></i> <span>Bảng điều khiển</span>
                </a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'settings') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('settings'); ?>">
                    <i class="fa fa-cogs"></i> <span>Cấu hình</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('settings'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình chung</a></li>
                    <li><a href="<?php echo get_admin_url('settings/main'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình site</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'images') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('images'); ?>"><i class="fa fa-photo"></i> Hình ảnh</a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'info') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-phone"></i>
                    <span>Thông tin</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('info'); ?>"><i class="fa fa-angle-double-right"></i> Danh sách thông tin</a></li>
                    <li><a href="<?php echo get_admin_url('info/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm thông tin</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'emails') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>Email</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('emails/logs'); ?>"><i class="fa fa-angle-double-right"></i> Nhật ký gửi mail</a></li>
                    <li><a href="<?php echo get_admin_url('emails'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'menu') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('menu'); ?>"><i class="fa fa-angle-double-right"></i> Các menu</a></li>
                    <li><a href="<?php echo get_admin_url('menu/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm menu</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'pages') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('pages'); ?>"><i class="fa fa-file"></i> Trang tĩnh</a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'posts') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Tin tức</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('posts/cat'); ?>"><i class="fa fa-angle-double-right"></i> Chủ đề</a></li>
                    <li><a href="<?php echo get_admin_url('posts'); ?>"><i class="fa fa-angle-double-right"></i> Bài viết</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'orders') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('orders'); ?>">
                    <i class="fa fa-cart-arrow-down"></i> <span>Đơn đặt hàng</span>
                    <small class="badge pull-right bg-yellow"><?php echo $num_rows_order; ?></small>
                </a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'shops') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> <span>Sản phẩm</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('shops/items'); ?>"><i class="fa fa-angle-double-right"></i> Danh sách sản phẩm</a></li>
                    <li><a href="<?php echo get_admin_url('shops/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm sản phẩm</a></li>
                    <li><a href="<?php echo get_admin_url('shops/cat'); ?>"><i class="fa fa-angle-double-right"></i> Danh mục sản phẩm</a></li>
                    <li><a href="<?php echo get_admin_url('shops/filter'); ?>"><i class="fa fa-angle-double-right"></i> Thương hiệu</a></li>
                </ul>
            </li>
            <li<?php if ($menu_admin_active == 'advisory') echo ' class="active"'; ?>>
                <a href="<?php echo get_admin_url('advisory'); ?>">
                    <i class="fa fa-envelope"></i> <span>Tư vấn</span>
                </a>
            </li>
            <li<?php if ($menu_admin_active == 'contact' || $menu_admin_active == 'view_contact') echo ' class="active"'; ?>>
                <a href="<?php echo get_admin_url('contact'); ?>">
                    <i class="fa fa-envelope"></i> <span>Liên hệ</span>
                    <small class="badge pull-right bg-yellow"><?php echo $num_rows_contact; ?></small>
                </a>
            </li>
            <li class="treeview<?php echo ($menu_admin_active == 'users') ? ' active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Người dùng</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('users'); ?>"><i class="fa fa-angle-double-right"></i> Danh sách</a></li>
                    <li><a href="<?php echo get_admin_url('users/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm</a></li>
                </ul>
            </li>
            <li class="treeview<?php echo ($menu_admin_active == 'sitemap') ? ' active' : ''; ?>">
                <a href="<?php echo get_admin_url('sitemap'); ?>"><i class="fa fa-sitemap"></i> Sitemap</a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>