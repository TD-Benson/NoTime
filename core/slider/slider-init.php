<?php

if (!defined('CORE_VERSION'))
	die();


require_once('slider-registry.php');
require_once('slider-options.php');


// Enqueue scripts
//
function core_slider_enqueue_scripts() {
	wp_enqueue_style('core-slider', CORE_URI. '/slider/slider.css');
	wp_enqueue_script('core-slider', CORE_URI. '/slider/slider.js', '', '', true);

	wp_enqueue_script('json2', '', '', '', '', true);
}
add_action('admin_enqueue_scripts', 'core_slider_enqueue_scripts');

// Print custom scripts
//
function core_slider_print_scripts() {
	// Store registered slider types in window
	// This way, the slider builder iframe can access this data
	// Possibly not the best solution
	if (is_admin()) {
		global $core_sliders;

		echo '<script type="text/javascript">';
		echo 'window.sliders = {};';
		foreach ($core_sliders as $name => $slider) {
			echo 'window.sliders["', $name, '"] = ', json_encode($slider), ';';
		}
		echo '</script>';
	}
}
add_action('admin_head', 'core_slider_print_scripts');

?>