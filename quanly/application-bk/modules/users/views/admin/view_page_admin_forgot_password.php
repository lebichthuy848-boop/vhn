<!DOCTYPE html>
<html class="loading" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><?php echo $title; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/Frest/favicon.ico'); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/Frest/favicon.ico'); ?>">
    <link rel="icon" href="<?php echo base_url('assets/Frest/favicon.ico'); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/vendors/css/vendors.min.css'); ?>">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/bootstrap-extended.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/colors.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/components.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/themes/dark-layout.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/themes/semi-dark-layout.css'); ?>">
    <!-- END: Theme CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/app-assets/css/pages/authentication.css'); ?>">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Frest/assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
</head>

<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- forgot password start -->
                <section class="row flexbox-container">
                    <div class="col-xl-7 col-md-9 col-10  px-0">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card custom-card disable-rounded-right mb-0 h-100 d-flex">
                                        <div class="box-user">
                                            <div class="block-user-header">
                                                <ul>
                                                    <li><a class="active" href="javascript:void(0);">Quên mật khẩu</a></li>
                                                </ul>
                                            </div>
                                            <div class="block-user-content">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php $this->load->view('view_notify'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group--el">
                                                            <input type="email" class="form-control" name="email" placeholder="Nhập email để lấy lại mật khẩu">
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <a href="<?php echo site_url(); ?>" class="btn btn-block btn-outline-secondary glow position-relative">Quay Lại</a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-block btn-outline-secondary glow position-relative">Lấy Mật Khẩu</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center px-0">
                                    <div class="card-content">
                                        <img class="img-fluid w-100" src="<?php echo base_url('assets/Frest/app-assets/images/pages/login.png'); ?>" alt="branding logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- forgot password ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url('assets/Frest/app-assets/vendors/js/vendors.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js'); ?>"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url('assets/Frest/app-assets/js/core/app-menu.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/js/core/app.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/js/scripts/components.js'); ?>"></script>
    <script src="<?php echo base_url('assets/Frest/app-assets/js/scripts/footer.js'); ?>"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?php echo base_url() . 'assets/plugins/jquery-validation' . '/' . 'jquery.validate' . '.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo base_url() . 'assets/plugins/jquery-validation' . '/localization/' . 'messages_vi' . '.js'; ?>" type="text/javascript"></script>
    <!-- END: Page JS-->
    <script type="text/javascript">
    $(document).ready(function() {
        $("#loginform").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
    </script>
</body>

</html>