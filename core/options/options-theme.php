<?php

if (!defined('CORE_VERSION'))
	die();


// Theme options nonce action
define('CORE_THEME_OPTIONS_ACTION', THEME_SLUG. '-options-save');


// Stores options that were passed through POST
// AJAX callback
//
function core_options_theme_save() {
	global $core_theme_options;

	// Verify nonce
	if (!wp_verify_nonce($_POST['core-options-nonce'], CORE_THEME_OPTIONS_ACTION)) {
		echo 'Invalid nonce.';
		die();
	}

	// Update registered options if they exist in the request, otherwise delete them
	foreach ($core_theme_options as $option_slug => $option) {
		$key = $option->key;

		// Checkboxes are false if not defined, true if they are
		if ($option->type == 'checkbox')
		{
			$value = isset($_POST[$key]);
			update_option($key, $value);

		// Other option types
		} else if (isset($_POST[$key])) {
			$value = $option->import($_POST[$key]);
			update_option($key, $value);
		} else {
			delete_option($key);
		}
	}

	echo __('Options saved succesfully.', THEME_SLUG);
	die();
}
add_action('wp_ajax_core_options_theme_save', 'core_options_theme_save');

// Outputs all registered core theme options
//
function core_options_theme_output() {
	global $core_theme_options_handler;
	
	// Sort option groups alphabetically
	ksort($core_theme_options_handler->groups);
	
	// Select visible group
	$page = THEME_SLUG . '-options-' . $core_theme_options_handler->default_group;

	// Form header
 	echo '<form method="post" id="core-theme-options-form" name="core-theme-options-form">';

	// WordPress nonce
	echo '<input type="hidden" name="core-options-nonce" value="', wp_create_nonce(CORE_THEME_OPTIONS_ACTION), '">';

	echo '<div id="core-theme-options">';
	
	// Output navigation links
	echo '<div id="sidebar">';
	echo '<ul id="navigation">';
	foreach ($core_theme_options_handler->groups as $group) {
		$group->output_link();
	}
	echo '</ul>';
	echo '</div>';

	echo '<div id="content">';

	// Groups
	foreach ($core_theme_options_handler->groups as $group) {
		$visible = (THEME_SLUG . '-options-' .$group->slug) == $page;
		$group->output(true, $visible, true);
	}

	// Submit button
	echo '<div class="core-option-theme-buttons">';
	echo '<input type="button" id="core-options-submit" class="core-option-submit" name="core-options-submit" value="Save changes">';

	// AJAX elements
	echo '<input type="hidden" name="action" value="core_options_theme_save">';
	echo '<div id="core-options-busy"></div>';
	echo '<p id="core-options-result"></p>';
	echo '</div>';

	echo '</div>';

	echo '</div>';

	echo '</form>';
}

?>