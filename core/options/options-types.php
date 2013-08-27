<?php

if (!defined('CORE_VERSION'))
	die();


// Registers standard option types
//
function core_options_register_types() {

	// Text field
	//
	function core_option_text_output($id, $value, $option) {
		echo '<input id="' .$id. '" name="' .$option->key. '" type="text" value="' .htmlentities($value). '">';
	}
	core_options_type_register('text', 'core_option_text');

	// Multiline text area
	//
	function core_option_text_multiline_output($id, $value, $option) {
		echo '<textarea id="' .$id. '" name="' .$option->key. '">' .$value. '</textarea>';
	}
	core_options_type_register('text-multiline', 'core_option_text_multiline');

	// Number field
	//
	function core_option_number_output($id, $value, $option) {
		echo '<input id="' .$id. '" name="' .$option->key. '" class="core-option-number-input" type="text" value="' .htmlentities($value). '"';
		echo ' data-step="', $option->step, '"';
		echo ' data-min="', $option->min, '"';
		echo ' data-max="', $option->max, '"';
		echo '>';

		echo '<div class="core-option-number-up"></div>';
		echo '<div class="core-option-number-down"></div>';
	}
	function core_option_number_import($value, $option) {
		return intval($value);
	}
	core_options_type_register('number', 'core_option_number');

	// Checkbox
	//
	function core_option_checkbox_output($id, $value, $option) {
		$checked = ($value == true ? ' checked' : '');
		echo '<input id="' .$id. '" name="' .$option->key. '" type="checkbox" value="1"' .$checked. '>';
	}
	function core_option_checkbox_import($value, $option) {
		if ($value == '')
			return false;
		else
			return true;
	}
	core_options_type_register('checkbox', 'core_option_checkbox');

	// Image
	//
	function core_option_image_output($id, $value, $option) {
		echo '<div class="core-option-image-select-container">';
		echo '<div class="preview-thumb add_media insert_media" data-title="',ucfirst(str_replace('_', ' ',str_replace('core_', '',$option->key))),'" data-destination="', $id, '"><img src="', $value, '"><div class="remove"></div></div><br>';
		echo '<input id="' .$id. '" name="' .$option->key. '" type="text" value="' .htmlentities($value). '">';
		echo '</div>';
	}
	core_options_type_register('image', 'core_option_image');

	// Pattern
	//
	function core_option_pattern_output($id, $value, $option) {
		echo '<div class="core-option-pattern-container">';

		$folder = $option->directory;
		$patterns = core_get_directory_list($folder);
		sort($patterns, SORT_NUMERIC);

		echo '<select id="' .$id. '" name="' .$option->key. '">';
		echo '<option value="none">' . __('None', THEME_SLUG) . '</option>';
		foreach($patterns as $file) {
			if($file == $value)
				$selected = ' selected';
			else
				$selected = '';

			if(strstr($file, '.png'))
				echo '<option value="' .$file. '"' .$selected. '>' . __('Pattern', THEME_SLUG) . ' ' .str_replace(array('-', '_', '.png'), ' ', $file). '</option>';
		}
		echo '</select>';
		echo '</div>';
	}
	core_options_type_register('pattern', 'core_option_pattern');

	// Color
	//
	function core_option_color_output($id, $value, $option) {
		$value = str_replace('#', '', $value);

		echo '<input id="' .$id. '" name="' .$option->key. '" class="core-option-color-input" type="text" value="' .htmlentities($value). '">';
		echo '<div class="core-option-color" style="background-color: #' .$value. '"></div>';
	}
	function core_option_color_import($value, $option) {
		// Always prepend # to colors
		if (!strpos($value, '#'))
			return '#' . $value;

		return $value;
	}
	core_options_type_register('color', 'core_option_color');

	// Select box
	//
	function core_option_select_output($id, $value, $option) {
		echo '<select id="' .$id. '" name="' .$option->key. '">';

		foreach ($option->parameters as $item_value => $item_name) {
			if ($item_value == $value)
				$selected = ' selected';
			else
				$selected = '';
			echo '<option' .$selected. ' value="', $item_value, '">' .$item_name. '</option>';
		}

		echo '</select>';
	}
	core_options_type_register('select', 'core_option_select');
}

?>