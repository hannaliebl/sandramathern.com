<?php
/**
 * @package WordPress
 */
/* Sets up media integration with the theme.
 * 
 * Adds theme option fields for Flickr ID and Vimeo ID for use in the works
 * pages and all slideshows. Includes the Flickr PHP library and 
 * initializes it when settings are updated.
 */

// The vimeo api base url
$_GLOBALS['vimeo_base_url'] = "http://vimeo.com/api/v2/";

// Include the php library for Flickr integration
// /functions/phpFlicker/phpFlickr.php 
//include( $GLOBALS["TEMPLATE_DIR_URL"] . "/functions/phpFlickr/phpFlickr.php");

// utility function to call flickr methods without the phpFlickr object
// taken and modified from the flickr example php response function:
// http://www.flickr.com/services/api/response.php.html
function call_flickr_api_method ($arguments) {
	// use the arguments to build the parameter array and construct the url
	$params = array_merge(array('format'=>'php_serial'),$arguments);
	$encoded_params = array();
	foreach ($params as $k => $v)
		$encoded_params[] = urlencode($k).'='.urlencode($v);
	$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
	// return response array
	return unserialize( file_get_contents($url) );
}

// Curl helper function taken and modified from the vimeo example php file:
// https://github.com/vimeo/vimeo-api-examples/blob/master/simple-api/gallery/php-example.php
function vimeo_call($user_id,$request) {
	$curl = curl_init( $_GLOBALS['vimeo_base_url'] . $user_id . '/' . $request . '.php');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	return unserialize($return);
}

// check if the api key is valid before updating
function update_flickr_api ($old_key, $new_key) {
	$rsp_obj = call_flickr_api_method(array(
		'api_key'	=> $new_key,
		'method'	=> 'flickr.test.echo'
	));
	_log($rsp_obj['stat']);
	// check if flickr saw the api key as valid and update if so
	if ($rsp_obj['stat'] == 'ok') {
		$_GLOBALS['flickr'] = new phpFlickr($new_key);
		return $new_key;
	} else {
		return $old_key;
	}
}

// check if the user id works with the flickr api (i.e. we have permission)
// before updating it
function update_flickr_usr ($old_id, $new_id) {
	$api_key = get_option('flickr_api_key');
	if (! $api_key) 
		return $old_id;
	$rsp_obj = call_flickr_api_method(array(
		'api_key'	=> $api_key,
		'user_id'	=> $new_id,
		'method'	=> 'flickr.people.getInfo'
	));
	// check if flickr saw the NSID as valid and update if so
	if ($rsp_obj['stat'] == 'ok') {
		return $new_id;
	} else {
		return $old_id;
	}
}

// check if vimeo user is real before updating the option
function update_vimeo_usr( $old_id, $new_id) {
	return (vimeo_call($_GLOBALS['vimeo_base_url'] . $new_id . "/info.php") ? 
				$new_id :
				$old_id );
}
add_action('update_option_vimeo_user_id','update_vimeo_usr');
add_action('update_option_flickr_api_key','update_flickr_api');
add_action('update_option_flickr_user_id','update_flickr_usr');

/*	Add flickr api key, flickr user id, and vimeo user id as theme customization fields
 *	to be saved as options values. 
 */
function media_customize_register( $wp_customize )
{
	$wp_customize->add_section( 'media_integration' , array(
    'title'      => __('Media Integration'),
    'priority'   => 30,
    'description'=> __('Necessary details for the accounts that are to be integrated into the Theme.')
	) );
	$wp_customize->add_setting( 'vimeo_user_id' , array(
	    'default'     => '',
	    'transport'   => 'refresh',
	    'type'		  => 'option'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'vimeo_id', array(
		'label'        => __( 'Vimeo User ID' ),
		'section'    => 'media_integration',
		'settings'   => 'vimeo_user_id'
	) ) );
	$wp_customize->add_setting( 'flickr_api_key' , array(
	    'default'     => '',
	    'transport'   => 'refresh',
	    'type'		  => 'option'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'flickr_api_key', array(
		'label'        => __( 'Flickr API Key' ),
		'section'    => 'media_integration',
		'settings'   => 'flickr_api_key'
	) ) );
	$wp_customize->add_setting( 'flickr_user_id' , array(
	    'default'     => '',
	    'transport'   => 'refresh',
	    'type'		  => 'option'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'flickr_id', array(
		'label'        => __( 'Flickr User ID' ),
		'section'    => 'media_integration',
		'settings'   => 'flickr_user_id'
	) ) );
}
add_action( 'customize_register', 'media_customize_register' );