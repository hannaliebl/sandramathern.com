<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

// --------------------- START DEBUGGING
if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}
// -------------------- END DEBUGGING

// Register the jQuery plugin I made for the front page slideshow

wp_register_script( 'jQuerySlider',
                    get_template_directory_uri() . "/js/jQuerySlider.js",
                    array("jquery")); 

// Enable categories for attachments so that they can be queried for the 
// front-page slideshow
add_action('admin_init', 'reg_tax');
function reg_tax() {
   register_taxonomy_for_object_type('category', 'attachment');
   add_post_type_support('attachment', 'category');
}

// include the media integration functions and libraries
// include the functions related to custom post types 'work', 'show', 'award'
include(get_template_directory() . "/functions/works.php");
include(get_template_directory() . "/functions/media_integration.php");
include(get_template_directory() . "/functions/phpFlickr/phpFlickr.php");

// Custom HTML5 Comment Markup
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

automatic_feed_links();

// Widgetized Sidebar HTML5 Markup
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<section>',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"] = get_bloginfo('template_url')."/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative($GLOBALS["TEMPLATE_URL"]);

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
  echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript($relative_url, $add_attributes=""){
  echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource($relative_url){
  $file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
  $file_version = "";

  if(file_exists($file)) {
    $file_version = "?v=".filemtime($file);
  }

  return $relative_url.$file_version;
}

/* Add footer menu and main menu support as well as a custom nav walker
 * for the footer menu
 * */

function registerMenus () {
  register_nav_menus( array(
    'nav-main' => __( 'Top menu' ), 
    'nav-footer' => __( 'Footer Navigation' ) 
  ));
}
add_action('init','registerMenus');

// declare a global javascript variable for the url to the php file that handles ajax requests
wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

// add a second editor box to the about template edit page so that 
add_action('edit_page_form','add_second_metabox_about');
function add_second_metabox_about(){
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
  if ($template_file == 'about.php') 
    wp_editor(get_post_meta($post->ID,'biography'),'biography');
}

// save the about page biography box
add_action('save_post','save_about_data');
function save_about_data( $post ) {
  $template_file = get_post_meta($post->ID,'_wp_page_template',TRUE);
  if ( $template_file == 'about.php') 
    update_post_meta($post->ID, 'biography', $_POST['biography']);
}

// Remove the ability to add edit posts from the admin menu
// as we do not use the basic "post" post type
function remove_admin_menu_blog () {
  // with WP 3.1 and higher
  if ( function_exists( 'remove_menu_page' ) ) {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
  } 
}
add_action( 'admin_menu', 'remove_admin_menu_blog' );

// Utility function for removing an element from an array. 
// Removes the first element of the array whose value is given
// Returns the modified array
// @param int $val - the value of the element to remove
// @param array &$array - an array to remove the element from
// Modified from: http://webit.ca/2011/08/php-array_remove/
function array_remove($val, &$array) {
  foreach ($array as $i => $v) {
    if ($val == $v){
      unset($array[$i]);
      return array_merge($array);
    }
  }
}

// register scripts/styles
function register_custom_scripts_styles(){
  // Use a month picker for the work edit page. Credit to: 
  // http://lucianocosta.info/jquery.mtz.monthpicker/
  wp_register_script(
    'monthpicker',
    get_template_directory_uri() . '/js/jquery.mtz.monthpicker.js',
    array('jquery')
  );
}
add_action('init','register_custom_scripts_styles');