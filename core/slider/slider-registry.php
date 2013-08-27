<?php

if (!defined('CORE_VERSION'))
	die();


$core_sliders = array();


// Registers a new slider type
//
function core_slider_register($slider) {
	global $core_sliders;

	$core_sliders[$slider['name']] = $slider;
}

// Outputs a slider
//
function core_slider($slug) {
	global $core_sliders;

	$sliders = core_options_get('sliders');
	if (!isset($sliders[$slug])) {
		core_warning(sprintf(__('Could not find slider with slug name "%s".', THEME_SLUG), $slug));
		return;
	}
	
	$settings = get_option('core_slider_' . $slug, null);
	if ($settings == null)
		return;
	$settings = json_decode(stripslashes($settings), true);

	$slider_type = $sliders[$slug]['type'];
	$output_func = $core_sliders[$slider_type]['output'];
	$scripts = $core_sliders[$slider_type]['scripts'];
	$styles = $core_sliders[$slider_type]['styles'];
	$output_func($settings);

	// Enqueue scripts and styles related to slider
	// WordPress 3.3 and later will load these in the footer
	foreach ($scripts as $name => $src) {
		wp_enqueue_script($name, $src);
	}
	foreach ($styles as $name => $src)
		wp_enqueue_style($name, $src);
}

// Stores options that were passed through POST
// AJAX callback
//
function core_slider_save() {
	if (!isset($_POST['nonce'])) {
		echo 'ERROR: No nonce.';
		die();
	}

	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'core-slider-save')) {
		echo 'ERROR: Invalid nonce.';
		die();
	}

	update_option('core_slider_' . $_POST['slug'], $_POST['settings']);
	
	echo __('Slider saved succesfully.', THEME_SLUG);
	die();
}
add_action('wp_ajax_core_slider_save', 'core_slider_save');

?>