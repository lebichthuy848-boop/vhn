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
                <!-- register section starts -->
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-10">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- register section left -->
																<div class="col-md-6 col-12 px-0">
																		<div class="card custom-card disable-rounded-right mb-0 h-100 d-flex">
																				<div class="box-user">
																						<div class="block-user-header">
																								<ul>
																										<li><a href="<?php echo site_url(); ?>">Đăng Nhập</a></li>
																										<li><a class="active" href="<?php echo site_url('dang-ky'); ?>">Đăng Ký</a></li>
																								</ul>
																						</div>
																						<div class="note-register">
																								<p>Vui lòng nhập thông tin của bạn để đăng ký và là một phần của công ty <strong>VHN 360</strong> của chúng tôi</p>
																						</div>
																						<div class="block-user-content">
																								<div class="card-content">
																										<div class="row">
																												<div class="col-lg-12">
																														<?php $this->load->view('view_notify'); ?>
																												</div>
																										</div>
																										<form id="f-register" action="<?php echo site_url('dang-ky'); ?>" method="post">
																												<div class="form-group form-group--el">
																														<input type="text" class="form-control<?php echo form_error('full_name') != '' ? ' is-invalid' : ''; ?>" name="full_name" placeholder="Họ tên">
																														<?php echo form_error('full_name'); ?>
																												</div>
																												<div class="form-group form-group--el">
																														<input type="text" class="form-control<?php echo form_error('username') != '' ? ' is-invalid' : ''; ?>" name="username" id="username" placeholder="Tên đăng nhập">
																														<?php echo form_error('username'); ?>
																												</div>
																												<div class="form-group form-group--el">
																														<input type="email" class="form-control<?php echo form_error('email') != '' ? ' is-invalid' : ''; ?>" name="email" id="email" placeholder="Địa chỉ Email">
																														<?php echo form_error('email'); ?>
																												</div>
																												<div class="form-row custom-form-row-2-collum">
																														<div class="col-md-6 px-0 line-collum-right">
																																<input type="password" class="form-control<?php echo form_error('password') != '' ? ' is-invalid' : ''; ?>" name="password" id="password" placeholder="Mật khẩu">
																																<?php echo form_error('password'); ?>
																														</div>
																														<div class="col-md-6 px-0">
																																<input type="password" class="form-control<?php echo form_error('passconf') != '' ? ' is-invalid' : ''; ?>" name="passconf" placeholder="Nhập lại mật khẩu">
																																<?php echo form_error('passconf'); ?>
																														</div>
																												</div>
																												<?php $is_ref = isset($ref) && (trim($ref) != ''); ?>
																												<div class="form-group form-group--ellast">
																														<input type="text" class="form-control" name="ref" value="<?php echo $is_ref ? $ref : ''; ?>"<?php echo $is_ref ? ' readonly="readonly"' : ''; ?> placeholder="Mã giới thiệu">
																														<?php echo form_error('reference'); ?>
																												</div>
																												<div class="d-flex justify-content-end">
																													<button type="submit" class="btn btn-outline-secondary glow position-relative">Đăng ký</button>
																												</div>
																										</form>
																								</div>
																						</div>
																				</div>
																		</div>
																</div>
																<!-- right section image -->
																<div class="col-md-6 d-md-block d-none text-center align-self-center px-0">
																		<div class="card-content">
																				<img class="img-fluid h-100 w-100" src="<?php echo base_url('assets/Frest/app-assets/images/pages/login.png'); ?>" alt="branding logo">
																		</div>
																</div>
																
																
																<!-- 
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">Đăng ký</h4>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p> <small> Vui lòng nhập thông tin của bạn để đăng ký và là một phần của công ty tuyệt vời của chúng tôi</small>
                                            </p>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <?php $this->load->view('view_notify'); ?>
                                                    </div>
                                                </div>
                                                <form id="f-register" action="<?php echo site_url('dang-ky'); ?>" method="post">
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600">Họ tên</label>
                                                        <input type="text" class="form-control<?php echo form_error('full_name') != '' ? ' is-invalid' : ''; ?>" name="full_name" placeholder="Họ tên">
                                                        <?php echo form_error('full_name'); ?>
                                                    </div>
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600">Tên đăng nhập</label>
                                                        <input type="text" class="form-control<?php echo form_error('username') != '' ? ' is-invalid' : ''; ?>" name="username" id="username" placeholder="Tên đăng nhập">
                                                        <?php echo form_error('username'); ?>
                                                    </div>
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600">Địa chị email</label>
                                                        <input type="email" class="form-control<?php echo form_error('email') != '' ? ' is-invalid' : ''; ?>" name="email" id="email" placeholder="Địa chỉ Email">
                                                        <?php echo form_error('email'); ?>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600">Mật khẩu</label>
                                                            <input type="password" class="form-control<?php echo form_error('password') != '' ? ' is-invalid' : ''; ?>" name="password" id="password" placeholder="Mật khẩu">
                                                            <?php echo form_error('password'); ?>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600">Nhập lại mật khẩu</label>
                                                            <input type="password" class="form-control<?php echo form_error('passconf') != '' ? ' is-invalid' : ''; ?>" name="passconf" placeholder="Nhập lại mật khẩu">
                                                            <?php echo form_error('passconf'); ?>
                                                        </div>
                                                    </div>
                                                    <?php $is_ref = isset($ref) && (trim($ref) != ''); ?>
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600">Người giới thiệu</label>
                                                        <input type="text" class="form-control" name="ref" value="<?php echo $is_ref ? $ref : ''; ?>"<?php echo $is_ref ? ' readonly="readonly"' : ''; ?> placeholder="Nhập mã giới thiệu">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary glow position-relative w-100">Đăng ký <i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                </form>
                                                <hr>
                                                <div class="text-center"><small class="mr-25">Bạn đã có tài khoản rồi?</small><a href="<?php echo site_url(); ?>"><small>Đăng nhập</small> </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
																
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="<?php echo base_url('assets/Frest/app-assets/images/pages/register.png'); ?>" alt="branding logo">
                                </div> -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- register section endss -->
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
        base_url = '<?php echo base_url(); ?>';
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.addMethod("usernameCheck", function() {
            var isSuccess = false;
            var username = $('#username').val();
            var strURL = base_url + 'users/check_username_availablity';
            var data = {'username': username, 'ajax': 1};
            $.ajax({
                url: strURL,
                type: 'POST',
                async: false,
                data: data,
                success: function(response) {
                    var getData = $.parseJSON(response);
                    if (getData.status === 'success') {
                        isSuccess = true;
                    }
                }
            });
            return isSuccess;
        }, 'Tên đăng nhập này đã có người sử dụng');

        jQuery.validator.addMethod("useremailCheck", function() {
            var isSuccess = false;
            var email = $('#email').val();
            var strURL = base_url + 'users/check_email_availablity';
            var data = {'email': email, 'ajax': 1};
            $.ajax({
                url: strURL,
                type: 'POST',
                async: false,
                data: data,
                success: function(response) {
                    var getData = $.parseJSON(response);
                    if (getData.status === 'success') {
                        isSuccess = true;
                    }
                }
            });
            return isSuccess;
        }, 'Email này đã có người sử dụng');

        $("#f-register").validate({
            rules: {
                full_name: {
                    required: true
                },
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 32,
                    usernameCheck: true
                },
                email: {
                    required: true,
                    email: true,
                    useremailCheck: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                passconf: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
								ref: {
                    required: true
                },
            },
            messages: {
                full_name: {
                    required: 'Nhập họ tên'
                },
                username: {
                    required: 'Nhập tên đăng nhập'
                },
                email: {
                    required: 'Nhập địa chỉ email',
                    email: 'Nhập đúng định dạng email'
                },
                password: {
                    required: 'Nhập mật khẩu'
                },
                passconf: {
                    required: 'Nhập mật khẩu lặp lại'
                },
								ref: {
                    required: 'Nhập mã giới thiệu'
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