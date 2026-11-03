<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo $title; ?></title>
        <!-- Favicons Icon -->
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <!-- Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- CSS Style -->

        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/style.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/revslider.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/owl.theme.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() . 'assets' . '/'; ?>css/font-awesome.css" type="text/css">
        <!-- Google Fonts -->
        <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>-->
        <?php foreach ($all_css as $css) : ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/' . $css['name'] . '.css'); ?>" />
        <?php endforeach; ?>

        <?php
        foreach ($plugins_css as $plugin_css) {
            ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/plugins/' . $plugin_css['folder'] . '/' . $plugin_css['name'] . '.css'); ?>" />
            <?php
        }
        foreach ($modules_css as $module_css) {
            ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/modules/' . $module_css['folder'] . '/css/' . $module_css['name'] . '.css'); ?>" />
            <?php
        }
        ?>
        <!-- Begin GA code -->
        <script type="text/javascript">
            /*
             (function (i, s, o, g, r, a, m) {
             i['GoogleAnalyticsObject'] = r;
             i[r] = i[r] || function () {
             (i[r].q = i[r].q || []).push(arguments)
             }, i[r].l = 1 * new Date();
             a = s.createElement(o),
             m = s.getElementsByTagName(o)[0];
             a.async = 1;
             a.src = g;
             m.parentNode.insertBefore(a, m)
             })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
             
             ga('create', '<?php echo $analytics_UA_code; ?>', 'auto');
             ga('send', 'pageview');
             */
        </script>
        <!-- End GA code -->
    </head>
    <body class="cms-index-index">
        <div class="page">
            <!-- Header -->
            <?php $this->load->view('header'); ?>
            <!-- #End Header --> 

            <!-- Navbar -->
            <?php $this->load->view('navbar'); ?>            
            <!-- End Navbar -->            

            <!-- main container -->
            <?php $this->load->view($main_content); ?>            
            <!-- End main container -->

            <!-- Footer -->
            <?php $this->load->view('footer'); ?>             
            <!-- End Footer --> 
        </div>
        <div class="social">
            <ul>
                <li class="fb"><a href="#"></a></li>
                <li class="tw"><a href="#"></a></li>
                <li class="googleplus"><a href="#"></a></li>
                <li class="rss"><a href="#"></a></li>
                <li class="pintrest"><a href="#"></a></li>
                <li class="linkedin"><a href="#"></a></li>
                <li class="youtube"><a href="#"></a></li>
            </ul>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Đổi avatar</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img src="<?php echo $path_img . 'pool.jpg'; ?>" id="cropbox" />
                        </p>
                        
                        <p>
                        <form action="" method="post" id="f_crop_image">
                            <input type="hidden" id="x" name="x" />
                            <input type="hidden" id="y" name="y" />
                            <input type="hidden" id="w" name="w" />
                            <input type="hidden" id="h" name="h" />
                            <input type="submit" value="Cắt ảnh" class="btn btn-primary" />
                        </form>
                        </p>

                        <p>
                            <img id="blah" src="#" alt="" />
                        </p>                        
                        <br> 
                        <div id=imgPrev>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            base_url = '<?php echo base_url(); ?>';
        </script>        
        <?php
        foreach ($all_script as $script) {
            ?>
            <script src="<?php echo base_url('assets/js/' . $script['name'] . '.js'); ?>" type="text/javascript"></script>
            <?php
        }
        foreach ($plugins_script as $plugin_script) {
            ?>
            <script src="<?php echo base_url('assets/plugins/' . $plugin_script['folder'] . '/' . $plugin_script['name'] . '.js'); ?>" type="text/javascript"></script>
            <?php
        }
        foreach ($modules_script as $module_script) {
            ?>
            <script src="<?php echo base_url() . 'assets/modules/' . $module_script['folder'] . '/js/' . $module_script['name'] . '.js'; ?>" type="text/javascript"></script>
            <?php
        }
        ?>
<!--        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/common.js"></script> 
<script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/revslider.js"></script> 
<script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/owl.carousel.min.js"></script>-->

        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/parallax.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/cloudzoom.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/common.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . 'assets' . '/'; ?>js/owl.carousel.min.js"></script>
    </body>
</html>
