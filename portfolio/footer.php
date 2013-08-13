<?php
/**
 * @package WordPress
 * @subpackage portfolio
 */
?>

<footer id="mainfooter" class="container">
          <div class="row">
            <div class="sixcol">

              <?php 
          wp_nav_menu(
            array(
              'theme_location'  => 'nav-footer',
              'menu_class'      => 'menu-footer',
              'depth'           => '1'
            )
          );
        ?>

              <p class="clear"><a href="mailto:mathern@denison.edu">Email Sandra</a></p>
            </div>
            <div class="sixcol last">
        <p class="credit">Photography by  Christian Faur<br />
        Development by <a href="http://coding-contemplation.blogspot.com/">Cyrus Smith</a>, Design by <a href="http://www.hannaliebl.com">Hanna Liebl</a><br />
        &copy <?php echo date("Y") ?></p>
            </div>
          </div>
        </footer>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
