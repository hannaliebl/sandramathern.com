<?php
/**
 * @package WordPress
 */
/*  By Cyrus Smith (http://coding-contemplation.blogspot.com/)
  	works.php adds functionality for adding "work" a custom post-type as well as
  	"show" and "award" all of which are interconnected. 
*/

// add the 'work', 'show', and 'award' post-types
function add_custom_post_types() {
  $labels = array(
    'name' => _x('Works', 'post type general name'),
    'singular_name' => _x('Work', 'post type singular name'),
    'add_new' => _x('Add New', 'work'),
    'add_new_item' => __('Add New Work'),
    'edit_item' => __('Edit Work'),
    'new_item' => __('New Work'),
    'all_items' => __('All Works'),
    'view_item' => __('View Work'),
    'search_items' => __('Search Works'),
    'not_found' =>  __('No Works found'),
    'not_found_in_trash' => __('No Works found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => __('Works')
  );
  
  $supports = array( 'title', 'editor', 'thumbnail' );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_nav_menus' => false,
    'show_in_menu' => true, 
    'show_in_admin_bar' => true,
    'menu_position' => null, // This defaults to below comments ( 60 > , < 25)
    // 'menu_icon' => 'url to icon for this menu'
    'hierarchical' => false,
    'supports' => $supports,
    'query_var' => true,
    'register_meta_box_cb' => 'works_meta_boxes'
  ); 
  
  /* The 'work' post-type will have the following fields:
   * title - title of the work
   * item_date - a date for comparison (inputted as month year, stored as unix timestamp)
   * editor - description of the work
   * related_awards - the associated award(s) for this work (stored as an array of post ids)
   * related_shows - the associated show(s) for this work (stored as an array of post ids)
   */
  register_post_type('work',$args);

  $labels = array(
    'name' => _x('Shows', 'post type general name'),
    'singular_name' => _x('Show', 'post type singular name'),
    'add_new' => _x('Add New', 'show'),
    'add_new_item' => __('Add New Show'),
    'edit_item' => __('Edit Show'),
    'new_item' => __('New Show'),
    'all_items' => __('All Shows'),
    'view_item' => __('View Show'),
    'search_items' => __('Search Shows'),
    'not_found' =>  __('No Shows found'),
    'not_found_in_trash' => __('No Shows found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => __('Shows')
  );
  
  $supports = array('editor');
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_nav_menus' => false,
    'show_in_menu' => true, 
    'show_in_admin_bar' => true,
    'menu_position' => null, // This defaults to below comments ( 60 > , < 25)
    // 'menu_icon' => 'url to icon for this menu'
    'hierarchical' => false,
    'supports' => $supports,
    'query_var' => true,
    'register_meta_box_cb' => 'shows_meta_boxes'
  ); 	

  /* The 'show' post-type will have the following fields:
   * item_date - a date range array of two values (end, start)
   * editor - html string to display as the location (with link to venue)
   * related_works - the associated work(s) for this show (stored as an array of post ids)
   */
  register_post_type('show',$args);

  $labels = array(
    'name' => _x('Awards', 'post type general name'),
    'singular_name' => _x('Award', 'post type singular name'),
    'add_new' => _x('Add New', 'award'),
    'add_new_item' => __('Add New Award'),
    'edit_item' => __('Edit Award'),
    'new_item' => __('New Award'),
    'all_items' => __('All Awards'),
    'view_item' => __('View Award'),
    'search_items' => __('Search Awards'),
    'not_found' =>  __('No Awards found'),
    'not_found_in_trash' => __('No Awards found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => __('Awards')
  );
  
  $supports = array( 'title', 'editor');
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_nav_menus' => false,
    'show_in_menu' => true, 
    'show_in_admin_bar' => true,
    'menu_position' => null, // This defaults to below comments ( 60 > , < 25)
    // 'menu_icon' => 'url to icon for this menu'
    'hierarchical' => false,
    'supports' => $supports,
    'query_var' => true,
    'register_meta_box_cb' => 'awards_meta_boxes'
  ); 
  
  /* The 'award' post-type will have the following fields:
   * title - the name of the award
   * item_date - the date the accolade was awarded, stored as unix timestamp
   * editor - brief description of the award (with links to associated web presence)
   * related_works - the associated work(s) for this award (stored as an array of post ids)
   */
  register_post_type('award',$args);
}
add_action('init','add_custom_post_types');

