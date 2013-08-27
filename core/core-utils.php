<?php

if (!defined('CORE_VERSION'))
	die();


// Converts an array's key value pairs to a list of CSS-style properties
//
function core_implode_properties($array) {
	$string = array();
	foreach ($array as $key => $val) {
		$string[] = "{$key}: {$val}";
	}

	return implode('; ', $string);
}

// Outputs a core warning\error message
//
function core_warning($message) {
	echo core_get_warning($message);
}
function core_get_warning($message) {
	return '<div class="core-warning">WARNING: ' .$message. '</div>';
}

// Outputs a core error and aborts all execution
//
function core_error($message) {
	echo '<div class="core-error">ERROR: ' .$message. '</div>';
	die();
}

// Returns the full requested page URI
//
function core_request_uri() {
	if (isset($_SERVER['HTTPS']))
		$request_uri = 'https://';
	else
		$request_uri = 'http://';
	
	$request_uri .= $_SERVER['HTTP_HOST'];

	if ($_SERVER["SERVER_PORT"] != '80')
		$request_uri .= ':' .$_SERVER['SERVER_PORT'];

	return $request_uri . $_SERVER['REQUEST_URI'];
}

// http://www.maverick.it/en/tech/create-thumbnails-using-wordpress-built-in-functions
function core_generate_thumbnail($img_url, $width=0, $height=0, $crop=null) {
	if ($width == 0)
		$width = get_option('thumbnail_size_w');
	if ($height == 0)
		$height = get_option('thumbnail_size_h');
	if ($crop == null)
		$crop = get_option('thumbnail_crop');

    $img = substr($img_url, strpos($img_url, 'wp-content'));
	
	// deprecated in WP 3.5
	//$thumb = image_resize($img, $width, $height, $crop); 
	
	// WP 3.5 compatibility
	$image = wp_get_image_editor($img);
	
	if ( ! is_wp_error( $image ) ) {
	    $image->resize( $width, $height, $crop );
	    $thumb = $image->save();
	}

    return (is_string($thumb)) ? site_url() . '/' .  $thumb : $img_url;
}

// Returns a reasonably unique identifier
//
function core_get_uuid($prefix='') {
	return uniqid($prefix);
}

// Returns true if the current request is an Ajax request
//
function core_is_ajax() {
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

// Returns a valid CSS unit
// Converts purely numeric values into px values
//
function core_css_unit($value) {
	if (is_numeric($value))
		return $value . 'px';
	else
		return $value;
}

// Returns a list of files inside a directory
//
function core_get_directory_list($directory) {
	$list = array();
	$handle = opendir($directory);

	while ($file = readdir($handle)) {
		if ($file != '.' && $file != '..')
			array_push($list, $file);
	}
	
	closedir($handle);
	
	return $list;
}

/**
 * Convert a hexadecimal color code to its RGB equivalent
 * http://www.php.net/manual/en/function.hexdec.php#99478
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */                                                                                                 
function core_hex2rgb($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

function core_color2rgba($colors) {
	if (!$colors)
		return null;
	return 'rgba(' .$colors['red']. ', ' .$colors['green']. ', ' .$colors['blue']. ', ' .$colors['alpha']. ')';
}

// Detects whether BuddyPress is installed
function core_is_buddypress_active(){

	// If BuddyPress is not activated, switch back to the default WP theme
	if ( !defined( 'BP_VERSION' ) )
		return false;
	
	return true;
}

// Detects if the pages or post is BuddyPress generated
function core_is_buddypress_pages(){
	
	if(core_is_buddypress_active()) {
		//check for active BP Component
		if ( bp_current_component()  ) {
		
			//check for the major components of BuddyPress
			if( 
				//check for the bp profile component
				bp_is_profile_component() 	|| 
				
				//check for the bp activity component
				bp_is_activity_component()	||
				
				//check for the bp blogs component
				bp_is_blogs_component()		||
				
				//check for the bp messages component
				bp_is_messages_component()	||
				
				//check for the bp friend component
				bp_is_friends_component()	||
				
				//check for the bp groups component
				bp_is_groups_component()	||
				
				//check for the bp setting component
				bp_is_settings_component() ){
				return true;

			}
			return false;
		}
		
		return false;
	}
	
	return false;
}

$alignment = array('left', 'right', 'center');
function core_element_align($align = 'left'){
	//if(in_array($align, $alignment, true))
		$align = $align.' --';
	return $align;
}

?>