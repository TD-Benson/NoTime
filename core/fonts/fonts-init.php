<?php

if (!defined('CORE_VERSION'))
	die();


require_once('fonts-list.php');


// Text used to preview a font
$core_fonts_preview_text = __('Amazingly few discotheques provide jukeboxes.', THEME_SLUG);


function core_fonts_enqueue_scripts() {
	wp_register_script('google-webfonts', 'http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
	wp_enqueue_script('google-webfonts');

	if (is_admin()) {
		wp_enqueue_script('core-fonts', CORE_URI. '/fonts/fonts.js', '', '', true);
		wp_enqueue_style('core-fonts-style', CORE_URI. '/fonts/fonts.css');
	}
}
add_action('wp_enqueue_scripts', 'core_fonts_enqueue_scripts');
add_action('admin_enqueue_scripts', 'core_fonts_enqueue_scripts');


// Font select option type
//
function core_fonts_option_output($id, $value, $option) {
	global $core_fonts;
	global $core_fonts_preview_text;

	echo '<div class="core-option-font-container">';
	echo '<select name="' .$option->key. '">';

	foreach ($core_fonts as $group_name => $group) {
		echo '<optgroup label="' .$group_name. '">';
		foreach ($group as $font_name) {
			if ($font_name == $value)
				$selected = ' selected';
			else
				$selected = '';
			echo '<option' .$selected. '>' .$font_name. '</option>';
		}
	}

	echo '</select><br>';

	echo '<input type="text" id="' .$id. '" name="', $option->key, '" value="', $value, '" data-previous="', $value, '">';
	echo '<div class="font-status"></div>';
	echo '<p>', $core_fonts_preview_text, '</p>';
	
	echo '</div>';
}
core_options_type_register('font', 'core_fonts_option');

// Sets the font preview text directly
//
function core_fonts_preview_text($text) {
	global $core_fonts_preview_text;

	 $core_fonts_preview_text = $text;
}

?>