/* Add jQuery UI datepicker support when editing 'work', 'show', and 'award' posts.
 */
function edit_custom_post_scripts() {
  global $pagenow, $typenow, $wp_scripts;
  if ( $pagenow=='edit.php' || $pagenow == 'post-new.php') {
    if ( $typenow == 'work' ) { 
      wp_enqueue_script('jquery');
      $ui = $wp_scripts->query('jquery-ui-core');
      $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/base/jquery-ui.css";
      wp_enqueue_style('jqueryuicss', $url, false, $url->ver);
      wp_enqueue_script('monthpicker',array('jquery'));
    } 
    if ($typenow == 'show' || $typenow == 'award') {
      wp_enqueue_script('jquery');
      $ui = $wp_scripts->query('jquery-ui-core');
      $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/base/jquery-ui.css";
      wp_enqueue_style('jqueryuicss', $url, false, $url->ver);
      wp_enqueue_script('jquery-ui-datepicker',array('jquery'));
    }
  }
}
add_action('admin_enqueue_scripts','edit_custom_post_scripts');

/* Utility function used to initialize the meta boxes on the 
 * "work" post-type administrative edit page
 */
function works_meta_boxes() {
  add_meta_box(
    'item_date',
    __('Date of Work'),
    'add_date_loc_of_item',
    'work',
    'side'
  );
  add_meta_box( 
    'related_events',
    __( 'Related Awards and Shows' ),
    'add_related_events',
    'work',
    'normal'
  );
  add_meta_box( 
    'related_media',
    __( 'Related Media' ),
    'add_related_media',
    'work',
    'side'
  );
}

/* Utility function used to initialize the meta boxes on the 
 * "show" post-type administrative edit page
 */
function shows_meta_boxes(){
  add_meta_box( 
    'show_works',
    __( 'Related Works' ),
    'add_related_works',
    'show',
    'normal'
  );
  add_meta_box(
    'item_date',
    __('Show\'s Date(s)'),
    'add_date_loc_of_item',
    'show',
    'side'
  );
}

/* Utility function used to initialize the meta boxes on the 
 * "award" post-type administrative edit page
 */
function awards_meta_boxes(){
  add_meta_box( 
    'award_works',
    __( 'Related Works' ),
    'add_related_works',
    'award',
    'normal'
  );
  add_meta_box(
    'item_date',
    __('Date of Award'),
    'add_date_loc_of_item',
    'award',
    'side'
  );
}

function admin_footer_scripts() {
  global $post;
  switch (get_post_type($post->ID)) {
    case "work":
      echo "<script type='text/javascript'>
            (function($) {
                $('#work-datepicker').monthpicker( {
                    pattern: 'yyyy-mm'
                });
            })(jQuery);
            </script>";
      break;
    case "show":
      echo "<script type='text/javascript'>
              (function($) {
                  $('#show-datepicker-from').datepicker( {
                      changeMonth: true,
                      changeYear: true,
                      showButtonPanel: true,
                      dateFormat: 'yy-mm-dd',
                      onClose: function( selectedDate ) {
                          $( '#show-datepicker-to' ).datepicker( 'option', 'minDate', selectedDate );
                      }
                  });
              })(jQuery);
              (function($) {
                  $('#show-datepicker-to').datepicker( {
                      changeMonth: true,
                      changeYear: true,
                      showButtonPanel: true,
                      dateFormat: 'yy-mm-dd',
                      onClose: function( selectedDate ) {
                          $( '#show-datepicker-from' ).datepicker( 'option', 'maxDate', selectedDate );
                      }
                  });
              })(jQuery);
            </script>";
      break;
    case "award":
      echo "<script type='text/javascript'>
              (function($) {
                  $('#award-datepicker').datepicker( {
                      changeMonth: true,
                      changeYear: true,
                      showButtonPanel: true,
                      dateFormat: 'yy-mm-dd'
                  });
              })(jQuery);
            </script>";
      break;
  }
}
add_action( 'admin_print_footer_scripts', 'admin_footer_scripts' );

