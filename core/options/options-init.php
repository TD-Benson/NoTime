<?php

if (!defined('CORE_VERSION'))
	die();

require_once('options-classes.php');
require_once('options-registry.php');
require_once('options-types.php');
require_once('options-theme.php');
require_once('options-metabox.php');


// Option handler for theme options
$core_theme_options_handler = array();


// Enqueue scripts
//
function core_options_enqueue_scripts() {
	global $core_menu_pages;

	$screen = get_current_screen();
	
	// Post editing options only
	if ($screen->base == 'post') {
		wp_enqueue_style('core-options-post', CORE_URI. '/options/css/core-options-post.css');
	
	// Theme options only
	} else if ($screen->base == 'appearance_page_' .THEME_SLUG . '-options') {
		wp_enqueue_style('core-options-theme', CORE_URI. '/options/css/core-options-theme.css');
	}

	// Common
	wp_enqueue_script('core-options', CORE_URI. '/options/options.js', '', '', true);
	
	if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}else{
	    wp_enqueue_style('thickbox');
	    wp_enqueue_script('media-upload');
	    wp_enqueue_script('thickbox');
	}

	// Color picker
	wp_enqueue_style('core-colorpicker');
	wp_enqueue_script('core-colorpicker', '', '', true);
}
add_action('admin_enqueue_scripts', 'core_options_enqueue_scripts');

// Admin menu initialisation
// Adds theme option page
//
function core_options_menu_init() {
	add_theme_page(THEME_NAME, THEME_NAME, 'edit_theme_options', THEME_SLUG . '-options', 'core_options_theme_output');
}
add_action('admin_menu', 'core_options_menu_init');

// Initialise options module
//
function core_options_init() {
	global $core_theme_options_handler;

	// Register standard option types
	core_options_register_types();

	// Create the default theme options handler
	$core_theme_options_handler = new CoreOptionHandler('theme');
}
core_options_init();

?>