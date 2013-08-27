<?php

if (!defined('CORE_VERSION'))
	die();


require_once('shortcodes-utils.php');
require_once('shortcodes.php');


// Enqueue scripts
//
function core_shortcodes_enqueue_scripts() {
	if (!is_admin()) {
		wp_enqueue_script('core-shortcodes', CORE_URI. '/shortcodes/shortcodes.js', '', '', true);
		wp_enqueue_style('core-shortcodes', CORE_URI. '/shortcodes/shortcodes.css');
	} else {
		wp_enqueue_script('core-shortcodes-admin', CORE_URI. '/shortcodes/shortcodes-admin.js', '', '', true);
	}
}
add_action('admin_enqueue_scripts', 'core_shortcodes_enqueue_scripts');
add_action('wp_enqueue_scripts', 'core_shortcodes_enqueue_scripts');

// Adds the shortcode button, which displays the shortcode thickbox
//
function core_shortcode_output_buttons($context)
{
	$href = CORE_URI . '/shortcodes/shortcodes-overlay.php?width=900&height=500';

	return $context . '<a class="thickbox" title="' .THEME_NAME. ' shortcodes" href="' .$href. '" onclick="return false;">
	<img alt="' .THEME_NAME. ' shortcodes" src="' .CORE_URI. '/shortcodes/images/icon-shortcodes.png"></a>';
}
add_action('media_buttons_context', 'core_shortcode_output_buttons');

// Allow use of shortcodes in sidebar widgets
add_filter('widget_text', 'do_shortcode');

?>