<?php

if (!defined('CORE_VERSION'))
	die();


// TODO: Remove orphaned sliders at some point
// Orphaned sliders happen when a slider is deleted from the slider list. But right now the slider's settings are kept in the options database.
// If you then create a new slider with the same name, the slider's settings will appear again.

// Register slider theme options
//
function core_slider_options_register() {
	global $core_theme_options_handler;

	$options = new CoreOptionGroup('sliders', 'Sliders', __('Create sliders, to be used on pages and post.', THEME_SLUG), THEME_URI. '/images/options-sliders.png');
	$core_theme_options_handler->group_add($options);

	$section = new CoreOptionSection('sliders');
	$options->section_add($section);

	$section->option_add(new CoreOption('sliders', null, 'slider-list', null, json_decode('{}', true)));
}
add_action('after_setup_theme', 'core_slider_options_register');

// Slider list option type
//
function core_slider_option_list_output($id, $value, $option) {
	global $core_sliders;

	echo '<div class="core-option-sliderlist">';

	echo '<input type="text" class="slider-name"></input>';
	echo '<select class="slider-type">';
	foreach ($core_sliders as $name => $slider) {
		echo '<option value="', $name, '">', $name, '</option>';
	}
	echo '</select>';
	echo '<input type="button" value="' . __('Add new', THEME_SLUG) . '"></input>';

	echo '<input type="hidden" name="', $option->key, '" id="' ,$id, '" value=\'', json_encode($value), '\'></input>';

	// Slider item template for JavaScript duplication
	echo '<div class="list list-template" data-slug="">';
	echo '<p class="name"></p>';
	echo '<p class="type"></p>';
	echo '<a href="#" class="edit">' . __('Edit', THEME_SLUG) . '</a>';
	echo '<a href="#" class="remove">' . __('Remove', THEME_SLUG) . '</a>';
	echo '</div>';

	// Slider items
	echo '<div class="list-items">';
	foreach ($value as $slug => $slider) {
		echo '<div class="list" data-slug="', $slug, '" data-slider="', $slider['type'], '">';
		echo '<p class="name">', $slider['name'], '</p>';
		echo '<p class="type">', $slider['type'], '</p>';
		echo '<a href="#" class="edit">' . __('Edit', THEME_SLUG) . '</a>';
		echo '<a href="#" class="remove">' . __('Remove', THEME_SLUG) . '</a>';
		echo '</div>';
	}
	echo '</div>';

	// Slider builder iframe
	echo '<iframe class="builder" scrolling="no" frameborder="0">';
	echo '</iframe>';

	echo '</div>';
}
function core_slider_option_list_import($value, $option) {
	return json_decode(stripslashes($value), true);
}
core_options_type_register('slider-list', 'core_slider_option_list');

// Sliders (built) option type
//
function core_slider_option_sliders_output($id, $value, $option) {
	$sliders = core_options_get('sliders');

	echo '<select id="', $id, '" name="', $option->key, '">';

	// 'none' options
	if ($value == 'none' || !$value)
		$selected = 'selected';
	else
		$selected = '';
	echo '<option value="none" ', $selected, '>' . __('None', THEME_SLUG) . '</option>';

	// Output slider names
	foreach ($sliders as $slug => $slider) {
		if ($slug == $value)
			$selected = ' selected';
		else
			$selected = '';

		echo '<option value="', $slug, '" ', $selected, '>', $slider['name'], ' (', $slider['type'], ')</option>';
	}
	echo '</select>';
}
core_options_type_register('sliders', 'core_slider_option_sliders');
?>