/* Adds the date/location metabox to the work edit page
 * Used code from http://stackoverflow.com/questions/2208480/jquery-ui-datepicker-to-show-month-year-only
 * to limit picking of date to only month year for works.
 */
function add_date_loc_of_item( $post ) {
  switch (get_post_type($post->ID)){
    case "work":
      echo "<label for='item_date'>Date of Work:</label>";
      echo "<input type='text' id='work-datepicker' name='item_date' readonly>";
      break;
    case "show":      
      echo "<div>Date(s) of Show</div>";
      echo "<label for='item_date_from'>From: </label>";
      echo "<input type='text' id='show-datepicker-from' name='item_date_from' readonly><br/>";
      echo "<label for='item_date_to'> To: </label>";
      echo "<input type='text' id='show-datepicker-to' name='item_date_to' readonly>";
      break;
    case "award":
      echo "<label for='item_date'>Date of Work:</label>";
      echo "<input type='text' id='award-datepicker' name='item_date' readonly>";
      break;
  }
}

// Adds the related awards and shows metabox to the work edit page
function add_related_events( $post ) {
  // nonce used for verification by update_custom_post_type
  wp_nonce_field(get_post_type($post->ID),'custom_nonce');
  
  // query all posts with the 'award' post-type
  $args = array(
    'post_type' => 'award',
    'order' => 'ASC'
  );
  $awards = get_posts($args);

  if ($awards) {
    // display the awards in a select table and preselect the terms that have the current work's id
    // stored in the related_works post meta field
    echo "<span>";
    echo "<label for='related_awards[]'>Related Award(s)</label>";
    echo "<select name='related_awards[]' multiple='multiple'>";
    foreach($awards as $award) {
      echo "<option value='" . $award->ID . "'" . 
        (get_post_custom_values($award->ID,'related_works') && 
          in_array($post->ID, get_post_custom_values($award->ID,'related_works')) 
          ? " selected='selected'":"") . 
        ">" . get_the_title($award->ID) . ' ' . get_post_meta($award->ID,'showtime') . "</option>";
    }
    echo "</select></span>";
  } else {
    echo "<span>No Awards</span>";
  }

  // change query for all posts of 'show' post-type
  $args['post_type'] = 'show';
  $shows = get_posts($args);

  echo "<span style='margin-left:2em'>";
  if ($shows) {
    // display the shows in a select table and preselect those which have the current work's id 
    // stored in the related_works post meta field
    echo "<label for='related_shows[]'>Related Show(s)</label>";
    echo "<select name='related_shows[]'  multiple='multiple'>";
    foreach($shows as $show) {
      echo "<option value='" . $show->ID . "'" . 
        (get_post_custom_values($show->ID,'related_works') && 
          in_array($post->ID, get_post_custom_values($show->ID,'related_works')) 
          ? " selected='selected":"") . 
        ">" . get_the_title($show->ID) . ' ' . get_post_meta($show->ID,'showtime') . "</option>";
    }
    echo "</select>";
  } else {
    echo "No Shows";
  }
  echo "</span>";
}

