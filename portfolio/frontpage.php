<?php
/*
Template Name: frontpage
*/
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        
        <!-- Google Webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400' rel='stylesheet' type='text/css'>    
        
        <?php if (is_front_page() || (get_post_type() == 'page' && has_post_thumbnail())) {
            wp_enqueue_script('jQuerySlider');
          } ?>
        
        <!-- Stylesheets -->
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/normalize.css") ?>
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/ie.css") ?>
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/style.css") ?>
    
        <!-- Wordpress Templates require a style.css in theme root directory -->
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."style.css") ?>
        
        <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
        <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."js/vendor/modernizr-2.6.1.min.js") ?>
        
         <?php wp_head(); ?>
        
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
     <!--  <div id="home-container"> -->
        <div id="home-bg">
        
        
         <?php
    if (is_front_page()) {
      $term = \get_term_by('name', 'frontpage', 'category');
      $attachments = get_posts(array(
              'category' => $term->term_id,
              'post_type' => 'attachment',
            ));
      $bgimages = array();
      foreach ($attachments as $bgimage) {
        $img_url = wp_get_attachment_image_src($bgimage->ID,'full');
        array_push($bgimages, $img_url[0]);
      }
      echo "<script>(function ($) {
              $('#home-bg').jQuerySlider({images:Array('" . implode("','",$bgimages) . "'),".
                                               "interval:8000,".
                                               "duration:1200});".
                    "})(jQuery);".
          "</script>";
    } 
    else if (get_post_type() == 'page' && has_post_thumbnail()) {
      $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
      echo "<script>(function ($) {".
                      "$('#home-bg').jQuerySlider({images:Array('" . $img_url[0] . "'),".
                                               "interval:8000,".
                                               "duration:1200});".
                    "})(jQuery);".
          "</script>";
    } else {
      echo "<style> #home-bg {background: black}</style>";
    }
    
    ?>
        
          <div class="container">
          	<header class="homepage">
            	<nav class="row">
              		<div class="twelvecol">
              
              
              <?php 
          wp_nav_menu(
            array(
              'theme_location'	=> 'nav-main',
              'menu_class'			=> 'menu',
              'depth'						=> '1'
            )
          );
        ?>
              </div>
            </nav>
       
            
              <div class="twelvecol">
                <h1>Sandra Mathern</h1>
              </div>
              </header>
            <div class="frontpage-row">
              <div class="threecol">
                <span class="tagline">Dance Artist</span>
              </div>
              <div class="threecol">
                <span class="tagline">Performer</span>
              </div>
              <div class="threecol">
                <span class="tagline">Improviser</span>
              </div>
              <div class="threecol last">
                <span class="tagline">Teacher</span>
              </div>
                </div>
                
            </header>
      
          <footer class="container" id="homefooter">
            <div class="row">
              <div class="twelvecol">
                <p>Photography by  Christian Faur<br />
                  Development by <a href="http://coding-contemplation.blogspot.com/">Cyrus Smith</a>, Design by <a href="http://www.hannaliebl.com">Hanna Liebl</a><br />
                   &copy <?php echo date("Y") ?></p>
              </div>
            </div>
          </footer>
          </div>
        </div>
      

        
     <!--  </div> -->
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
        <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."js/plugins.js") ?>
        <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."js/main.js") ?>

    </body>
</html>



