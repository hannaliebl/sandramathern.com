<?php
/**
 * @package WordPress
 * @subpackage portfolio
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
        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?> – <?php the_title(); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        
        <!-- Google Webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400' rel='stylesheet' type='text/css'> 
        
        <!-- Stylesheets -->
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/normalize.css") ?>
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/ie.css") ?>
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."css/style.css") ?>
    
        <!-- Wordpress Templates require a style.css in theme root directory -->
        <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."style.css") ?>
        
        <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
        <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/vendor/modernizr-2.6.1.min.js") ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
<div id="works-container"> 
	<header class="container">
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
        		<h1>Sandra Mathern</h1>
              </div>
            </nav>
		<div class="row">
        	<div class="twelvecol">
        		<h2><?php the_title(); ?></h2>
        	</div>
        </div>