// Adds the related works metabox to the award and show edit page
function add_related_works( $post ) {
  // used in update_custom_post_type for verification
  wp_nonce_field(get_post_type($post->ID),'custom_nonce');

  // query all posts with the 'work' post-type
  $args = array(
   'post_type' => 'work',
   'order' => 'ASC'
  );
  $works = get_posts($args);

  // display a select array of all works and preselects the works which are in the 'related_works'
  // post meta field of the current award or show
  echo "<label for='related_works'>Related Work(s)</label>";
  echo "<select name='related_works'  multiple='multiple'>";
  foreach($works as $work) {
    echo "<option value='" . $work->ID . "'" . 
      (get_post_custom_values($post->ID,'related_works') && 
        in_array($work->ID, get_post_custom_values($post->ID,'related_works')) 
        ? " selected='selected'":"") . 
      ">" . get_the_title($work->ID) . "</option>";
  }
  echo "</select>";
}

// Adds the flickr photoset selection and vimeo album selection 
// to the work edit page with respect to the media settings in the
// theme options
function add_related_media( $post ) {
  $flickr_user_id = get_option('flickr_user_id');
  if(isset($_GLOBALS['flickr']) && $flickr_user_id) {
    global $flickr;
    $photosets = $flickr->photosets_getList($flickr_user_id);
    echo "<label for='flickr_photoset'>Photoset for Header:</label>";
    echo "<select name='flickr_photoset'>";
    foreach($photosets['photosets']['photoset'] as $photoset) {
      echo "<option value='" . $photoset['id'] . "'" . 
        (get_post_meta($post->ID,'related_photoset') && 
          in_array($photoset['id'], get_post_meta($post->ID,'related_photoset')) 
          ? " selected='selected'":"") . 
        ">" . $photoset['title']['_content'] . "</option>";
    }
    echo "</select>";
  } else {
    echo "<span>Your Flickr integration settings are incorrect.<br/></span>";
  }
  $vimeo_user_id = get_option('vimeo_user_id');
  if($vimeo_user_id) {
    echo "<label for='vimeo_album'>Vimeo Album to Include:</label>";
    echo "<select name='vimeo_album'>";

    $vimeo_albums = vimeo_call( $vimeo_user_id , 'albums' );
    foreach($vimeo_albums as $album) {
      echo "<option value='" . $album['id'] . "'" . 
        (get_post_meta($post->ID,'related_vimeo') && 
          in_array($album['id'], get_post_meta($post->ID,'related_vimeo')) 
          ? " selected='selected'":"") . 
        ">" . $album['title'] . "</option>";
    }
    echo "</select>";
  } else {
    echo "<span>Your Vimeo integration settings are incorrect.<br/></span>";
  }
  echo "<div>" . get_option('vimeo_user_id') . " -- " . 
        get_option('flickr_user_id') . " -- " . 
        get_option('flickr_api_key') . " -- " . 
        ($_GLOBALS['flickr']?"true":"false") . "</div>";
} 

/* Called on the update or addition of posts. Used to update
 * or set the post-meta for the post-types: "work", "show", "award"
 */
