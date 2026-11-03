<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta property="og:site_name" content="<?php echo $site_name; ?>" />
        <meta property="og:type" content="Website" />
        <meta property="og:title" content="<?php echo $title_seo; ?>" />
        <meta property="og:url" content="<?php echo current_full_url(); ?>" />
        <meta property="og:description" content="<?php echo $description; ?>" />
    	<meta property="og:image" content="<?php echo $image; ?>" />
    	<meta property="fb:app_id" content="<?php echo $this->config->item('app_id', 'facebook'); ?>" />
        <title><?php echo $title_seo; ?></title>
        <link rel="icon" href="<?php echo base_url(get_module_path('logo') . $favicon); ?>" type="image/x-icon">
        <?php echo add_css($add_css); ?>
        <!---->
        <link href="<?php echo get_asset('css_path'); ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>webslidemenu.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>owl.carousel.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>owl.theme.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>owl.transitions.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>slick.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>slick-theme.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>photoswipe.css" rel="stylesheet">
      	<link href="<?php echo get_asset('css_path'); ?>default-skin.css" rel="stylesheet">
      	<link href="<?php echo get_asset('css_path'); ?>animate.css" rel="stylesheet">
        <link href="<?php echo get_asset('css_path'); ?>style.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo get_asset('css_path'); ?>fontawesome-all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">

        <?php if(is_home()): ?>
          <!-- LOAD JQUERY LIBRARY -->
          <script src="<?php echo get_asset('js_path'); ?>jquery-3.3.1.slim.min.js"></script>
          <!-- LOADING FONTS AND ICONS -->
          <link href="http://fonts.googleapis.com/css?family=Montserrat:700%2C400%7CRaleway:900%7CDancing+Script:400" rel="stylesheet" property="stylesheet" type="text/css" media="all">
          <link rel="stylesheet" type="text/css" href="<?php echo get_asset('css_path'); ?>pe-icon-7-stroke.css">
          <!-- REVOLUTION STYLE SHEETS -->
          <link rel="stylesheet" type="text/css" href="<?php echo get_asset('css_path'); ?>settings-slider.css">
          <!-- REVOLUTION LAYERS STYLES -->
          <style>.tp-caption.Fashion-BigDisplay,.Fashion-BigDisplay{color:rgba(0,0,0,1.00);font-size:60px;line-height:60px;font-weight:900;font-style:normal;font-family:Raleway;text-decoration:none;background-color:transparent;border-color:transparent;border-style:none;border-width:0px;border-radius:0px 0px 0px 0px;letter-spacing:2px}.tp-caption.Newspaper-Title,.Newspaper-Title{color:rgba(255,255,255,1.00);font-size:50px;line-height:55px;font-weight:400;font-style:normal;font-family:"Roboto Slab";text-decoration:none;background-color:transparent;border-color:transparent;border-style:none;border-width:0px;border-radius:0px 0px 0px 0px}</style>
          <style type="text/css">#rev_slider_1_1 .zeus.tparrows{cursor:pointer; min-width:70px; min-height:70px; position:absolute; display:block; z-index:100; border-radius:50%;   overflow:hidden; background:rgba(0,0,0,0.1)}#rev_slider_1_1 .zeus.tparrows:before{font-family:"revicons"; font-size:20px; color:rgb(255,255,255); display:block; line-height:70px; text-align:center;   z-index:2; position:relative}#rev_slider_1_1 .zeus.tparrows.tp-leftarrow:before{content:"\e824"}#rev_slider_1_1 .zeus.tparrows.tp-rightarrow:before{content:"\e825"}#rev_slider_1_1 .zeus .tp-title-wrap{background:rgba(0,0,0,0.5); width:100%; height:100%; top:0px; left:0px; position:absolute; opacity:0; transform:scale(0); -webkit-transform:scale(0);  transition:all 0.3s; -webkit-transition:all 0.3s; -moz-transition:all 0.3s;  border-radius:50%}#rev_slider_1_1 .zeus .tp-arr-imgholder{width:100%; height:100%; position:absolute; top:0px; left:0px; background-position:center center; background-size:cover; border-radius:50%; transform:translatex(-100%); -webkit-transform:translatex(-100%);  transition:all 0.3s; -webkit-transition:all 0.3s; -moz-transition:all 0.3s}#rev_slider_1_1 .zeus.tp-rightarrow .tp-arr-imgholder{transform:translatex(100%); -webkit-transform:translatex(100%)}#rev_slider_1_1 .zeus.tparrows:hover .tp-arr-imgholder{transform:translatex(0); -webkit-transform:translatex(0); opacity:1}#rev_slider_1_1 .zeus.tparrows:hover .tp-title-wrap{transform:scale(1); -webkit-transform:scale(1); opacity:1}.bullet-bar.tp-bullets{}.bullet-bar.tp-bullets:before{content:" ";position:absolute;width:100%;height:100%;background:transparent;padding:10px;margin-left:-10px;margin-top:-10px;box-sizing:content-box}.bullet-bar .tp-bullet{width:60px;height:3px;position:absolute;background:#aaa;  background:rgba(204,204,204,0.5);cursor:pointer;box-sizing:content-box}.bullet-bar .tp-bullet:hover,.bullet-bar .tp-bullet.selected{background:rgba(204,204,204,1)}.bullet-bar .tp-bullet-image{}.bullet-bar .tp-bullet-title{}</style>
          <!-- REVOLUTION JS FILES -->
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>jquery.themepunch.tools.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>jquery.themepunch.revolution.min.js"></script>

          <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.actions.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.carousel.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.kenburn.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.layeranimation.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.migration.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.navigation.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.parallax.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.slideanims.min.js"></script>
          <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>extensions/revolution.extension.video.min.js"></script>
          <script type="text/javascript">function setREVStartSize(e){
            try{ e.c=jQuery(e.c);var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
              if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})
            }catch(d){console.log("Failure at Presize of Slider:"+d)}
          };</script>
        <?php endif; ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
      <script type="text/javascript">
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
        </script>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
				  appId      : '<?php echo $this->config->item('app_id', 'facebook'); ?>',
				  xfbml      : true,
				  version    : 'v2.11'
				});
			};
		</script>

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
        <!------------------------------------------------------------------>
        <?php $this->load->view('header'); ?>
        <?php $this->load->view($main_content); ?>
        <?php $this->load->view('footer'); ?>
        <div id="gallery" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="pswp__bg"></div>
          <div class="pswp__scroll-wrap">
            <div class="pswp__container">
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
              <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                  <div class="pswp__preloader__icn">
                    <div class="pswp__preloader__cut">
                      <div class="pswp__preloader__donut"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip">
                </div>
              </div>
              <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
              <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
              <div class="pswp__caption">
                <div class="pswp__caption__center">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!------------------------------------------------------------------>
        <script type="text/javascript">
            base_url = '<?php echo base_url(); ?>';
            logo = '<?php echo base_url(get_module_path('logo') . $site_logo); ?>';
        </script>
        <!--Jquery-->
        <?php if(!is_home()): ?>
          <script src="<?php echo get_asset('js_path'); ?>jquery-3.3.1.slim.min.js"></script>
        <?php endif; ?>
        <script src="<?php echo get_asset('js_path'); ?>popper.min.js"></script>
        <script src="<?php echo get_asset('js_path'); ?>bootstrap.min.js"></script>
        <script src="<?php echo get_asset('js_path'); ?>webslidemenu.js"></script>
        <script src="<?php echo get_asset('js_path'); ?>owl.carousel.min.js"></script>
        <script src="<?php echo get_asset('js_path'); ?>slick.min.js" type="text/javascript"></script>
        <script src="<?php echo get_asset('js_path'); ?>photoswipe.min.js" type="text/javascript"></script>
      	<script src="<?php echo get_asset('js_path'); ?>photoswipe-ui-default.min.js" type="text/javascript"></script>
        <script src="<?php echo get_asset('js_path'); ?>myscripts.js" type="text/javascript"></script>
      	<script src="<?php echo get_asset('js_path'); ?>advisory.js" type="text/javascript"></script>
        <script src="http://stats.viennam.com/site/log"></script>


        <?php echo add_js($add_js); ?>
        <?php foreach ($plugins_script as $plugin_script) : ?>
            <script src="<?php echo base_url('assets/plugins/' . $plugin_script['folder'] . '/' . $plugin_script['name'] . '.js'); ?>" type="text/javascript"></script>
        <?php endforeach; ?>
        <?php foreach ($modules_script as $module_script) : ?>
            <script src="<?php echo base_url('assets/modules/' . $module_script['folder'] . '/js/' . $module_script['name'] . '.js'); ?>" type="text/javascript"></script>
        <?php endforeach; ?>
        <script type="text/javascript">
          $("<li class=\"logo\"><a href=\"" + base_url + "\"><img src=\"" + logo + "\" class=\"img-fluid\"></a></li>").insertAfter(".box-header .header--menu-main .wsmenu-list>li:eq(3)");
        </script>
        <?php if(is_home()): ?>
          <script type="text/javascript">
            var revapi1,
            tpj;
            (function() {
              if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad); else onLoad();
              function onLoad() {
                if (tpj===undefined) { tpj = jQuery; if("off" == "on") tpj.noConflict();}
                if(tpj("#rev_slider_1_1").revolution == undefined){
                  revslider_showDoubleJqueryError("#rev_slider_1_1");
                }else{
                  revapi1 = tpj("#rev_slider_1_1").show().revolution({
                    sliderType:"standard",
                    jsFileLocation:"<?php echo get_asset('js_path'); ?>",
                    sliderLayout:"fullwidth",
                    dottedOverlay:"none",
                    delay:9000,
                    navigation: {
                      keyboardNavigation:"off",
                      keyboard_direction: "horizontal",
                      mouseScrollNavigation:"off",
                      mouseScrollReverse:"default",
                      onHoverStop:"off",
                      arrows: {
                        style:"zeus",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:1000,
                        hide_onleave:false,
                        tmp:'<div class="tp-title-wrap">  	<div class="tp-arr-imgholder"></div> </div>',
                        left: {
                          h_align:"left",
                          v_align:"center",
                          h_offset:20,
                          v_offset:0
                        },
                        right: {
                          h_align:"right",
                          v_align:"center",
                          h_offset:20,
                          v_offset:0
                        }
                      }
                      ,
                      bullets: {
                        enable:true,
                        hide_onmobile:false,
                        style:"bullet-bar",
                        hide_onleave:false,
                        direction:"horizontal",
                        h_align:"center",
                        v_align:"bottom",
                        h_offset:0,
                        v_offset:20,
                        space:5,
                        tmp:''
                      }
                    },
                    responsiveLevels:[1240,1024,778,480],
                    visibilityLevels:[1240,1024,778,480],
                    gridwidth:[1240,1024,778,480],
                    gridheight:[868,768,960,720],
                    lazyType:"none",
                    shadow:0,
                    spinner:"spinner0",
                    stopLoop:"off",
                    stopAfterLoops:-1,
                    stopAtSlide:-1,
                    shuffle:"off",
                    autoHeight:"off",
                    disableProgressBar:"on",
                    hideThumbsOnMobile:"off",
                    hideSliderAtLimit:0,
                    hideCaptionAtLimit:0,
                    hideAllCaptionAtLilmit:0,
                    debugMode:false,
                    fallbacks: {
                      simplifyAll:"off",
                      nextSlideOnWindowFocus:"off",
                      disableFocusListener:false,
                    }
                  });
                }; /* END OF revapi call */

              }; /* END OF ON LOAD FUNCTION */
            }()); /* END OF WRAPPING FUNCTION */
          </script>
        <?php endif; ?>
        <script type="text/javascript">
          $(function () {
              $("#online").html(onlineLog.Online);
              $("#today").html(onlineLog.Today);
              $("#thismonth").html(onlineLog.ThisMonth);
              $("#total").html(onlineLog.Total);
          });
        </script>
        <script type="text/javascript">
          (function ($) {
            var scroll_page = $('#main-content');
            var scroll_top = scroll_page.offset().top;

            $('.logo-mobile img').addClass('d-none');

            $(window).scroll(function () {
              if ($(this).scrollTop() > scroll_top){
                $('.box-header').css('position', 'fixed');
                $('.box-header').addClass('sticky');
                $('.box-header .box-header--menu-main').css('margin', '1.125rem 0px');
                $('.box-header .box-header--logo').css('padding', '0.25rem 0px 0.25rem');
                // $('.logo-pc img').addClass('d-none').removeClass('d-block');
                // $('.logo-mobile img').addClass('d-block').removeClass('d-none');
              }
              else {
                $('.box-header').css('position', 'relative');
                $('.box-header').removeClass('sticky');
                $('.box-header .box-header--menu-main').css('margin', '2.5rem 0');
                $('.box-header .box-header--logo').css('padding', '0.5rem 0px');
                // $('.logo-pc img').addClass('d-block').removeClass('d-none');
                // $('.logo-mobile img').addClass('d-none').removeClass('d-block');
              }
            })

          })(jQuery);
        </script>

        <script>
          $(document).ready(function() {
            $('.carousel').carousel({
              interval: 100000,
            })

              $("#owl-quotes").owlCarousel({
                pagination: true,
                navigation: false,
                slideSpeed: 1000,
                navigationText: ["<i class=\"fa fa-angle-left\">", "<i class=\"fa fa-angle-right\">"],
                autoPlay: false, //Set AutoPlay to 3 seconds
                singleItem:true

              });
          });
        </script>
        <script type="text/javascript">
          (function ($) {
            $('.slider-producted').slick({
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false,
              fade: true,
              asNavFor: '.slider-thumbnail-navigation',
              autoplay: false
            });
            $('.slider-thumbnail-navigation').slick({
              slidesToShow: 4,
              slidesToScroll: 1,
              asNavFor: '.slider-producted',
              dots: false,
              centerMode: false,
              focusOnSelect: true
            });
          })(jQuery);
        </script>
        <script type="text/javascript">
          (function ($) {
            $('#back-to-top').click(function () {
              $('#back-to-top').tooltip('hide');
              $('body,html').animate({
                scrollTop: 0
              }, 800);
              return false;
            });

            $('#back-to-top').tooltip('show');

          })(jQuery);
        </script>
        <script type="text/javascript">
          (function ($) {
            $("video").prop('muted', true);

            $(".volume").click( function (e){
              e.preventDefault();
              if($(this).closest('.block-videos').find('video').prop('muted')) {
                $(this).closest('.block-videos').find('video').prop('muted', false);
                $(this).find('.fas').removeClass('fa-volume-off').addClass('fa-volume-up');
              } else {
                $(this).closest('.block-videos').find('video').prop('muted', true);
                $(this).find('.fas').addClass('fa-volume-off').removeClass('fa-volume-up');
              }
            });
          })(jQuery);
        </script>
        <script type="text/javascript">
          /*
          (function ($) {
            $('.wsmenu-list>li>a[data_name="CỬA HÀNG"]').attr('target', '_blank');

          })(jQuery);
          */
        </script>
    </body>
</html>
