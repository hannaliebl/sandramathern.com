<?php
add_action('init', 'tagline');
function tagline() {
$args = array(
'label' => _('tagline'),
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => true,
'has_archive' => false,
'supports' => array('title', 'editor'), );
//Register type and custom taxonomy for this type.
register_post_type( 'taglines' , $args );
}
?>