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
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
																<!-- left section-login -->
																<div class="col-md-6 col-12 px-0">
																		<div class="card custom-card disable-rounded-right mb-0 h-100 d-flex">
																				<div class="box-user">
																						<div class="block-user-header">
																								<ul>
																										<li><a class="active" href="<?php echo site_url(); ?>">Đăng Nhập</a></li>
																										<li><a href="<?php echo site_url('dang-ky'); ?>">Đăng Ký</a></li>
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
																												<form id="f-login" action="<?php echo base_url(); ?>" method="post">
																														<fieldset class="form-group form-group--el position-relative">
																																<?php $username = (set_value('username') != '' ? set_value('username') : ''); ?>
																																<input type="text" class="form-control<?php echo form_error('username') != '' ? ' is-invalid' : ''; ?>" name="username" id="username" value="<?php echo $username; ?>" placeholder="Tên đăng nhập...">
																																<div class="form-control-position">
																																		<i class="bx bx-envelope"></i>
																																</div>
																																<?php echo form_error('username'); ?>
																														</fieldset>
																														<fieldset class="form-group form-group--ellast position-relative">
																																<input type="password" class="form-control<?php echo form_error('password') != '' ? ' is-invalid' : ''; ?>" name="password" id="password" placeholder="Mật khẩu">
																																<div class="form-control-position">
																																		<i class="bx bx-show"></i>
																																</div>
																																<?php echo form_error('password'); ?>
																														</fieldset>
																														<div class="form-group d-flex flex-md-row justify-content-between flex-column align-items-center">
																																<div class="text-left">
																																		<div class="checkbox checkbox-sm">
																																				<input type="checkbox" class="form-check-input" id="login-remember" name="remember" value="1">
																																				<label class="checkboxsmall" for="login-remember"><small>Duy trì đăng nhập</small></label>
																																		</div>
																																		<a href="<?php echo site_url('quen-mat-khau'); ?>" class="forgot-password-link card-link"><small>Quên mật khẩu?</small></a>
																																</div>
																																<button type="submit" class="btn btn-outline-secondary glow position-relative">Đăng nhập</button>
																														</div>
																												</form>
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
																
																
                                <!--
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">Đăng Nhập</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <?php $this->load->view('view_notify'); ?>
                                                    </div>
                                                </div>
                                                <form id="f-login" action="<?php echo base_url(); ?>" method="post">
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600" for="username">Tên đăng nhập</label>
                                                        <?php $username = (set_value('username') != '' ? set_value('username') : ''); ?>
                                                        <input type="text" class="form-control<?php echo form_error('username') != '' ? ' is-invalid' : ''; ?>" name="username" value="<?php echo $username; ?>" placeholder="Tên đăng nhập...">
                                                        <?php echo form_error('username'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-bold-600" for="password">Mật khẩu</label>
                                                        <input type="password" class="form-control<?php echo form_error('password') != '' ? ' is-invalid' : ''; ?>" name="password" placeholder="********">
                                                        <?php echo form_error('password'); ?>
                                                    </div>
                                                    <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <div class="checkbox checkbox-sm">
                                                                <input type="checkbox" class="form-check-input" id="login-remember" name="remember" value="1">
                                                                <label class="checkboxsmall" for="login-remember"><small>Duy trì đăng nhập</small></label>
                                                            </div>
                                                        </div>
                                                        <div class="text-right"><a href="auth-forgot-password.html" class="card-link"><small>Quên mật khẩu?</small></a></div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary glow w-100 position-relative">Đăng nhập<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                </form>
                                                <hr>
                                                <div class="text-center"><small class="mr-25">Bạn đã có tài khoản chưa?</small><a href="<?php echo site_url('dang-ky'); ?>"><small>Đăng ký</small></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <div class="card-content">
                                        <img class="img-fluid" src="<?php echo base_url('assets/Frest/app-assets/images/pages/login.png'); ?>" alt="branding logo">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->
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
        $("#f-login").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: 'Nhập tên đăng nhập'
                },
                password: {
                    required: 'Nhập mật khẩu'
                }
            },
            highlight: function(element) {
								$(element).removeClass('is-valid').addClass('is-invalid');
						},
						unhighlight: function(element) {
								$(element).removeClass('is-invalid').addClass('is-valid');
						},
						errorElement: 'div',
						errorClass: 'invalid-feedback',
						errorPlacement: function(error, element) {
								if (element.parent('.form-control-position').length) {
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