function update_custom_post_type( $post_id ) {
  // check if we're not autosaving, the nonce is correct, and the user has permission
  if ((defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) ||
      !wp_verify_nonce( $_POST['post_type'], 'custom_nonce' ) || 
      !current_user_can( 'edit_page', $post_id )) 
    return;
  // save the specified fields given the post-type
  switch ($_POST['post_type']) {
    case "work":
      $diff = array_merge(array_diff($_POST['related_awards[]'] + $_POST['related_shows[]'], 
        get_post_custom_values($post_id,'related_awards') + get_post_custom_values($post_id,'related_shows')));
      foreach ($diff as $event) {
        $related_works = get_post_custom_values($event,'related_works');
        if (!in_array($post_id,$related_works)) 
          array_push($post_id,$related_works);
        else 
          array_remove($event,$related_works);
      }
      update_post_meta($post_id,'related_awards',$_POST['related_awards[]']);
      update_post_meta($post_id,'related_shows',$_POST['related_shows[]']);
      if ($_POST['item_date'])
        update_post_meta($post_id,'item_date',array(strtotime($_POST['item_date'])));
      if ($_POST['related_photoset'])
        update_post_meta($post_id,'related_photoset',$_POST['related_photoset']);
      if ($_POST['related_vimeo'])
        update_post_meta($post_id,'related_vimeo',$_POST['related_vimeo']);
      break;
    case "show":
      $diff = array_merge(array_diff($_POST['related_works[]'],get_post_custom_values($post_id,'related_works')));
      foreach ($diff as $work) {
        $related_shows = get_post_custom_values($work,'related_shows');
        if (!in_array($post_id,$related_shows)) 
          array_push($post_id,$related_shows);
        else 
          array_remove($work,$related_shows);
      }
      update_post_meta($post_id,'related_works',$_POST['related_works[]']);
      if ($_POST['item_date_to'] || $_POST['item_date_from']) {
        $event_time = array();
        if ($_POST['item_date_to'])
          array_push($_POST['item_date_to'],$event_time);
        if ($_POST['item_date_from'])
          array_push($_POST['item_date_from'],$event_time);
      }
      if ($event_time)
        update_post_meta($post_id,'item_date',$event_time);
      break;
    case "award": 
      $diff = array_merge(array_diff($_POST['related_works[]'],get_post_custom_values($post_id,'related_works')));
      foreach ($diff as $work) {
        $related_shows = get_post_custom_values($work,'related_awards');
        if (!in_array($post_id,$related_awards)) 
          array_push($post_id,$related_awards);
        else 
          array_remove($work,$related_awards);
      }
      update_post_meta($post_id,'related_works',$_POST['related_works[]']);
      if ($_POST['item_date'])
        update_post_meta($post_id,'item_date',array(strtotime($_POST['item_date'])));
      break;
  }
}
add_action('update_post','update_custom_post_type');

/* Used on the "works" page to display every work as its 
 * corresponding image linking to its respective page. 
 * @param (int) $work_id - used to highlight the work that is currently being shown
 */
function display_works( $work_id ) {
  // Query a list of all 'work' posts and order them by the meta field work_date
  // from newest to oldest (highest to lowest since my dates are stored as UNIX timestamps) 
  $args = array(
            'post_type' => 'work',
            'orderby' => 'meta_value_num',
            'meta_key' => 'work_date',
            'order' => 'DESC'
          );
  $works = get_posts($args);

  // for each 'work' post display it and the title of that work for use in the main work page
  foreach ($works as $work) {
    echo "<div data-id='" . $work->ID . "' class='work" . 
              ($work_id == $work->ID ? " current" : "") . "'>";
    echo "<img url='" . (post_has_thumbnail($work->ID) ? 
            wp_get_attachment_thumb_url(get_post_thumbnail_id($work->ID)) : 
            "") . 
          "' >";
    echo "<span>" . get_the_title($work->ID) . "</span>";
    echo "</div>";
  }
}

/* Used to display a chronological list of shows and/or awards associated with 
 * the post id passed as the parameter. A null parameter will list all awards and shows.
 * If work_id is set, the associated work(s) column is left out.
 * Sortabililty will be added later.
 * @param (int) $work_id - the id of the work whose associated shows and awards will be listed
 */
function list_attributed( $work_id = false ) {
  $args = array(
            'post_type' => array('award','show'),
            'orderby' => 'meta_value_num',
            'meta_key' => 'item_date',
            'order' => 'DESC'
          );
  if ($work_id) 
    $args['meta_query'] = array(
                            array(
                              'key' => 'related_works',
                              'value' => $work_id, 
                              'compare' => 'LIKE'
                            )
                          );

  // Retrieve a chronologically sorted list of associated (or not) 'show' and 'award' posts
  $attributed = get_posts($args);
  $num_items = count($attributed);
  $item_count = 0;
  // If there are no associated shows or awards then don't display the container
  if ($num_items > 0) {
    // Display the table header
    echo "<table>" .
            "<thead>" . 
              "<td>".
                "<th>Name or Location</th>".
                "<th>Date</th>".
                ($work_id ? "" : "<th>Attributed Work</th>") .
              "</td>".
            "</thead>".
            "<tbody>";

    function title_util_func($n) { 
      return get_post_field('post_title',$n); 
    }
    // Display each 
    foreach ($attributed as $item) {
      // Get a imploded list of the titles of works associated with this show or award
      if (!$work_id) {
        $related_works = get_post_custom_values($item->ID,'related_works');
        $disp_works = implode( ', ', 
                        array_map(
                          'title_util_func',
                          $related_works)
                      );
      }
      // Get the date, if a new year has been reached, close the old row group,
      // create a new row group, and display the year as a header for that group
      $item_dates = array_map(intval,get_post_custom_values($item->ID,'item_date'));
      if ( !$disp_year || intval(date('Y',$item_dates[0])) < $disp_year )
        echo "<tr><td>" . date('Y',$item_dates[0]) . "</td></tr>";

      $time_format = "%a %m/%d";
      // Display the various attributes of the item. If the date is a range, display it as such.
      echo    "<tr>";
      echo      "<td>" . get_post_field('post_content',$item->ID) . "</td>".
                "<td>" . strftime($time_format,$item_dates[0]) .
                  ($item_type == "show" && isset($item_dates[1]) ?
                    " - " . strftime($time_format,$item_dates[1]) :
                    "" ) . 
                "</td><td>";
      if ($work_id) {
        $disp_works = array();
        foreach ($related_works as $work) 
          array_push($disp_works,"<a href='" . get_permalink($work) . "'>" 
                                  . get_post_field('post_title',$work) . "</a>");
        echo implode(',',$disp_works);
      }   
      echo  "</td></tr>"; 
    }
    echo "</tbody></table>";
  }
}

// used when setting up the slideshow after ajaxing the html content on the works page
add_action('wp_ajax_nopriv_get_flickr','ajax_flickr');
function ajax_flickr() {
  echo display_flickr_photoset_urls($_POST['work_id']);
  exit();
}

// @param str $work_id - the post id of the work post
// returns a string of a comma separated list of quoted urls of the images for the slideshow
function display_flickr_photoset_urls($work_id) {
  if (!$_GLOBALS['flickr']){
    return "";
  }
  $photoset_id = get_post_meta($work_id, 'related_photoset');
  $flickr_return = $_GLOBALS['flickr']->photosets_getPhotos($photoset_id);
  $photos = Array();
  foreach ($flickr_return['photoset']['photo'] as $photo)
    array_push($photos,$_GLOBALS['flickr']->buildPhotoURL($photo));
  return '"' . implode('","',$photos) . '"';
}

// @param str $work_id - the post id of the work post
// returns a string of embed html vimeo videos related to the work post
function display_vimeo_album($work_id) {
  if( !get_post_meta($work_id, 'related_vimeo', true) )
    return "";
  $output = "";
  $vims = vimeo_call('album/'.get_post_meta($work_id, 'related_vimeo', true),'videos.php');
  foreach ($vims[videos] as $video) {
    $output .= do_shortcode('[vimeo ' . $video['id'] . ']');
  }
  return $output;
}

// used with the work page to ajax the selected work's html
add_action('wp_ajax_nopriv_get_work','ajax_works_page');
function ajax_works_page() {
  echo display_work($_POST['work_id']);
  exit();
}

// creates the html for the specific work
function display_work($work_id) {
  return '<header id="header-container">'. 
          '<a id="work"></a>'.
          '<div class="row"><h2>'. 
          get_the_title($work_id) .
          '</h2></div>'.
        '</header>'.
        '<div class="main-container extra-padding">'.
          '<div class="container">'.
            '<div class="row">'.
              '<div class="sixcol">'.
                  get_post_field('post_content',$work_id) .
              '</div>'.
              '<div class="sixcol last">'.
                  list_attributed($work_id) . 
                  display_vimeo_album($work_id) .
              '</div>'.  
            '</div>'.
          '</div>'.
        '</div>';
}